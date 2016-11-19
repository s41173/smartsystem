<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends Custom_Model
{
    private $logs;
    
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
                             'price', 'discount', 'qty', 'min_order', 'image', 'url1', 'url2', 'url3', 'url4', 'url5',
                             'dimension', 'dimension_class', 'weight', 'related', 'publish',
                             'created', 'updated', 'deleted');
    protected $com;
            
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
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
    
    function force_delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->tableName);
        
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'forced_delete', $this->com);
    }
    
    function delete($uid)
    {
        $val = array('deleted' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $val);
        
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'delete', $this->com);
    }
    
    function add($users)
    {
        $this->db->insert($this->tableName, $users);
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'create', $this->com);
    }
    
    
    function get_by_id($uid)
    {
        $this->db->select($this->field);
        $this->db->where('id', $uid);
        return $this->db->get($this->tableName);
    }

    function get_user()
    {
        $this->db->order_by('name', 'asc'); // query order
        return $this->db->get($this->tableName);
    }
    
    function counter()
    {
        $this->db->select_max('userid');
        return $this->db->get($this->tableName);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $users);
        
        $val = array('updated' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $val);
        
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'update', $this->com);
    }
    

}

?>