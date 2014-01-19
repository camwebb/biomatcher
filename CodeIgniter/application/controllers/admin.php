<?php

class Admin extends CI_Controller {
    
	public function view($page = 'dashboard')
	{

	if ( ! file_exists('../CodeIgniter/application/views/admin/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
    
    

	$data['title'] = ucfirst($page); // Capitalize the first letter
    
    if ($page == 'admin-projects'){
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
        $count_images = $getData->num_rows();
        $config['base_url'] = base_url().'index.php/pages/view/projects/';
        $config['total_rows'] = $count_images; //total rows
        $config['per_page'] = '10'; //the number of per page for pagination
        $config['uri_segment'] = 4; //see from base_url. biomatcher.org/index.php/pages/view/project/pid/pagination
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config); //initialize pagination
        
       	$data['list_project'] = $this->m_admin->list_project($config['per_page'],$this->uri->segment(4));
        $this->load->library('user_agent');
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
                        redirect('admin/view/admin-projects', 'refresh');
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
    
}

?>