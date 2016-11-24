<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontmenu extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Frontmenu_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

        $this->compo = $this->components->combo();
    }
    
    private $properti, $modul, $title;
    private $compo;

    private $atts1 = array(
	  'class'      => 'edit',
	  'title'      => '',
	  'width'      => '600',
	  'height'     => '500',
	  'scrollbars' => 'yes',
	  'status'     => 'yes',
	  'resizable'  => 'yes',
	  'screenx'    =>  '\'+((parseInt(screen.width) - 600)/2)+\'',
	  'screeny'    =>  '\'+((parseInt(screen.height) - 500)/2)+\'',
    );
    
    function index()
    { $this->get_last_frontmenu(); }
    
    function get_last_frontmenu()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'frontmenu_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

        $data['query_menu'] = $this->Frontmenu_model->get_frontmenu_name();

        $data['tombol'] = anchor_popup('article/get_article/', 'ARTICLE ID', $this->atts1);

	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        $frontmenus = $this->Frontmenu_model->get_last_frontmenu($this->modul['limit'], $offset)->result(); // ambil data dari db
        $num_rows = $this->Frontmenu_model->count_all_num_rows(); // hitung jumlah baris
        
        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url($this->title.'/get_last_frontmenu');
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
	    $this->table->set_heading('#','No', 'Parent', 'Position', 'Name', 'Type', 'Url', 'Order', 'Limit', 'Target', 'Action');
            $i = 0 + $offset;
            
            foreach ($frontmenus as $frontmenu)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $frontmenu->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, $this->parentname($frontmenu->parent_id), $frontmenu->position, $frontmenu->name, $frontmenu->type, $frontmenu->url, $frontmenu->menu_order, $frontmenu->limit, $frontmenu->target,
		    anchor($this->title.'/update/'.$frontmenu->id,'<span>update</span>',array('class' => 'update', 'title' => '')).' '.
                    anchor($this->title.'/delete/'.$frontmenu->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
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
           $menu = $this->Frontmenu_model->get_frontmenu_by_id($catid)->row();
           $val = $menu->name;
        }
        else
        {$val = "top";}
        return $val;
    }
        
    public function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        $this->cek_top_menu($uid);

        $img = $this->Frontmenu_model->get_frontmenu_by_id($uid)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/frontmenu/".$img; unlink("$img"); }

        $this->Frontmenu_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
    }

    private function cek_top_menu($id)
    {
        if( $id == 0 )
        {
          $this->session->set_flashdata('message', "root menu can't removed..!!"); 
          redirect($this->title);
        }
    }

    function delete_all()
    {
      $this->acl->otentikasi_admin($this->title);
      $cek = $this->input->post('cek');

      if($cek)
      {
        $jumlah = count($cek);
        for ($i=0; $i<$jumlah; $i++)
        {
            $this->cek_top_menu($cek[$i]);
            $img = $this->Frontmenu_model->get_frontmenu_by_id($cek[$i])->row();
            $img = $img->icon;
            if ($img){ $img = "./images/frontmenu/".$img; unlink("$img"); }
            $this->Frontmenu_model->delete($cek[$i]);
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
    
    function add_process()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'frontmenu_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['query_menu']  = $this->Frontmenu_model->get_frontmenu_name();
        $data['query_modul'] = $this->compo;
        $data['error']       = '';
        $data['tombol'] = anchor('news/get_news/', 'ARTICLE ID', array('class' => 'update'));
         
	$this->form_validation->set_rules('tname', 'Menu Name', 'required|callback_valid_name');
        $this->form_validation->set_rules('ctype', 'Menu Type', 'required');
        $this->form_validation->set_rules('cparent', 'Parent Menu', 'required');
        $this->form_validation->set_rules('rposition', 'Menu Position', 'required');
        $this->form_validation->set_rules('turl', 'URL', 'required');
        $this->form_validation->set_rules('tmenuorder', 'Menu Order', 'required');
        $this->form_validation->set_rules('tlimit', 'Limit', 'required');
        $this->form_validation->set_rules('tclass', 'Class', '');
        $this->form_validation->set_rules('tid', 'ID', '');
        $this->form_validation->set_rules('ctarget', 'Target', 'required');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path']   = './images/frontmenu/';
            $config['file_name']     = $this->input->post('tname');
            $config['allowed_types'] = 'png|jpg';
            $config['overwrite']     = TRUE;
            $config['max_size']	     = '150';
            $config['max_width']     = '200';
            $config['max_height']    = '200';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();

                $frontmenu = array('parent_id' => $this->input->post('cparent'), 'position' => $this->input->post('rposition'),
                                   'type' => $this->input->post('ctype'), 'name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                   'menu_order' => $this->input->post('tmenuorder'), 'limit' => $this->input->post('tlimit'),
                                   'class_style' => $this->input->post('tclass'), 'id_style' => $this->input->post('tid'), 'icon' => null,
                                   'target' => $this->input->post('ctarget'));

            }
            else
            {
                $info = $this->upload->data();
                $frontmenu = array('parent_id' => $this->input->post('cparent'), 'position' => $this->input->post('rposition'),
                                   'type' => $this->input->post('ctype'), 'name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                   'menu_order' => $this->input->post('tmenuorder'), 'limit' => $this->input->post('tlimit'),
                                   'class_style' => $this->input->post('tclass'), 'id_style' => $this->input->post('tid'), 'icon' => $info['file_name'],
                                   'target' => $this->input->post('ctarget'));
            }

            $this->Frontmenu_model->add($frontmenu);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title);
        }
        else { $this->load->view('template', $data); }
    }

    function valid_name($name)
    {
        $position = $this->input->post('rposition');
        if ($this->Frontmenu_model->valid_name($name,$position) == FALSE)
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
	$id = $this->session->userdata('fmid');
        $position = $this->input->post('rposition');

	if ($this->Frontmenu_model->validating_name($name, $position, $id) == FALSE)
        {
            $this->form_validation->set_message('validating_name', "This $this->title name is already registered!");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function update($uid)
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'frontmenu_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['query_menu']  = $this->Frontmenu_model->get_frontmenu_name();
        $data['query_modul'] = $this->compo;
        $data['error']       = '';
        $data['tombol'] = anchor_popup('article/get_article/', 'ARTICLE ID', $this->atts1);

        $frontmenu = $this->Frontmenu_model->get_frontmenu_by_id($uid)->row();

        $data['default']['parent'] = $frontmenu->parent_id;
	$data['default']['name'] = $frontmenu->name;
        $data['default']['type'] = $frontmenu->type;
        $data['default']['position'] = $frontmenu->position;
        $data['default']['url'] = $frontmenu->url;
        $data['default']['menuorder'] = $frontmenu->menu_order;
        $data['default']['class'] = $frontmenu->class_style;
        $data['default']['id'] = $frontmenu->id_style;
        $data['default']['limit'] = $frontmenu->limit;
        $data['default']['target'] = $frontmenu->target;

        $icon = isset($frontmenu->icon) ? $frontmenu->icon : 'default.png';
        $data['default']['image'] = base_url().'images/frontmenu/'.$icon;

	$this->session->set_userdata('fmid', $frontmenu->id);
    
       $this->load->view('frontmenu_update', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'frontmenu_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['query_menu']  = $this->Frontmenu_model->get_frontmenu_name();
        $data['query_modul'] = $this->compo;
        $data['error']       = '';
        $data['tombol'] = anchor('news/get_news/', 'ARTICLE ID', array('class' => 'update'));
        
	$this->form_validation->set_rules('tname', 'Menu Name', 'required|callback_validating_name');
        $this->form_validation->set_rules('ctype', 'Menu Type', 'required');
        $this->form_validation->set_rules('cparent', 'Parent Menu', '');
        $this->form_validation->set_rules('rposition', 'Menu Position', 'required');
        $this->form_validation->set_rules('turl', 'URL', 'required');
        $this->form_validation->set_rules('tmenuorder', 'Menu Order', 'required');
        $this->form_validation->set_rules('tlimit', 'Limit', 'required');
        $this->form_validation->set_rules('tclass', 'Class', '');
        $this->form_validation->set_rules('tid', 'ID', '');
        $this->form_validation->set_rules('ctarget', 'Target', 'required');
	
        if ($this->form_validation->run($this) == TRUE)
        {   
            $config['upload_path']   = './images/frontmenu/';
            $config['file_name']     = $this->input->post('tname');
            $config['allowed_types'] = 'png|jpg';
            $config['overwrite']     = TRUE;
            $config['max_size']	     = '150';
            $config['max_width']     = '200';
            $config['max_height']    = '200';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                $frontmenu = array('parent_id' => $this->cek_val($this->input->post('cparent')), 'position' => $this->input->post('rposition'),
                                   'type' => $this->input->post('ctype'), 'name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                   'menu_order' => $this->input->post('tmenuorder'), 'limit' => $this->input->post('tlimit'),
                                   'class_style' => $this->input->post('tclass'), 'id_style' => $this->input->post('tid'),'target' => $this->input->post('ctarget'));

            }
            else
            {
                $info = $this->upload->data();
                $frontmenu = array('parent_id' => $this->cek_val($this->input->post('cparent')), 'position' => $this->input->post('rposition'),
                                   'type' => $this->input->post('ctype'), 'name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                   'menu_order' => $this->input->post('tmenuorder'), 'limit' => $this->input->post('tlimit'),
                                   'class_style' => $this->input->post('tclass'), 'id_style' => $this->input->post('tid'), 'icon' => $info['file_name'],'target' => $this->input->post('ctarget'));
            }

            $this->Frontmenu_model->update($this->session->userdata('fmid'), $frontmenu);
            $this->session->set_flashdata('message', "One $this->title of data successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('fmid'));
            $this->session->unset_userdata('fmid');
        }
        else
        {
           $this->load->view('frontmenu_update', $data);
        }
    }

    private function cek_val($val) { if (!$val){ return '0'; }  else{ return $val; } }
    
}

?>