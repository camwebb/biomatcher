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
    
    public function login_success($page = 'login_success')
	{

	if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		//show_404();
        echo $page;
	}

	$data['title'] = ucfirst($page); // Capitalize the first letter
	
	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);

    }
  
    public function login()
    {
        $this->load->model('m_pages');
        $login =$this->m_pages->login_user();
        if ($login['sukses'] == 1 )
        {
            $this->session->set_userdata(array('username' => $login['username'], 'id_user' => $login['id']));
        }
        else 
        {
            $this->session->set_userdata(array('username' => "", 'id_user' => ""));
        }
    
        redirect('pages/login_success', 'refresh');
    }
    
    public function logout($page = 'login_success')
	{
	    $this->session->unset_userdata(array('username'=>'','cartid'=>'','id_user'=>''));
        redirect('', 'refresh');
	}

}
