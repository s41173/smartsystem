<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget_lib {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;

    function combo_position()
    {
        $data=null;
        for ($i=1; $i<=20; $i++)
        {
            $data['options']['user'.$i] = 'user '.$i;
        }
        return $data;
    }


}

/* End of file Property.php */