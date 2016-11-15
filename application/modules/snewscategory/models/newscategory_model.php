<?php

class Newscategory_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    var $table = 'news_category';
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_category($limit, $offset)
    {
        $this->db->select('id, parent_id, name, desc');
        $this->db->from($this->table);
        $this->db->order_by('name', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    // tarik data untuk combobox
    function get_category_name()
    {
        $this->db->select('id, name');
        $val = $this->db->get($this->table)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->name;}
        return $data;
    }

    function get_category_condition($uid)
    {
        $this->db->where_not_in('id', $uid);
        $this->db->order_by('name');
        $val = $this->db->get($this->table)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->name;}

        if ($data)
        {return $data; } else { return null; }

//        return $data;
    }
    
    function delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table); // perintah untuk delete data dari db
        $this->delete_category($uid);
    }

    function delete_category($uid)
    {
       $this->db->where('parent_id', $uid);
       $this->db->delete($this->table);
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
    }
    
    function get_category_by_id($uid)
    {
        $this->db->select('id, parent_id, name, desc'); // select kolom yang mau di tampilkan
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }
   
    function update($uid, $value)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $value);
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
        if($query > 0){ return FALSE; } else { return TRUE; }
    }
}

?>