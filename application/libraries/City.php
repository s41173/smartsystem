<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;

    function combo()
    {
        $this->ci->db->select('id, name');
        $val = $this->ci->db->get('city')->result();
        foreach($val as $row){$data['options'][$row->name] = $row->name;}
        return $data;
    }


}

/* End of file Property.php */