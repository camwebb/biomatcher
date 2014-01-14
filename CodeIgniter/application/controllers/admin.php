<?php

class Admin extends CI_Controller {
    
	public function view($page = 'dashboard')
	{

	if ( ! file_exists('../CodeIgniter/application/views/admin/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}

	$data['title'] = ucfirst($page); // Capitalize the first letter
    
    $this->load->model('m_pages');
    
    
	$this->load->view('admin/templates/header', $data);
	$this->load->view('admin/'.$page, $data);
	$this->load->view('admin/templates/footer', $data);
    
    }
    
}

?>