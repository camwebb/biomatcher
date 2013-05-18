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
    $data['get_csv'] = $this->m_pages->get_csv();    
    
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
        $this->register($page = 'projects');
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
    
    function do_addProject()
    {
        //function add project
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $config = array(
               array(
                     'field'   => 'nameProject', 
                     'label'   => 'Project Name', 
                     'rules'   => 'trim|required|min_length[4]|callback_project_exists|xss_clean'
                     // fungsi callback_project_exist belom dibuat
                  ),
               array(
                     'field'   => 'type', 
                     'label'   => 'Type', 
                     'rules'   => 'trim|required|xss_clean'
                  )
            );
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run() == FALSE)
        {
            $this->view($page = 'projects');
        }
        else
        {
        $this->load->model('m_pages');
        $this->m_pages->add_project();
        
        $this->view($page = 'projects');
        }
        //redirect redirect('', 'refresh');
    }
    
    public function upload_file()
    {
        $this->load->helper('url');
    	$status = "";
    	$msg = "";
    	$file_element_name = 'zipped_file'; /*zipped_file*/
    	
        $project_id = $this->input->get('pid');
        
        if (!empty($project_id)){
        
    	if ($status != "error")
    	{
    	    //$orig_name = $_FILES['zipped_file'];
    		$config['upload_path'] = '../tmp/';
    		$config['allowed_types'] = 'zip';
    		$config['max_size']	= '500000';
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
            	$file = $data['full_path'];
                $file_name = $data['raw_name'];
                $path_extract = $data['file_path'].$file_name;
                $path_data = 'data/';
                $path_user = $path_data.$this->session->userdata('username');
                $path_project = $path_user.'/'.$project_id;
                $path_img = $path_project.'/img';
                $path_img_ori = $path_img.'/ori';
                $path_img_500px = $path_img.'/500px';
                $path_img_100px = $path_img.'/100px';
                
                mkdir($path_extract, 0755);

                //extract and delete zip file             
                shell_exec("unzip -jo $file  -d $path_extract");
                unlink($file);
                
                //create folder if not exist
                $toCreate = array($path_user, $path_project, $path_img, $path_img_ori, $path_img_500px, $path_img_100px);
                $permissions = 0755;
                foreach ($toCreate as $dir) {
                    if (!is_dir($dir)){
                        mkdir($dir, $permissions, TRUE);
                    }
                }
                
                $list = count(glob($path_extract.'/'. "*.{jpg,jpeg}",GLOB_BRACE));

                if ($handle = opendir($path_extract)) {
                    // loop over the directory.
                    //$num = 0;
                    while (false !== ($entry = readdir($handle))) {
                        //print_r($entry);
                        if(preg_match('#\.(jpg|jpeg)$#i', $entry))
                        {
                            //$num +=1;
                            //echo json_encode(array('list' => $list, 'num' => $num.$entry));
                            $image_name_encrypt = md5($entry);
                            
                            $fileinfo = getimagesize($path_extract."/".$entry);
                            if(!$fileinfo) {
                                $status = "error";
                                $msg = "No file type info";
                            }else{
                            $valid_types = array(IMAGETYPE_JPEG);
                        
                            if(in_array($fileinfo[2],  $valid_types)) {
                                $this->load->model('m_pages');
                                $list_file = array('projectID'=> $project_id, 'nameOri' => $entry);
                                if($this->m_pages->file_exist($list_file))
                                {
                                    $list_file_exist = array();
                                    $list_file_exist[] = $entry;
                                    $status = "error";
                                    $msg = "No image processed";
                                }else{
                                    copy($path_extract."/".$entry, $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg');
                                    if(!@ copy($path_extract."/".$entry, $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg'))
                                    {
                                        $status = "error";
                                        $msg= error_get_last();
                                    }
                                    else{
                                        //Set config for img library
                                        $config['image_library'] = 'ImageMagick';
                                        $config['library_path'] = '/usr/bin/';
                                        $config['quality'] = "100%";
                                        $config['source_image'] = $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg';
                                        $config['new_image'] = $path_img_500px.'/'.$image_name_encrypt.'.500px.jpg';
                                        $config['maintain_ratio'] = false;
                                        
                                        //Set cropping for y or x axis, depending on image orientation
                                        if ($fileinfo[0] > $fileinfo[1]) {
                                            $config['width'] = $fileinfo[1];
                                            $config['height'] = $fileinfo[1];
                                            $config['x_axis'] = (($fileinfo[0] / 2) - ($config['width'] / 2));
                                        }
                                        else {
                                            $config['height'] = $fileinfo[0];
                                            $config['width'] = $fileinfo[0];
                                            $config['y_axis'] = (($fileinfo[1] / 2) - ($config['height'] / 2));
                                        }
                                        
                                        //Load image library and crop
                                        $this->load->library('image_lib', $config);
                                        $this->image_lib->initialize($config);
                                        if ($this->image_lib->crop()) {
                                            $status = "error";
                                            $msg = $this->image_lib->display_errors();
                                        }
                                        
                                        //Clear image library settings
                                        $this->image_lib->clear();
                                        unset($config);
                                        
                                        // resize image after cropping to square
                                        $config['image_library'] = 'gd2';
                                        $config['quality'] = "100%";
                                        $config['source_image'] = $path_img_500px.'/'.$image_name_encrypt.'.500px.jpg';
                                        $config['maintain_ratio'] = TRUE; 
                                        $config['master_dim'] = 'width';
                                        $config['width'] = 500; 
                                        $config['height'] = 500; 
                                        
                                        $this->load->library('image_lib');
                                        $this->image_lib->resize();
                                        $this->image_lib->clear();
                                        $this->image_lib->initialize($config); 
                                        if(!$this->image_lib->resize()){
                                            $status = "error";
                                            $msg = $this->image_lib->display_errors();
                                        }
                                        
                                        //Clear image library settings
                                        $this->image_lib->clear();
                                        unset($config);
                                        
                                        // create thumbnail
                                        $config['image_library'] = 'gd2';
                                        $config['quality'] = "100%";
                                        $config['source_image'] = $path_img_500px.'/'.$image_name_encrypt.'.500px.jpg';
                                        $config['new_image'] = $path_img_100px.'/'.$image_name_encrypt.'.100px.jpg';
                                        $config['maintain_ratio'] = TRUE; 
                                        $config['master_dim'] = 'width';
                                        $config['width'] = 100; 
                                        $config['height'] = 100; 
                                        
                                        $this->load->library('image_lib');
                                        $this->image_lib->resize();
                                        $this->image_lib->clear();
                                        $this->image_lib->initialize($config); 
                                        if(!$this->image_lib->resize()){
                                            $status = "error";
                                            $msg = $this->image_lib->display_errors();
                                        }
                                        else{
                                            // add file info to database
                                            $data_image=array('id'=>'', 'projectID'=> $project_id, 'nameOri' => $entry, 'md5sum' => $image_name_encrypt);
                                            $this->load->model('m_pages');
                                            $this->m_pages->upload_image($data_image);
                                            
                                            $status = "success";
            				                $msg = "File successfully uploaded";
                                            
                                            shell_exec("chmod 644 $path_img_ori/$image_name_encrypt.ori.jpg");
                                            shell_exec("chmod 644 $path_img_500px/$image_name_encrypt.500px.jpg");
                                            shell_exec("chmod 644 $path_img_100px/$image_name_encrypt.100px.jpg");
                                        }
                                    }
                                }
                            }
                            
                            else{
                                $status = "error";
                                $msg = "File type error";
                            }
                            }                              
                        }
                    }
                    closedir($handle);
                    shell_exec("rm -r $path_extract");
                }
                
    		}
    	}
    	
        }else{
            $status ="error";
            $msg = "No Project id";
        }
        $report_file_exist = "";
        if(!empty($list_file_exist)){
            $report_file_exist = "Some files can not be processed due to duplicate";
        }
        echo json_encode(array('status' => $status, 'msg' => $msg, 'processed' => 'done', 'report' => $report_file_exist));
    }
    
    function do_editAllLabel(){
        $csv = $this->input->post('csv');
        $u_id = $this->input->post('user_id');
        $p_id = $this->input->post('project_address'); 
        $p_name = $this->input->post('project_name');
        $path_csv = $_SERVER['DOCUMENT_ROOT']."/biomatcher/tmp/csv_tmp/".$this->session->userdata('username');
        if(!is_dir($path_csv)) //create the folder if it's not already exists
        {
         mkdir($path_csv, 0755,true);
        }
        write_file($_SERVER['DOCUMENT_ROOT'].'/biomatcher/tmp/csv_tmp/'.$this->session->userdata('username').'/'.$u_id.'-'.$this->session->userdata('username').'_'.$p_id.'-'.$p_name.'.csv',$csv);  
        //$this->load->library('csvreader');
        //$result =   $this->csvreader->parse_file('../tmp/csv_tmp/dhitatracker/7-dhitatracker_11-Sample Project.csv');
        //echo '<pre>';
        //print_r($result);
        $this->load->model('m_pages');
        $this->m_pages->update_csv();
        delete_files($_SERVER['DOCUMENT_ROOT'].'/biomatcher/tmp/csv_tmp/'.$this->session->userdata('username').'/', true);
        rmdir($_SERVER['DOCUMENT_ROOT'].'/biomatcher/tmp/csv_tmp/'.$this->session->userdata('username').'/');
        $this->load->view('pages/project', $p_id);
        redirect('pages/view/project/'.$p_id, 'refresh');
    }
    
}

?>