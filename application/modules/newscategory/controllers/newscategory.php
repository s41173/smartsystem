<?php

class Newscategory extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Newscategory_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
    }
    
    private $properti, $modul, $title;
    
    function index()
    { $this->get_last_category(); }
    
    function get_last_category()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'newscategory_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

        $data['category'] = $this->Newscategory_model->get_category_name();

	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        $categorys = $this->Newscategory_model->get_last_category($this->modul['limit'], $offset)->result(); // ambil data dari db
        $num_rows = $this->Newscategory_model->count_all_num_rows(); // hitung jumlah baris

        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url($this->title.'/get_last_category');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination
	    
            // library HTML table untuk membuat template table class zebra
            $tmpl = array('table_open' => '<table cellpadding="2" cellspacing="1" class="tablemaster table table-bordered">');
            
            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");
            
            //Set heading untuk table
	    $this->table->set_heading('#','No', 'Name', 'Parent', 'Desc', 'Action');
            
            $i = 0 + $offset;
            foreach ($categorys as $category)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $category->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, $category->name, $this->parentname($category->parent_id), $category->desc,
		    anchor($this->title.'/update/'.$category->id,'<span>update</span>',array('class' => 'update', 'title' => '')).' '.
                    anchor($this->title.'/delete/'.$category->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
                );
            }
            
            // table di generate 
            $data['table'] = $this->table->generate();
            //          fasilitas check all
            $js = "onClick='cekall($i)'";
            $sj = "onClick='uncekall($i)'";
            $data['radio1'] = form_radio('newsletter', 'accept1', FALSE, $js).'Check';
            $data['radio2'] = form_radio('newsletter', 'accept2', FALSE, $sj).'Uncheck';
        }
        else
        {
            $data['message'] = "Not found any $this->title of data!";
        }
	
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    private function parentname($catid)
    {
        if ($catid != 0)
        {
           $category = $this->Newscategory_model->get_category_by_id($catid)->row();
           $val = $category->name;
        }
        else
        {$val = "top";}
        return $val;
    }

    function delete_all()
    {
      $this->acl->otentikasi3($this->title);
      $cek = $this->input->post('cek');

      if($cek)
      {
        $jumlah = count($cek);
        for ($i=0; $i<$jumlah; $i++)
        {
            $this->cek_top_menu($cek[$i]);
            $this->Newscategory_model->delete($cek[$i]);
//            $this->News_model->delete_based_category($cek[$i]);
        }
        $this->session->set_flashdata('message', "$jumlah $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
      }
      else
      {
           $this->session->set_flashdata('message', "No $this->title Selected..!!"); // set flash data message dengan session
           redirect($this->title);
      }
    }
    
    function delete($uid)
    {
        $this->acl->otentikasi3($this->title);
        $this->cek_top_menu($uid);
        $this->Newscategory_model->delete($uid); // memanggil model untuk mendelete data
//        $this->News_model->delete_based_category($uid);
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
    }
    
    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'newscategory_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['category'] = $this->Newscategory_model->get_category_name();
         
	$this->form_validation->set_rules('tname', 'Category Name', 'required|callback_valid_name');
        $this->form_validation->set_rules('cparent', 'Parent Newscategory', 'required');
        $this->form_validation->set_rules('tdesc', 'Description', '');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            $category = array('name' => $this->input->post('tname'), 'parent_id' => $this->input->post('cparent'),'desc' => $this->input->post('tdesc'));

            $this->Newscategory_model->add($category);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
//            redirect($this->title);
            echo "true";
        }
        else
        {
//            $this->load->view('template', $data);
            echo validation_errors();
        }
    }

    private function cek_top_menu($id)
    {
        if( $id == 0 )
        {
          $this->session->set_flashdata('message', "root menu can't removed..!!");
          redirect($this->title);
        }
    }

    function valid_name($name)
    {
        if ($this->Newscategory_model->valid_name($name) == FALSE)
        {
            $this->form_validation->set_message('valid_name', $this->title.' name registered');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function validating_name($name)
    {
	$id = $this->session->userdata('cnid');
	if ($this->Newscategory_model->validating_name($name,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_name', "This $this->title name is already registered!");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid)
    {
        $this->acl->otentikasi2($this->title);
        $this->cek_top_menu($uid);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'newscategory_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['category'] = $this->Newscategory_model->get_category_condition($uid);
        
        $category = $this->Newscategory_model->get_category_by_id($uid)->row();
        
        $data['default']['parent'] = $category->parent_id;
	$data['default']['name'] = $category->name;
        $data['default']['desc'] = $category->desc;
	
	$this->session->set_userdata('cnid', $category->id);
    
       $this->load->view('newscategory_update', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'newscategory_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['category'] = $this->Newscategory_model->get_category_condition($this->session->userdata('cnid'));
        
	$this->form_validation->set_rules('tname', 'Password', 'required|callback_validating_name');
        $this->form_validation->set_rules('cparent', 'Parent Newscategory', 'required');
        $this->form_validation->set_rules('tdesc', 'Description', '');
	
        if ($this->form_validation->run() == TRUE)
        {   
            $category = array('name' => $this->input->post('tname'), 'parent_id' => $this->input->post('cparent'),'desc' => $this->input->post('tdesc'));
            $this->Newscategory_model->update($this->session->userdata('cnid'), $category);
            $this->session->set_flashdata('message', "One $this->title of data successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('cnid'));
            $this->session->unset_userdata('cnid');
        }
        else
        {
           $this->load->view('template', $data);
        }
    }
    
}

?>