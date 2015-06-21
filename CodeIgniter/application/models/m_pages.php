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
            $hasil['email']=$data[0]->email;
			$hasil['password']=$data[0]->password;
            $hasil['name']=$data[0]->name;
            $hasil['type']=$data[0]->type;
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

    function edit_profile($id_user,$name,$username,$email){
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
        echo json_encode(array('result' => 'Success')); 
    }
    
    function edit_pass($id_user,$new_pass){
        $data = array(
               'password' => $new_pass
            );
        
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        echo json_encode(array('result' => 'Success')); 
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

    function check_username($id_user,$key){
        $query = $this->db->query("SELECT * FROM user where id = '".$id_user."' and username ='".$key."' ");
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            $query2 = $this->db->query("SELECT * FROM user where username ='".$key."' ");
            if ($query2->num_rows() > 0){
                return FALSE;
            }
            else{
                return TRUE;
            }
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
    
    function site_exists($site)
    {
        $id_user = $this->session->userdata('id_user');
        $where = array('url'=> $site, 'userID' => $id_user);
        
        $query = $this->db->get_where('site', $where);
        
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function list_project($perPage,$uri){
        $id_user = $this->session->userdata('id_user');
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
    
    function get_img_by_id($id){
        $this->db->where('id',$id);
        $img_file = $this->db->get('image');
        $return = $img_file->result();
        return $return;
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
    
    function match_images($projectID){
        $query = $this->db->query("SELECT m.imageA,m.imageB,projectID, CONCAT (GREATEST(m.imageA,m.imageB),',',LEAST(m.imageA,m.imageB)) as pair_id,
                    sum(case when m.same = 'yes' then 1 else 0 end) as same_match,
                    sum(case when m.same = 'no' then 1 else 0 end) as diff_match,
                    COUNT(*) as match_sum
                    FROM `match` m
                    JOIN `image` i ON m.`imageA` = i.`id` WHERE i.`projectID` = '$projectID'
                    GROUP BY pair_id");
        $stat=$query->result();
        
        return $stat;
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
        $query = $this->db->query("SELECT * FROM `match` INNER JOIN `image` ON match.imageA=image.id or match.imageB=image.id WHERE image.projectID = '".$project_id."' AND match.same='yes';");
        return $query->num_rows();
    }
    
    function count_diff($project_id){ 
        $query = $this->db->query("SELECT * FROM `match` INNER JOIN `image` ON match.imageA=image.id or match.imageB=image.id WHERE image.projectID = '".$project_id."' AND match.same='no';");
        return $query->num_rows();
    }
    
    function download_statistic($project_id,$same,$percent){
        $list_image_a = array();
        $list_image_a[] = "imageA/imageB";
        $list_image_b = array();
        //get all image with the same projectID
        $q_a = "SELECT id,nameOri from `image` where projectID = '".$project_id."' order by id";
        $get_image = $this->db->query($q_a)->result();
        for($i=0;$i<count($get_image);$i++){
            //divide into 2 list images
            $list_image_a[]=$get_image[$i]->nameOri;
            $list_image_b[]=$get_image[$i]->nameOri;
        }    
        //print_r($list_image_a);
        //print_r($list_image_b);
        
        $matching_image = array();
        //get count
        if($percent == 'no'){
            for($j=0;$j<count($get_image);$j++){
                for($i=0;$i<count($get_image);$i++){
                    $q_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image[$i]->id."' and same = '".$same."' and imageB ='".$get_image[$j]->id."'";
                    $get_hitung = $this->db->query($q_hitung)->result();
                    $matching_image[$get_image[$j]->nameOri][$get_image[$i]->nameOri] = $get_hitung[0]->hitung;
                }    
            }
        }
        //get percent count
        else if($percent == 'yes'){
            for($j=0;$j<count($get_image);$j++){
                for($i=0;$i<count($get_image);$i++){
                    if($same == 'yes'){
                        $comparison = 'no';
                    }
                    else if($same == 'no'){
                        $comparison = 'yes';
                    }
                    $q_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image[$i]->id."' and same = '".$same."' and imageB ='".$get_image[$j]->id."'";
                    $get_hitung = $this->db->query($q_hitung)->result();
                    $c_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image[$i]->id."' and same = '".$comparison."' and imageB ='".$get_image[$j]->id."'";
                    $get_hitung_comparison = $this->db->query($c_hitung)->result();
                    
                    $initial = $get_hitung[0]->hitung;
                    $comparative = $get_hitung_comparison[0]->hitung;
                    
                    if($initial == 0){
                        $percentage = 0;
                    }
                    else{
                        $percentage = round(($initial /($initial + $comparative))*100,2);
                    }
                    
                    
                    $matching_image[$get_image[$j]->nameOri][$get_image[$i]->nameOri] = $percentage.'%';
                }    
            }
        }
        
        ksort($matching_image);
        //print_r($matching_image); 
        
        
        //array format for csv result
        $array[] = $list_image_a;
        foreach($list_image_b as $key=>$val){    
            $ar_row = array();
            $ar_row[0]=$val;
            $set_counter = 1;
            foreach($matching_image[$val] as $key=>$val){
                $ar_row[$set_counter] = $val;
                $set_counter++;
            }
            $array[] = $ar_row;
        }
        //print_r($array);
        
        //CSV proccess
        $this->load->library('Convertcsv');
        $csv_data = $this->convertcsv->array_to_csv($array, false);
        $this->load->helper('download');
        $data = $csv_data;
        $filename = "SELECT * from `project` where id = '".$project_id."' ";
        $get_filename = $this->db->query($filename)->result();
        foreach ($get_filename as $name){
            if($same == 'yes' && $percent == 'no'){
                $name = $name->name.'-same.csv';               
            }
            else if($same == 'yes' && $percent == 'yes'){
                $name = $name->name.'-same_percentage.csv';               
            }
            else if($same == 'no' && $percent == 'no'){
                $name = $name->name.'-different.csv';               
            }
            else if($same == 'no' && $percent == 'yes'){
                $name = $name->name.'-different_percentage.csv';               
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
    
    function selectRandomProject(){
        $this->db->select('id, userID');
        $project_query = $this->db->get('project');
        return $project_query->result();
    }
    
    function selectImagePre($projectID){
        $query = $this->db->query("SELECT id, md5sum, label ,COUNT(label) as jumlah FROM image a WHERE projectID=$projectID GROUP BY projectID,label HAVING jumlah >1");
        $result_project=$query->result_array();
        
        return $result_project;
    }
    
    function selectImage($projectID){
        $query = $this->db->query("SELECT id, md5sum, label FROM image WHERE projectID=$projectID");
        $result_project=$query->result_array();
        if(!empty($result_project)){
            return $result_project;
        }
    }
    
    function get_user_id($email){
        $this->db->select('id');
        $user = $this->db->get_where('user', array('email' => $email));
        $user_id = $user->result();
        if(!empty($user_id)){
            foreach ($user_id as $id){
                $return_id = $id->id;
            }
            return $return_id;
        }
    }
    
    function get_user_email($id){
        $this->db->select('email');
        $user = $this->db->get_where('user', array('id' => $id));
        $user_email = $user->result();
        if(!empty($user_email)){
            foreach ($user_email as $userData){
                $return_email = $userData->email;
            }
            return $return_email;
        }
    }
    
    /**
     * @param $id_user = int id user
     * @return token hash
     */
    function get_token($id_user, $site_id){
        $this->db->select('activate_token_hash');
        $get = $this->db->get_where('activate_tokens', array('activate_token_user_id' => $id_user, 'activate_token_site_id' => $site_id));

        $get_token = $get->result();
        if(!empty($get_token)){
            foreach ($get_token as $token){
                $return = $token->activate_token_hash;
            }
            return $return;
        }
    }
    
    /**
     * @param $token = token give to user per site
     * @return id_user
     */
    function get_id_byToken($token){
        $this->db->select('activate_token_user_id');
        $get = $this->db->get_where('activate_tokens', array('activate_token_hash' => $token));
        $get_id = $get->result();
        if(!empty($get_id)){
            foreach ($get_id as $id){
                $return = $id->activate_token_user_id;
            }
            return $return;
        }
    }
    
    function check_url($url){
        $this->db->select('id');
        $get = $this->db->get_where('site', array('url' => $url));
        $get_detail = $get->result();
        if(!empty($get_detail)){
            foreach ($get_detail as $result_id){
                $return_id = $result_id->id;
            }
            return $return_id;
        }else{
            return false;
        }
    }
    
    function check_token($token, $url_id){ 
        $this->db->select('activate_token_user_id');
        $get = $this->db->get_where('activate_tokens', array('activate_token_hash' => $token, 'activate_token_site_id' => $url_id));
        $get_id = $get->result();
        if(!empty($get_id)){
            return true;
        }else{
            return false;
        }
    }
    
    function list_website($user_id,$perPage,$uri){
        $this->db->where('userID',$user_id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get('site', $perPage, $uri);
        if (!empty($query)){
            return $query->result();
        }
    }
    
    function count_website($user_id){
        $this->db->where('userID',$user_id);
        $getData = $this->db->get('site');
        $count = $getData->num_rows();
        return $count;
    }
    
    function activate_site($site_id) {
        $query = $this->db->query(
            'UPDATE '.$this->db->dbprefix.'site
                SET site_activated = 1
            WHERE id = ?',
            $site_id
        );
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
    
    //get_url_by_site_id
    function get_url_by_site_id($site_id){
        $this->db->select('url');
        $get_url = $this->db->get_where('site', array('id' => $site_id));
        $url = $get_url->result();
        if(!empty($url)){
            foreach ($url as $result_url){
                $return_url = $result_url->url;
            }
            return $return_url;
        }
    }
    
    function check_url_owner($user_id, $site_id){
        $this->db->select('url');
        $get = $this->db->get_where('site', array('userID' => $user_id, 'id' => $site_id));
        $get_id = $get->result();
        if(!empty($get_id)){
            return true;
        }else{
            return false;
        }
    }
    
    function delete_project($data)
    {
        $query = $this->db->delete('project', $data);
        
        return($query);
    }
    
    function delete_project_cascade()
    {
        
    }
    
    function deleteData($table=false, $data=array()){
        if (!$table and empty($data)) return false;

		$query = $this->db->delete($table, $data);
        
        return($query);
        
    }
}


/* End of file m_pages.php */
/* Location: ./application/models/m_pages.php */