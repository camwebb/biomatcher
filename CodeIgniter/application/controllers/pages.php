<?php

class Pages extends CI_Controller {
    
    public function index()
	{
        $data['title'] = ucfirst('Home');
		$this->load->view('templates/header', $data);
    	$this->load->view('pages/home', $data);
    	$this->load->view('templates/footer', $data);
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
    
    if ($page == 'project'){
        $os = $this->config->item('os');
        
        $id_project = $this->uri->segment(4, 0);
        if(!$this->m_pages->check_user_project($id_project)){
            show_404();
        }
        
        $this->load->library('pagination');
        //count the total rows of images
        
        $this->db->where('projectID',$id_project);
        $getData = $this->db->get('image');
        $list_image = "list_image";
        
        $count_images = $getData->num_rows();
        
        $config['base_url'] = base_url().'index.php/pages/view/project/'.$id_project.'/';
        $config['total_rows'] = $count_images; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 5; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
        $data['project_title'] = $this->m_pages->project_title();
       	$data['list_images'] = $this->m_pages->$list_image($config['per_page'],$this->uri->segment(5));
        $data['get_csv'] = $this->m_pages->get_csv();
        
        $data['link_upload'] = 'pages/upload_file';
        if($os == 'windows'){
            $data['link_upload'] = 'dev/upload_file';
        }
    }
    
    if ($page == 'projects'){
        //check user (supplier or consumer by id_user)
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_pages->user_type($id_user);
        if($type == "consumer"){
            show_404();
        }
        
        $this->load->library('pagination');
        //count the total rows of projects
        $this->db->where('userID',$id_user);
        $getData = $this->db->get('project');
        $count_images = $getData->num_rows();
        $config['base_url'] = base_url().'index.php/pages/view/projects/';
        $config['total_rows'] = $count_images; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 4; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
       	$data['list_project'] = $this->m_pages->list_project($config['per_page'],$this->uri->segment(4));
        $this->load->library('user_agent');
    }
    
    if ($page == 'match'){
        if ($this->session->userdata('shuffled_pid') == ""){
            $this->session->set_userdata(array('count_match' => 1));
            $result_project = $this->m_pages->selectProject();
            $shuffled_project = array();
            foreach ($result_project as $project){
                $projectID = $project->id;
                //check if project contain min 5 images
                //note: active project?
                if($this->m_pages->activeProject($projectID)){
                    $shuffled_project[] = $project;
                }
            }
            //shuffle array from project
            shuffle ($shuffled_project);
            
            if(!empty($shuffled_project)){
                $pidA = $shuffled_project[0]->id;
                $userID_A = $shuffled_project[0]->userID;
                
                //get username of project
                $get_username_A = $this->m_pages->get_user($userID_A);
                
                $username_A = $get_username_A[0]->username;
                
                //set session for matching from a project random
                $this->session->set_userdata(array('shuffled_pid' =>$pidA, 'username_pid' => $username_A));
            }
        }
        if ($this->session->userdata('count_match') == 15){
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
                
                if(count($image_pre) > 1){
                    shuffle($image_pre);
                    //print_r($pair_mode[0]);
                    
                    if ($pair_mode[0] == "same"){ // for same pair
                        $image_preB = $this->m_pages->getImagePreSame($project_pre_match[0]->id,$image_pre[0]['id'], $image_pre[0]['label']);
                        $data['pair_match'] = array('projectID_pre' => $project_pre_match[0]->id , 'username_pre' => $username_pre,'shuffled_image_pre_A' => $image_pre[0], 'shuffled_image_pre_B' => $image_preB[0]);
                    }elseif ($pair_mode[0] == "different"){ // for different pair
                        $data['pair_match'] = array('projectID_pre' => $project_pre_match[0]->id , 'username_pre' => $username_pre,'shuffled_image_pre_A' => $image_pre[0], 'shuffled_image_pre_B' => $image_pre[1]);
                    }else{
                        $this->session->set_userdata(array('count_match' => 1));            
                    }
                }else{
                    $this->session->set_userdata(array('count_match' => 1));            
                }
            }else{
                $this->session->set_userdata(array('count_match' => 1));
            }
            
            
        }
        if ($this->session->userdata('count_match') == 16){
            $this->session->set_userdata(array('count_match' => 1));
        }
        $imageRandom = $this->selectRandom();
        $data['imageformatch'] = $imageRandom;
        
    }else{
        $this->session->unset_userdata(array('shuffled_pid' => "", 'username_pid' => ""));
    }
    
    if ($page == 'statistic'){
        $project_id = $this->uri->segment(4, 0);

        if(!$this->m_pages->check_user_project($project_id)){
            show_404();
        }
        $matches = array();
        $total = array();
        
        $images = $this->m_pages->match_images($project_id);
        
        $totalMatches = 0;
        
        foreach ($images as $image){
            $A = $this->m_pages->get_name_image($image->imageA);
            $B = $this->m_pages->get_name_image($image->imageB);
            
            $totalMatches += $image->match_sum;
            
            $filenameA = $A[0]->nameOri;
            $filenameB = $B[0]->nameOri;
            
            $same = $this->m_pages->same($image->imageA, $image->imageB, 'yes');
            $different = $this->m_pages->same($image->imageA, $image->imageB, 'no');
            $same_probability = round(($image->same_match/($image->same_match+$image->diff_match))*100,2);
            $different_probability = round(($image->diff_match/($image->same_match+$image->diff_match))*100,2);
            $total_per_images = $image->same_match + $image->diff_match;
            
            $matches[] = array('filenameA' => $filenameA, 'filenameB' => $filenameB, 'same' => $image->same_match, 'different' => $image->diff_match, 'same_probability' => $same_probability, 'different_probability' => $different_probability, 'total_per_images' => $total_per_images );

        }
        
        $matches_send = array_map("unserialize", array_unique(array_map("serialize", $matches)));
        
        $data['project_title'] = $this->m_pages->project_title();
        $data['matches'] = $matches_send;
        $data['project_id'] = $project_id;
        $data['totalMatches'] = $totalMatches;
    }
    
    if ($page == 'get_code') {
        if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
        
        $this->load->model('m_pages');
        
        $site_id = $this->uri->segment(4);
        if($site_id){
            $user_id = $this->session->userdata('id_user');
            $url = $this->m_pages->get_url_by_site_id($site_id);
            if($url){
                $check_user = $this->m_pages->check_url_owner($user_id, $site_id);
                if($check_user){
                    $get_token = $this->m_pages->get_token($user_id, $site_id);
                    
                    if (!empty($get_token)){
                        $token = $get_token;
                    }else{
                        $token = $this->get_token();
                    }
                    
                    $data['token'] = $token;
                }else{
                    show_404();
                }
            }else{
                show_404();
            }
        }else{
            redirect('pages/view/my_website', 'refresh');
        }
        
    	$data['title'] = ucfirst("Get Code"); // Capitalize the first letter
        $data['url'] = $url;
    	
        $this->load->library('Auth');
        $this->load->model('m_pages');
        
    }
    
    if ($page == 'my_website') {
        if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
        
        $this->load->model('m_pages');
        
        $user_id = $this->session->userdata('id_user');
        
        $this->load->library('pagination');
        $list = "list_website";
        //count the total rows of images
        
        $count = $this->m_pages->count_website($user_id);
        
        $config['base_url'] = base_url().'index.php/pages/view/my_website/';
        $config['total_rows'] = $count; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 4; //see from base_url. biomatcher.org/index.php/pages/view/my_website/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
        //$data_website = $this->m_pages->get_website($user_id);
        //$data['site'] = $data_website;
        
        $data['site'] = $this->m_pages->$list($user_id,$config['per_page'],$this->uri->segment(4));
    	$data['title'] = ucfirst("My Website"); // Capitalize the first letter
    	
        $this->load->library('Auth');
        $this->load->model('m_pages');
        
    }   
    
    if ($page == 'download_statistic'){
        $project_id = $this->uri->segment(4, 0);
        
        if(!$this->m_pages->check_user_project($project_id)){
            show_404();
        }
        
        $same = $this->m_pages->count_same($project_id);
        $diff = $this->m_pages->count_diff($project_id);
        
        $count = array();
        $count[] = array('same' => $same, 'diff' => $diff);
        
        $data['project_title'] = $this->m_pages->project_title();
        $data['count_condition'] = $count;
    }
    
	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);
    
    }
    
    public function download_stats(){
        $project_id = $this->uri->segment(3, 0);
        $percent = $this->uri->segment(5, 0);
        $this->load->model('m_pages');
        if(!$this->m_pages->check_user_project($project_id)){
            show_404();
        }
        $check_match = $this->uri->segment(4, 0);
        if($check_match == 'same'){
            $same = 'yes';
        }
        else if($check_match == 'different'){
            $same = 'no';
        }
        
        $this->m_pages->download_statistic($project_id,$same,$percent);
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
            
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            
            $login =$this->m_pages->login_user($username);
            if ($login['sukses'] == 1 )
            {
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
                        $this->session->set_userdata(array('name' =>$login['name'],'username' => $login['username'], 'id_user' => $login['id'], 'email' => $login['email'], 'type' => $login['type']));
            			$cookieUsername = array(
            				'name'   => 'user',
            				'value'  => $login['username'],
            				'expire' => time()+2592000,
            				'path'   => '/',
            				'secure' => FALSE
            			);
            
            			$cookiePassword = array(
            				'name'   => 'pass',
            				'value'  => $login['password'],
            				'expire' => time()+2592000,
            				'path'   => '/',
            				'secure' => FALSE
            			);
                		//set cookie to browser
                		$this->input->set_cookie($cookieUsername);
                		$this->input->set_cookie($cookiePassword);
                        if ($login['type'] == 'admin'){
                            redirect('admin', 'refresh');
                        }else{
                            redirect('', 'refresh');
                        }
                        
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
    
    function userlog()
    {
        $this->load->helper('cookie');
        $this->load->model('m_pages');
        
        $username = $this->input->cookie('user');
        $password = $this->input->cookie('pass');        
                
        $login =$this->m_pages->login_user($username);
        if ($login['sukses'] == 1 )
        {
            $user_credentials = array();
    		$user_credentials[$username] = array(
    			'username' => $login['username'],
    			'password' => $login['password']
    		);
            if(array_key_exists($username, $user_credentials))
            {
                if($password == $user_credentials[$username]['password'])
                {
                    //login success
                    $this->session->set_userdata(array('name' =>$login['name'],'username' => $login['username'], 'id_user' => $login['id'], 'type' => $login['type']));
        			$cookieUsername = array(
        				'name'   => 'user',
        				'value'  => $login['username'],
        				'expire' => time()+2592000,
        				'path'   => '/',
        				'secure' => FALSE
        			);
        
        			$cookiePassword = array(
        				'name'   => 'pass',
        				'value'  => $login['password'],
        				'expire' => time()+2592000,
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
                    $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => "", 'shuffled_pid' => ""));
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
    
    public function logout()
	{
		$this->load->helper('cookie');
        $this->session->sess_destroy();
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
    
    function auth_register($page = 'auth_register')
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
    
    function do_addProject()
    {
        //function add project
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $config = array(
               array(
                     'field'   => 'nameProject', 
                     'label'   => 'Project Name', 
                     'rules'   => 'trim|required|min_length[4]|callback_project_exists|xss_clean' //alpha_numeric|
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
        redirect('pages/view/projects', 'refresh');
        }
    }
    
    function project_exists($key)
    {
        $this->load->model('m_pages');
        if($this->m_pages->project_exists($key))
        {
            $this->form_validation->set_message('project_exists', 'Project name already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }     
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
                $size_image_medium = '400px';
                $size_image_thumbnail = '100px';
                
                
    			$data = $this->upload->data();
            	$file = $data['full_path'];
                $file_name = $data['raw_name'];
                $path_extract = $data['file_path'].$file_name;
                $path_data = 'data/';
                $path_user = $path_data.$this->session->userdata('username');
                $path_project = $path_user.'/'.$project_id;
                $path_img = $path_project.'/img';
                $path_img_ori = $path_img.'/ori';
                $path_img_medium = $path_img.'/'.$size_image_medium;
                $path_img_thumbnail = $path_img.'/'.$size_image_thumbnail;
                $num = 0;                                
                
                mkdir($path_extract, 0755);

                //extract and delete zip file             
                shell_exec("unzip -jo $file  -d $path_extract");
                unlink($file);
                
                //create folder if not exist
                $toCreate = array($path_user, $path_project, $path_img, $path_img_ori, $path_img_medium, $path_img_thumbnail);
                $permissions = 0755;
                foreach ($toCreate as $dir) {
                    if (!is_dir($dir)){
                        mkdir($dir, $permissions, TRUE);
                    }
                }
                
                $list = count(glob($path_extract.'/'. "*.{jpg,jpeg}",GLOB_BRACE));

                if ($handle = opendir($path_extract)) {
                    // loop over the directory.
                    while (false !== ($entry = readdir($handle))) {
                        //print_r($entry);
                        if(preg_match('#\.(jpg|jpeg)$#i', $entry))
                        {
                            //$num +=1;
                            $now = date("Y-m-d H:i:s");
                            $image_name_encrypt = md5($entry.$now);
                            
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
                                    //$list_file_exist = array();
                                    $list_file_exist[] = $entry;
                                    $count_file_exist = count($list_file_exist, COUNT_RECURSIVE);
                                    //echo json_encode(array('list' => $list, 'num' => $count_file_exist));
                                    
                                    $file_processed = $list - $count_file_exist;
                                    if($file_processed < 1){
                                        $status = "error";
                                        $msg = "No image processed";
                                    }else{
                                        $status = "success";
                                        $msg = "File successfully uploaded";
                                    }
                                }else{
                                    $num += 1;
                                    //echo json_encode(array('num_process' => $num));
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
                                        $config['new_image'] = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
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
                                        $config['source_image'] = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
                                        $config['maintain_ratio'] = TRUE; 
                                        $config['master_dim'] = 'width';
                                        $config['width'] = 400; 
                                        $config['height'] = 400; 
                                        
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
                                        $config['source_image'] = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
                                        $config['new_image'] = $path_img_thumbnail.'/'.$image_name_encrypt.'.'.$size_image_thumbnail.'.jpg';
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
                                            $this->load->model('m_pages');
                                            
                                            $data_image=array('id'=>'', 'projectID'=> $project_id, 'nameOri' => $entry, 'md5sum' => $image_name_encrypt);
                                            $this->m_pages->upload_image($data_image);
                                            
                                            $status = "success";
            				                $msg = "File successfully uploaded";
                                            
                                            shell_exec("chmod 644 $path_img_ori/$image_name_encrypt.ori.jpg");
                                            shell_exec("chmod 644 $path_img_medium/$image_name_encrypt.$size_image_medium.jpg");
                                            shell_exec("chmod 644 $path_img_thumbnail/$image_name_encrypt.$size_image_thumbnail.jpg");
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
        echo json_encode(array('status' => $status, 'msg' => $msg, 'processed' => 'done', 'report' => $report_file_exist, 'pID' => $project_id));
    }
    
    function do_editAllLabel(){
        $csv = $this->input->post('csv');
        $user_id = $this->input->post('user_id');
        $project_address = $this->input->post('project_address'); 
        $project_name = $this->input->post('project_name');
        $server_root = $_SERVER['DOCUMENT_ROOT'];
        $path_csv = $server_root."/biomatcher/tmp/csv_tmp/".md5($this->session->userdata('username'));
        if(!is_dir($path_csv)) //create the folder if it's not already exists
        {
         mkdir($path_csv, 0755,true);
        }
        $folder_encrypt = md5($user_id.'-'.$this->session->userdata('username').'_'.$project_address.'-'.$project_name); 
        write_file($path_csv.'/'.$folder_encrypt.'.csv',$csv);  
        //$this->load->library('csvreader');
        //$result =   $this->csvreader->parse_file('../tmp/csv_tmp/dhitatracker/7-dhitatracker_11-Sample Project.csv');
        //echo '<pre>';
        //print_r($result);
        $this->load->model('m_pages');
        $this->m_pages->update_csv($user_id,$project_address,$project_name,$path_csv,$folder_encrypt);
        delete_files($path_csv.'/', true);
        rmdir($path_csv.'/');
    }
    
    function find_IDLabel(){
        $id_label = $this->input->post('id_label');
        $this->load->model('m_pages');
        $this->m_pages->id_label($id_label);
    }
    
    function do_editLabel(){
        $id_label2 = $this->input->post('id_label2');
        $new_label = $this->input->post('new_label');
        $new_label = $this->security->xss_clean($new_label);
        $this->load->model('m_pages');
        $this->m_pages->edit_label($id_label2,$new_label);
    }
    
    function selectRandom(){
        $time_start = $this->microtime_float();
        if($this->session->userdata('username_pid')!= ""){

            $pidA = $this->session->userdata('shuffled_pid');
            
            $this->db->where('projectID',$pidA);
            $image_query_A = $this->db->get('image');
            $image_A = $image_query_A->result_array();
            shuffle ($image_A);
            $shuffled_image_A = $image_A[0];
            $shuffled_image_B = $image_A[1];

            $time_end = $this->microtime_float();
            $time= $time_end - $time_start;
    
            $shuffled_image = array('shuffled_image_A' => $shuffled_image_A, 'shuffled_image_B' => $shuffled_image_B);
            return $shuffled_image;
        }       
    }
    
    function microtime_float()
    {
       list($usec, $sec) = explode(" ", microtime());
       return ((float)$usec + (float)$sec);
    }
    
    function insert_match(){
        $this->load->model('m_pages');
        
        $imageIDA = $this->input->post('imageIDA');
        $imageIDB = $this->input->post('imageIDB');
        $same     = $this->input->post('same');
        $matcher  = $this->session->userdata('id_user');
        $date     = date("Y-m-d H:i:s");
        
        if (!empty($imageIDA) && !empty($imageIDB) && !empty($matcher)){
            $data     = array('id' => '', 'imageA' => $imageIDA, 'imageB' => $imageIDB, 'time' => $date, 'matcher' => $matcher, 'same' => $same);
            $this->m_pages->insert_match($data);
            $status = 'success';
            $count_match = $this->session->userdata('count_match') + 1;
            $this->session->set_userdata(array('count_match' =>$count_match));
        }else{
            $status = 'error';
        }
        
        echo json_encode(array('status' => $status));
    }
    
    function insert_match_byToken(){
        $this->load->model('m_pages');
        
        $imageIDA = $this->input->post('imageIDA');
        $imageIDB = $this->input->post('imageIDB');
        $same     = $this->input->post('same');
        $token    = $this->input->post('token');
        $site     = $this->input->post('site');
        
        //authenticate site & token
        $site_id  = $this->m_pages->check_url($site);
        if($site_id){
            $check_token = $this->m_pages->check_token($token, $site_id);
            if($check_token){
                //get user data 
                $matcher  = $this->m_pages->get_id_byToken($token);
                $date     = date("Y-m-d H:i:s");
                
                if (!empty($imageIDA) && !empty($imageIDB) && !empty($matcher)){
                    //insert match data
                    $data     = array('id' => '', 'imageA' => $imageIDA, 'imageB' => $imageIDB, 'time' => $date, 'matcher' => $matcher, 'same' => $same, 'siteID'=> $site_id);
                    $this->m_pages->insert_match($data);
                    $status = 'success';
                }else{
                    $status = 'error';
                }
            }
        }
        
        echo json_encode($status);
    }
    
    function install_auth($page = 'auth_register')
    {
        if ( ! file_exists('../CodeIgniter/application/views/pages/'.$page.'.php'))
    	{
    		// Whoops, we don't have a page for that!
    		show_404();
    	}
        
        $this->load->library('Auth');
        $this->auth->install();
        
    }
    
    function get_token(){
        $this->load->library('Auth');
        $this->load->model('m_pages');
        
        $site_id_uri = $this->uri->segment(4);
        if(!empty($site_id_uri)){
            $site_id = $site_id_uri;
        }else if (!empty($_GET['site_id'])){
            $site_id = $_GET['site_id'];
        }       
        
        $user_id = $this->session->userdata('id_user');        
        $token = $this->auth->get_activate_token($user_id, $site_id);
        
        if (!empty($_GET)){
            echo $token;
        }
        
        return $token;
            
        //redirect('pages/view/my_website', 'refresh');
          
    }
    
    function add_site(){
        //function add site
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $config = array(
               array(
                     'field'   => 'url', 
                     'label'   => 'URL', 
                     'rules'   => 'trim|required|min_length[4]|url|xss_clean|prep_url|urldecode|callback_site_exists' //alpha_numeric|
                  )
            );
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run() == FALSE)
        {
            $this->view($page = 'my_website');
        }
        else
        {
            $this->load->library('Auth');
            $this->load->model('m_pages');
            
            $url = $this->input->post('url');
            $user_id = $this->session->userdata('id_user');        
            $register_site = $this->auth->register($url, $user_id);
            
            if ($register_site){
                redirect('pages/view/my_website', 'refresh');
            }
        }
    }
    
    function site_exists($key)
    {
        $this->load->model('m_pages');
        if($this->m_pages->site_exists($key))
        {
            $this->form_validation->set_message('site_exists', 'URL already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }     
    }
    
}

?>