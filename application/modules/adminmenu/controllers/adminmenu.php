<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adminmenu extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Adminmenu_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->city = new City_lib();
        $this->menu = new Adminmenu_lib();
        $this->component = new Components();
    }

    private $properti, $modul, $title;
    private $role,$city,$menu,$component;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Adminmenu_model->get_last($this->modul['limit'])->result(); }
	
        $output = null;
        if ($result){
            
          foreach ($result as $res)    
          {
              if ($res->parent_status == 1){ $stts = 'parent'; }else { $stts = 'child'; }
              $output[] = array ($res->id, $this->menu->getmenuname($res->parent_id), $res->name, $res->modul, $res->url, $res->menu_order,
                                 $res->class_style, $res->id_style, $res->icon, $res->target, $stts
                             );
          }
            
        $this->output
         ->set_status_header(200)
         ->set_content_type('application/json', 'utf-8')
         ->set_output(json_encode($output, JSON_PRETTY_PRINT))
         ->_display();
         exit;  
        }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Configurationistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'menu_view';
        $data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['parent'] = $this->menu->combo();
        $data['modul'] = $this->component->combo();
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
        $this->table->set_heading('#','No', 'Parent', 'Name', 'Modul', 'Url', 'Order', 'Class', 'ID', 'Target', 'Status', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function add_process()
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
            $data['h2title'] = $this->modul['title'];
            $data['main_view'] = 'admin_view';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('tname', 'Password', 'required|callback_valid_name');
            $this->form_validation->set_rules('cparent', 'Parent Adminmenu', 'required');
            $this->form_validation->set_rules('cmodul', 'Modul', 'required');
            $this->form_validation->set_rules('turl', 'URL', 'required');
            $this->form_validation->set_rules('tmenuorder', 'Menu Order', 'required');
            $this->form_validation->set_rules('tclass', 'Class', '');
            $this->form_validation->set_rules('tid', 'ID', '');
            $this->form_validation->set_rules('ctarget', 'Target', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {//
                $users = array('username' => $this->input->post('tusername'),'password' => $this->input->post('tpassword'),'name' => $this->input->post('tname'),
                               'address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone'), 'city' => $this->input->post('ccity'),
                               'email' => $this->input->post('tmail'), 'yahooid' => setnull($this->input->post('tid')), 'role' => $this->input->post('crole'), 
                               'status' => $this->input->post('rstatus'));

                $this->Admin_model->add($users);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                echo 'true|Data successfully saved..!';
            }
            else
            {
    //            $this->load->view('template', $data);
    //            echo validation_errors();
                echo 'warning|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk mengupdate db
    function update_process($param=0)
    {
        if ($this->acl->otentikasi3($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Configurationistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action1'] = site_url($this->title.'/update_process/1');
        $data['form_action2'] = site_url($this->title.'/update_process/2');
        $data['form_action3'] = site_url($this->title.'/update_process/3');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        if ($param == 1)
        {
           $this->form_validation->set_rules('tname', 'Property', 'required|max_length[100]');
           $this->form_validation->set_rules('taddress', 'Address', 'required');
	   $this->form_validation->set_rules('tphone1', 'Phone1', 'required|max_length[15]');
           $this->form_validation->set_rules('tphone2', 'Phone2', 'required|max_length[15]');
           $this->form_validation->set_rules('tmail', 'Property Mail', 'required|valid_email|max_length[100]');
           $this->form_validation->set_rules('tbillmail', 'Billing Email', 'required|valid_email|max_length[100]');
           $this->form_validation->set_rules('ttechmail', 'Technical Email', 'required|valid_email|max_length[100]');
           $this->form_validation->set_rules('tccmail', 'CC Email', 'required|valid_email|max_length[100]');
	   $this->form_validation->set_rules('ccity', 'City', 'required|max_length[25]');
           $this->form_validation->set_rules('tzip', 'Zip Code', 'required|numeric|max_length[25]');
        }
        elseif ($param == 2)
        {
            $this->form_validation->set_rules('taccount_name', 'Account Name', 'required|max_length[100]');
            $this->form_validation->set_rules('taccount_no', 'Account No', 'required|max_length[100]');
            $this->form_validation->set_rules('tbank', 'Bank Name', 'required'); 
        }
        elseif ($param == 3)
        {
            $this->form_validation->set_rules('tsitename', 'Site Name', 'required');
            $this->form_validation->set_rules('tmetadesc', 'Global Meta Description', '');
            $this->form_validation->set_rules('tmetakey', 'Global Meta Keyword', ''); 
        }


        if ($this->form_validation->run($this) == TRUE)
        {
            if ($param == 1)
            {
                $property = array('name' => $this->input->post('tname'), 'address' => $this->input->post('taddress'),
                                  'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                                  'cc_email' => $this->input->post('tccmail'), 'email' => $this->input->post('tmail'),
                                  'billing_email' => $this->input->post('tbillmail'), 'technical_email' => $this->input->post('ttechmail'),
                                  'zip' => $this->input->post('tzip'),'city' => $this->input->post('ccity'));

                $this->Adminmenu_model->update(1, $property);
                echo "true|One $this->title has successfully updated..! ";
            }
            elseif ($param == 2)
            {
                $property = array( 'bank' => $this->input->post('tbank'), 'account_name' => $this->input->post('taccount_name'), 'account_no' => $this->input->post('taccount_no'));
                $this->Adminmenu_model->update(1, $property);
                echo "true|One $this->title has successfully updated..! ";
            }
            elseif ($param == 3){
            
               $config['upload_path']   = './images/property/';
               $config['allowed_types'] = 'gif|jpg|png';
               $config['overwrite']     = TRUE;
               $config['max_size']      = '15000';
               $config['max_width']     = '10000';
               $config['max_height']    = '10000';
               $config['remove_spaces'] = TRUE;

               $this->load->library('upload', $config); 
               
               if ( !$this->upload->do_upload("userfile")){
                   $data['error'] = $this->upload->display_errors();
                   $property = array('site_name' => $this->input->post('tsitename'), 'meta_description' => $this->input->post('tmetadesc'), 'meta_keyword' => $this->input->post('tmetakey'));
               }
               else{
                   $info = $this->upload->data();
                   $property = array('site_name' => $this->input->post('tsitename'), 'meta_description' => $this->input->post('tmetadesc'), 'meta_keyword' => $this->input->post('tmetakey'), 'logo' => $info['file_name']);
               }
               
               $this->Adminmenu_model->update(1, $property);
               if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
               else { echo "true|One $this->title has successfully updated..! "; }
            }
            
        } else{ echo 'error|'.validation_errors(); }
      }
      else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_img()
    {
        $img = $this->Adminmenu_model->get_by_id(1)->row();
        $img = $img->logo;
        if ($img){ $img = "./images/property/".$img; unlink("$img"); }
    }

}

?>