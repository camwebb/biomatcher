<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function index()
	{
        
	}
    
    public function forgot_password()
    {
        $page = 'forgot_password';
        $data['title'] = ucfirst("Forgot Password");
        
        $this->template($page,$data);
    }
    
    function template($page, $data=NULL)
    {
        if(!$page) return FALSE;
        
        $this->load->view('templates/header', $data);
    	$this->load->view('user/'.$page, $data);
    	$this->load->view('templates/footer', $data);
    }
    
    function send_reset_link()
    {
        $post= $_POST;
        //print_r($post);
        
        $this->load->library('form_validation');
        // field name, error message, validation rules
        
        $config = array(
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'trim|required|valid_email|callback_email_not_exists'
                  )
            );
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run() == FALSE)
        {
            $this->forgot_password();
        }
    }
    
    function email_not_exists($key)
    {
        $this->load->model('m_pages');
        if($this->m_pages->email_exists($key))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('email_not_exists', 'Email does not exist');
            return FALSE;
        }     
    }
    
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */