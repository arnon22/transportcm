<?php

class Income_model extends CI_Model{
    
    public function __construct(){
        
        parent::__construct();
    }// End of Construct
    
    
    public function get_grid_data(){
        $q = $this->db->query("SELECT * FROM income");

        return $q;

}


   public function get_factory_dropdown(){
    
    $sql = "SELECT DISTINCT factory_id AS k,factory_code AS v FROM transport_factory WHERE factory_status=1 ORDER BY factory_id ASC";
    
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
    public function get_customer_type(){
    
    $sql = "SELECT DISTINCT customer_type_id AS k,customer_type_title AS v FROM transport_customer_type WHERE customer_type_status=1 ORDER BY customer_type_id ASC";
    
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
   
   public function grid_dropdown($str){
    
    //$sql = "SELECT DISTINCT factory_id AS k,factory_code AS v FROM transport_factory WHERE factory_status=1 ORDER BY factory_id ASC";
    
    $sql = $str;
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
   
   public function get_factory_recommence(){
    
    $sql = "SELECT DISTINCT factory_code AS k,factory_name AS v FROM transport_factory WHERE factory_status=1 ORDER BY factory_id ASC";
    
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
   
   
   public function income_fect_assoc($data){
    
    $query = $this->db->query("SELECT SUM(total_amount) AS s FROM(SELECT total_amount FROM income ORDER BY id ASC LIMIT 2) AS tmp");

        $row = $query->row_array();

        //$maxID = $row['total_amount'];
        return $row; 
        
        
            
        } //end of income_fect_assoc
   
   
   public function testJoe($str){
    
        return $str;
   }
    
}// End of Class



        


?>