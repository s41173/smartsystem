<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'product';
    }

    protected $field = array('id', 'sku', 'category', 'manufacture', 'name', 'model', 'permalink', 'currency',
                             'description', 'shortdesc', 'spesification', 'meta_title', 'meta_desc', 'meta_keywords',
                             'price', 'discount', 'qty', 'min_order', 'image', 'url_upload', 'url1', 'url2', 'url3', 'url4', 'url5',
                             'dimension', 'dimension_class', 'weight', 'related', 'publish',
                             'created', 'updated', 'deleted');

    function cek_relation($id,$type)
    {
       $this->db->where($type, $id);
       $query = $this->db->get('product')->num_rows();
       if ($query > 0) { return FALSE; } else { return TRUE; }
    }

    function add_qty($name=null,$amount_qty=null)
    {
        $this->db->where('name', $name);
        $qty = $this->db->get('product')->row();
        $qty = $qty->qty;
        $qty = $qty + $amount_qty;

        $res = array('qty' => $qty);
        $this->db->where('name', $name);
        $this->db->update('product', $res);
    }

    function min_qty($name=null,$amount_qty=null)
    {
        $this->db->where('name', $name);
        $qty = $this->db->get('product')->row();
        $qty = $qty->qty;
        $qty = $qty - $amount_qty;

        $res = array('qty' => $qty);
        $this->db->where('name', $name);
        $this->db->update('product', $res);
    }

    function edit_price($name=null,$price=0)
    {
        $this->db->where('name', $name);
        $val = $this->db->get('product')->row();

        $res = array('price' => $price);
        $this->db->where('name', $name);
        $this->db->update('product', $res);
    }

    function valid_qty($pid,$qty)
    {
       $this->db->select('id, name, qty');
       $this->db->where('id', $pid);
       $res = $this->db->get('product')->row();
       if ($res->qty - $qty < 0){ return FALSE; } else { return TRUE; }
    }

    function get_details($name=null)
    {
        if ($name)
        {
           $this->db->select('id, name, qty');
           $this->db->where('name', $name);
           return $this->db->get('product')->row();
        }
    }

    function get_id($name=null)
    {
        if ($name)
        {
           $this->db->select('id, name, qty');
           $this->db->where('name', $name);
           $res = $this->db->get('product')->row();
           return $res->id;
        }
    }

    function get_name($id=null)
    {
        if ($id)
        {
           $this->db->select('id, name, qty');
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return $res->name;
        }
    }

    function get_unit($id=null)
    {
        if ($id)
        {
           $this->db->select('unit');
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return $res->unit;
        }
    }

    function get_qty($id=null)
    {
        if ($id)
        {
           $this->db->select('qty');
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return $res->qty;
        }
    }

    function get_price($id=null)
    {
        if ($id)
        {
           $this->db->select('price');
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return $res->price;
        }
    }

    function get_all()
    {
      $this->db->select('id, name, qty, unit');
      $this->db->order_by('name', 'asc');
      return $this->db->get('product');
    }
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);} }
        else { $data['options'][''] = '--'; }        
        return $data;
    }
    
    function combo_publish($id)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $this->db->where_not_in('id', $id);
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);} }
        else { $data['options'][''] = '--'; }        
        return $data;
    }
    
    function get_product_based_category($cat)
    {
        $this->db->select_sum('qty');
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $this->db->where('category', $cat);
        $res = $this->db->get($this->tableName)->row_array();
        return intval($res['qty']); 
    }

}

/* End of file Property.php */