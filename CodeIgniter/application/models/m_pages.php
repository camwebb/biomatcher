<?php
class M_pages extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function login_user()
    {
        $username=$this->input->post('username');
        //$password=md5($this->input->post('password'));
        $password=$this->input->post('password');
        $query = $this->db->query("SELECT * FROM users where username='$username' and password='$password' limit 1;");
		
		//$query = $this->db->query('users', array('username'=> 'fitri', 'password'=> '12345'))-> row_array();
        $data=$query->result();
        $hasil['sukses']=$query->num_rows();
        
        if ($query->num_rows() >=1)
        {
            $hasil['id']=$data[0]->id;
            $hasil['username']=$data[0]->username;
            //$hasil['email']=$data[0]->email;
        }
        return $hasil;
        //return $query->num_rows();
    }
    
    function register_user()
    {
        $id = "";
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $type = $this->input->post('type');
        
        
       $data = array (
                    'id' => $id,
                    'username'=> $username,
                    'password' => $password,
                    'type' => $type
                    );
    
        $this->db->insert('users',$data);    
    
    }

}

/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */