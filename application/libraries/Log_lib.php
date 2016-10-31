<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_lib {

    public function __construct($params=null)
    {
        // Do something with $params
        $this->ci = & get_instance();
    }

    private $table = 'log';
    private $ci;

    public function max_log()
    {
        $this->ci->db->select_max('id');
        $val = $this->ci->db->get($this->table)->row_array();
        $val = $val['id'];
        return $val;
    }

    public function insert($userid=null, $date=null, $time=null, $activity=null, $com=0)
    {
        $logs = array('userid' => $userid, 'date' => $date, 'time' => $time, 'activity' => $activity, 'component_id' => $com);
        $this->ci->db->insert($this->table, $logs);
    }
}

/* End of file Property.php */