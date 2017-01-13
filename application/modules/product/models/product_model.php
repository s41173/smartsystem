<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('product');
        $this->tableName = 'product';
    }
    
    protected $field = array('id', 'sku', 'category', 'manufacture', 'name', 'model', 'permalink', 'currency',
                             'description', 'shortdesc', 'spesification', 'meta_title', 'meta_desc', 'meta_keywords',
                             'price', 'discount', 'qty', 'min_order', 'image', 'url_upload', 'url1', 'url2', 'url3', 'url4', 'url5',
                             'dimension', 'dimension_class', 'weight', 'related', 'publish',
                             'created', 'updated', 'deleted');
    protected $com;
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function search($cat=null,$publish=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($cat, 'category');
        $this->cek_null_string($publish, 'publish');
        
        $this->db->order_by('name', 'asc'); 
        return $this->db->get(); 
    }
    
    function report($cat=null,$manufacture=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null($cat, 'category');
        $this->cek_null($manufacture, 'manufacture');
        
        $this->db->order_by('name', 'asc'); 
        return $this->db->get(); 
    }

}

?>