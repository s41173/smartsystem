<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends Custom_Model
{
    private $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('log');
    }
    
    
    protected $table = 'log';
    protected $field = array('id', 'userid', 'date', 'time', 'component_id', 'activity', 
                             'created', 'updated', 'deleted'
                            );
    protected $com;
            
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_user($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->table); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function force_delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table);
        
      //  $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'forced_delete', $this->com);
    }
    
    function delete($uid)
    {
        $val = array('deleted' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->table, $val);
        
      //  $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'delete', $this->com);
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
        $this->logs->insert($this->session->userdata('userid'), date('Y-m-d'), waktuindo(), 'create', $this->com);
    }
    
    
    function get_user_by_id($uid)
    {
        $this->db->select($this->field);
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }

    function get_userid($name)
    {
        $this->db->select($this->field);
        $this->db->where('username', $name);
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
    
    function valid_name($uid)
    {
        $this->db->where('username', $uid);
        $query = $this->db->get($this->table)->num_rows();
                                        
        if($query > 0){ return FALSE; } else{ return TRUE; }
    }

    function validation_username($name ,$id)
    {
        $this->db->where('username', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0){ return FALSE; } else{ return TRUE; }
    }

}

?>