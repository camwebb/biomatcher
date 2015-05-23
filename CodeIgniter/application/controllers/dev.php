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
                exit;
                
                //create folder if not exist
                $toCreate = array($path_user, $path_project, $path_img, $path_img_ori, $path_img_medium, $path_img_thumbnail);
                $permissions = 0755;
                foreach ($toCreate as $dir) {
                    if (!is_dir($dir)){
                        mkdir($dir, $permissions, TRUE);
                    }
                }
                
                $list = count(glob($path_extract.'/'. "*.{jpg,jpeg}",GLOB_BRACE));
                print_r($list);
                exit;
                if ($handle = opendir($path_extract)) {
                    // loop over the directory.
                    while (false !== ($entry = readdir($handle))) {
                        //print_r($entry);
                        if(preg_match('#\.(jpg|jpeg)$#i', $entry))
                        {
                            //$num +=1;
                            $now = date("Y-m-d H:i:s");
                            $image_name_encrypt = md5($entry.$now);
                            
                            $fileinfo = getimagesize($path_extract."/".$entry);
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
                                    copy($path_extract."/".$entry, $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg');
                                    if(!@ copy($path_extract."/".$entry, $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg'))
                                    {
                                        $status = "error";
                                        $msg= error_get_last();
                                    }
                                    else{
                                        //Set config for img library
                                        $config['image_library'] = 'ImageMagick';
                                        $config['library_path'] = '/usr/bin/';
                                        $config['quality'] = "100%";
                                        $config['source_image'] = $path_img_ori.'/'.$image_name_encrypt.'.ori.jpg';
                                        $config['new_image'] = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
                                        $config['maintain_ratio'] = false;
                                        
                                        //Set cropping for y or x axis, depending on image orientation
                                        if ($fileinfo[0] > $fileinfo[1]) {
                                            $config['width'] = $fileinfo[1];
                                            $config['height'] = $fileinfo[1];
                                            $config['x_axis'] = (($fileinfo[0] / 2) - ($config['width'] / 2));
                                        }
                                        else {
                                            $config['height'] = $fileinfo[0];
                                            $config['width'] = $fileinfo[0];
                                            $config['y_axis'] = (($fileinfo[1] / 2) - ($config['height'] / 2));
                                        }
                                        
                                        //Load image library and crop
                                        $this->load->library('image_lib', $config);
                                        $this->image_lib->initialize($config);
                                        if ($this->image_lib->crop()) {
                                            $status = "error";
                                            $msg = $this->image_lib->display_errors();
                                        }
                                        
                                        //Clear image library settings
                                        $this->image_lib->clear();
                                        unset($config);
                                        
                                        // resize image after cropping to square
                                        $config['image_library'] = 'gd2';
                                        $config['quality'] = "100%";
                                        $config['source_image'] = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
                                        $config['maintain_ratio'] = TRUE; 
                                        $config['master_dim'] = 'width';
                                        $config['width'] = 400; 
                                        $config['height'] = 400; 
                                        
                                        $this->load->library('image_lib');
                                        $this->image_lib->resize();
                                        $this->image_lib->clear();
                                        $this->image_lib->initialize($config); 
                                        if(!$this->image_lib->resize()){
                                            $status = "error";
                                            $msg = $this->image_lib->display_errors();
                                        }
                                        
                                        //Clear image library settings
                                        $this->image_lib->clear();
                                        unset($config);
                                        
                                        // create thumbnail
                                        $config['image_library'] = 'gd2';
                                        $config['quality'] = "100%";
                                        $config['source_image'] = $path_img_medium.'/'.$image_name_encrypt.'.'.$size_image_medium.'.jpg';
                                        $config['new_image'] = $path_img_thumbnail.'/'.$image_name_encrypt.'.'.$size_image_thumbnail.'.jpg';
                                        $config['maintain_ratio'] = TRUE; 
                                        $config['master_dim'] = 'width';
                                        $config['width'] = 100; 
                                        $config['height'] = 100; 
                                        
                                        $this->load->library('image_lib');
                                        $this->image_lib->resize();
                                        $this->image_lib->clear();
                                        $this->image_lib->initialize($config); 
                                        if(!$this->image_lib->resize()){
                                            $status = "error";
                                            $msg = $this->image_lib->display_errors();
                                        }
                                        else{
                                            // add file info to database
                                            $this->load->model('m_pages');
                                            
                                            $data_image=array('id'=>'', 'projectID'=> $project_id, 'nameOri' => $entry, 'md5sum' => $image_name_encrypt);
                                            $this->m_pages->upload_image($data_image);
                                            
                                            $status = "success";
            				                $msg = "File successfully uploaded";
                                            
                                            shell_exec("chmod 644 $path_img_ori/$image_name_encrypt.ori.jpg");
                                            shell_exec("chmod 644 $path_img_medium/$image_name_encrypt.$size_image_medium.jpg");
                                            shell_exec("chmod 644 $path_img_thumbnail/$image_name_encrypt.$size_image_thumbnail.jpg");
                                        }
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
                    closedir($handle);
                    shell_exec("rm -r $path_extract");
                }
                
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
    
}