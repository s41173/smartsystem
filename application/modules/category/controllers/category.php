<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Category_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->product = $this->load->library('products');
        $this->category = $this->load->library('categoryproduct');

    }

    private $properti, $modul, $title;
    private $product,$category;

    function index()
    {
        $this->get_last_category(); 
    }
    
    function chart()
    {
        $this->db->select('playerid, score');
        $this->db->from('score'); 
        $result = $this->db->get()->result(); 
        
        print json_encode($result); 
    }

    function get_last_category()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['parent'] = $this->category->combo();
        
	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

	// ---------------------------------------- //
        $categorys = $this->Category_model->get_last_category($this->modul['limit'], $offset)->result();
        $num_rows  = $this->Category_model->count_all_num_rows();

        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url($this->title.'/get_last_category');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            
            $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
            $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
         
            $config['cur_tag_open'] = "<li><span><b>";
            $config['cur_tag_close'] = "</b></span></li>";
            
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination

            // library HTML table untuk membuat template table class zebra
            $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");

            //Set heading untuk table
            $this->table->set_heading('#','No', 'Name', 'Parent', 'Action');

            $i = 0 + $offset;
            foreach ($categorys as $category)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $category->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, $category->name, $this->category->get_name($category->parent_id),
                    anchor('#','<i class="fa fas-2x fa-edit"></i>',array('class' => 'text-primary', 'data-id' => $category->id, 'title' => '')).'  '.
                    anchor('#','<i class="fa fa-trash fa-s2x"></i>',array('class'=> 'text-danger', 'id' => $category->id, 'title' => 'delete' ,'onclick'=>""))
                );
            }

            $data['table'] = $this->table->generate();
            
            //          fasilitas check all
            $js = "onClick='cekall($i)', id='chkselect'";
            $sj = "onClick='uncekall($i)'";
            
            $data['checkbox'] = form_checkbox('newsletter', 'accept1', FALSE, $js);
        }
        else
        {
            $data['message'] = "No $this->title data was found!";
        }

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
              $img = $this->Category_model->get_category_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/category/".$img; unlink("$img"); }

              $this->Category_model->delete($cek[$i]); 
           }
           else { $x=$x+1; }
           
           $res = intval($jumlah-$x);
           $this->session->set_flashdata('message', "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!");
        }
      }
      else
      { $this->session->set_flashdata('message', "No $this->title Selected..!!"); }
      redirect($this->title);
    }

    function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Category_model->get_category_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/category/".$img; unlink("$img"); }

           $this->Category_model->delete($uid);
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
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_category');
        $this->form_validation->set_rules('cparent', 'Parent Category', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/category/';
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
                $category = array('name' => $this->input->post('tname'),'parent_id' => $this->input->post('cparent'), 'image' => null);
            }
            else
            {
                $info = $this->upload->data();
                $category = array('name' => $this->input->post('tname'),'parent_id' => $this->input->post('cparent'), 'image' => $info['file_name']);
            }

            $this->Category_model->add($category);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($info['file_name'])
            {
              $img = base_url().'images/category/'.$info['file_name'];
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
//        $this->acl->otentikasi2($this->title);
//
//        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
//        $data['h2title'] = $this->modul['title'];
//        $data['main_view'] = 'category_update';
//	  $data['form_action'] = site_url($this->title.'/update_process');
//	  $data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));
        
        $uid = $this->input->post('id'); 
        $data['parent'] = $this->category->combo_update($uid);
        $category = $this->Category_model->get_category_by_id($uid)->row();
        $data['default']['name'] = $category->name;
        $data['default']['parent'] = $category->parent_id;
        $data['default']['image'] = base_url().'images/category/'.$category->image;
//
	$this->session->set_userdata('langid', $category->id);
//        $this->load->view('category_update', $data);
        
        echo $uid.'|'.$data['parent'].'|'.$category->name.'|'.$category->parent_id.'|'.base_url().'images/category/'.$category->image;
    }


    public function valid_category($name)
    {
        if ($this->Category_model->valid_category($name) == FALSE)
        {
            $this->form_validation->set_message('valid_category', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_category($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Category_model->validating_category($name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_category', 'This category is already registered!');
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
        $data['main_view'] = 'category_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));
        $data['parent'] = $this->category->combo_update($this->session->userdata('langid'));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|max_length[100]|callback_validation_category');
        $this->form_validation->set_rules('cparent', 'Parent Category', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/category/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '1000';
            $config['max_width']  = '3000';
            $config['max_height']  = '3000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                $category = array('name' => $this->input->post('tname'),'parent_id' => $this->input->post('cparent'));
                $img = null;
            }
            else
            {
                $info = $this->upload->data();
                $category = array('name' => $this->input->post('tname'),'parent_id' => $this->input->post('cparent'), 'image' => $info['file_name']);
                $img = base_url().'images/category/'.$info['file_name'];
            }

	    $this->Category_model->update($this->session->userdata('langid'), $category);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
//            redirect($this->title.'/update/'.$this->session->userdata('langid'));
            $this->session->unset_userdata('langid');
          //  echo "<img src='$img' />";
         //   echo $img;
            echo "<img src='$img' />";

        }
        else
        {
//            $this->load->view('category_update', $data);
            echo 'invalid';
        }
    }

}

?>