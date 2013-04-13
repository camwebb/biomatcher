<?php

class Pages extends CI_Controller {
    public function index(){
        
    }

	public function view($page = 'home')
	{

	if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}

	$data['title'] = ucfirst($page); // Capitalize the first letter
	
	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);

    }
    
    public function login($page = 'login')
	{

	if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}

	$data['title'] = ucfirst($page); // Capitalize the first letter
	
	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);

    }
  
    public function do_login()
    {
        $this->load->library(array('encrypt', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        // field name, error message, validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="errorbox">', '</div>');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->login();
        }else{
            $this->load->helper('cookie');
            $this->load->model('m_pages');
            $login =$this->m_pages->login_user();
            if ($login['sukses'] == 1 )
            {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $user_credentials = array();
        		$user_credentials[$username] = array(
        			'username' => $login['username'],
        			'password' => $login['password']
        		);
                if(array_key_exists($username, $user_credentials))
                {
                    if(md5($password) == $user_credentials[$username]['password'])
                    {
                        //die("USER LOGGED IN!");
                        //login success
                        $this->session->set_userdata(array('username' => $login['username'], 'id_user' => $login['id']));
            			$cookieUsername = array(
            				'name'   => 'user',
            				'value'  => $login['username'],
            				'expire' => time()+1000,
            				'path'   => '/',
            				'secure' => FALSE
            			);
            
            			$cookiePassword = array(
            				'name'   => 'pass',
            				'value'  => $login['password'],
            				'expire' => time()+1000,
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
                        $this->session->set_userdata(array('username' => "", 'id_user' => ""));
                        $this->session->set_flashdata('message', 'Incorrect password.');
                        redirect('pages/login');
                    }
                }
            }
            else
            {
                //login failed
                $this->session->set_userdata(array('username' => "", 'id_user' => ""));
                $this->session->set_flashdata('message', 'A user does not exist for the username specified.');
                redirect('pages/login');
            }
        }
		
    }
    
    public function logout()
	{
		$this->load->helper('cookie');

	    $this->session->unset_userdata(array('username' => "", 'id_user' => ""));
		delete_cookie("user");
		delete_cookie("pass");
        redirect('pages/login', 'refresh');
	}
    
    function register($page = 'register')
    {
        if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	$this->load->view('templates/header', $data);
    	$this->load->view('pages/'.$page, $data);
    	$this->load->view('templates/footer', $data);      
    }
    
    function do_register()
    {
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|callback_username_exists|callback_username_character|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('conpassword', 'Password Confirmation', 'trim|required|matches[password]');
        
        if($this->form_validation->run() == FALSE)
        {
        $this->register();
        }
        else
        {
        $this->load->model('m_pages');
        $this->m_pages->register_user();
        $this->register_success();
        }
    }
    
    function username_exists($key)
    {
        $this->load->model('m_pages');
        if($this->m_pages->username_exists($key))
        {
            $this->form_validation->set_message('username_exists', 'Username already Exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }     
    }
    
    function username_character($char)
    {
        if (preg_match('/^[a-zA-Z0-9]+$/', $char)) {
            return true;
        }
        else{
            $this->form_validation->set_message('username_character', 'Username must contain A-Z a-z 0-9 only.');
            return false;
        }
    } 
    
    public function register_success($page = 'register_success')
	{

	if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}

	$data['title'] = ucfirst($page); // Capitalize the first letter
	
	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);

    }
    

}
