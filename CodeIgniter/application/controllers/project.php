<?php

class Project extends CI_Controller {
    
    public function index()
	{
        
	}
    
    function deleteImage(){
        $os = $this->config->item('os');
        
        $img_id = $this->input->post('id_image');
        $pid = $this->input->post('pid');
        $this->load->model('m_pages');
        
        $path = 'data/';
        
        $arr_matched = array();
        $message = '';
        $matches = '';

        foreach ($img_id as $id){
            /* checking table match */
            if($this->m_pages->check_match($id)){
                $query="id='$id' AND projectID='$pid'";
                $this->db->where($query, NULL, FALSE);
                $img_file = $this->db->get('image');
                $file = $img_file->result();
                
                foreach ($file as $files){
                    $thumbnail = base_url($path.$this->session->userdata('username').'/'.$pid.'/img/100px/'.$files->md5sum.'.100px.jpg');
                    $files->thumbnail = $thumbnail;
                    $matches[] = $files;
                }
                
                $id_matches[] = $id;
                
            }else{
                $dbtoDelete[] = $id;
            
                $this->db->where('id',$id);
                $query="id='$id' AND projectID='$pid'";
                $this->db->where($query, NULL, FALSE);
                $img_file = $this->db->get('image');
                $file = $img_file->result();
                foreach ($file as $md5sum)
                
                $ori = $path.$this->session->userdata('username').'/'.$pid.'/img/ori/'.$md5sum->md5sum.'.ori.jpg';
                $converted = $path.$this->session->userdata('username').'/'.$pid.'/img/400px/'.$md5sum->md5sum.'.400px.jpg';
                $thumbnail = $path.$this->session->userdata('username').'/'.$pid.'/img/100px/'.$md5sum->md5sum.'.100px.jpg';
                
                $toDelete = array($ori, $converted, $thumbnail);
                foreach ($toDelete as $file_to_del) {
                    if($os == 'windows'){
                        unlink($file_to_del);
                    }else{
                        shell_exec("rm $file_to_del");
                    }
                }
            }
        }
        
        $count = count($matches);
        if($count > 0){
            $arr_matched = $id_matches;
            $matched = true;
            $message = 'This image(s) has been matched. Do you want to delete?';
        }
        
        if (!empty($dbtoDelete)){
        
            if($this->m_pages->delete_image($dbtoDelete)){
            //if($this->m_pages->delete_image($img_id)){  //image delete without confirm
                echo json_encode(array('status' => "success", 'projectID' => $pid, 'matched' => $matched, 'message' => $message, 'id_matched' => $arr_matched, 'data' => $matches));
            }
        }else{
            //$this->session->set_flashdata('message', 'Found No file(s) to delete! Perhaps your image(s) has been matched!');
            echo json_encode(array('status' => "success", 'projectID' => $pid, 'matched' => $matched, 'message' => $message, 'id_matched' => $arr_matched, 'data' => $matches));
        }
        
    }
    
    function delImgCascade(){
        
    }
    
}

?>