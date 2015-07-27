<?php
class Order_model extends CI_Model{
    
     public function __construct(){
        
        parent::__construct();
    }
    
    
    public function getCubic(){
        $query = $this->db->where('cubic_status',1)->get('transport_cubiccode');;
        
        return $query->result_array();  
        
        
              
    }
    
    
    
     public function record_count() {
       $strSql = "SELECT order_id,ord.created_datetime,fac.factory_name,real_distance,distance_code,cubic_value,driver_name,car_number FROM orders as ord 
LEFT JOIN driver AS driv ON(ord.driver_id=driv.driver_id) 
LEFT JOIN transport_factory as fac on(ord.site_id=fac.factory_id)
LEFT JOIN distancecode as distanc ON (ord.distance_id=distanc.distance_id)
LEFT JOIN transport_cubiccode AS cubic ON (ord.cubic_id=cubic.cubic_id)
LEFT JOIN transport_cars as car ON(ord.car_id=car.car_id)
ORDER BY ord.created_datetime DESC";


        $query = $this->db->query($strSql);
        
        return $query->num_rows();
    
    
    }// end of record_count()
    
    
    
    public function show_order_list($limit, $start){
        
        $strSql = "SELECT order_id,ord.created_datetime,dp_number,fac.factory_name,real_distance,distance_code,cubic_value,driver_name,car_number FROM orders as ord 
LEFT JOIN driver AS driv ON(ord.driver_id=driv.driver_id) 
LEFT JOIN transport_factory as fac on(ord.site_id=fac.factory_id)
LEFT JOIN distancecode as distanc ON (ord.distance_id=distanc.distance_id)
LEFT JOIN transport_cubiccode AS cubic ON (ord.cubic_id=cubic.cubic_id)
LEFT JOIN transport_cars as car ON(ord.car_id=car.car_id)
ORDER BY ord.created_datetime DESC LIMIT $start,$limit";

       //$this->db->limit($limit, $start);
        $query = $this->db->query($strSql);
        
        if($query->num_rows() > 0){        
            foreach($query->result() as $row){
            
            $data[]=$row;
        }
        
        return $data;
            
            
        }
        return false;
        
        
        
        
    }// end of show_order_list;
    
    
    
    
    
    
} //end of class



?>