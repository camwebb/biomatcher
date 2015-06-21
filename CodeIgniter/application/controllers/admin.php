<?php

class Admin extends CI_Controller {
    
    public function index()
	{
        $this->load->model('m_admin');
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_admin->user_type($id_user);
        if($type == ''){
            redirect('admin/view/login');
        }else{
            redirect('admin/view/projects');
        }
	}
    
	public function view($page = 'dashboard')
	{

	if ( ! file_exists('../CodeIgniter/application/views/admin/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
    
    $data['title'] = ucfirst($page); // Capitalize the first letter
    
    if ($page == 'projects'){
        $this->load->model('m_admin');
        //check user (must be admin)
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_admin->user_type($id_user);
        if($type != "admin"){
            show_404();
        }
        
        $this->load->library('pagination');
        //count the total rows of projects
        $getData = $this->db->get('project');
        $count_projects = $getData->num_rows();
        $config['base_url'] = base_url().'index.php/pages/view/projects/';
        $config['total_rows'] = $count_projects; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 4; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
       	$data['list_project'] = $this->m_admin->list_project($config['per_page'],$this->uri->segment(4));
        $this->load->library('user_agent');
    }
    
    if ($page == 'users'){
        $this->load->model('m_admin');
        //check user (must be admin)
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_admin->user_type($id_user);
        if($type != "admin"){
            show_404();
        }
        
        $this->load->library('pagination');
        //count the total rows of projects
        $getData = $this->db->get('user');
        $count_users = $getData->num_rows();
        $config['base_url'] = base_url().'index.php/pages/view/users/';
        $config['total_rows'] = $count_users; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 4; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
       	$data['list_user'] = $this->m_admin->list_user($config['per_page'],$this->uri->segment(4));
        $this->load->library('user_agent');
    }
    
    if ($page == 'websites'){
        $this->load->model('m_admin');
        //check user (must be admin)
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_admin->user_type($id_user);
        
        if($type != "admin"){
            show_404();
        }
        
        $this->load->library('pagination');
        //count the total rows of projects
        $getData = $this->db->get('site');
        $count_websites = $getData->num_rows();
        $config['base_url'] = base_url().'index.php/pages/view/users/';
        $config['total_rows'] = $count_websites; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 4; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
       	$data['list_website'] = $this->m_admin->list_website($config['per_page'],$this->uri->segment(4));
        $this->load->library('user_agent');
    }
    
    if ($page == 'user_projects'){
        $this->load->model('m_admin');
        //check user (must be admin)
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_admin->user_type($id_user);
        if($type != 'admin'){
            show_404();
        }
        
        $user_id = $this->uri->segment(4,0);
        $type_project = $this->m_admin->user_type($user_id);
        if($type_project == 'supplier'){
            $data['user_projects'] = $this->m_admin->project_supplier($user_id);
            $for_type[] = array('type_project' => 'supplier');
        }
        else if($type_project == 'consumer'){
            $sites = $this->m_admin->project_consumer($user_id);
            $data_sites_QC = array();
            foreach ($sites as $site){
                //get QC matches data
                $QC_matches_data = $this->QC_report($site->site_id);
                
                //count the algorithm
                $data_sites_QC[] = array('site_url'=>$site->site_url, 'url_activated'=>$site->url_activated, 'success_QC'=>$QC_matches_data);
            }
            
            $data['user_projects'] = $data_sites_QC;
            $for_type[] = array('type_project' => 'consumer');
        }
        
        $data['for_type'] = $for_type;  
        $data['user_data'] = $this->m_admin->user_data($user_id);
    }
    
    if ($page == 'setting'){
        $this->load->model('m_admin');
        //check user (must be admin)
        $id_user = $this->session->userdata('id_user');
        $type = $this->m_admin->user_type($id_user);
        if($type != 'admin'){
            show_404();
        }
    }
    
    if ($page == 'project'){
        $project_id = $this->uri->segment(4, 0);
        $this->load->model('m_admin');
        $this->load->library('pagination');
        //count the total rows of images
        
        $this->db->where('projectID',$project_id);
        $getData = $this->db->get('image');
        $list_image = "list_image";
        
        $count_images = $getData->num_rows();
        
        $config['base_url'] = base_url().'index.php/admin/view/project/'.$project_id.'/';
        $config['total_rows'] = $count_images; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 5; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
        $data['project_data'] = $this->m_admin->project_data($project_id);
        $data['user_data'] = $this->m_admin->user_data($data['project_data'][0]->userID);
       	$data['list_images'] = $this->m_admin->$list_image($config['per_page'],$this->uri->segment(5));
        $data['get_csv'] = $this->m_admin->get_csv(); 
    }
    
    if ($page == 'statistic'){
        $this->load->model('m_admin');
        $project_id = $this->uri->segment(4, 0);

        $matches = array();
        $total = array();
        
        $images = $this->m_admin->match_images($project_id);
        
        $totalMatches = 0;
        
        foreach ($images as $image){
            $A = $this->m_admin->get_name_image($image->imageA);
            $B = $this->m_admin->get_name_image($image->imageB);
            
            $totalMatches += $image->match_sum;
            
            $filenameA = $A[0]->nameOri;
            $filenameB = $B[0]->nameOri;
            
            $same = $this->m_admin->same($image->imageA, $image->imageB, 'yes');
            $different = $this->m_admin->same($image->imageA, $image->imageB, 'no');
            $same_probability = round(($image->same_match/($image->same_match+$image->diff_match))*100,2);
            $different_probability = round(($image->diff_match/($image->same_match+$image->diff_match))*100,2);
            $total_per_images = $image->same_match + $image->diff_match;
            
            $matches[] = array('filenameA' => $filenameA, 'filenameB' => $filenameB, 'same' => $image->same_match, 'different' => $image->diff_match, 'same_probability' => $same_probability, 'different_probability' => $different_probability, 'total_per_images' => $total_per_images );

        }
        
        $matches_send = array_map("unserialize", array_unique(array_map("serialize", $matches)));
        
        $data['project_data'] = $this->m_admin->project_data($project_id);
        $data['matches'] = $matches_send;
        $data['project_id'] = $project_id;
        $data['totalMatches'] = $totalMatches;
    }
    
	$this->load->view('admin/templates/header', $data);
	$this->load->view('admin/'.$page, $data);
	$this->load->view('admin/templates/footer', $data);
    
    }
    
    private function QC_report($siteID){
        $matches_data = $this->m_admin->matches_data($siteID);
        $success = 0;
        $case = 0;
        $percentage = '0';
        //get image data
        if (is_array($matches_data)){
            foreach ($matches_data as $matches){
                $imageA_data = $this->m_admin->image_data($matches->imageA);
                $imageB_data = $this->m_admin->image_data($matches->imageB);
                
                if($imageA_data){
                    //get user decision
                    $user_decision = $matches->same;
                    
                    //check real decision
                    if($imageA_data[0]['label'] == $imageB_data[0]['label']){
                        $real_decision = 'yes';
                    }else{
                        $real_decision = 'no';
                    }
                    
                    if($user_decision == $real_decision){
                        $success +=1;
                    }
                    $case +=1;
                }
            }
            
            //count the percentage
            $this->load->library('biomatcher_lib');
            $percentage = $this->biomatcher_lib->percentage($success,$case);
        }
        
        return $percentage;
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
            $this->load->model('m_admin');
            
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            
            $login =$this->m_admin->login_admin($username);
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
                        redirect('admin/view/projects', 'refresh');
                    }
                    else
                    {
                        //incorrect password
                        $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                        $this->session->set_flashdata('message', 'Incorrect password.');
                        redirect('admin/view/login');
                    }
                }
            }
            else
            {
                //login failed
                $this->session->set_userdata(array('name' => "", 'username' => "", 'id_user' => ""));
                $this->session->set_flashdata('message', 'A user does not exist for the username specified.');
                redirect('admin/view/login');
            }
        }
		
    }
    
    public function logout()
	{
		$this->load->helper('cookie');
        $this->session->sess_destroy();
        delete_cookie("user");
		delete_cookie("pass");
        redirect('admin/view/login', 'refresh');
	}
    
    public function profile_admin()
    {
        $id_user = $this->session->userdata('id_user');
        $name=$this->input->post('name');
        $username=$this->input->post('username');
        $email=$this->input->post('email');
        
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
                     'rules'   => 'trim|required|min_length[4]|alpha_numeric|xss_clean|callback_check_username'
                  ),
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'trim|required|valid_email'
                  ),
                array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'required|md5|callback_check_pass'
                  )
                );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == FALSE){
            $name = form_error('name');
            $username = form_error('username');
            $email = form_error('email');
            $password = form_error('password');
            echo json_encode(array('result' => 'failed','name' => $name, 'username' => $username, 'email' => $email, 'password' => $password)); 
        }
        
        else{
            $this->load->model('m_admin');
            $change_info = $this->m_admin->profile_admin($id_user,$name,$username,$email);
            redirect('admin/view/setting','refresh');
        }
    }
    
    public function pass_admin()
    {
        $id_user = $this->session->userdata('id_user');
        $old_pass= md5($this->input->post('old_pass'));
        $new_pass=md5($this->input->post('new_pass'));
        $renew_pass=md5($this->input->post('renew_pass'));
        
        
        $this->load->library('form_validation');
        // field name, error message, validation rules
        $config = array(
                array(
                     'field'   => 'old_pass', 
                     'label'   => 'Old Password', 
                     'rules'   => 'required|md5|callback_check_pass'
                  ),
                array(
                     'field'   => 'new_pass', 
                     'label'   => 'New Password', 
                     'rules'   => 'required|trim|min_length[4]|max_length[32]'
                  ),
                array(
                     'field'   => 'renew_pass', 
                     'label'   => 'Re-New Password', 
                     'rules'   => 'required|trim|matches[new_pass]'
                  )
                );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == FALSE){
            //echo form_error('old_pass').form_error('new_pass').form_error('renew_pass');
            $old_pass = form_error('old_pass');
            $new_pass = form_error('new_pass');
            $renew_pass = form_error('renew_pass');
            echo json_encode(array('result' => 'failed','old_pass' => $old_pass, 'new_pass' => $new_pass, 'renew_pass' => $renew_pass));    
        }
        
        else{
            $this->load->model('m_admin');
            $change_info = $this->m_admin->pass_admin($id_user,$new_pass);
        }
    }
    
    public function check_pass($key){
        $id_user = $this->session->userdata('id_user');
        $this->load->model('m_admin');
        if($this->m_admin->check_password($id_user,$key))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_pass', 'Wrong Password');
            return FALSE;
        }     
    }

    public function check_username($key){
        $id_user = $this->session->userdata('id_user');
        $this->load->model('m_admin');
        if($this->m_admin->check_username($id_user,$key))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_username', 'Username already exist');
            return FALSE;
        }     
    }
    
    public function download_stats(){
        $project_id = $this->uri->segment(3, 0);
        $percent = $this->uri->segment(5, 0);
        $this->load->model('m_admin');
        $check_match = $this->uri->segment(4, 0);
        if($check_match == 'same'){
            $same = 'yes';
        }
        else if($check_match == 'different'){
            $same = 'no';
        }
        
        $this->m_admin->download_statistic($project_id,$same,$percent);
    }
    
}

?>