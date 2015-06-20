<?php
class M_general extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getAllData($condition,$tbl,$where){
        if($condition==true){
            $this->db->where($where);
            $query = $this->db->get($tbl);
        }
        elseif($condition==false){
            $query = $this->db->get($tbl);
        }
        return $query->result();
    }

    function insertData($table,$data){
        $insert = $this->db->insert($table, $data);
        if($insert){
            $return['lastid'] = $this->db->insert_id();
            $return['status'] = true;
            return $return;
        }
        else{return false;}
    }
    
    function updateData($table,$where,$data){
        $this->db->where($where);
        $update = $this->db->update($table, $data); 
        if($update){return true;}
        else{return false;}
    }
    
    function deleteData($table,$where){
        $this->db->where($where);
        $delete = $this->db->delete($table); 
        if($delete){return true;}
        else{return false;}
    }
}    
    
    
    
/* End of file m_admin.php */
/* Location: ./application/models/m_admin.php */