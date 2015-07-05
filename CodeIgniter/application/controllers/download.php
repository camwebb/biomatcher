<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {
    
    public function index()
	{
        $data['title'] = ucfirst('Download');
		$this->load->view('templates/header', $data);
    	$this->load->view('download/download');
    	$this->load->view('templates/footer');
	}
    
}

?>