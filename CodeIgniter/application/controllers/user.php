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
    
    public function do_login()
    {
        // field name, error message, validation rules
        $config = array(
               array(
                     'field'   => 'username', 
                     'label'   => 'Username', 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('message', validation_errors());
            redirect('', 'refresh');
        }else{
            $post = $this->input->post(NULL, TRUE);
            $where = array('username' => $post['username']);
            $checkStatus = $this->m_general->getAllData(TRUE,'user',$where);

            if ($checkStatus) {
                if($checkStatus['0']->status == '1'){
                    $login=$this->m_pages->login($post);
                    if($login){
                        //login success
                        $this->session->set_userdata(array('name' =>$login['name'],'username' => $login['username'], 'id_user' => $login['id'], 'email' => $login['email'], 'type' => $login['type']));
                        $cookieUsername = array(
                            'name'   => 'user',
                            'value'  => $login['username'],
                            'expire' => time()+2592000,
                            'path'   => '/',
                            'secure' => FALSE
                        );
            
                        $cookiePassword = array(
                            'name'   => 'pass',
                            'value'  => $login['password'],
                            'expire' => time()+2592000,
                            'path'   => '/',
                            'secure' => FALSE
                        );
                        //set cookie to browser
                        $this->input->set_cookie($cookieUsername);
                        $this->input->set_cookie($cookiePassword);
                        if ($login['type'] == 'admin'){
                            redirect('admin', 'refresh');
                        }else{
                            redirect('', 'refresh');
                        }
                    }
                    else{
                        //incorrect password
                        $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                        $this->session->set_flashdata('message', 'Incorrect password.');
                        redirect('');
                    }
                }
                else{
                    //Unverified user
                    $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                    $this->session->set_flashdata('message', 'Your account has not been verified, please check your email to verify.');
                    redirect('');
                }
            }
            else{
                //login failed
                $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                $this->session->set_flashdata('message', 'A user does not exist for the username specified.');
                redirect('');
            }
        }
		
    }
    
    /**
     * Auto Login function
     * uses browser's cookie
     * */
    function userlog()
    {
        $this->load->helper('cookie');
        $this->load->model('m_pages');
        
        $username = $this->input->cookie('user');
        $password = $this->input->cookie('pass');        
                
        $login =$this->m_pages->login_user($username);
        if ($login['sukses'] == 1 )
        {
            $user_credentials = array();
    		$user_credentials[$username] = array(
    			'username' => $login['username'],
    			'password' => $login['password']
    		);
            if(array_key_exists($username, $user_credentials))
            {
                if($password == $user_credentials[$username]['password'])
                {
                    //login success
                    $this->session->set_userdata(array('name' =>$login['name'],'username' => $login['username'], 'id_user' => $login['id'], 'type' => $login['type']));
        			$cookieUsername = array(
        				'name'   => 'user',
        				'value'  => $login['username'],
        				'expire' => time()+2592000,
        				'path'   => '/',
        				'secure' => FALSE
        			);
        
        			$cookiePassword = array(
        				'name'   => 'pass',
        				'value'  => $login['password'],
        				'expire' => time()+2592000,
        				'path'   => '/',
        				'secure' => FALSE
        			);
            		//set cookie to browser
            		$this->input->set_cookie($cookieUsername);
            		$this->input->set_cookie($cookiePassword);
                    redirect('', 'refresh');
                }
                else
                {
                    //incorrect password
                    $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => "", 'shuffled_pid' => ""));
                    $this->session->set_flashdata('message', 'Incorrect password.');
                    redirect('');
                }
            }
        }
        else
        {
            //login failed
            $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
            $this->session->set_flashdata('message', 'A user does not exist for the username specified.');
            redirect('');
        }
    }
    
    public function logout()
	{
		$this->load->helper('cookie');
        $this->session->sess_destroy();
		delete_cookie("user");
		delete_cookie("pass");
        redirect('', 'refresh');
	}
    
    function register($page = 'register')
    {
        if ( ! file_exists('../CodeIgniter/application/views/user/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	$this->template($page,$data);
    }
    
    //unused
    function auth_register($page = 'auth_register')
    {
        if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	$this->template($page,$data);
    }
    
    function do_register()
    {
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
                     'rules'   => 'trim|required|min_length[4]|callback_username_exists|alpha_numeric|xss_clean'
                  ),
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'trim|required|valid_email|callback_email_exists'
                  ),
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
        
        if($this->form_validation->run() == FALSE){
            $this->register();
        }else{
            $post = $this->input->post(NULL, TRUE);
            $date = date("Y-m-d H:i:s");
            $token = $this->get_sha256($post['email'].$date, 'activate');

            //Insert to database
            $dataUser = array(
                'username' => $post['username'],
                'password' => md5($post['password']),
                'type' => $post['type'],
                'email' => $post['email'],
                'name' => $post['name'],
                'date_created' => $date,
                'token' => $token
            );
            $this->m_general->insertData('user',$dataUser);

            //send email verification
            $reset_data = array('username' => $post['username'], 'email' => $post['email'], 'token' => $token);
            $serial = serialize($reset_data);
            $encode = base64_encode($serial);
            $url_param = rtrim($encode, '=');
            
            $link = site_url().'/user/do_verify/'.$url_param;
            $mail_content['username'] = $post['name'];
            $mail_content['content'] = array(
                                            "<strong>Click the link below to verify your account</strong>",
                                            "<a href='".$link."'>".$link."</a>",
                                            "If clicking the link doesn't work, you can copy and paste the link into your browser's address window, or retype it there."
                                            );
            $mail_content['thank_message'] = 'Thank you for using Biomatcher!';
            
            $html_email = $this->load->view('templates/mail', $mail_content, true);
            $sendEmail = $this->sendEmail('[BIOMATCHER] Account Verification', $post['email'], $html_email);

            redirect('user/register_success', 'refresh');
        }
    }
    
    function register_success()
    {
        $page = 'register_success';
        $data['title'] = ucfirst("Register Success");
        
        $this->template($page,$data);
    }

    function do_verify(){
        $url = $this->uri->segment(3);
        $base_64 = $url . str_repeat('=', strlen($url) % 4);
        $serial = base64_decode($base_64);
        $data_user = unserialize($serial);
        $date = date('Y-m-d H:i:s');

        //check data
        $where = array('username' => $data_user['username'], 'email' => $data_user['email'], 'token' => $data_user['token']);
        $check_user = $this->m_general->getAllData(TRUE,'user',$where);
        
        if($check_user){
            //update database
            $data_update = array('date_verified' => $date, 'status' => '1'); 
            $update_user = $this->m_general->updateData('user',$where,$data_update);

            //login user
            $this->session->set_userdata(array('name' =>$check_user['0']->name,'username' => $check_user['0']->username, 'id_user' => $check_user['0']->id, 'type' => $check_user['0']->type));
            $cookieUsername = array(
                'name'   => 'user',
                'value'  => $check_user['0']->username,
                'expire' => time()+2592000,
                'path'   => '/',
                'secure' => FALSE
            );

            $cookiePassword = array(
                'name'   => 'pass',
                'value'  => $check_user['0']->password,
                'expire' => time()+2592000,
                'path'   => '/',
                'secure' => FALSE
            );
            //set cookie to browser
            $this->input->set_cookie($cookieUsername);
            $this->input->set_cookie($cookiePassword);

            $data['result'] = 'success';
            $page = 'verify_result';
            $data['title'] = ucfirst('Verify Page');
            $this->template($page,$data);
        }
        else{
            $data['result'] = 'failed';
            $page = 'verify_result';
            $data['title'] = ucfirst('Verify Page');
            $this->template($page,$data);
        }
    }
    
    function username_exists($key)
    {
        $this->load->model('m_pages');
        if($this->m_pages->username_exists($key))
        {
            $this->form_validation->set_message('username_exists', 'Username already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }     
    }
    
    function email_exists($key)
    {
        $this->load->model('m_pages');
        if($this->m_pages->email_exists($key))
        {
            $this->form_validation->set_message('email_exists', 'Email already exist');
            return FALSE;
        }
        else
        {
            return TRUE;
        }     
    }
    
    public function forgot_password()
    {
        $page = 'forgot_password';
        $data['title'] = ucfirst("Forgot Password");
        
        $this->template($page,$data);
    }
    
    function send_reset_link()
    {
        $configEmail = $this->config->load('email');
        
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
            $this->email->from($this->config->item('smtp_user'), 'Biomatcher');
            $this->email->to($post['email']);
            $this->email->subject('[BIOMATCHER] Reset Password');
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
    
    /**
     * Send Email function
     *
     * @param string $subject for email subject
     * @param string $email recipent email
     * @return string $html_email email content
     */
    private function sendEmail($subject, $email, $html_email){
        $configEmail = $this->config->load('email');
        
        $this->email->from($this->config->item('smtp_user'), "Biomatcher Admin Team");
        $this->email->to($email);  
        $this->email->subject($subject);
        $this->email->message($html_email);
        $send = $this->email->send();
        //echo $this->email->print_debugger();
        if($send){return true;}
    }
    
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */