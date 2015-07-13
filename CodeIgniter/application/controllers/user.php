<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('m_general');
        $this->load->model('m_pages');
        $this->load->library('encrypt');
    }
    
    public function index()
	{
        
	}
    
    public function forgot_password()
    {
        $page = 'forgot_password';
        $data['title'] = ucfirst("Forgot Password");
        
        $this->template($page,$data);
    }
    
    function send_reset_link()
    {
        $post= $_POST;
        
        //delete old request data
        //---
        
        $reset_link = 'reset_password';
        
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
        else
        {
            $date = time();
            $user_id = $this->m_pages->get_user_id($post['email']);
            $token = $this->get_sha256($post['email'].$date, 'activate');
            
            //insert requested data
            $data_insert['user_id'] = $user_id;
            $data_insert['token'] = $token;
            
            $this->m_general->insertData('reset_password',$data_insert);
            
            $serial = serialize('email/'.$post['email'].'/token/'.$token);
            $encode = $this->encrypt->encode($serial);
            $link = '/'.$reset_link.'/'.$serial;
            
            //create mail
            //---
            
            //send mail
            //---
            
            //redirect
            //---
        }
    }
    
    /**
     * Generate sha256 hash for given data.
     *
     * @param mixed $to_hash Can be string or array of data
     * @param string $mode Hash key mode, accepted values are session, password and cookie
     * @return string 64 characters hash of has_key concat with the given data
     */
    protected function get_sha256($to_hash, $mode = 'password') {
        if(is_array($to_hash))
            $to_hash = implode('', $to_hash);

        return hash('sha256', $this->config->item('auth_'.$mode.'_hash_key').$to_hash);
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
    
    function template($page, $data=NULL)
    {
        if(!$page) return FALSE;
        
        $this->load->view('templates/header', $data);
    	$this->load->view('user/'.$page, $data);
    	$this->load->view('templates/footer', $data);
    }
    
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */