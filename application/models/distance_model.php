<?php
class Distance_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
    
    //show distance
    
    public function getDistance(){
        //$query = $this->db->get('distancecode');
        
          //  $strSql = "SELECT * FROM `distancecode` LIMIT $per_page, $limit_page";
             $strSql = "SELECT * FROM distancecode ";
        
        $query = $this->db->query($strSql);
        return $query->result_array();
    
    } // end of getDistance 
    
    public function getJson_Distance(){
        
        $query = $this->db->get('distancecode');
        
        foreach($query->result_array() as $row) {
            
            $data_distance[] = array(
                'distance_id'=>$row['distance_id'],
            'distance_code'=>$row['distance_code'],
            'range_min'=>$row['range_min'],
            'range_max'=>$row['range_max'],
            'distance_status'=>$row['distance_status'],
            'distance_name'=>$row['distance_name']  
            );
        }
        
        return $data_distance;
        
    } // end of getJson_Distance()
    
    
    
    
    public function getDistances($distance_id){
        
        $query = $this->db->where('distance_id',$distance_id)->get('distancecode') ;
        
        foreach($query->result_array() as $row){
            
            $data_distance[] = array(
            'distance_id'=>$row['distance_id'],
            'distance_code'=>$row['distance_code'],
            'range_min'=>$row['range_min'],
            'range_max'=>$row['range_max'],
            'distance_status'=>$row['distance_status'],
            'distance_name'=>$row['distance_name']           
            
            );
            
        } // end of foreach
        
        return $data_distance;
        
    }// end of function getDistance($distance_id)
    
    
    public function Update_distance($data,$distance_id){
        
        $this->db->where('distance_id',$distance_id)->update('distancecode',$data);
        
        $num = $this->db->affected_rows();
        
        return $num;      
        
        
    }
    
    
    public function Insert_distance($data){
        
        $this->db->insert('distancecode',$data);
        
        $num = $this->db->affected_rows();
        
        return $num;
        
    }
    
    
    
    
    
    
    
}// End of class





?>