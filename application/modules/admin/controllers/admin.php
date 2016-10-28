<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Admin_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->product = new Products();
        $this->admin = new Categoryproduct();

    }

    private $properti, $modul, $title;
    private $product,$admin;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Admin_model->get_last_user($this->modul['limit'])->result(); }
	
	foreach($result as $res)
	{
           if ($res->status == 1){ $stts = 'TRUE'; }else { $stts = 'FALSE'; }
	   $output[] = array ($res->userid, $res->username, $res->name, $res->address, $res->phone1, $res->phone2,
                              $res->city, $res->email, $res->yahooid, $res->role, $stts, $res->lastlogin,
                              $res->created, $res->updated, $res->deleted
                             );
	}
	
      $this->output
      ->set_status_header(200)
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($output, JSON_PRETTY_PRINT))
      ->_display();
      exit; 
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['parent'] = $this->admin->combo();
	// ---------------------------------------- //
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Username', 'E-mail', 'Role', 'Status', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('admin/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function delete_all()
    {
      $this->acl->otentikasi_admin($this->title);
      
      $cek = $this->input->post('cek');
      $jumlah = count($cek);

      if($cek)
      {
        $jumlah = count($cek);
        $x = 0;
        for ($i=0; $i<$jumlah; $i++)
        {
           if ( $this->cek_relation($cek[$i]) == TRUE ) 
           {
              $this->Admin_model->delete($cek[$i]); 
           }
           else { $x=$x+1; }
           
        }
        $res = intval($jumlah-$x);
        //$this->session->set_flashdata('message', "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!");
        $mess = "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!";
        echo 'true|'.$mess;
      }
      else
      { //$this->session->set_flashdata('message', "No $this->title Selected..!!"); 
        $mess = "No $this->title Selected..!!";
        echo 'false|'.$mess;
      }
   //   redirect($this->title);
    }

    function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Admin_model->get_admin_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/admin/".$img; unlink("$img"); }

           $this->Admin_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo 'true';
        }
        else { $this->session->set_flashdata('message', "$this->title related to another component..!"); 
        echo  "$this->title related to another component..!";}
       // redirect($this->title);
    }

    private function cek_relation($id)
    {
        $product = $this->product->cek_relation($id, $this->title);
        if ($product == TRUE) { return TRUE; } else { return FALSE; }
    }

    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_admin');
        $this->form_validation->set_rules('cparent', 'Parent Category', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/admin/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '1000';
            $config['max_width']  = '3000';
            $config['max_height']  = '3000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $admin = array('name' => strtolower($this->input->post('tname')),'parent_id' => $this->input->post('cparent'), 'image' => null);
            }
            else
            {
                $info = $this->upload->data();
                $admin = array('name' => strtolower($this->input->post('tname')),'parent_id' => $this->input->post('cparent'), 'image' => $info['file_name']);
            }

            $this->Admin_model->add($admin);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($info['file_name'])
            {
              $img = base_url().'images/admin/'.$info['file_name'];
              echo "<img width='200' src='$img' />";
            }
            else { echo '<p style="color:#FD080C; font-size:12px; font-weight:bold;"> '.$this->title.' Successfully Saved...! </p>'; }
            
          //  echo 'true';
        }
        else
        {
//               $this->load->view('template', $data);
//            echo validation_errors();
            echo 'invalid';
        }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['parent'] = $this->admin->combo_update($uid);
        $admin = $this->Admin_model->get_admin_by_id($uid)->row();
        $data['default']['name'] = $admin->name;
        $data['default']['parent'] = $admin->parent_id;
        $data['default']['image'] = base_url().'images/admin/'.$admin->image;
//
	$this->session->set_userdata('langid', $admin->id);
//        $this->load->view('admin_update', $data);
        
        echo $uid.'|'.$admin->name.'|'.$admin->parent_id.'|'.base_url().'images/admin/'.$admin->image;
    }


    public function valid_admin($name)
    {
        if ($this->Admin_model->valid_admin($name) == FALSE)
        {
            $this->form_validation->set_message('valid_admin', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_admin($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Admin_model->validating_admin($name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_admin', 'This admin is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));
        $data['parent'] = $this->admin->combo_update($this->session->userdata('langid'));

	// Form validation
        $this->form_validation->set_rules('tname_update', 'Name', 'required|max_length[100]|callback_validation_admin');
        $this->form_validation->set_rules('cparent_update', 'Parent Category', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/admin/';
            $config['file_name'] = $this->input->post('tname_update');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile_update")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                $admin = array('name' => strtolower($this->input->post('tname_update')),'parent_id' => $this->input->post('cparent_update'));
                $img = null;
            }
            else
            {
                $info = $this->upload->data();
                $admin = array('name' => strtolower($this->input->post('tname_update')),'parent_id' => $this->input->post('cparent_update'), 'image' => $info['file_name']);
                $img = base_url().'images/admin/'.$info['file_name'];
            }

	    $this->Admin_model->update($this->session->userdata('langid'), $admin);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
          //  $this->session->unset_userdata('langid');
            echo "true|".$img;

        }
        else
        {
            echo 'invalid|'.validation_errors();
        }
    }

}

?>