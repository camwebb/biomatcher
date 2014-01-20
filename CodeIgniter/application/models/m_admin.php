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
			$hasil['password']=$data[0]->password;
            $hasil['name']=$data[0]->name;
            $hasil['type']=$data[0]->type;
        }
        return $hasil;
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
}


/* End of file m_admin.php */
/* Location: ./application/models/m_admin.php */