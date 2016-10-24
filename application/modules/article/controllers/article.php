<?php

class Article extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Article_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->lang = $this->load->library('language');
        $this->category = $this->load->library('article_category');

        $this->load->helper('ckeditor');
        $this->load->helper('editor');
        $this->load->helper('tebal');

    }
    
    private $properti, $modul, $title;
    private $lang, $category;
    
    function index()
    {
        $this->get_last_article();
    }
    
    function get_last_article()
    {
        $this->acl->otentikasi1($this->title);
        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'article_view';
	$data['form_action'] = site_url($this->title.'/search');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

        $data['language'] = $this->lang->combo_all();
        $data['category'] = $this->category->combo_all();
        
	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $articles = $this->Article_model->get_last_article($this->modul['limit'], $offset)->result(); // ambil data dari db
        $num_rows = $this->Article_model->count_all_num_rows(); // hitung jumlah baris
        
        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url($this->title.'/get_last_article');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination

//            -------------- table ------------------------------------------------------
            // library HTML table untuk membuat template table class zebra
            $tmpl = array('table_open' => '<table cellpadding="2" cellspacing="1" class="tablemaster table table-bordered">');
            
            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");
            
            //Set heading untuk table
            $heading = array('#','No', 'Category', '#', 'Title', 'Date', 'User', 'Action');
            $this->table->set_heading($heading);
            $i = 0 + $offset;
//            $this->table($heading,$articles,$i);

            foreach ($articles as $article)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $article->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, $article->category, $article->lang, $article->title, tgleng($article->dates), $article->user,
                    anchor($this->title.'/update/'.$article->id,'<span>update</span>',array('class' => 'edit', 'title' => '')).' '.
                    anchor($this->title.'/delete/'.$article->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
                );
            }
 
            // table di generate 
            $data['table'] = $this->table->generate();
                        //          fasilitas check all
            $js = "onClick='cekall($i)'";
            $sj = "onClick='uncekall($i)'";
            $data['radio1'] = form_radio('articleletter', 'accept1', FALSE, $js).'<span> Check </span>';
            $data['radio2'] = form_radio('articleletter', 'accept2', FALSE, $sj).'<span> Uncheck </span>';

//            -------------- table ------------------------------------------------------

        }
        else
        {
            $data['message'] = "Not found any $this->title of data!";
        }
	
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    function search()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Searching '.$this->modul['title'];
        $data['main_view'] = 'article_view';
	$data['form_action'] = site_url($this->title.'/search');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['language'] = $this->lang->combo_all();
        $data['category'] = $this->category->combo_all();

//         batas combo box

        $articles = $this->Article_model->search_article($this->input->post('ccategory'),$this->input->post('tdate'),$this->input->post('clang'))->result();

	$tmpl = array('table_open' => '<table cellpadding="2" cellspacing="1" class="tablemaster table table-bordered">');

	$this->table->set_template($tmpl);
	$this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $heading = array('#','No', 'Category', '#', 'Title', 'Date', 'User', 'Action');
        $this->table->set_heading($heading);
        $i = 0;

        foreach ($articles as $article)
        {
            $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $article->id,'checked'=> FALSE, 'style'=> 'margin:0px');
            $this->table->add_row
            (
                form_checkbox($datax), ++$i, $article->category, $article->lang, $article->title, tgleng($article->dates), $article->user,
                anchor($this->title.'/update/'.$article->id,'<span>update</span>',array('class' => 'edit', 'title' => '')).' '.
                anchor($this->title.'/delete/'.$article->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
            );
        }
        
        // table di generate
        $data['table'] = $this->table->generate();
                    //          fasilitas check all
        $js = "onClick='cekall($i)'";
        $sj = "onClick='uncekall($i)'";
        $data['radio1'] = form_radio('articleletter', 'accept1', FALSE, $js).'Check';
        $data['radio2'] = form_radio('articleletter', 'accept2', FALSE, $sj).'Uncheck';
       $this->load->view('template', $data);
    }

//     fungsi get article untuk set berita di menu

    function get_article()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['waktu'] = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';
        $data['h2_title'] = 'Article Details';
	$data['form_action'] = site_url('article/search_berita');
	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $data['options_lang'] = $this->lang->combo_all();
        $data['options_cat']  = $this->category->combo_all();

        $data['articles'] = $this->Article_model->get_last_article($this->modul['limit'], $offset)->result(); // ambil data dari db
        $num_rows = $this->Article_model->count_all_num_rows(); // hitung jumlah baris

        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url('article/get_article');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination
        }
        else
        {
            $data['message'] = "Not found any $this->title of data!";
        }

        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('article/get_article', $data);
    }

    function search_berita()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['waktu'] = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';
        $data['h2_title'] = 'Article Details';
	$data['form_action'] = site_url('article/search_berita');
        $data['link'] = array('link_back' => anchor('article/get_article','<span>back</span>', array('class' => 'back')));

        $data['options_lang'] = $this->lang->combo_all();
        $data['options_cat']  = $this->category->combo_all();

//         batas combo box

        $data['articles'] = $this->Article_model->search_article($this->input->post('ccategory'))->result();
        
        $this->load->view('article/get_article', $data);
    }

// batas set berita di menu
    
    function delete($uid)
    {
        $this->acl->otentikasi3($this->title);

        $img = $this->Article_model->get_article_by_id($uid)->row();
        $img = $img->image;
        if ($img){ $img = "./images/article/".$img; unlink("$img"); }

        $this->Article_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
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
            $img = $this->Article_model->get_article_by_id($cek[$i])->row();
            $img = $img->image;
            if ($img){ $img = "./images/article/".$img; unlink("$img"); }
            $this->Article_model->delete($cek[$i]);
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

    function add()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['language'] = $this->lang->combo();
        $data['category'] = $this->category->combo();
	$data['ckeditor'] = editor();

        $this->load->view('template', $data);
    }

    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['language'] = $this->lang->combo();
        $data['category'] = $this->category->combo();
	$data['ckeditor'] = editor();

        $this->form_validation->set_rules('ttitle', 'Article Title', 'required|maxlength[100]|callback_valid_title');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('clang', 'Language', 'required');
        $this->form_validation->set_rules('tpermalink', 'Permalink', 'required|maxlength[20]');
        $this->form_validation->set_rules('tdesc', 'Article Content', '');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/article/';
            $config['file_name'] = $this->input->post('ttitle');
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

                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('tpermalink')),
                'lang' => $this->input->post('clang'), 'image' => null, 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdate')), 'text' => $this->input->post('tdesc'));

            }
            else
            {
                $info = $this->upload->data();
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('tpermalink')),
                'lang' => $this->input->post('clang'), 'image' => $info['file_name'], 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdate')), 'text' => $this->input->post('tdesc'));
            }
            
            $this->Article_model->add($article);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title.'/add/');
        }
        else
        {
            $this->load->view('template', $data);
        }
    }

    function valid_title($val)
    {
        if ($this->Article_model->valid_title($val) == FALSE)
        {
            $this->form_validation->set_message('valid_title', $this->title.' registered');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function validating_title($val)
    {
	$id = $this->session->userdata('articleid');
	if ($this->Article_model->validating_title($val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_article', "This $this->title name is already registered!");
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
        $data['h2title'] = 'Update '.$this->modul['title'];
        $data['main_view'] = 'article_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['language'] = $this->lang->combo();
        $data['category'] = $this->category->combo();
	$data['ckeditor'] = editor();
        
        $article = $this->Article_model->get_article_by_id($uid)->row();
       
	$data['default']['category'] = $article->category_id;
        $data['default']['title'] = $article->title;
        $data['default']['date'] = $article->dates;
        $data['desc'] = $article->text;
        $data['default']['lang'] = $article->lang;
        $data['default']['coment'] = $article->comment;
        $data['default']['front'] = $article->front;
        $data['default']['permalink'] = $article->permalink;
        $data['default']['image'] = base_url()."images/article/".$article->image;
	
	$this->session->set_userdata('articleid', $article->id);
    
       $this->load->view('template', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Update '.$this->modul['title'];
        $data['main_view'] = 'article_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['language'] = $this->lang->combo();
        $data['category'] = $this->category->combo();
	$data['ckeditor'] = editor();
        
        $this->form_validation->set_rules('ttitle', 'Article Title', 'required||maxlength[100]|callback_validating_title');
        $this->form_validation->set_rules('clang', 'Language', 'required');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('tpermalink', 'Permalink', 'required');
        $this->form_validation->set_rules('tdate', 'Article Date', '');
        $this->form_validation->set_rules('tdesc', 'Article Content', '');
	
        if ($this->form_validation->run() == TRUE)
        {
            $config['upload_path'] = './images/article/';
            $config['file_name'] = $this->input->post('ttitle');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = TRUE;
            $config['max_size']	= '500';
            $config['max_width']  = '2000';
            $config['max_height']  = '2000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();

                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('tpermalink')),
                'lang' => $this->input->post('clang'), 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdate')), 'text' => $this->input->post('tdesc'));

            }
            else
            {
                $info = $this->upload->data();
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('tpermalink')),
                'lang' => $this->input->post('clang'), 'image' => $info['file_name'], 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdate')), 'text' => $this->input->post('tdesc'));
            }

            $this->Article_model->update($this->session->userdata('articleid'), $article);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title.'/update/'.$this->session->userdata('articleid'));
            $this->session->unset_userdata('articleid');
            
        }
        else { $this->load->view('template', $data); }
    }
    
}

?>