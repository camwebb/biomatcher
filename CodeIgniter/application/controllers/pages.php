<?php

class Pages extends CI_Controller {

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
		$this->load->helper('cookie');
        $this->load->model('m_pages');
        $login =$this->m_pages->login_user();
        if ($login['sukses'] == 1 )
        {
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
        }
        else 
        {
            //login failed
            $this->session->set_userdata(array('username' => "", 'id_user' => ""));
        }
    
        redirect('', 'refresh');
    }
    
    public function logout()
	{
		//$this->load->helper('cookie');

	    $this->session->unset_userdata(array('username' => "", 'id_user' => ""));
        redirect('pages/login', 'refresh');
	}
    
    function register($page = 'register')
    {
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $this->load->view('templates/header', $data);
    	$this->load->view('pages/'.$page, $data);
    	$this->load->view('templates/footer', $data);
        
        $this->session->unset_userdata('error');
        if ($this->input->post('password')!="" and $this->input->post('username')!="" and $this->input->post('type')!="")
            {
                $this->load->model('m_pages');
                $this->load->view('pages/register');
                $register = $this->m_pages->register_user();
                redirect('/pages/register_success','refresh');
                
            }
        else {
            $this->session->set_userdata(array('error' => "Make sure you fill all the required information"));
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
