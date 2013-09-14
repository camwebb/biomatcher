<?php

class Captcha extends CI_Controller {
    
	function show()
    {
        $page = 'captcha_view';
        if ( ! file_exists('../CodeIgniter/application/views/captcha/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	//$this->load->view('templates/header', $data);
    	$this->load->view('captcha/'.$page, $data);
    	//$this->load->view('templates/footer', $data);
    }
    
    function frame()
    {
        $page = 'frame';
        if ( ! file_exists('../CodeIgniter/application/views/captcha/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	$this->load->view('captcha/header', $data);
    	$this->load->view('captcha/'.$page, $data);
    	$this->load->view('captcha/footer', $data);
    }
    
    function test_frame()
    {
        $page = 'iframe_captcha_testing';
        if ( ! file_exists('../CodeIgniter/application/views/captcha/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	//$this->load->view('captcha/header', $data);
    	$this->load->view('captcha/'.$page, $data);
    	//$this->load->view('captcha/footer', $data);
    }
    
}

?>