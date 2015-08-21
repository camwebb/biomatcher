<?php

class Demo extends CI_Controller {
    
    public function index()
	{
        $data['title'] = ucfirst('demo');

        $this->load->view('templates/header', $data);
		$this->load->view('demo/index', $data);
		$this->load->view('templates/footer', $data);
	}
    
}

?>