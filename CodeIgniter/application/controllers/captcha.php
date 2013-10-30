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
        
        $this->load->library('biomatcher_lib');
        $pair_mode[0] = "same";
        $pair_mode[1] = "different";
        
        shuffle($pair_mode);
        
        $project_pre_match = $this->biomatcher_lib->selectQC();
        
        if(!empty($project_pre_match)){
            $userID_pre = $project_pre_match[0]->userID;
            $get_username_pre = $this->m_pages->get_user($userID_pre);
            $username_pre = $get_username_pre[0]->username;
            $image_pre = $this->m_pages->selectImagePre($project_pre_match[0]->id);
            
            if(!empty($image_pre)){
                shuffle($image_pre);
            //print_r($pair_mode[0]);
            
                if ($pair_mode[0] == "same"){ // for same pair
                    $image_preB = $this->m_pages->getImagePreSame($project_pre_match[0]->id,$image_pre[0]['id'], $image_pre[0]['label']);
                    $data['pair_match'] = array('projectID_pre' => $project_pre_match[0]->id , 'username_pre' => $username_pre,'shuffled_image_pre_A' => $image_pre[0], 'shuffled_image_pre_B' => $image_preB[0]);
                }elseif ($pair_mode[0] == "different"){ // for different pair
                    $data['pair_match'] = array('projectID_pre' => $project_pre_match[0]->id , 'username_pre' => $username_pre,'shuffled_image_pre_A' => $image_pre[0], 'shuffled_image_pre_B' => $image_pre[1]);
                } 
            }else{
                show_404();
            }         
                                    
        }else{
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
    
    function form_no_ajax(){
        $page = 'form_no_ajax';
        if ( ! file_exists('../CodeIgniter/application/views/captcha/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	$this->load->view('captcha/'.$page, $data);
    }
    
    public function _check_captcha()
	{
		$this->load->library('securimage/securimage');
		$securimage = new Securimage();	

		if( ! $securimage->check($this->input->post('captcha')))
		{
			$this->form_validation->set_message('_check_captcha', 'The code you entered is invalid');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function si_test()
	{
        $this->load->library('form_validation');
        $this->load->helper('html');
		if($this->input->post())
		{
			$val = $this->form_validation;
			$val->set_rules('captcha', 'captcha', 'trim|required|callback__check_captcha');
			$val->set_error_delimiters('<div class="error">','</div>');
		
			if($val->run())
			{
				echo 'Captcha OK';
			}
		}			

		$this->load->view('captcha/simagetest');
	}	

	public function securimage()
	{
        $this->load->helper('html');
		$this->load->config('csecurimage');
		$active = $this->config->item('si_active');		
		$allsettings = array_merge($this->config->item($active), $this->config->item('si_general'));

		$this->load->library('securimage/securimage');
		$img = new Securimage($allsettings);
		
		//$img->captcha_type = Securimage::SI_CAPTCHA_MATHEMATIC;
		
		$img->show(APPPATH . 'libraries/securimage/backgrounds/bg3.png');
	}
    
}

?>