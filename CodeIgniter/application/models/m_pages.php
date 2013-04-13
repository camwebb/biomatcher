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
        $password=md5($this->input->post('password'));
        $query = $this->db->query("SELECT * FROM user where username='$username' limit 1;");

        $data=$query->result();
        $hasil['sukses']=$query->num_rows();
        
        if ($query->num_rows() >=1)
        {
            $hasil['id']=$data[0]->id;
            $hasil['username']=$data[0]->username;
			$hasil['password']=$data[0]->password;
        }
        return $hasil;
    }
    
    function register_user()
    {
        $data=array(
        'username'=>$this->input->post('username'),
        'type'=>$this->input->post('type'),
        'password'=>md5($this->input->post('password'))
        );
        $this->db->insert('user',$data);
    }
    
    function username_exists($key)
    {
        $this->db->where('username',$key);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0){
    
            return true;
        }
        else{
            return false;
        }
    }

}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */