<?php

class Company_model extends CI_Model{
    
    public function __construct(){
        
        parent::__construct();
        
    }
    
    
    public function getCompany_name(){
        $str = "SELECT * FROM transport_company_info";
        $result = $this->db->query($str);
        
        if($result->num_rows() > 0){
            
            foreach($result->result() as $rs){
                
                $data = $rs->company_name;
            }
            
            return $data;
        }
        
        
        
        
        
    } // End of function getComapny_name
    
    
    
    
    
    
} // End of Class






?>