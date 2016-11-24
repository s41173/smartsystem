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
        $this->role = new Role_lib();
        $this->category = new Categoryproduct_lib();
        $this->manufacture = new Manufacture_lib();
        $this->attribute = new Attribute_lib();
        $this->attribute_product = new Attribute_product_lib();
        $this->attribute_list = new Attribute_list_lib();
        $this->currency = new Currency_lib();
        $this->product = new Product_lib();
    }

    private $properti, $modul, $title, $product;
    private $role, $category, $manufacture, $attribute, $attribute_product, $attribute_list, $currency;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null,$cat='null',$publish='null')
    {
        if(!$search){ $result = $this->Product_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Product_model->search($cat,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
	   $output[] = array ($res->id, $this->category->get_name($res->category), base_url().'images/product/'.$res->image, $res->sku, $res->name, $res->model,
                              idr_format($res->price), $res->qty, $res->publish, $res->category,
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

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Product Manager');
        $data['h2title'] = 'Product Manager';
        $data['main_view'] = 'product_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo_all();
        $data['manufacture'] = $this->manufacture->combo_all();
        $data['currency'] = $this->currency->combo();
        $data['array'] = array('','');
        
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
        $this->table->set_heading('#','No', 'Image', 'Category', 'SKU', 'Name', 'Model', 'Price', 'Qty', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Product_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Product_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function delete_all($type='soft')
    {
      if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
      
        $cek = $this->input->post('cek');
        $jumlah = count($cek);

        if($cek)
        {
          $jumlah = count($cek);
          $x = 0;
          for ($i=0; $i<$jumlah; $i++)
          {
             if ($type == 'soft') { $this->Product_model->delete($cek[$i]); }
             else { $this->remove_img($cek[$i],'force');
                    $this->attribute_product->force_delete_by_product($cek[$i]);
                    $this->Product_model->force_delete($cek[$i]);  }
             $x=$x+1;
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
      }else{ echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
      
    }

    function delete($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
            $this->Product_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function add()
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['currency'] = $this->currency->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tsku', 'SKU', 'required|callback_valid_sku');
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_name');
        $this->form_validation->set_rules('tmodel', 'Model', 'required|callback_valid_model');
        $this->form_validation->set_rules('ccur', 'Currency', 'required');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('cmanufacture', 'Manufacture', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/product/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $product = array('name' => strtolower($this->input->post('tname')), 'permalink' => split_space($this->input->post('tname')),
                                  'sku' => $this->input->post('tsku'), 'model' => $this->input->post('tmodel'), 
                                  'currency' => $this->input->post('ccur'), 'category' => $this->input->post('ccategory'),
                                  'manufacture' => $this->input->post('cmanufacture'),
                                  'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                
                $product = array('name' => strtolower($this->input->post('tname')), 'permalink' => split_space($this->input->post('tname')),
                                  'sku' => $this->input->post('tsku'), 'model' => $this->input->post('tmodel'), 
                                  'currency' => $this->input->post('ccur'), 'category' => $this->input->post('ccategory'),
                                  'manufacture' => $this->input->post('cmanufacture'),
                                  'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->Product_model->add($product);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/product/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    private function split_array($val)
    { return implode(",",$val); }
    
    function remove_img($id,$type='primary')
    {
        $img = $this->Product_model->get_by_id($id)->row();
        
        if ($type == 'primary'){
            $img = $img->image;
            if ($img){ $img = "./images/product/".$img; @unlink("$img"); }
        }else{
            $image = "./images/product/".$img->image; @unlink("$image");
            $img1 = "./images/product/".$img->url1; @unlink("$img1"); 
            $img2 = "./images/product/".$img->url2; @unlink("$img2");
            $img3 = "./images/product/".$img->url3; @unlink("$img3");
            $img4 = "./images/product/".$img->url4; @unlink("$img4");
            $img5 = "./images/product/".$img->url5; @unlink("$img5");
        }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'product_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['manufacture'] = $this->manufacture->combo();
        $data['category'] = $this->category->combo();
        $data['currency'] = $this->currency->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        $data['related'] = $this->product->combo_publish($uid);
        $data['array'] = array('','');
        
        $product = $this->Product_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $product->id);
        
        $data['default']['sku'] = $product->sku;
        $data['default']['category'] = $product->category;
        $data['default']['manufacture'] = $product->manufacture;
        $data['default']['name'] = $product->name;
        $data['default']['model'] = $product->model;
        $data['default']['permalink'] = $product->permalink;
        $data['default']['currency'] = $product->currency;
        $data['default']['description'] = $product->description;
        $data['default']['sdesc'] = $product->shortdesc;
        $data['default']['spec'] = $product->spesification;
        $data['default']['metatitle'] = $product->meta_title;
        $data['default']['metadesc'] = $product->meta_desc;
        $data['default']['metakeywords'] = $product->meta_keywords;
        $data['default']['price'] = $product->price;
        $data['default']['discount'] = $product->discount;
        $data['default']['qty'] = $product->qty;
        $data['default']['min'] = $product->min_order;
        $data['default']['image'] = base_url().'images/product/'.$product->image;
        $data['default']['dclass'] = $product->dimension_class;
        $data['default']['weight'] = $product->weight;
        $data['default']['disc_p'] = @intval($product->discount/$product->price*100);
        $data['default']['dimension'] = $product->dimension;
        
        if ($product->dimension)
        {
            $dimension = explode('x', $product->dimension);
            $data['default']['length'] = $dimension[0];
            $data['default']['width'] = $dimension[1];
            $data['default']['height'] = $dimension[2];
        }
        else{
            $data['default']['length'] = '';
            $data['default']['width'] = '';
            $data['default']['height'] = '';
        }

        if ($product->related){
            $related = explode(',', $product->related);
            $data['default']['related'] = $related;
        }
         
        $this->load->helper('editor');
        editor();
        $this->load->view('template', $data);
    }
    
    function image_gallery($pid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_image/'.$pid);
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $result = $this->Product_model->get_by_id($pid)->row();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No', 'Name', 'Image');
        
        for ($i=1; $i<=5; $i++)
        {   
            switch ($i) {
                case 1:$url = $result->url1; break;
                case 2:$url = $result->url2; break;
                case 3:$url = $result->url3; break;
                case 4:$url = $result->url4; break;
                case 5:$url = $result->url5; break;
            }
            
            if ($url){ if ($result->url_upload == 1){ $url = base_url().'images/product/'.$url; } }
            
            $image_properties = array('src' => $url, 'alt' => 'Image'.$i, 'class' => 'img_product', 'width' => '60', 'title' => 'Image'.$i,);
            $this->table->add_row
            (
               $i, 'Image'.$i, !empty($url) ? img($image_properties) : ''
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view('product_image', $data);
    }
    
    function valid_image($val)
    {
        if ($val == 0)
        {
            if (!$this->input->post('turl')){ $this->form_validation->set_message('valid_image','Image Url Required..!'); return FALSE; }
            else { return TRUE; }            
        }
    }
    
    function add_image($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Product Manager');
            $data['h2title'] = 'Product Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cname', 'Image Attribute', 'required|');
            $this->form_validation->set_rules('userfile', 'Image Value', '');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $result = $this->Product_model->get_by_id($pid)->row();
                if ($result->url_upload == 1)               
                {
                    switch ($this->input->post('cname')) {
                    case 1:$img = "./images/product/".$result->url1; break;
                    case 2:$img = "./images/product/".$result->url2; break;
                    case 3:$img = "./images/product/".$result->url3; break;
                    case 4:$img = "./images/product/".$result->url4; break;
                    case 5:$img = "./images/product/".$result->url5; break;
                  }
                  @unlink("$img"); 
                }
                
                    $config['upload_path'] = './images/product/';
                    $config['file_name'] = split_space($result->name.'_'.$this->input->post('cname'));
                    $config['allowed_types'] = 'jpg|gif|png';
                    $config['overwrite']  = true;
                    $config['max_size']   = '1000';
                    $config['max_width']  = '30000';
                    $config['max_height'] = '30000';
                    $config['remove_spaces'] = TRUE;

                    $this->load->library('upload', $config);
                    
                    if ( !$this->upload->do_upload("userfile")) // if upload failure
                    {
                        $attr = array('url'.$this->input->post('cname') => null, 'url_upload' => 1);
                    }
                    else {$info = $this->upload->data();
                         $attr = array('url'.$this->input->post('cname') => $info['file_name'], 'url_upload' => 1); 
                    } 
                
                $this->Product_model->update($pid, $attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function attribute($pid=null,$category=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_attribute/'.$pid);
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['attributes'] = $this->attribute->combo($category);  
        $result = $this->attribute_product->get_list($pid)->result();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No','Attribute', 'Value', '#');
        
        $i = 0;
        foreach ($result as $res)
        {
            $this->table->add_row
            (
                ++$i, $this->attribute_list->get_name($res->attribute_id), $res->value,
                anchor('#','<span>delete</span>',array('class'=> 'btn btn-danger btn-sm text-danger', 'id' => $res->id, 'title' => 'delete'))
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view('product_attribute', $data);
    }
    
    function add_attribute($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Product Manager');
            $data['h2title'] = 'Product Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cattribute', 'Attribute List', 'required|maxlength[100]|callback_valid_attribute['.$pid.']');
            $this->form_validation->set_rules('tvalue', 'Attribute Value', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $attr = array('product_id' => $pid, 'attribute_id' => $this->input->post('cattribute'), 'value' => $this->input->post('tvalue'));
                $this->attribute_product->add($attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function delete_attribute($id)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){
        $this->attribute_product->force_delete($id);
        echo 'true|Attribute Deleted..!';
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function valid_attribute($attr,$pid)
    {
        
        if($this->attribute_product->valid($attr, $pid) == FALSE)
        {
          $this->form_validation->set_message('valid_attribute', "Attribute Registered..!");
          return FALSE;
        }
        else{ return TRUE; }
    }

    function valid_role($val)
    {
        if(!$val)
        {
          $this->form_validation->set_message('valid_role', "role type required.");
          return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_sku($val)
    {
        if ($this->Product_model->valid('sku',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_sku','SKU registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_sku($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Product_model->validating('sku',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_sku', "SKU registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_name($val)
    {
        if ($this->Product_model->valid('name',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_name','Name registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_name($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Product_model->validating('name',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_name', "Name registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_model($val)
    {
        if ($this->Product_model->valid('model',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_model','Model registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_model($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Product_model->validating('model',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_model', "Model registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process($param=0)
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Productistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        if ($param == 1)
        {
            $this->form_validation->set_rules('tsku', 'SKU', 'required|callback_validating_sku');
            $this->form_validation->set_rules('ccategory', 'Category', 'required');
            $this->form_validation->set_rules('cmanufacture', 'Manufacture', 'required');
            $this->form_validation->set_rules('tname', 'Product Name', 'required|callback_validating_name');
            $this->form_validation->set_rules('tmodel', 'Product Model', 'required|callback_validating_model');
            $this->form_validation->set_rules('ccurrency', 'Currency', 'required');
            $this->form_validation->set_rules('tdesc', 'Description', '');
            $this->form_validation->set_rules('tshortdesc', 'Short Description', '');
            
            if ($this->form_validation->run($this) == TRUE)
            {
                // start update 1
                $config['upload_path'] = './images/product/';
                $config['file_name'] = split_space($this->input->post('tname'));
                $config['allowed_types'] = 'jpg|gif|png';
                $config['overwrite'] = true;
                $config['max_size']	= '10000';
                $config['max_width']  = '30000';
                $config['max_height']  = '30000';
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);

                if ( !$this->upload->do_upload("userfile")) // if upload failure
                {
                    $info['file_name'] = null;
                    $data['error'] = $this->upload->display_errors();
                    $product = array('name' => strtolower($this->input->post('tname')), 'permalink' => split_space($this->input->post('tname')),
                                     'sku' => $this->input->post('tsku'), 'model' => $this->input->post('tmodel'), 
                                     'currency' => $this->input->post('ccurrency'), 'category' => $this->input->post('ccategory'),
                                     'manufacture' => $this->input->post('cmanufacture'), 'shortdesc' => $this->input->post('tshortdesc'),
                                     'description' => $this->input->post('tdesc'));
                }
                else
                {
                    $info = $this->upload->data();

                    $product = array('name' => strtolower($this->input->post('tname')), 'permalink' => split_space($this->input->post('tname')),
                                      'sku' => $this->input->post('tsku'), 'model' => $this->input->post('tmodel'), 
                                      'currency' => $this->input->post('ccurrency'), 'category' => $this->input->post('ccategory'),
                                      'manufacture' => $this->input->post('cmanufacture'), 'shortdesc' => $this->input->post('tshortdesc'),
                                      'description' => $this->input->post('tdesc'),
                                      'image' => $info['file_name']);
                }
                
                $this->Product_model->update($this->session->userdata('langid'), $product);
                $this->session->set_flashdata('message', "One $this->title has successfully updated!");
                redirect($this->title.'/update/'.$this->session->userdata('langid'));
                
                // end update 1
            }
            else{ $this->session->set_flashdata('message', validation_errors());
                  redirect($this->title.'/update/'.$this->session->userdata('langid'));
                }
        }
        elseif ($param == 2)
        {
            $product = array('meta_title' => $this->input->post('tmetatitle'), 'meta_desc' => $this->input->post('tmetadesc'),
                             'meta_keywords' => $this->input->post('tmetakeywords'), 'spesification' => $this->input->post('tspec')
                             );
            $this->Product_model->update($this->session->userdata('langid'), $product);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('langid'));
        }
        elseif ($param == 3)
        {
            $this->form_validation->set_rules('tprice', 'Price', 'required|numeric');
            $this->form_validation->set_rules('tdisc_p', 'Discount Percentage', 'numeric');
            $this->form_validation->set_rules('tdiscount', 'Discount', 'required|numeric');
            $this->form_validation->set_rules('tmin', 'Minimum Order', 'required|numeric');
            
            $product = array('price' => $this->input->post('tprice'), 'discount' => $this->input->post('tdiscount'),
                             'min_order' => $this->input->post('tmin')
                             );
            $this->Product_model->update($this->session->userdata('langid'), $product);
            echo 'true|One '.$this->title.' price and qty has successfully updated!';
        }
        elseif ($param == 4)
        {
            $this->form_validation->set_rules('tlength', 'Length (Dimension)', 'numeric');
            $this->form_validation->set_rules('twidth', 'Width (Dimension)', 'numeric');
            $this->form_validation->set_rules('theight', 'Height (Dimension)', 'numeric');
            $this->form_validation->set_rules('cdimension', 'Dimension Class', '');
            $this->form_validation->set_rules('tweight', 'Weight', 'numeric');
            
            $dimension = $this->input->post('tlength').'x'.$this->input->post('twidth').'x'.$this->input->post('theight');
            $product = array('dimension' => $dimension, 'dimension_class' => $this->input->post('cdimension'),
                             'weight' => $this->input->post('tweight'), 'related' => !empty($this->input->post('crelated')) ? split_array($this->input->post('crelated')) : null
                             );
            $this->Product_model->update($this->session->userdata('langid'), $product);
            echo 'true|One '.$this->title.' dimension has successfully updated!';
        }

        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
   

}

?>