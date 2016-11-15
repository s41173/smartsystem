<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends Custom_Model
{
    private $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('article');
    }
    
    
    protected $table = 'article';
    protected $field = array('id', 'category_id', 'user', 'lang', 'permalink', 'title', 'text', 'image', 'dates', 'time', 'counter', 
                             'comment', 'front', 'publish', 'created', 'updated', 'deleted');
    protected $com;
            
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->table); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('dates', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function search($cat=null,$lang=null,$publish=null,$dates=null)
    {
        if ($dates != 'null'){
          $start = picker_between_split($dates, 0);
          $end = picker_between_split($dates, 1);
        }
        else { $start = null; $end=null; }
        
        $this->db->select($this->field);
        $this->db->from($this->table); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($lang, 'lang');
        $this->cek_null_string($publish, 'publish');
        $this->between('dates', $start, $end);
        
        $this->db->order_by('dates', 'asc'); 
        return $this->db->get(); 
    }
    
    function force_delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table);
        
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'forced_delete', $this->com);
    }
    
    function delete($uid)
    {
        $val = array('deleted' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->table, $val);
        
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'delete', $this->com);
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'create', $this->com);
    }
    
    
    function get_by_id($uid)
    {
        $this->db->select($this->field);
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }

    function get_user()
    {
        $this->db->order_by('name', 'asc'); // query order
        return $this->db->get($this->table);
    }
    
    function counter()
    {
        $this->db->select_max('userid');
        return $this->db->get($this->table);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
        
        $val = array('updated' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->table, $val);
        
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'update', $this->com);
    }
    
    function valid_modul($name)
    {
        $this->db->where('title', $name);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0){ return FALSE; }
        else{ return TRUE; }
    }

    function validating_modul($name,$id)
    {
        $this->db->where('title', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0){ return FALSE; }
        else{ return TRUE;}
    }

}

?>