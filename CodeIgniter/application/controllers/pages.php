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
    
    $this->load->model('m_pages');
    $data['list_project'] = $this->m_pages->list_project();
	$data['list_images'] = $this->m_pages->list_image();
    $data['project_title'] = $this->m_pages->project_title();
    $data['list_edit_label'] = $this->m_pages->list_edit_label();
    
	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);

    }
  
    public function do_login()
    {
        $this->load->library(array('encrypt', 'form_validation', 'session'));
        $this->load->helper(array('form', 'url'));
        // field name, error message, validation rules
        $config = array(
               array(
                     'field'   => 'username', 
                     'label'   => 'Username', 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'trim|required'
                  )
            );
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run() == FALSE)
        {
            $this->view();
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
                        //login success
                        $this->session->set_userdata(array('name' =>$login['name'],'username' => $login['username'], 'id_user' => $login['id']));
            			$cookieUsername = array(
            				'name'   => 'user',
            				'value'  => $login['username'],
            				'expire' => time()+36000,
            				'path'   => '/',
            				'secure' => FALSE
            			);
            
            			$cookiePassword = array(
            				'name'   => 'pass',
            				'value'  => $login['password'],
            				'expire' => time()+36000,
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
                        $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                        $this->session->set_flashdata('message', 'Incorrect password.');
                        redirect('');
                    }
                }
            }
            else
            {
                //login failed
                $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                $this->session->set_flashdata('message', 'A user does not exist for the username specified.');
                redirect('');
            }
        }
		
    }
    
    public function logout()
	{
		$this->load->helper('cookie');

	    $this->session->unset_userdata(array('username' => "", 'id_user' => ""));
		delete_cookie("user");
		delete_cookie("pass");
        redirect('', 'refresh');
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
        
        $config = array(
               array(
                     'field'   => 'name', 
                     'label'   => 'Name', 
                     'rules'   => 'trim|required|min_length[4]|xss_clean'
                  ),
               array(
                     'field'   => 'username', 
                     'label'   => 'Username', 
                     'rules'   => 'trim|required|min_length[4]|callback_username_exists|alpha_numeric|xss_clean'
                  ),
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'trim|required|valid_email'
                  ),
               array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'trim|required|min_length[4]|max_length[32]'
                  ),
               array(
                     'field'   => 'conpassword', 
                     'label'   => 'Password Confirmation', 
                     'rules'   => 'trim|required|matches[password]'
                  )
            );
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run() == FALSE)
        {
        $this->register();
        }
        else
        {
        $this->load->model('m_pages');
        $this->m_pages->register_user();
        
        $this->view($page = 'register_success');
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
    
    function do_addProject($page = 'project')
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
    
    public function upload_file()
    {
        $this->load->helper('url');
    	$status = "";
    	$msg = "";
    	$file_element_name = 'zipped_file'; /*zipped_file*/
    	
    	if ($status != "error")
    	{
    	    //$orig_name = $_FILES['zipped_file'];
    		$config['upload_path'] = '../tmp/';
    		$config['allowed_types'] = 'zip';
    		$config['max_size']	= 1024 * 8;
    		$config['encrypt_name'] = TRUE;
    
    		$this->load->library('upload', $config);
    
    		if (!$this->upload->do_upload($file_element_name))
    		{
    			$status = 'error';
    			$msg = $this->upload->display_errors('', '');
    		}
    		else
    		{
    			$data = $this->upload->data();
                //$data = array('upload_data' => $this->upload->data());
            	//$zip = new ZipArchive;
            	$file = $data['full_path'];
                $file_name = $data['raw_name'];
                $path_extract = $data['file_path'].$file_name;
                // or specify a destination directory
                chmod($file,0777);
                mkdir($path_extract, 0777);
           	    chmod($path_extract,0777);
                
                $this->load->library('unzip');
                // Optional: Only take out these files, anything else is ignored
                $this->unzip->allow(array('jpeg', 'jpg'));                
                $this->unzip->extract($file, $path_extract.'/');
				if(fopen($file, 'r') == TRUE){
					fclose(fopen($file, 'r'));
					chmod($file,0777);
					unlink($file);
				}else{
					chmod($file,0777);
					unlink($file);
				}
                /*while(is_file($file) == TRUE)
                {
                    unlink($file);
                }*/
            	/*if ($zip->open($file) === TRUE) {
            	    //extract to folder path
                    mkdir($path_extract, 0777);
            	    chmod($path_extract,0777);      	   
            		$zip->extractTo($path_extract);
            		$zip->close();
                    unlink($file);
            		$msg = 'extract success';
            	} else {
        	        unlink($file);
            		$msg = 'extract failed';
                }*/
    		}
    		@unlink($_FILES[$file_element_name]);
    	}
    	echo json_encode(array('status' => $status, 'msg' => $msg));
    }
    
    public function thumb() { 
        $config['image_library'] = 'gd2'; 
        $config['source_image'] = '../data/fitri/1/img/aa5998d9be7c003ea824fb71d9327f47';
        $config['new_image'] = '../data/fitri/1/img/thumb/';
        $config['create_thumb'] = TRUE; 
        $config['maintain_ratio'] = TRUE; 
        $config['width'] = 100; 
        $config['height'] = 100; 
        
        $this->load->library('image_lib', $config); 
        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors(); 
    }
    
    function editLabel(){
        $this->load->model('m_pages');
        $data['list_edit_label'] = $this->m_pages->list_edit_label();
    }
    
    function create_csv(){
        $this->load->model('m_pages');
        $report = $this->m_pages->test_csv();
       

        }

}
