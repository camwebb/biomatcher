<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();        
            $this->load->helper(array('form', 'url'));
            $this->load->model('m_pages');   
    }
    
	public function index()
    {
        $data['title'] = ucfirst('Setting');
        $this->load->view('templates/header', $data);
        $this->load->view('setting/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function do_profile()
    {
        $id_user = $this->session->userdata('id_user');
        $name=$this->input->post('name');
        $username=$this->input->post('username');
        $email=$this->input->post('email');
        
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $config = array(
                array(
                     'field'   => 'name', 
                     'label'   => 'Name', 
                     'rules'   => 'trim|required|min_length[4]|xss_clean'
                  ),
                array(
                     'field'   => 'username', 
                     'label'   => 'Username', 
                     'rules'   => 'trim|required|min_length[4]|alpha_numeric|xss_clean'
                  ),
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'trim|required|valid_email'
                  ),
                array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'required|md5|callback_check_pass'
                  )
                );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == FALSE){
            $name = form_error('name');
            $username = form_error('username');
            $email = form_error('email');
            $password = form_error('password');
            echo json_encode(array('result' => 'failed','name' => $name, 'username' => $username, 'email' => $email, 'password' => $password)); 
        }
        
        else{
            $this->load->model('m_pages');
            $change_info = $this->m_pages->edit_profile($id_user,$name,$username,$email);
            redirect('setting','refresh');
        }
    }

    public function do_pass()
    {
        $id_user = $this->session->userdata('id_user');
        $old_pass= md5($this->input->post('old_pass'));
        $new_pass=md5($this->input->post('new_pass'));
        $renew_pass=md5($this->input->post('renew_pass'));
        
        
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $config = array(
                array(
                     'field'   => 'old_pass', 
                     'label'   => 'Old Password', 
                     'rules'   => 'required|md5|callback_check_pass'
                  ),
                array(
                     'field'   => 'new_pass', 
                     'label'   => 'New Password', 
                     'rules'   => 'required|trim|min_length[4]|max_length[32]'
                  ),
                array(
                     'field'   => 'renew_pass', 
                     'label'   => 'Re-New Password', 
                     'rules'   => 'required|trim|matches[new_pass]'
                  )
                );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == FALSE){
            //echo form_error('old_pass').form_error('new_pass').form_error('renew_pass');
            $old_pass = form_error('old_pass');
            $new_pass = form_error('new_pass');
            $renew_pass = form_error('renew_pass');
            echo json_encode(array('result' => 'failed','old_pass' => $old_pass, 'new_pass' => $new_pass, 'renew_pass' => $renew_pass));    
        }
        
        else{
            $this->load->model('m_pages');
            $change_info = $this->m_pages->edit_pass($id_user,$new_pass);
        }
    }

    public function check_pass($key){
        $id_user = $this->session->userdata('id_user');
        $this->load->model('m_admin');
        if($this->m_admin->check_password($id_user,$key))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_pass', 'Wrong Password');
            return FALSE;
        }     
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */