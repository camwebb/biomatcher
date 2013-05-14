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
    
    function add_project(){
        $id_user = $this->session->userdata('id_user');
        $data=array(
        'userID' => $id_user,
        'name'=>$this->input->post('nameProject'),
        'qcSet'=>$this->input->post('type'),
        );
        $this->db->insert('project',$data);
    }
    
    function upload_image($data_image){
        $this->db->insert('image', $data_image);
    }
    
  /*  function getIdLabel(){
        $query=$this->db->query("SELECT * FROM image where id='7'");
        return $query->result();   
    }*/
    
    function get_csv(){
        $this->load->dbutil();
        $project_id = $this->uri->segment(4, 0);
        $query = $this->db->query("SELECT nameOri,label FROM image where projectID='$project_id'");
        return $query->result();  
        $delimiter = ",";
        $newline = "\r\n";
      // echo $this->dbutil->csv_from_result($query, $delimiter, $newline);
    }    
    
    function update_csv(){
        $u_id = $this->input->post('user_id');
        $p_id = $this->input->post('project_address'); 
        $p_name = $this->input->post('project_name');
        $this->load->dbforge();
        $fields = array(
                        'nameOri' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '200',
                                          ),
                        'label' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '100',
                                        ),
                );
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('tmp_image');
        $query= $this->db->query("LOAD DATA INFILE '../../htdocs/biomatcher/codeigniter/data/csv_tmp/".$this->session->userdata('username')."/".$u_id."-".$this->session->userdata('username')."_".$p_id."-".$p_name.".csv' INTO TABLE tmp_image FIELDS TERMINATED BY ',' (nameOri,label); ");
        $query2= $this->db->query("UPDATE image INNER JOIN tmp_image on tmp_image.nameOri = image.nameOri SET image.label = tmp_image.label;");
        $this->dbforge->drop_table('tmp_image');
    }
    

}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */