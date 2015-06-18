<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();        
            $this->load->helper(array('form', 'url'));
            $this->load->model('m_pages');   
    }
    
	public function index()
    {
        $data['title'] = ucfirst('Setting');
        $this->load->view('templates/header', $data);
        $this->load->view('setting/index', $data);
        $this->load->view('templates/footer', $data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */