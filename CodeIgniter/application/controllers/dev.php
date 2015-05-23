<?php

class Dev extends CI_Controller {
    
    public function upload_file()
    {
        $this->load->helper('url');
        $this->load->library('zip');
        
    	$status = "";
    	$msg = "";
    	$file_element_name = 'zipped_file'; /*zipped_file*/
    	
        $project_id = $this->input->get('pid');
        
        if (!empty($project_id)){
        
    	if ($status != "error")
    	{
    	    //$orig_name = $_FILES['zipped_file'];
    		$config['upload_path'] = '../tmp/';
    		$config['allowed_types'] = 'zip';
    		$config['max_size']	= '500000';
    		$config['encrypt_name'] = TRUE;
    
    		$this->load->library('upload', $config);
            
    
    		if (!$this->upload->do_upload($file_element_name))
    		{
    			$status = 'error';
    			$msg = $this->upload->display_errors('', '');
    		}
    		else
    		{
                $size_image_medium = '400px';
                $size_image_thumbnail = '100px';
                
                
    			$data = $this->upload->data();
            	$file = $data['full_path'];
                $file_name = $data['raw_name'];
                $path_extract = $data['file_path'].$file_name;
                $path_data = 'data/';
                $path_user = $path_data.$this->session->userdata('username');
                $path_project = $path_user.'/'.$project_id;
                $path_img = $path_project.'/img';
                $path_img_ori = $path_img.'/ori';
                $path_img_medium = $path_img.'/'.$size_image_medium;
                $path_img_thumbnail = $path_img.'/'.$size_image_thumbnail;
                $num = 0;                                
                
                $this->zip->unzip($file, $path_extract);
                
                //create folder if not exist
                $toCreate = array($path_user, $path_project, $path_img, $path_img_ori, $path_img_medium, $path_img_thumbnail);
                $permissions = 0755;
                foreach ($toCreate as $dir) {
                    if (!is_dir($dir)){
                        mkdir($dir, $permissions, TRUE);
                    }
                }
                
                $images = $this->GetContents($path_extract);
                $list = count($images);
                
                foreach ($images as $image){
                    $entry = $image['filename'];
                    $path_entry = $image['path'];
                    
                    if(preg_match('#\.(jpg|jpeg)$#i', $entry))
                    {
                        //$num +=1;
                        $now = date("Y-m-d H:i:s");
                        $image_name_encrypt = md5($entry.$now);
                        
                        $fileinfo = getimagesize($path_entry."/".$entry);
                        if(!$fileinfo) {
                            $status = "error";
                            $msg = "No file type info";
                        }else{
                            $valid_types = array(IMAGETYPE_JPEG);
                        
                            if(in_array($fileinfo[2],  $valid_types)) {
                                $this->load->model('m_pages');
                                $list_file = array('projectID'=> $project_id, 'nameOri' => $entry);
                                if($this->m_pages->file_exist($list_file))
                                {
                                    //$list_file_exist = array();
                                    $list_file_exist[] = $entry;
                                    $count_file_exist = count($list_file_exist, COUNT_RECURSIVE);
                                    //echo json_encode(array('list' => $list, 'num' => $count_file_exist));
                                    
                                    $file_processed = $list - $count_file_exist;
                                    if($file_processed < 1){
                                        $status = "error";
                                        $msg = "No image processed";
                                    }else{
                                        $status = "success";
                                        $msg = "File successfully uploaded";
                                    }
                                }else{
                                    $num += 1;
                                    //echo json_encode(array('num_process' => $num));
                                    copy($path_entry."/".$entry, $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg');
                                    if(!@ copy($path_entry."/".$entry, $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg'))
                                    {
                                        $status = "error";
                                        $msg= error_get_last();
                                    }
                                    else{
                                        //Set config for img library
                                        $src_ori = $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg';
                                        $dest_medium = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
                                        $dest_thumbnail = $path_img_thumbnail.'/'.$image_name_encrypt.'.'.$size_image_thumbnail.'.jpg';
                                        
                                        //Set cropping for y or x axis, depending on image orientation
                                        if ($fileinfo[0] > $fileinfo[1]) {
                                            $config['width'] = $fileinfo[1];
                                            $config['height'] = $fileinfo[1];
                                            $config['x_axis'] = (($fileinfo[0] / 2) - ($config['width'] / 2));
                                            $config['y_axis'] = 0;
                                        }
                                        else {
                                            $config['width'] = $fileinfo[0];
                                            $config['height'] = $fileinfo[0];
                                            $config['x_axis'] = 0;
                                            $config['y_axis'] = (($fileinfo[1] / 2) - ($config['height'] / 2));
                                        }
        
                                        $this->cropToSquare($src_ori, $dest_medium, $config);
                                        unset($config);
                                        
                                        //set new config
                                        $config['width'] = 400;
                                        $config['height'] = 400;
                                        $this->resize_pic($dest_medium, $dest_medium, $config);
                                        unset($config);
                                        
                                        $config['width'] = 100;
                                        $config['height'] = 100;
                                        $this->resize_pic($dest_medium, $dest_thumbnail, $config);
                                        unset($config);
                                        
                                        // add file info to database
                                        $this->load->model('m_pages');
                                        
                                        $data_image=array('id'=>'', 'projectID'=> $project_id, 'nameOri' => $entry, 'md5sum' => $image_name_encrypt);
                                        $this->m_pages->upload_image($data_image);
                                        
                                        $status = "success";
        				                $msg = "File successfully uploaded";
                                        
                                        //shell_exec("chmod 644 $path_img_ori/$image_name_encrypt.ori.jpg");
                                        //shell_exec("chmod 644 $path_img_medium/$image_name_encrypt.$size_image_medium.jpg");
                                        //shell_exec("chmod 644 $path_img_thumbnail/$image_name_encrypt.$size_image_thumbnail.jpg");
                                    }
                                }
                            }
                            
                            else{
                                $status = "error";
                                $msg = "File type error";
                            }
                        }
                    }
                }
                
                $this->deleteDir($path_extract);
                
    		}
    	}
    	
        }else{
            $status ="error";
            $msg = "No Project id";
        }
        $report_file_exist = "";
        if(!empty($list_file_exist)){
            $report_file_exist = "Some files can not be processed due to duplicate";
        }
        echo json_encode(array('status' => $status, 'msg' => $msg, 'processed' => 'done', 'report' => $report_file_exist, 'pID' => $project_id));
    }
    
    /**
     * @todo get all files in a folder and it's subfolder
     * 
     * @param string $dir = path to directory
     * @var array $files = array to store file information
     * 
     * @return array([0] => array('path' => 'string path to file', 'filename' => 'filename'))
     * 
     * */
    function GetContents($dir,$files=array()) { 
        if(!($res=opendir($dir))) exit("$dir doesn't exist!"); 
            while(($file=readdir($res))==TRUE) 
            if($file!="." && $file!="..")
                if(is_dir("$dir/$file")){
                    $files=$this->GetContents("$dir/$file",$files); 
                }else{
                    $file_info = array('path' => $dir, 'filename' => $file);
                    array_push($files,$file_info); 
                }
        
        closedir($res); 
        return $files; 
    }
    
    /**
     * @todo crop image to square from center
     * 
     * @param string $src = full image path with file name
     * @param string $dest = path destination for new image
     * @param array $config = array contain configuration to crop image
     * 
     * @param int $config['width']
     * @param int $config['height']
     * @param int $config['x_axis']
     * @param int $config['y_axis']
     * 
     * @return bool Returns TRUE on success, FALSE on failure
     * 
     * */
    function cropToSquare($src, $dest, $config){
        list($current_width, $current_height) = getimagesize($src);
        $canvas = imagecreatetruecolor($config['width'], $config['height']);
        $current_image = imagecreatefromjpeg($src);
        if (!@ imagecopy($canvas, $current_image, 0, 0, $config['x_axis'], $config['y_axis'], $current_width, $current_height)){
            return false;
        }else{
            if (!@ imagejpeg($canvas, $dest, 100)){
                return false;
            }else{
                return true;
            }
        }
    }
    
    /**
     * @todo resize image
     * 
     * @param string $src = full image path with file name
     * @param string $dest = path destination for new image
     * @param array $config = array contain configuration to crop image
     * 
     * @param int $config['width']
     * @param int $config['height']
     * 
     * @return bool Returns TRUE on success, FALSE on failure
     * 
     * */
    function resize_pic($src, $dest, $config){
        list($current_width, $current_height) = getimagesize($src);
        $canvas = imagecreatetruecolor($config['width'], $config['height']);
        $current_image = imagecreatefromjpeg($src);
        
        // Resize
        if (!@ imagecopyresized($canvas, $current_image, 0, 0, 0, 0, $config['width'], $config['height'], $current_width, $current_height)){
            return false;
        }else{
            // Output
            if (!@ imagejpeg($canvas, $dest, 100)){
                return false;
            }else{
                return true;
            }
        }
    }
    
    /**
    * @todo Delete a file, or a folder and its contents
    * @param string $dirPath Directory to delete
    * @return bool Returns TRUE on success, FALSE on failure
    */
    function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDir($file);
            } else {
                unlink($file);
            }
        }
        return rmdir($dirPath);
    }
    
}