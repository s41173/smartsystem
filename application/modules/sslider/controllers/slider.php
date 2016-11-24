<?php

class Slider extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Slider_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

    }
    
    private $properti, $modul, $title;
    private $lang, $category;
    
    function index()
    {
        $this->get_last_slider();
    }
    
    function get_last_slider()
    {
        $this->acl->otentikasi1($this->title);
        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'slider_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

        $sliders = $this->Slider_model->get_last_slider()->result();
       
        $tmpl = array('table_open' => '<table class="tablemaster table table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $heading = array('No', 'Name', 'Image', 'Url', 'Action');
        $this->table->set_heading($heading);
        $i = 0;

        foreach ($sliders as $slider)
        {
            $ip = array('src' => base_url().'images/slider/'.$slider->image, 'alt' => $slider->name, 'width' => '100');

            $this->table->add_row
            (
                ++$i, $slider->name, img($ip), $slider->url,
                anchor($this->title.'/delete/'.$slider->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
            );
        }

        // table di generate
        $data['table'] = $this->table->generate();
//            -------------- table ------------------------------------------------------
	$this->load->view('template', $data);
    }
    
    function delete($uid)
    {
        $this->acl->otentikasi3($this->title);

        $img = $this->Slider_model->get_slider_by_id($uid)->row();
        $img = $img->image;
        if ($img){ $img = "./images/slider/".$img; unlink("$img"); }

        $this->Slider_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
    }
    
    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'slider_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $this->form_validation->set_rules('tname', 'Title', 'required|maxlength[100]|callback_valid_name');
        $this->form_validation->set_rules('turl', 'Url', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/slider/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '500';
            $config['max_width']  = '2000';
            $config['max_height']  = '2000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();

                $slider = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'), 'image' => null);

            }
            else
            {
                $info = $this->upload->data();
                $slider = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'), 'image' => $info['file_name']);
            }
            
            $this->Slider_model->add($slider);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title);
        }
        else
        {
            $this->load->view('template', $data);
        }
    }

    function valid_name($val)
    {
        if ($this->Slider_model->valid_name($val) == FALSE)
        {
            $this->form_validation->set_message('valid_name', $this->title.' registered');
            return FALSE;
        }
        else {  return TRUE; }
    }

    function validating_name($val)
    {
	$id = $this->session->userdata('sliderid');
	if ($this->Slider_model->validating_name($val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_name', "This $this->title name is already registered!");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
}

?>