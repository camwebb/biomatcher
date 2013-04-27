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
            $hasil['name']=$data[0]->name;
        }
        return $hasil;
    }
    
    function register_user()
    {
        $data=array(
        'name'=>$this->input->post('name'),
        'username'=>$this->input->post('username'),
        'email'=>$this->input->post('email'),
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
    
    function list_project(){
        $id_user = $this->session->userdata('id_user');
        $query=$this->db->query("SELECT * FROM project where userID='$id_user'");
        return $query->result();
    }
    
    function list_image(){
        $project_id = $this->uri->segment(4, 0);
        $query=$this->db->query("SELECT * FROM image where projectID='$project_id'");
        return $query->result();
    }
    
    function project_title(){
        $project_id = $this->uri->segment(4, 0);
        $query=$this->db->query("SELECT * FROM project where id='$project_id'");
        return $query->result();            
    }
    
    function list_edit_label(){
        $image_id = $this->input->post('id');
        //$image_id = '2';
        echo $image_id;
        $query=$this->db->query("SELECT * FROM image where id='$image_id'");
        return $query->result();
    }
    
    function test_csv(){
        $this->load->dbutil();
        $query = $this->db->query("SELECT label FROM image WHERE id='7'");
        $delimiter = ",";
        $newline = "\r\n";
        echo $this->dbutil->csv_from_result($query, $delimiter, $newline);
      
   // return $query = $this->db->get('user');
    }        
    

}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */