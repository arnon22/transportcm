<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Custom_query_model extends grocery_CRUD_model {
 
	private  $query_str = ''; 
	function __construct() {
		parent::__construct();
	}
 
	function get_list() {
		$query=$this->db->query($this->query_str);
 
		$results_array=$query->result();
		return $results_array;		
	}
 
	public function set_query_str($query_str) {
		$this->query_str = $query_str;
	}
    
     public function show_price2(){
        
        
        for($i=1;$i<=3;$i++){
            
            
            $strSql = "SELECT DISTINCT pr.price FROM transport_pricelist AS pr LEFT JOIN distancecode AS dis ON(pr.distance_id=dis.distance_id)
JOIN transport_cubiccode AS cubic ON (pr.cubic_id = cubic.cubic_id)
WHERE pr.start_date = '0000-00-00' or pr.start_date < NOW() AND pr.distance_id =".$i."";


            $query = $this->db->query($strSql);
            
            foreach($query->result() as $row){
                
                
                $result[]=array('c_price'=>$row->price);
                
            }
            
            $data[] =$result;
            
            //$data[]=array_merge($res[$i],$result);
            
        }
        
        
        

        
        
        //$result = $query->result_array();
        
        
        return $data;
        
        //return json_encode($data); 
       
      
        
        
    }
    
    
}