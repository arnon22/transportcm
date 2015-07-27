<?php
class Dropdown_model extends CI_Model{
    
    public function __construct(){
        
        parent::__construct();
    }// End of Construct

 public function get_customer_dropdown(){
    
    $sql = "SELECT DISTINCT customer_id as k,customers_name as v FROM transport_customers ORDER BY customers_name ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_customer_dropdown
   
   public function get_customer_oil(){
    
    $sql = "SELECT DISTINCT customer_id as k,customers_name as v FROM transport_customers WHERE customer_type_id=2 ORDER BY customers_name ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_customer_dropdown
   
   public function get_distancecode_dropdown(){
    
    $sql = "SELECT DISTINCT distance_id as k,distance_code as v FROM distancecode WHERE distance_status=1 ORDER BY distance_id ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_distancecode_dropdown
   
    public function get_cubiccode_dropdown(){
    
    $sql = "SELECT DISTINCT cubic_id as k,cubic_value as v FROM transport_cubiccode WHERE cubic_status=1";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_cubiccode_dropdown
   
   public function get_car_dropdown(){
    
    $sql = "SELECT DISTINCT car_id as k,car_number as v FROM transport_cars WHERE status=1 ORDER BY car_id ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_car_dropdown
   
   public function get_drivers_dropdown(){
    
    $sql = "SELECT DISTINCT driver_id as k,driver_name as v FROM driver WHERE driver_status=1 ORDER BY driver_id ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_driver_dropdown
   
   
     public function get_cartype_dropdown(){
    
    $sql = "SELECT DISTINCT car_type_id as k,car_type_name as v FROM transport_car_type WHERE status=1 ORDER BY car_type_id ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   } // End of get_driver_dropdown
   
   public function get_status(){
    
    $sql = "SELECT DISTINCT id AS k,status_description AS v FROM driver_status ORDER BY id ASC";
    
    $str = array();
    $result = $this->db->query($sql);  
    
    //$result =$conn->db->query($sql);
        $arr = $result->result_array();
        
        
        foreach($arr as $rs)
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
            
            	$str = implode($str,";");
		return $str;
    
   }
   
   



}// end of class







?>