<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {


   public function __construct()
   {
        parent::__construct();

        $this->load->model('Login_model', '', TRUE);

        $this->load->helper('date');
        $this->load->library('log');
        $this->load->library('email');

        $this->properti = $this->property->get();

        // Your own constructor code
   }

   private $date,$time;
   private $properti;

   function index()
   {
        $data['pname'] = $this->properti['name'];
        $data['logo'] = $this->properti['logo'];
        $data['form_action'] = site_url('login/login_process');

        $this->load->view('login_view', $data);
    }

    // function untuk memeriksa input user dari form sebagai admin
    function login_process()
    {
        
        $datax = (array)json_decode(file_get_contents('php://input')); 

        $username = $datax['user'];
        $password = $datax['pass'];

            if ($this->Login_model->check_user($username,$password) == TRUE)
            {
                $this->date  = date('Y-m-d');
                $this->time  = waktuindo();
                $userid = $this->Login_model->get_userid($username);
                $role = $this->Login_model->get_role($username);
                $rules = $this->Login_model->get_rules($role);
                $logid = $this->log->max_log();
                $waktu = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';

                $this->log->insert($userid, $this->date, $this->time, 'login');

                $data = array('username' => $username, 'role' => $role, 'rules' => $rules, 'log' => $logid, 'login' => TRUE, 'waktu' => $waktu);
                $this->session->set_userdata($data);
                
                $response = array(
                  'Success' => true,
		  'User' => $datax['user'],
                  'Info' => 'Login Success'); 
            }
            else
            {
                $response = array(
                'Success' => false,
                'Info' => 'Invalid Login..!!');
            }
            
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;

    }

    // function untuk logout
    function process_logout()
    {
        $userid = $this->Login_model->get_userid($this->session->userdata('username'));
        $this->date  = date('Y-m-d');
        $this->time  = waktuindo();
        
        $this->log->insert($userid, $this->date, $this->time, 'logout');
        $this->session->sess_destroy();
        redirect('login');
    }

    function forgot()
    {
	$data['form_action'] = site_url('login/send_password');
        $data['pname'] = $this->properti['name'];
        $data['logo'] = $this->properti['logo'];
        $this->load->view('forgot_view' ,$data);
    }

    function send_password()
    {
        $this->form_validation->set_rules('username', 'Type Username', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->Login_model->check_username($this->input->post('username')) == FALSE)
            {
               $this->session->set_flashdata('message', 'Username not registered ..!!');
               redirect('login/forgot');
            }
            else
            {
              $email = $this->Login_model->get_email($this->input->post('username'));
              $pass = $this->Login_model->get_pass($this->input->post('username'));
              $mess = "
                ".$this->properti['name']." - ".base_url()."
                FORGOT PASSWORD :

                Your Username is: ".$this->input->post('username')."
                Your Password : ".$pass." <hr />
Your password for this account has been recovered . You don’t need to do anything, this message is simply a notification to protect the security of your account.
Please note: your password may take awhile to activate. If it doesn’t work on your first try, please try it again later
DO NOT REPLY TO THIS MESSAGE. For further help or to contact support, please email to ".$this->properti['email']."
****************************************************************************************************************** ";

              $params = array($this->properti['email'], $this->properti['name'], $email, 'Password Recovery', $mess, 'text');
              $se = $this->load->library('send_email',$params);

              if ( $se->send_process() == TRUE )
              { $this->session->set_flashdata('message', 'Password has been sent to your email!'); }
              else { $this->session->set_flashdata('message', 'Failed To Sent Email!'); }
              redirect('login/forgot');

            }
            
        }
        else
        {
            $data['form_action'] = site_url('login/send_password');
            $data['pname'] = $this->properti['name'];
            $this->load->view('forgot_view' ,$data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */