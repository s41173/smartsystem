<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Components {

    public function __construct($params=null)
    {
        // Do something with $params
        $this->ci = & get_instance();
    }

    private $table = 'modul';
    private $ci;

//    private $id, $name, $address, $phone1, $phone2, $fax, $email, $billing_email, $technical_email, $cc_email,
//            $zip, $city, $account_name, $account_no, $bank, $site_name, $logo, $meta_description, $meta_keyword;


    public function get($name = null)
    {
        $this->ci->db->where('name', $name);
        $res = $this->ci->db->get($this->table)->row();
        $val = array('id' => $res->id, 'name' => $res->name, 'title' => $res->title, 'limit' => $res->limit, 'publish' => $res->publish,
                     'status' => $res->status,'aktif' => $res->aktif, 'role' => $res->role, 'icon' => $res->icon, 'order' => $res->order
                    );
        return $val;
    }

    function combo()
    {
        $this->ci->db->select('name');
        $val = $this->ci->db->get($this->table)->result();
        foreach($val as $row){$data['options'][$row->name] = $row->name;}
        return $data;
    }
}

/* End of file Property.php */