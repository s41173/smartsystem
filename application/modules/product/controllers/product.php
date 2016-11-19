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
    }

    private $properti, $modul, $title;
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
    
    function delete_all()
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
             $this->Product_model->delete($cek[$i]);
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
                $product = array('name' => strtolower($this->input->post('tname')),
                                  'sku' => $this->input->post('tsku'), 'model' => $this->input->post('tmodel'), 
                                  'currency' => $this->input->post('ccur'), 'category' => $this->input->post('ccategory'),
                                  'manufacture' => $this->input->post('cmanufacture'),
                                  'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                
                $product = array('name' => strtolower($this->input->post('tname')),
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
    
    function remove_img($id)
    {
        $img = $this->Product_model->get_by_id($id)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/component/".$img; unlink("$img"); }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $article = $this->Product_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $article->id);
        
        $data['default']['category'] = $article->category_id;
        $data['default']['language'] = $article->lang;
        $data['default']['title'] = $article->title;
        $data['default']['date'] = $article->dates;
        $data['default']['coment'] = $article->comment;
        $data['default']['front'] = $article->front;
        $data['default']['image'] = base_url().'images/article/'.$article->image;
        $data['default']['desc'] = $article->text;
        
        echo $article->title;
        
        $this->load->helper('editor');
        editor();
        
        $this->load->view('template', $data);
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
    function update_process()
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Productistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('ttitle', 'Product Title', 'required|maxlength[100]|callback_validating_modul');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('clang', 'Language', 'required');
        $this->form_validation->set_rules('tdates', 'Product Dates', 'required');
        $this->form_validation->set_rules('tdesc', 'Product Content', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path']   = './images/article/';
            $config['file_name']     = split_space($this->input->post('ttitle'));
            $config['allowed_types'] = 'png|jpg';
            $config['overwrite']     = TRUE;
            $config['max_size']	 = '10000';
            $config['max_width']     = '10000';
            $config['max_height']    = '10000';
            $config['remove_spaces'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if ( !$this->upload->do_upload("userfile"))
            {
                $data['error'] = $this->upload->display_errors();
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('ttitle')),
                'lang' => $this->input->post('clang'), 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdates')), 'time' => waktuindo(), 'text' => $this->input->post('tdesc'),
                'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('tpermalink')),
                'lang' => $this->input->post('clang'), 'image' => $info['file_name'], 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdates')), 'time' => waktuindo(), 'text' => $this->input->post('tdesc'),
                'created' => date('Y-m-d H:i:s'));
            }

	    $this->Product_model->update($this->session->userdata('langid'), $article);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('langid'));
          //  $this->session->unset_userdata('langid');
//             if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
//             else { echo 'true|Data successfully saved..!|'.base_url().'images/component/'.$info['file_name']; }

        }
        else{ $this->load->view('template', $data); echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

}

?>