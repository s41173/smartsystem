<?php

class Slider_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    var $table = 'slider';
    
    
    function get_last_slider()
    {
        $this->db->select('id, name, image, url');
        $this->db->from($this->table); // from table dengan join nya
        $this->db->order_by('id', 'desc');
        return $this->db->get(); // mengembalikan isi dari db
    }

    function cek_null($val,$field)
    {
        if ($val == ""){return null;}
        else {return $this->db->where($field, $val);}
    }
    
    function delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table); // perintah untuk delete data dari db
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
    }
    
    function get_slider_by_id($uid)
    {
        $this->db->select('id, name, image, url');
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
    }
    
    function valid_name($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) { return FALSE; } else { return TRUE; }
    }

    function validating_name($name,$id)
    {
        $this->db->where('name', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) { return FALSE; } else { return TRUE; }
    }

}

?>