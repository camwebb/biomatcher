<?php

class Test_csv extends CI_Controller {
    
	public function load(){
	   $matches = array();
       $total = array();
       
       $project_id = $this->uri->segment(3, 0);
       $this->load->model('m_pages');  
       
       $images = $this->m_pages->match_images($project_id);
       foreach ($images as $id){
            $A = $this->m_pages->get_name_image($id->imageA);
            $B = $this->m_pages->get_name_image($id->imageB);
            
            $filenameA = $A[0]->nameOri;
            $filenameB = $B[0]->nameOri;
            $idA = $id->imageA;
            $idB = $id->imageB;
            
            $same = $this->m_pages->same($id->imageA, $id->imageB, 'yes');
            $different = $this->m_pages->same($id->imageA, $id->imageB, 'no');
            
            $matches[] = array('filenameA' => $filenameA, 'filenameB' => $filenameB, 'same' => $same, 'different' => $different, 'idA' => $idA, 'idB' => $idB);
            
            $matches_send = array_map("unserialize", array_unique(array_map("serialize", $matches)));
        
        $data['project_title'] = $this->m_pages->project_title();
        $matches = $matches_send;
        $data['totalMatches'] = count($matches);
        }
        
        
        $unique = array();
        $idx = 1;
        foreach ($matches as $match){     
            $unique[0] = '';
            $unique[] = $match['idA'];       
            $imageAunique = array_unique($unique);       
            $array[0] = $imageAunique;
            //$array[] = array($idx => $match['idB']);   
            if($match['idA']=='31'){
                $array[] = array($idx => $match['idB'],'same1'=>'xx','same2'=>'');
                $idx++;
            }
            else if($match['idA']=='32'){
                $array[] = array($idx => $match['idB'],'same'=>'','same2'=>'xx');
                $idx++;
            }
            else{
                $array[] = array($idx => $match['idB'],'same'=>'','same2'=>'');
                $idx++;
            }
           // $idx++;
        }   
        
        echo '<pre>';
        print_r ($array);
        echo '</hr>';
        
        //Converting array to SCV.
        //$this->load->library('Csvreader2');
        //$csv_data = $this->csvreader2->array_to_csv($array, false);
        //print_r($csv_data);
        
        
        echo '</pre>';  
    	$this->load->view('pages/test_csv');
    }
}

?>