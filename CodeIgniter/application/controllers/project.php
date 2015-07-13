<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('m_pages');
    }
    
    public function index()
	{
        
	}
    
    function deleteImage(){
        $os = $this->config->item('os');
        
        $img_id = $this->input->post('id_image');
        $pid = $this->input->post('pid');
        
        $path = 'data/';
        
        $arr_matched = array();
        $message = '';
        $matches = array();

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
        $matched = false;
        $count = count($matches);
        if($count > 0){
            $arr_matched = $id_matches;
            $matched = true;
            $message = 'This image(s) has been matched. Do you want to delete?';
        }
        
        if (!empty($dbtoDelete)){
        
            if($this->m_pages->delete_image($dbtoDelete)){
            //if($this->m_pages->delete_image($img_id)){  //image delete without confirm
                $this->session->set_flashdata('success', 'Delete file(s) success.');
                echo json_encode(array('status' => "success", 'projectID' => $pid, 'matched' => $matched, 'message' => $message, 'id_matched' => $arr_matched, 'data' => $matches));
            }
        }else{
            //$this->session->set_flashdata('message', 'Found No file(s) to delete! Perhaps your image(s) has been matched!');
            echo json_encode(array('status' => "success", 'projectID' => $pid, 'matched' => $matched, 'message' => $message, 'id_matched' => $arr_matched, 'data' => $matches));
        }
        
    }
    
    function delImgCascade(){
        $post = $this->input->post();
        
        $pid = $post['pid'];
        $path = 'data/';
        
        $os = $this->config->item('os');
        
        foreach ($post['id_image'] as $id){
            $file = $this->m_pages->get_img_by_id($id);
            
            foreach ($file as $md5sum){
                
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
            
        if($this->m_pages->delete_image($post['id_image'])){
            $this->session->set_flashdata('success', 'Delete file(s) success.');
            echo json_encode(array('status' => 'success'));
        }else{
            $this->session->set_flashdata('message', 'Delete unsuccessful! Please try again.');
            echo json_encode(array('status' => 'error'));
        }
        
    }
    
    function delete_project()
    {
        $post = $this->input->post();
        $pid = $post['pid'];
        
        $list_images = $this->m_pages->selectImage($pid);
        
        $message = '';
        $data = array();
        
        $data['project_id'] = $pid;
        
        if($list_images)
        {
            $status = 'not empty';
            $message = 'This project is not empty. Do you want to delete?';
            
            $id_matches = array();
            foreach($list_images as $image)
            {
                if($this->m_pages->check_match($image['id']))
                {
                    $id_matches[] = $image['id'];
                }
            }
            
            $count_matches = count($id_matches);
            $data['count_matched'] = $count_matches;
            if($count_matches > 0)
            {
                $status = 'matched';
                $message = 'The image(s) in this project have been matched.<br /> Do you want to delete?';
            }
        }
        else
        {
            $delete = $this->m_pages->delete_project(array('id' => $pid));
            if($delete)
            {
                $status = 'success';
                $this->session->set_flashdata('success', 'Delete project success.');
            }
            else
            {
                $status = 'error';
                $this->session->set_flashdata('message', 'Delete unsuccessful! Please try again.');
            }
        }
        
        echo json_encode(array('status' => $status, 'message' => $message, 'data' => $data));
    }
    
    function del_pr_cascade()
    {
        $post = $this->input->post();
        
        $pid = $post['project_id'];
        $path = 'data/';
        
        $os = $this->config->item('os');
        
        $images = $this->m_pages->selectImage($pid);
        if(!empty($pid))
        {
            if($this->m_pages->delete_project(array('id' => $pid)))
            {
                $username = $this->session->userdata('username');
                $path_project = $path.$username.'/'.$pid;
                
                if(!empty($path) AND !empty($username) AND !empty($pid)){
                    $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($path_project, RecursiveDirectoryIterator::SKIP_DOTS),
                        RecursiveIteratorIterator::CHILD_FIRST
                    );
                    
                    foreach ($files as $fileinfo) {
                        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                        $todo($fileinfo->getRealPath());
                    }
                    
                    rmdir($path_project);
                }
                $this->session->set_flashdata('success', 'Delete project success.');
            }else{
                $this->session->set_flashdata('message', 'Delete unsuccessful! Please try again.');
            }
        }else{
            $this->session->set_flashdata('message', 'Delete unsuccessful! Please try again.');
        }
        redirect('pages/view/projects', 'refresh');
    }
    
}

/* End of file project.php */
/* Location: ./application/controllers/project.php */