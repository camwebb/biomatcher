<?php
class M_pages extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function login_user($username)
    {
        $query = $this->db->query("SELECT * FROM user where username='$username' limit 1");

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
        $query=$this->db->query("SELECT * FROM project where userID='$id_user' order by id ASC");
        return $query->result();
    }
    
    function list_image($perPage,$uri){
        $project_id = $this->uri->segment(4, 0);

        $this->db->where('projectID',$project_id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get('image', $perPage, $uri);
        
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
    
    function file_exist($list_file)
    {
        //checking file name
        $query = $this->db->get_where('image', $list_file);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function get_csv(){
        $this->load->dbutil();
        $project_id = $this->uri->segment(4, 0);
        $query = $this->db->query("SELECT nameOri,label FROM image where projectID='$project_id' order by id DESC");
        return $query->result();  
        $delimiter = ",";
        $newline = "\r\n";
      // echo $this->dbutil->csv_from_result($query, $delimiter, $newline);
    }    
    
    function update_csv(){
        $user_id = $this->input->post('user_id');
        $project_address = $this->input->post('project_address'); 
        $project_name = $this->input->post('project_name');
        $path_csv = "/home/bmatch/biomatcher/tmp/csv_tmp/".md5($this->session->userdata('username'));
        $folder_encrypt = md5($user_id.'-'.$this->session->userdata('username').'_'.$project_address.'-'.$project_name);                 
        $this->load->dbforge();
        $this->dbforge->drop_table('tmp_image'); 
        $fields = array(
                        'nameOri' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '200',
                                          ),
                        'label' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '100',
                                                 'null' => TRUE,
                                                 'default' => 'NULL',
                                        ),
                );
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('tmp_image');
        $this->load->library('csvreader');
        $result = $this->csvreader->parse_file($path_csv.'/'.$folder_encrypt.'.csv');
        $this->db->insert_batch('tmp_image', $result);
        $query1= $this->db->query("UPDATE image INNER JOIN tmp_image on tmp_image.nameOri = image.nameOri SET image.label = NULL WHERE image.projectID = $project_address AND tmp_image.label='';");
        $this->db->insert_batch('tmp_image', $result);
        $query2= $this->db->query("UPDATE image INNER JOIN tmp_image on tmp_image.nameOri = image.nameOri SET image.label = tmp_image.label WHERE image.projectID = $project_address AND tmp_image.label!='';");
        $this->dbforge->drop_table('tmp_image');        
    }
    
    function id_label(){
        $id_label = $this->input->post('id_label');
        $query=$this->db->query("SELECT * FROM image where id='$id_label'");
        foreach ($query->result() as $row)
        {
           echo $row->label;
        }
    }
    
    function edit_label(){
        $id_label2 = $this->input->post('id_label2');
        $new_label = $this->input->post('new_label');
        $query=$this->db->query("UPDATE image SET label='$new_label' WHERE id='$id_label2'");
        echo $new_label;
    }
    
    function delete_image($img_id){
        $this->db->where('id IN ('.implode(',',$img_id).')', NULL, FALSE);
        $this->db->delete('image');
        return true;
    }
    
    function get_user($id_project){
        $this->db->select('username');
        $this->db->where('id',$id_project);
        $query = $this->db->get('user');
        return $query->result();
        //print_r($query->result());
    }
    
    function activeProject($projectID)
    {
        //checking is project active
        $this->db->where('projectID',$projectID);
        $query = $this->db->get('image');
        if ($query->num_rows() > 5){
            return true;
        }
        else{
            return false;
        }
    }
}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */