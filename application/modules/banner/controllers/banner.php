<?php

class Banner extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Banner_model', '', TRUE);
        
        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->menu = $this->load->library('frontmenu');
    }

    private $properti, $modul, $title, $menu;
    
    function index() { $this->get_last_banner(); }
    
    function get_last_banner()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'banner_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        $banners = $this->Banner_model->get_last_banner($this->modul['limit'], $offset)->result(); // ambil data dari db
        $num_rows = $this->Banner_model->count_all_num_rows(); // hitung jumlah baris

        $data['menu'] = $this->menu->combo();

        
        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url('banner/get_last_banner');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination
	    
            // library HTML table untuk membuat template table class zebra
            $tmpl = array( 'table_open' => '<table class="tablemaster table table-bordered">');
            
            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");
            
            //Set heading untuk table
	    $this->table->set_heading('No', 'Name', 'Position', 'Image', 'Size <sup>px</sup>', 'Publish', 'Action');
            
            $i = 0 + $offset;
            foreach ($banners as $banner)
            {
                $ip = array('src' => base_url().'images/banner/'.$banner->image, 'alt' => $banner->name, 'width' => '100', 'height' => '100');
                $this->table->add_row
                (
                    ++$i, $banner->name, $banner->position, img($ip), $banner->width.' x '.$banner->height, $this->publish($banner->active),
		    anchor('banner/update/'.$banner->id,'<span>update</span>',array('class' => 'update', 'title' => '')).' '.
                    anchor('banner/delete/'.$banner->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
                );
            }
            
            // table di generate 
            $data['table'] = $this->table->generate();
        }
        else
        {
            $data['message'] = "Not found any $this->title of data!";
        }
	
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    function publish($val)
    { if ($val == 0) {$val = "N";} else {$val = "Y";} return $val; }
    
    function delete($uid)
    {
        $this->acl->otentikasi3($this->title);

        $img = $this->Banner_model->get_banner_by_id($uid)->row();
        $img = $img->image;
        if ($img){ $img = "./images/banner/".$img; unlink("$img"); }

        $this->Banner_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
    }
    
    function add_process()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'banner_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['menu'] = $this->menu->combo();
         
        $this->form_validation->set_rules('tname', 'Banner Name', 'required||maxlength[100]|callback_valid_banner');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');
        $this->form_validation->set_rules('cposition', 'Status', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('turl', 'Url', 'required');
        $this->form_validation->set_rules('twidth', 'Width', 'required|numeric');
        $this->form_validation->set_rules('theight', 'Height', 'required|numeric');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/banner/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite']   = true;
            $config['max_size']	   = '500';
            $config['max_width']   = '2000';
            $config['max_height']  = '2000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();

                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'), 'image' => null,
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'active' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'),
                                'menu' => $this->split_array($this->input->post('cmenu')));
            }
            else
            {
                $info = $this->upload->data();
                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'), 'image' => $info['file_name'],
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'active' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'),
                                'menu' => $this->split_array($this->input->post('cmenu')));
            }
            
            $this->Banner_model->add($banner);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title);
        }
        else
        {
            $this->load->view('template', $data);
//            echo validation_errors();
        }
    }

    function split_array($val){ return implode(",",$val); }

    function valid_banner($val)
    {
        if ($this->Banner_model->valid_banner($val) == FALSE)
        {
            $this->form_validation->set_message('valid_banner', $this->title.' registered');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function validating_banner($val)
    {
	$id = $this->session->userdata('widid');
	if ($this->Banner_model->validating_banner($val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_banner', "This $this->title name is already registered!");
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

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'banner_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['menu'] = $this->menu->combo();
        
        $banner = $this->Banner_model->get_banner_by_id($uid)->row();

	$data['default']['name']     = $banner->name;
        $data['default']['position'] = $banner->position;
        $data['default']['url']      = $banner->url;
        $data['default']['publish']  = $banner->active;
        $data['default']['image']    = base_url().'images/banner/'.$banner->image;
        $data['default']['width']    = $banner->width;
        $data['default']['height']   = $banner->height;
        $data['valuemenu'] = explode(",", $banner->menu);
	
	$this->session->set_userdata('widid', $banner->id);
    
       $this->load->view('banner_update', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'banner_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['menu'] = $this->menu->combo();
        
        $this->form_validation->set_rules('tname', 'Banner Name', 'required||maxlength[50]|callback_validating_banner');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');
        $this->form_validation->set_rules('cposition', 'Status', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('turl', 'Url', 'required');
        $this->form_validation->set_rules('twidth', 'Width', 'required|numeric');
        $this->form_validation->set_rules('theight', 'Height', 'required|numeric');
	
        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/banner/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite']   = true;
            $config['max_size']	   = '500';
            $config['max_width']   = '2000';
            $config['max_height']  = '2000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();

                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'active' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'),
                                'menu' => $this->split_array($this->input->post('cmenu')));
            }
            else
            {
                $info = $this->upload->data();
                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'), 'image' => $info['file_name'],
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'active' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'),
                                'menu' => $this->split_array($this->input->post('cmenu')));
            }

            $this->Banner_model->update($this->session->userdata('widid'),$banner);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title.'/update/'.$this->session->userdata('widid'));
            $this->session->unset_userdata('widid');
        }
        else { $this->load->view('banner_update', $data); }
    }
    
}

?>