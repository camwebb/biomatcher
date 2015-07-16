<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('m_general');
        $this->load->model('m_pages');
        $this->load->library('encrypt');
        $this->load->library('email');
        $this->load->library('form_validation');
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
            
            //check request exist
            $exist = $this->m_general->getAllData(TRUE,'reset_password',array('user_id' => $user_id));
            $data_user = $this->m_pages->get_user($user_id);
            
            //insert requested data
            $data_insert['user_id'] = $user_id;
            $data_insert['token'] = $token;
            $data_insert['date_request'] = date('Y-m-d H:i:s');
            
            if($exist)
            {
                $this->m_general->updateData('reset_password',array('user_id' => $user_id),$data_insert);
            }
            else
            {
                $this->m_general->insertData('reset_password',$data_insert);
            }
            
            $reset_data = array('user_id' => $user_id, 'email' => $post['email'], 'token' => $token);
            $serial = serialize($reset_data);
            $encode = base64_encode($serial);
            $url_param = rtrim($encode, '=');
            
            $reset_link = 'user/reset_password';
            
            $link = site_url($reset_link.'/'.$url_param);
            
            //create mail
            $mail_content['username'] = $data_user[0]->username;
            $mail_content['content'] = array(
                                            "We've received a request to reset the password for this email address.",
                                            "If you did not request to have your password reset, you can safely ignore this email. Your current password will continue to work.",
                                            "<strong>Click the link below to reset your password</strong>",
                                            "<a href='".$link."'>".$link."</a>",
                                            "The link will be expired after 24 hours.",
                                            "If clicking the link doesn't work, you can copy and paste the link into your browser's address window, or retype it there."
                                            );
            $mail_content['thank_message'] = 'Thank you for using Biomatcher!';
            $mail = $this->create_mail($mail_content);
            
            //send mail
            $this->email->from('biomatcher@gmail.com', 'Biomatcher');
            $this->email->to('widiw374@gmail.com');
            
            $this->email->subject('Reset Password');
            $this->email->message($mail);	
            
            $this->email->send();
            //echo $this->email->print_debugger();
            
            //redirect
            $this->session->set_flashdata('success', "We've sent a reset link to your email address.");
            
            redirect('user/forgot_password', 'refresh');
        }
    }
    
    public function reset_password()
    {
        $url = $this->uri->segment(3);
        
        //print_r($data_user);
        
        $page = 'reset_password';
        $data['title'] = ucfirst("Reset Password");
        $data['url'] = $url;
        
        $this->template($page,$data);
    }
    
    public function do_reset_password()
    {
        $url = $this->uri->segment(3);
        
        $base_64 = $url . str_repeat('=', strlen($url) % 4);
        $serial = base64_decode($base_64);
        $data_user = unserialize($serial);
        
        if(!$data_user['user_id'] && !$data_user['email'] && !$data_user['token'])
        {
            $this->session->set_flashdata('message', "The link is invalid.");
            
            redirect('user/forgot_password', 'refresh');
        }
        else
        {
            //check token reset password
            $token_exist = $this->m_general->getAllData(TRUE,'reset_password',array('user_id' => $data_user['user_id'], 'token' => $data_user['token']));
            
            if(!$token_exist)
            {
                $this->session->set_flashdata('message', "The link is invalid.");
            
                redirect('user/forgot_password', 'refresh');
            }
            
            //check date request
            $date = date('Y-m-d H:i:s');
            $plus24hours = strtotime($token_exist[0]->date_request) + 86400;
            $current_date = strtotime($date);
                
            if ($current_date > $plus24hours) {
                $this->session->set_flashdata('message', "The link has expired.");
            
                redirect('user/forgot_password', 'refresh');
            }
            
            $config = array(
                   array(
                         'field'   => 'password', 
                         'label'   => 'Password', 
                         'rules'   => 'trim|required|min_length[4]|max_length[32]'
                      ),
                   array(
                         'field'   => 'conpassword', 
                         'label'   => 'Password Confirmation', 
                         'rules'   => 'trim|required|matches[password]'
                      )
                );
            $this->form_validation->set_rules($config);
            
            if($this->form_validation->run() == FALSE)
            {
                $this->reset_password();
            }
            else
            {
                $new_pass = md5($this->input->post('password'));
                
                $this->m_general->updateData('user',array('id' => $data_user['user_id']),array('password' => $new_pass));
                
                $this->session->set_flashdata('message', "Your password has been reset.");
            
                redirect('', 'refresh');
            }
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
    
    function create_mail($data)
    {
        return $this->load->view('templates/mail', $data, TRUE);
    }
    
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */