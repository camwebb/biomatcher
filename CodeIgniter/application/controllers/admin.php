<?php

class Admin extends CI_Controller {
    
    public function index()
	{
        redirect('admin/view/projects');
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
                //count the algorithm
                $data_sites_QC[] = array('site_url'=>$site->site_url, 'url_activated'=>$site->url_activated, 'success_QC'=>'');
            }
            
            $data['user_projects'] = $data_sites_QC;
            $for_type[] = array('type_project' => 'consumer');
            print_r($data['user_projects']);
        }
        
        $data['for_type'] = $for_type;  
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
    
	$this->load->view('admin/templates/header', $data);
	$this->load->view('admin/'.$page, $data);
	$this->load->view('admin/templates/footer', $data);
    
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
            				'name'   => 'user_admin',
            				'value'  => $login['username'],
            				'expire' => time()+2592000,
            				'path'   => '/',
            				'secure' => FALSE
            			);
            
            			$cookiePassword = array(
            				'name'   => 'pass_admin',
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
    
    public function QC_report(){
        //still on my mind
        foreach ($users as $user){
            $sites = $user->url();
            foreach ($sites as $site){
                foreach ($match_QC as $match){
                    $user_decision = $match->match();
                    if ($imageA->label == $imageB->label){
                        $real_decision = "yes";
                    }else{
                        $real_decision = "no";
                    }
                    
                    if ($user_decision==$real_decision){
                        $argument += 1;
                    }
                    $case +=1;
                }
            }
        }
        echo $case;
        
        //per url
        // get site id
        // get all QC matches by siteID
        // foreach QC_matches as QC_match{
        // get image_label
        // get $user_decision ("yes"/"no" on match)
        // if QC_match->imageA->label == QC_match_imageB->label{
        // then $real_decision == "yes"
        // else $real_decision == "no"}
        // if $user_decision == $real_decision{
        // then $success + = 1}
        // $case + = 1
        // } closing in foreach QC_matches
    }
    
    public function logout()
	{
		$this->load->helper('cookie');
        $this->session->sess_destroy();
		delete_cookie("user_admin");
		delete_cookie("pass_admin");
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
                     'rules'   => 'trim|required|min_length[4]|alpha_numeric|xss_clean'
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
            $this->view($page = 'setting');
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
                     'rules'   => 'trim|min_length[4]|max_length[32]'
                  ),
                array(
                     'field'   => 'renew_pass', 
                     'label'   => 'Re-New Password', 
                     'rules'   => 'trim|matches[new_pass]'
                  )
                );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == FALSE){
            $this->view('setting');
        }
        
        else{
            $this->load->model('m_admin');
            $change_info = $this->m_admin->pass_admin($id_user,$new_pass);
            redirect('admin/view/setting','refresh');
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
    
}

?>