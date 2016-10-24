<?php

class Widget extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Widget_model', '', TRUE);
        
        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->menu = $this->load->library('frontmenu');
    }

    private $properti, $modul, $title, $menu;
    
    function index() { $this->get_last_widget(); }
    
    function get_last_widget()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'widget_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        $widgets = $this->Widget_model->get_last_widget($this->modul['limit'], $offset)->result(); // ambil data dari db
        $num_rows = $this->Widget_model->count_all_num_rows(); // hitung jumlah baris

        $data['menu'] = $this->menu->combo();

        
        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url('widget/get_last_widget');
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
	    $this->table->set_heading('#','No', 'Name', 'Title', 'Position', 'Order', 'More', 'Limit', 'Publish', 'Action');
            
            $i = 0 + $offset;
            foreach ($widgets as $widget)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $widget->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, $widget->name, ucwords($widget->title), $widget->position, $widget->order, $this->menu->getmenuname($widget->moremenu), $widget->limit, $this->publish($widget->publish),
		    anchor('widget/update/'.$widget->id,'<span>update</span>',array('class' => 'update', 'title' => '')).' '.
                    anchor('widget/delete/'.$widget->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
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

    function publish($val)
    { if ($val == 0) {$val = "N";} else {$val = "Y";} return $val; }
    
    function delete($uid)
    {
        otentikasi3($this->title);
        $this->Widget_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
    }

    function delete_all()
    {
      acl($this->title);
      $cek = $this->input->post('cek');

      if($cek)
      {
        $jumlah = count($cek);
        for ($i=0; $i<$jumlah; $i++)
        {  $this->Widget_model->delete($cek[$i]); }
        $this->session->set_flashdata('message', "$jumlah $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
      }
      else
      {
           $this->session->set_flashdata('message', "No $this->title Selected..!!"); // set flash data message dengan session
           redirect($this->title);
      }
    }
    
    function add_process()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'widget_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['menu'] = $this->menu->combo();
         
        $this->form_validation->set_rules('tname', 'Widget Name', 'required||maxlength[50]|callback_valid_widget');
        $this->form_validation->set_rules('ttitle', 'Title', '');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');
        $this->form_validation->set_rules('cposition', 'Status', 'required');
        $this->form_validation->set_rules('tmenuorder', 'Active', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('cmore', 'Readmore', 'required');
        $this->form_validation->set_rules('tlimit', 'Limit', 'required');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            $widget = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'), 'limit' => $this->input->post('tlimit'),
                            'publish' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'), 'moremenu' => $this->input->post('cmore'),
                            'order' => $this->input->post('tmenuorder'), 'menu' => $this->split_array($this->input->post('cmenu')));
            
            $this->Widget_model->add($widget);
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

    function split_array($val)
    {
      return implode(",",$val);
    }

    function valid_role($val)
    {
        if(!$val)
        {
          $this->form_validation->set_message('valid_role', "role type required.");
          return FALSE;
        }
        else
        {
          return TRUE;
        }
    }


    function valid_widget($val)
    {
        if ($this->Widget_model->valid_widget($val) == FALSE)
        {
            $this->form_validation->set_message('valid_widget', $this->title.' registered');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function validating_widget($val)
    {
	$id = $this->session->userdata('widid');
	if ($this->Widget_model->validating_widget($val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_widget', "This $this->title name is already registered!");
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
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'widget_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['menu'] = $this->menu->combo();
        
        $widget = $this->Widget_model->get_widget_by_id($uid)->row();

	$data['default']['name'] = $widget->name;
        $data['default']['title'] = $widget->title;
        $data['default']['position'] = $widget->position;
        $data['default']['publish'] = $widget->publish;
        $data['default']['menuorder'] = $widget->order;
        $data['default']['more'] = $widget->moremenu;
        $data['default']['limit'] = $widget->limit;
        $data['valuemenu'] = explode(",", $widget->menu);
	
	$this->session->set_userdata('widid', $widget->id);
    
       $this->load->view('widget_update', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'widget_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['menu'] = $this->menu->combo();
        
        $this->form_validation->set_rules('tname', 'Widget Name', 'required||maxlength[50]|callback_validating_widget');
        $this->form_validation->set_rules('ttitle', 'Title', '');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');
        $this->form_validation->set_rules('cposition', 'Status', 'required');
        $this->form_validation->set_rules('tmenuorder', 'Active', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('cmore', 'Readmore', 'required');
        $this->form_validation->set_rules('tlimit', 'Limit', 'required');
	
        if ($this->form_validation->run($this) == TRUE)
        {
            $widget = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'), 'limit' => $this->input->post('tlimit'),
                            'publish' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'), 
                            'moremenu' => $this->input->post('cmore'), 'order' => $this->input->post('tmenuorder'),
                            'menu' => $this->split_array($this->input->post('cmenu')));

            $this->Widget_model->update($this->session->userdata('widid'),$widget);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title.'/update/'.$this->session->userdata('widid'));
            $this->session->unset_userdata('widid');
        }
        else { $this->load->view('widget_update', $data); }
    }
    
}

?>