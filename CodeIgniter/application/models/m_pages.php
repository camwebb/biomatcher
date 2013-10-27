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
    
    function check_match($img_id){
        $this->db->where('imageA =', $img_id);
        $this->db->or_where('imageB =', $img_id); 
        $query = $this->db->get('match');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
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
        $this->db->order_by('image.id','asc');
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
    
    function count_same($project_id){ 
        $query = $this->db->query("SELECT * FROM `match` INNER JOIN `image` ON match.imageA=image.id WHERE image.projectID = '".$project_id."' AND match.same='yes';");
        return $query->num_rows();
    }
    
    function count_diff($project_id){ 
        $query = $this->db->query("SELECT * FROM `match` INNER JOIN `image` ON match.imageA=image.id WHERE image.projectID = '".$project_id."' AND match.same='no';");
        return $query->num_rows();
    }
    
    function download_statistic($project_id,$same){
        $list_image_a = array();
        $list_image_a[] = "row/col";
        $list_image_b = array();
        //get all imageA with the same projectID
        $q_a = "SELECT id,nameOri from `image` where projectID = '".$project_id."' order by id";
        $get_image_a = $this->db->query($q_a)->result();
        for($i=0;$i<count($get_image_a);$i++){
            //get imageB for every imageA
            $q_b = "SELECT imageB,imageA from `match` where imageA = '".$get_image_a[$i]->id."' and same = '".$same."' or imageB = '".$get_image_a[$i]->id."' and same = '".$same."' order by imageA";
            $get_image_b = $this->db->query($q_b)->result();
            if(!empty($get_image_b)){
                for($j=0;$j<count($get_image_b);$j++){
                    if($get_image_b[$j]->imageB == $get_image_a[$i]->id){
                        if(!in_array($get_image_b[$j]->imageA,$list_image_b)){
                            $list_image_b[]=$get_image_b[$j]->imageA;    
                        } 
                    }
                    else if($get_image_b[$j]->imageA == $get_image_a[$i]->id){
                        if(!in_array($get_image_b[$j]->imageB,$list_image_b)){
                            $list_image_b[]=$get_image_b[$j]->imageB;    
                        }
                    } 
                }
            }
            $list_image_a[]=$get_image_a[$i]->id;
        }
        ksort($list_image_a);
        sort($list_image_b);
        //print_r($list_image_b);
        $matching_image = array();
        //get count
        for($j=0;$j<count($list_image_b);$j++){
            for($i=0;$i<count($get_image_a);$i++){
                $q_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image_a[$i]->id."' and same = '".$same."' and imageB ='".$list_image_b[$j]."' or imageB = '".$get_image_a[$i]->id."' and same = '".$same."' and imageA ='".$list_image_b[$j]."'";
                $get_hitung = $this->db->query($q_hitung)->result();
                $matching_image[$list_image_b[$j]][$get_image_a[$i]->id] = $get_hitung[0]->hitung;
        
            }    
        }
        ksort($matching_image);
        //print_r($matching_image);
        $array[] = $list_image_a;
        for($i=0;$i<count($list_image_b);$i++){
            $ar_row = array();
            $ar_row[0]=$list_image_b[$i];
            $set_counter = 1;
            foreach($matching_image[$list_image_b[$i]] as $key=>$val){
                $ar_row[$set_counter] = $val;
                $set_counter++;
            }
            $array[] = $ar_row;
        }
        $this->load->library('Convertcsv');
        $csv_data = $this->convertcsv->array_to_csv($array, false);
        $this->load->helper('download');
        $data = $csv_data;
        $filename = "SELECT * from `project` where id = '".$project_id."' ";
        $get_filename = $this->db->query($filename)->result();
        foreach ($get_filename as $name){
            if($same == 'yes'){
                $name = 'Same_Statistic-'.$name->name.'.csv';               
            }
            else if($same == 'no'){
                $name = 'Different_Statistic-'.$name->name.'.csv';               
            }
                    
        }
        //print_r($data);
        force_download($name, $data);
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
    
    function pair($project_id){
        $this->db->select('*');
        $this->db->from('match');
        $this->db->join('image', 'match.imageA=image.id');
        $this->db->where('projectID',$project_id);
        $this->db->order_by('image.id','asc');
        $query = $this->db->get();
        $result = $query->result();
        
        foreach ($result as $row){
            echo $row->id.'<br />';
            echo $row->imageB.'<br/>';
        }
        
        
        
        
        //$test[] = array($a);
        
        //echo '<pre>';
        //print_r($test);
        //echo '</hr>';
        
    }
    
    function check_QCSet($project_id){
        $this->db->where('id',$project_id);
        $this->db->select('qcSet');
        $query = $this->db->get('project');
        $result = $query->result();

        foreach ($result as $QC){
            $status = $QC->qcSet;
        }
        return $status;
    }
    
    function getImagePreSame($projectID, $imageID, $label){
        $query=$this->db->query("SELECT id, md5sum, label FROM image where projectID = '$projectID' AND id !='$imageID' AND label = '$label' ");
        return $query->result_array();
    }
    
    function selectProject(){
        $this->db->select('id, userID');
        $project_query = $this->db->get_where('project', array('QCSet' => 'no'));
        return $project_query->result();
    }
    
    function selectQCProject(){
        $this->db->select('id, userID');
        $project_query = $this->db->get_where('project', array('QCSet' => 'yes'));
        return $project_query->result();
    }
    
    function selectImagePre($projectID){
        $query = $this->db->query("SELECT id, md5sum, label ,COUNT(label) as jumlah FROM image a WHERE projectID=$projectID GROUP BY projectID,label HAVING jumlah >1");
        $result_project=$query->result_array();
        
        return $result_project;
    }
    
}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */