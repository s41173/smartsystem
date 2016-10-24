<?php

class Frontmenu_model extends CI_Model
{
    function __construct()
    {
         parent::__construct();
    }
    
    var $table = 'menu';
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_frontmenu($limit, $offset)
    {
        $this->db->select('id, parent_id, position, name, type, url, menu_order, limit, class_style, id_style, icon, target');
        $this->db->from($this->table); 
        $this->db->order_by('menu_order', 'asc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    // tarik data untuk combobox
    function get_frontmenu_name()
    {
        $this->db->order_by('name');
        $val = $this->db->get($this->table)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->name;}
        return $data;
    }

    function get_menu_condition($uid)
    {
        $this->db->where_not_in('id', $uid);
        $this->db->order_by('name');
        return $this->db->get($this->table);
    }
    
    function delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table); // perintah untuk delete data dari db
        $this->delete_submenu($uid);
    }

    function delete_submenu($uid)
    {
       $this->db->where('parent_id', $uid);
       $this->db->delete($this->table);
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
    }
    
    function get_frontmenu_by_id($uid)
    {
        $this->db->select('id, parent_id, position, name, type, url, menu_order, limit, default, class_style, id_style, icon, target');
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }
   
    function update($uid, $value)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $value);
    }

    function valid_name($name,$position)
    {
        $this->db->where('name', $name);
        $this->db->where('position', $position);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0)
        {
          return FALSE;
        }
        else
        {
          return TRUE;
        }
    }

    function validating_name($name, $position ,$id)
    {
        $this->db->where('name', $name);
        $this->db->where('position', $position);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0)
        {
           return FALSE;
        }
        else
        {
           return TRUE;
        }
    }

}

?>