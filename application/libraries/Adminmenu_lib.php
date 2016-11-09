<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminmenu_lib {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;
    private $table = 'admin_menu';

    function combo()
    {
        $this->ci->db->select('id, name');
        $val = $this->ci->db->get($this->table)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->name;}
        return $data;
    }

    public function getmenuname($val)
    {
        if ($val)
        {
           $this->ci->db->select('id, icon, parent_id, name, modul, url, menu_order, class_style, id_style, target');
           $this->ci->db->where('id', $val);
           $res = $this->ci->db->get($this->table)->row();

           if ($res) {  return $res->name; } else{ return null; }
        }
    }


}

/* End of file Property.php */