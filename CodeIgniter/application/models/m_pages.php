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
    
    function project_exists($nameProject)
    {
        $id_user = $this->session->userdata('id_user');
        $where = array('name'=> $nameProject, 'userID' => $id_user);
        
        $query = $this->db->get_where('project', $where);
        
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function list_project($perPage,$uri){
        $id_user = $this->session->userdata('id_user');
        //$query=$this->db->query("SELECT * FROM project where userID='$id_user' order by id ASC");
        $this->db->where('userID',$id_user);
        $this->db->order_by('id','ASC');
        $query = $this->db->get('project', $perPage, $uri);
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
    
    function update_csv($user_id,$project_address,$project_name,$path_csv,$folder_encrypt){
        $this->load->dbforge();
        $this->dbforge->drop_table('tmp_image'); 
        $fields = array(
                        'FILENAME' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '200',
                                          ),
                        'LABEL' => array(
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
        $query1= $this->db->query("UPDATE image INNER JOIN tmp_image on tmp_image.FILENAME = image.nameOri SET image.label = NULL WHERE image.projectID = $project_address AND tmp_image.LABEL='';");
        $this->db->insert_batch('tmp_image', $result);
        $query2= $this->db->query("UPDATE image INNER JOIN tmp_image on tmp_image.FILENAME = image.nameOri SET image.label = tmp_image.LABEL WHERE image.projectID = $project_address AND tmp_image.LABEL!='';");
        $this->dbforge->drop_table('tmp_image');        
    }
    
    function id_label($id_label){
        $query=$this->db->query("SELECT * FROM image where id='$id_label'");
        foreach ($query->result() as $row)
        {
           echo $row->label;
        }
    }
    
    function edit_label($id_label2,$new_label){
        $query=$this->db->query("UPDATE image SET label='$new_label' WHERE id='$id_label2'");
        echo $new_label;
    }
    
    function delete_image($img_id){
        $this->db->where('id IN ('.implode(',',$img_id).')', NULL, FALSE);
        $this->db->delete('image');
        return true;
    }
    
    function get_user($idUser){
        //get one user data
        $this->db->select('username');
        $this->db->where('id',$idUser);
        $query = $this->db->get('user');
        return $query->result();
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
    
    function insert_match($data){
        $this->db->insert('match', $data);
    }
    
    function match_images($key){
        $this->db->distinct();  
        $this->db->from('match');
        $this->db->join('image', 'match.imageA = image.id');
        $this->db->where('projectID', $key);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_name_image($id){
        $this->db->select('nameOri');
        $this->db->where('id',$id);
        $query = $this->db->get('image');
        return $query->result();
    }
    
    function same($imageA, $imageB, $same){
        $where = array('imageA'=> $imageA, 'imageB' => $imageB, 'same' => $same);
        
        $query = $this->db->get_where('match', $where);

        return $query->num_rows();
    }
    
    function total_matches($imageA){
        $this->db->where('imageA IN ('.implode(',',$imageA).')', NULL, FALSE);
        $query = $this->db->get('match');
        return $query->num_rows();
    }
    
    function check_user_project($id_project){
        //get user id from project
        $this->db->where('id',$id_project);
        $this->db->select('userID');
        $query = $this->db->get('project');
        $result = $query->result();
        
        $userID = "";
        foreach ($result as $user){
            $userID = $user->userID;
        }
        
        if ($userID == $this->session->userdata('id_user')){
            return true;
        }else{
            return false;
        }
    }
    
    function csv(){
        $array[] = array('key1' => 'row1-1', 'key2' => 'row1-2', 'key3' => 'row1-3', 'key4' => 'row1-4', 'key5' => 'row1-5');
        $array[] = array('key1' => 'row2-1', 'key2' => 'row2-2', 'key3' => 'row2-3', 'key4' => 'row2-4', 'key5' => 'row2-5');
        $array[] = array('key1' => 'row3-1', 'key2' => 'row3-2', 'key3' => 'row3-3', 'key4' => 'row3-4', 'key5' => 'row3-5');
        $array[] = array('key1' => 'row4-1', 'key2' => 'row4-2', 'key3' => 'row4-3', 'key4' => 'row4-4', 'key5' => 'row4-5');
        
        echo '<pre>';
        print_r($array);
        echo '</hr>';
        
        //Converting array to SCV.
        $csv_data = array_to_scv($array, false);
        print_r($csv_data);
        
        
        echo '</pre>';
    }
    
}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */