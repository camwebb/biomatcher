<?php
class M_admin extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function login_admin($username)
    {
        $query = $this->db->query("SELECT * FROM user where username='$username' and type='admin' limit 1");

        $data=$query->result();
        $hasil['sukses']=$query->num_rows();
        
        if ($query->num_rows() >=1)
        {
            $hasil['id']=$data[0]->id;
            $hasil['username']=$data[0]->username;
            $hasil['email']=$data[0]->email;
			$hasil['password']=$data[0]->password;
            $hasil['name']=$data[0]->name;
            $hasil['type']=$data[0]->type;
        }
        return $hasil;
    }
    
    function check_password($id_user,$key){
        $query = $this->db->query("SELECT * FROM user where id = '".$id_user."' and password ='".$key."' ");
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function profile_admin($id_user,$name,$username,$email){
        $data = array(
               'name' => $name,
               'username' => $username,
               'email' => $email
            );
        
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);    
        
        $data_admin = $this->db->get_where('user', array('id' => $id_user));
        $get_admin = $data_admin->result();  
        $this->session->set_userdata(array('name' =>$get_admin[0]->name,'username' => $get_admin[0]->username, 'id_user' => $get_admin[0]->id, 'email' => $get_admin[0]->email, 'type' => $get_admin[0]->type));
    }
    
    function pass_admin($id_user,$new_pass){
        $data = array(
               'password' => $new_pass
            );
        
        $this->db->where('id', $id_user);
        $this->db->update('user', $data); 
    }
    
    function user_type($id){
        $this->db->select('type');
        $user = $this->db->get_where('user', array('id' => $id));
        $user_type = $user->result();
        if(!empty($user_type)){
            foreach ($user_type as $userData){
                $return_type = $userData->type;
            }
            return $return_type;
        }
    }
    
    function list_project($perPage,$uri){
        $this->db->select('project.name as project_name,user.name as user_name,project.id as project_id,project.userID as project_userID');
        $this->db->order_by('project.id','ASC');
        $this->db->join('user', 'project.userID = user.id','left');
        $query = $this->db->get('project', $perPage, $uri);
        return $query->result();
    }
    
    function list_user($perPage,$uri){
        $query = $this->db->get('user', $perPage, $uri);
        return $query->result();
    }
    
    function list_website($perPage,$uri){
        $this->db->order_by('site.id','ASC');
        $this->db->join('user', 'site.userID = user.id','left');
        $query = $this->db->get('site', $perPage, $uri);
        return $query->result();
    }
    
    function project_supplier($user_id){
        $this->db->select('project.id as project_id, project.name as project_name, project.qcSet as project_qcSet, user.username as username, user.name as name, user.type as type, user.email as email');
        $this->db->join('project', 'project.userID = user.id');
        $this->db->where('user.id',$user_id);
        $query = $this->db->get('user');
        return $query->result();
    }
    
    function project_consumer($user_id){
        $this->db->select('site.id as site_id, site.url as site_url, site.url_activated as url_activated, user.username as username, user.name as name, user.type as type, user.email as email');
        $this->db->join('site', 'site.userID = user.id');
        $this->db->where('user.id',$user_id);
        $query = $this->db->get('user');
        return $query->result();
    }
}


/* End of file m_admin.php */
/* Location: ./application/models/m_admin.php */