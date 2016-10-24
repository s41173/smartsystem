<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl {

    public function __construct()
    {
        // Do something with $params
        $this->ci = & get_instance();
    }

    private $ci;

    public function otentikasi()
    { if ($this->ci->session->userdata('login') != TRUE ){ redirect('login'); } }

    function otentikasi1($title)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row) { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE)
        {
           $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to access '.$title.' component');
           redirect('main');
        }
    }

    function otentikasi2($title)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row)
        { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE || $this->ci->session->userdata('rules') != 2 && $this->ci->session->userdata('rules') != 3)
        {
           $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to edit this value');
           redirect($title);
        }
    }

    function otentikasi3($title)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row)
        { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE || $this->ci->session->userdata('rules') != 3)
        {
           $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to edit this value');
           redirect($title);
        }
    }

    function otentikasi4($title)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row)
        { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE || $this->ci->session->userdata('rules') != 4)
        {
           $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to edit this value');
           redirect($title);
        }
    }

    function otentikasi_admin($title)
    {
        if ($this->ci->session->userdata('rules') != 3)
        {
           $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to edit this value');
           redirect($title);
        }
    }
}

/* End of file Property.php */