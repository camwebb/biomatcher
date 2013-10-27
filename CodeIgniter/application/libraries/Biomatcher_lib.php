<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Biomatcher_lib {
    
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function selectQC(){
        $this->CI->load->model('m_pages');
        $result_project = $this->CI->m_pages->selectQCProject();
        $shuffled_project = array();
        foreach ($result_project as $project){
            $projectID = $project->id;
            //check if project contain min 5 images
            //note: active project?
            if($this->CI->m_pages->activeProject($projectID)){
                $shuffled_project[] = $project;
            }
        }
        //shuffle array from project
        shuffle ($shuffled_project);
        
        return $shuffled_project;
    
    }
    
    public function selectProjectCaptcha(){
        $this->CI->load->model('m_pages');
        $result_project = $this->CI->m_pages->selectProject();
        $shuffled_project = array();
        foreach ($result_project as $project){
            $projectID = $project->id;
            //check if project contain min 5 images
            //note: active project?
            if($this->CI->m_pages->activeProject($projectID)){
                $shuffled_project[] = $project;
            }
        }
        //shuffle array from project
        shuffle ($shuffled_project);
        
        return $shuffled_project;
    
    }
}

/* End of file Biomatcher_lib.php */