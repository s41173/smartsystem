<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    var $table = 'product';
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_product($limit, $offset)
    {
        $this->db->select('id, category, name, desc, shortdesc, price, image, url1, url2, url3, publish');
        $this->db->from($this->table); 
        $this->db->order_by('id', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }

    function search($cat=null, $name=null)
    {
        $this->db->select('id, category, name, desc, shortdesc, price, image, url1, url2, url3, publish');
        $this->db->from($this->table);
        $this->cek_null($cat,"category");
        $this->cek_null($name,"name");
        $this->db->order_by('id', 'asc');
        return $this->db->get();
    }

    private function cek_null($val,$field)
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
    
    function get_product_by_id($uid)
    {
        $this->db->select('id, category, name, desc, shortdesc, price, image, url1, url2, url3, publish');
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
    }
    
    function valid_product($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) { return FALSE; } else { return TRUE; }
    }

    function validating_product($name,$id)
    {
        $this->db->where('name', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) {  return FALSE; } else { return TRUE; }
    }

}

?>