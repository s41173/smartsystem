<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoryproduct {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;

    function combo()
    {
        $this->ci->db->select('id, name');
        $this->ci->db->where('deleted', NULL);
        $this->ci->db->order_by('name', 'asc');
        $val = $this->ci->db->get('category')->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function combo_all()
    {
        $this->ci->db->select('id, name');
        $this->ci->db->where('deleted', NULL);
        $this->ci->db->order_by('name', 'asc');
        $val = $this->ci->db->get('category')->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function combo_update($id)
    {
        $this->ci->db->select('id, name');
        $this->ci->db->where('deleted', NULL);
        $this->ci->db->order_by('name', 'asc');
        $this->ci->db->where_not_in('id', $id);
        $val = $this->ci->db->get('category')->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }

    function get_name($id=null)
    {
        if ($id)
        {
            $this->ci->db->select('id,name');
            $this->ci->db->where('id', $id);
            $val = $this->ci->db->get('category')->row();
            if ($val){ return $val->name; }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }

}

/* End of file Property.php */