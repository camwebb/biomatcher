<?php

class Captcha extends CI_Controller {
    
    function frame()
    {
        $this->load->helper('html');
        $page = 'frame';
        if ( ! file_exists('../CodeIgniter/application/views/captcha/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
        $this->load->model('m_pages');
        
        $token = $_GET['token'];
        $url = $_GET['yoururl'];
        
        if(isset($_GET['demo']))
        {
            if($_GET['demo']) $page = 'frame_demo';
        }
        
        $check_url_id = $this->m_pages->check_url($url);
        if(!$check_url_id){
            $page = 'invalid_token';
            $data['message'] = "You have not register your site or your token is invalid. Please register and check your code at <a href='http://www.biomatcher.org/'>http://www.biomatcher.org/</a>";
        }else{
        
            $check = $this->m_pages->check_token($token, $check_url_id);
            if(!$check){
                $page = 'invalid_token';
                $data['message'] = "You have not register your site or your token is invalid. Please register and check your code at <a href='http://www.biomatcher.org/'>http://www.biomatcher.org/</a>";
            }else{
            
                $this->load->library('biomatcher_lib');
                
                //send image captcha (random from 1 project)
                $project_pre_match = $this->biomatcher_lib->selectProjectCaptcha();
                
                if(!empty($project_pre_match)){
                    $userID_pre = $project_pre_match[0]->userID;
                    $get_username_pre = $this->m_pages->get_user($userID_pre);
                    $username_pre = $get_username_pre[0]->username;
                    $image_pre = $this->m_pages->selectImage($project_pre_match[0]->id);
                    
                    if(!empty($image_pre)){
                        shuffle ($image_pre);
                        $data['pair_match'] = array('projectID_pre' => $project_pre_match[0]->id , 'username_pre' => $username_pre,'shuffled_image_pre_A' => $image_pre[0], 'shuffled_image_pre_B' => $image_pre[1]);
                    }
                }
            }
        }
    
    	$data['title'] = ucfirst($page); // Capitalize the first letter
    	
    	$this->load->view('captcha/header', $data);
    	$this->load->view('captcha/'.$page, $data);
    	$this->load->view('captcha/footer', $data);
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
            $captcha = $this->input->post('captcha');
			$val = $this->form_validation;
			$val->set_rules('captcha', 'captcha', 'trim|required|callback__check_captcha');
			$val->set_error_delimiters('<div class="error">','</div>');
            
            //if($captcha)
			if($val->run()== TRUE)
			{
				echo 'ok';
			}
            else{
                echo 'invalid';
            }
		}		

		//$this->load->view('captcha/simagetest');
	}	

	public function securimage()
	{
        $this->load->helper('html');
		$this->load->config('csecurimage');
		$active = $this->config->item('si_active');		
		$allsettings = array_merge($this->config->item($active), $this->config->item('si_general'));

		$this->load->library('securimage/securimage');
		$img = new Securimage($allsettings);		
		$img->show(APPPATH . 'libraries/securimage/backgrounds/bg6.png');
        $img->outputAudioFile();
	}
    
    public function securimage_audio()
	{
        $this->load->helper('html');
		$this->load->config('csecurimage');
        $active = $this->config->item('si_active');
        
		$settings['audio_path'] = APPPATH.'libraries/securimage/audio';// If you didn't configure this it will secureimage library path and follow by dir /audio/
        $settings['audio_noise_path'] = APPPATH.'libraries/securimage/audio/noise';//save as above audio path
        $settings['audio_use_noise'] = true; // true or false;
        $settings['degrade_audio'] = true; // true or false; 
        
        // Then init the secureimage with the options
        $this->load->library('securimage/securimage');
        $img = new Securimage($settings);
        //$img->show(); // this will show the image src
        $img->outputAudioFile(); // this will output the audio file to the browser
	}
    
}

?>