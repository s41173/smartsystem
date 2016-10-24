<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Product_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

        $this->category = $this->load->library('categoryproduct');
        $this->progallery = $this->load->library('progallery');
        $this->prodesc = $this->load->library('prodesc');

        $this->load->helper('ckeditor');
        $this->load->helper('editor');
    }

    private $properti, $modul, $title;
    private $category,$progallery,$prodesc;

    function index()
    { $this->get_last_product(); }


    function get_last_product()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_view';
	$data['form_action'] = site_url($this->title.'/search');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main','Back', array('class' => 'btn btn-danger')));
        $data['category'] = $this->category->combo_all();
        
	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

	// ---------------------------------------- //
        $products = $this->Product_model->get_last_product($this->modul['limit'], $offset)->result();
        $num_rows = $this->Product_model->count_all_num_rows();

        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url($this->title.'/get_last_product');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination

            // library HTML table untuk membuat template table class zebra
            $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");

            //Set heading untuk table
            $this->table->set_heading('#','No', 'Code', 'Category', 'Name / Model', 'Price', 'Action');

            $i = 0 + $offset;
            foreach ($products as $product)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $product->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, 'PRO-0'.$product->id, $this->category->get_name($product->category), $product->name, number_format($product->price),
                    anchor('#'.$product->id,'<i class="fa fa-file-text-o"></i>',array('class' => 'text-desc', 'data-id' => $product->id, 'title' => 'description')).' '.     
                    anchor('progallery/get_gallery/'.$product->id,'<i class="fa fa-picture-o"></i>',array('class' => 'text-primary', 'data-id' => $product->id, 'title' => 'gallery')).' &nbsp; '.    
                    anchor('#','<i class="fa fas-2x fa-edit"></i>',array('class' => 'text-primary', 'data-id' => $product->id, 'title' => '')).'  '.
                    anchor('#','<i class="fa fa-trash fa-s2x"></i>',array('class'=> 'text-danger', 'id' => $product->id, 'title' => 'delete' ,'onclick'=>""))
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

    function search()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Find '.$this->modul['title'];
        $data['main_view'] = 'product_view';
	$data['form_action'] = site_url($this->title.'/search');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo_all();

	// ---------------------------------------- //
        $products = $this->Product_model->search($this->input->post('ccategory'),$this->input->post('tsearch'))->result();

        $tmpl = array('table_open' => '<table class="tablemaster table table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Code', 'Category', 'Name / Model', 'Price', 'Action');

        $i = 0;
        foreach ($products as $product)
        {
            $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $product->id,'checked'=> FALSE, 'style'=> 'margin:0px');

            $this->table->add_row
            (
                form_checkbox($datax), ++$i, 'PRO-0'.$product->id, $this->category->get_name($product->category), $product->name, number_format($product->price),
                anchor($this->title.'/update/'.$product->id,'<span>details</span>',array('class' => 'update', 'title' => '')).' '.
                anchor($this->title.'/delete/'.$product->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
            );
        }

        $data['table'] = $this->table->generate();
        //          fasilitas check all
            $js = "onClick='cekall($i)'";
            $sj = "onClick='uncekall($i)'";
            $data['radio1'] = form_radio('newsletter', 'accept1', FALSE, $js).'Check';
            $data['radio2'] = form_radio('newsletter', 'accept2', FALSE, $sj).'Uncheck';
            
	$this->load->view('template', $data);
    }

    function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        $product = $this->Product_model->get_product_by_id($uid)->row();

        $img = $product->image;
        if ($img){ $img = "./images/product/".$img; unlink("$img"); }

        $this->progallery->delete_by_product($uid);
        $this->prodesc->delete_by_product($uid);

        $this->Product_model->delete($uid);
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
        redirect($this->title);
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
           $product = $this->Product_model->get_product_by_id($cek[$i])->row();
           $img = $product->image;
           if ($img){ $img = "./images/product/".$img; unlink("$img"); }

           $this->prodesc->delete_by_product($cek[$i]);
           $this->progalley->delete_by_product($cek[$i]);
           $this->Product_model->delete($cek[$i]);
           $this->session->set_flashdata('message', "$jumlah $this->title successfully removed..!!");
        }
      }
      else
      { $this->session->set_flashdata('message', "No $this->title Selected..!!"); }
      redirect($this->title);
    }

    private function cek_relation($id)
    {
        $name = $this->Product_model->get_product_by_id($id)->row();
        
        $in = $this->purchase_item->cek_relation($name->name, 'name');
        $out = $this->stock_out_item->cek_relation($id, $this->title);
        if ($in == TRUE && $out == TRUE) { return TRUE; } else { return FALSE; }
    }

    function add()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['category'] = $this->category->combo();
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));
//        $data['ckeditor'] = editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_form';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('product','Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo();

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_product');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('tdesc', 'Description', 'required');
        $this->form_validation->set_rules('tshortdesc', 'Short Description', 'required');
        $this->form_validation->set_rules('tprice', 'Price', 'required|numeric');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/product/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '3000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                
                $product = array('name' => $this->input->post('tname'), 'category' => $this->input->post('ccategory'),
                            'desc' => $this->input->post('tdesc'), 'shortdesc' => $this->input->post('tshortdesc'), 'price' => $this->input->post('tprice'),
                            'publish' => $this->input->post('rpublish'), 'url1' => $this->input->post('turl1'),
                            'url2' => $this->input->post('turl2'), 'url3' => $this->input->post('turl3'), 'image' => null
                           );
            }
            else
            {
                $info = $this->upload->data();
                $product = array('name' => $this->input->post('tname'), 'category' => $this->input->post('ccategory'),
                            'desc' => $this->input->post('tdesc'), 'shortdesc' => $this->input->post('tshortdesc'), 'price' => $this->input->post('tprice'),
                            'publish' => $this->input->post('rpublish'), 'url1' => $this->input->post('turl1'),
                            'url2' => $this->input->post('turl2'), 'url3' => $this->input->post('turl3'), 'image' => $info['file_name']
                           );
            }
            
            $this->Product_model->add($product);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            
//            if ($info['file_name'])
//            {
//              $img = base_url().'images/product/'.$info['file_name'];
//              echo "success|<img width='200' src='$img' />";
//            }
//            else { echo 'success|<p style="color:#FD080C; font-size:12px; font-weight:bold;"> '.$this->title.' Successfully Saved...! </p>'; }
            
            redirect($this->title.'/add/');
        }
        else
        {
//            echo 'invalid';
            $data['error'] =  validation_errors();
            $this->load->view('template', $data);
//            echo 'invalid|'.validation_errors();
        }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid)
    {
        $this->acl->otentikasi3($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

        $data['category'] = $this->category->combo();
        $data['ckeditor'] = editor();

        $product = $this->Product_model->get_product_by_id($uid)->row();

        $data['default']['category'] = $product->category;
        $data['default']['name'] = $product->name;
        $data['default']['desc'] = $product->desc;
        $data['default']['shortdesc'] = $product->shortdesc;
        $data['default']['image'] = base_url().'images/product/'.$product->image;
        $data['default']['price'] = $product->price;
        $data['default']['publish'] = $product->publish;
        $data['default']['url1'] = $product->url1;
        $data['default']['url2'] = $product->url2;
        $data['default']['url3'] = $product->url3;

	$this->session->set_userdata('curid', $product->id);
        $this->load->view('product_update', $data);
    }


    public function valid_product($name)
    {
        if ($this->Product_model->valid_product($name) == FALSE)
        {
            $this->form_validation->set_message('valid_product', "This $this->title is already registered.!");
            return FALSE;
        }
        else { return TRUE; }
    }

    function validation_product($name)
    {
	$id = $this->session->userdata('curid');
	if ($this->Product_model->validating_product($name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_product', 'This product is already registered!');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi3($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('product/','<span>back</span>', array('class' => 'back')));

        $data['category'] = $this->category->combo();
        $data['ckeditor'] = editor();

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_validation_product');
        $this->form_validation->set_rules('ccategory', 'Category Person', 'required');
        $this->form_validation->set_rules('tdesc', 'Description', 'required');
        $this->form_validation->set_rules('tshortdesc', 'Short Description', 'required');
        $this->form_validation->set_rules('tprice', 'Price', 'required|numeric');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/product/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '300';
            $config['max_width']  = '3000';
            $config['max_height']  = '3000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();

                $product = array('name' => $this->input->post('tname'), 'category' => $this->input->post('ccategory'),
                            'desc' => $this->input->post('tdesc'), 'shortdesc' => $this->input->post('tshortdesc'), 
                            'price' => $this->input->post('tprice'), 'publish' => $this->input->post('rpublish'), 'url1' => $this->input->post('turl1'),
                            'url2' => $this->input->post('turl2'), 'url3' => $this->input->post('turl3')
                           );
            }
            else
            {
                $info = $this->upload->data();
                $product = array('name' => $this->input->post('tname'), 'category' => $this->input->post('ccategory'),
                            'desc' => $this->input->post('tdesc'), 'shortdesc' => $this->input->post('tshortdesc'), 
                            'price' => $this->input->post('tprice'), 'publish' => $this->input->post('rpublish'),
                            'url1' => $this->input->post('turl1'),
                            'url2' => $this->input->post('turl2'), 'url3' => $this->input->post('turl3'), 'image' => $info['file_name']
                           );
            }

	    $this->Product_model->update($this->session->userdata('curid'), $product);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            redirect($this->title.'/update/'.$this->session->userdata('curid'));
        }
        else
        { $this->load->view('product_update', $data); }
    }

}

?>