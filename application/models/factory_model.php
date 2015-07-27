<?php
class Factory_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function record_count() {
        return $this->db->count_all("transport_factory");
    }
    
    public function fetch_factory($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get("transport_factory");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
    
    
    public function show_factory($data_table){
        $table_name = $data_table;
        //$this->db->select($table_name);
        $query = $this->db->get($table_name);
        return $query->result_array();
    }
    
    public function add_factory($db_table,$data){
        $this->db->insert('$db_table',$data);      
        
    }
    
    public function getFactory(){
        $this->db->where('factory_status','1');
        $query = $this->db->get('transport_factory');
        return $query->result_array();
        
    }
    
    public function getJsonFactory(){        
        $strSql = "SELECT * FROM transport_factory";
        
        $query = $this->db->query($strSql);
        
        foreach($query->result_array() AS $rows){
            $data_factory[] = array('fac_id'=>$rows['factory_id'],'fac_name'=>$rows['factory_name'],'fac_note'=>$rows['factory_note'],'fac_code'=>$rows['factory_code'],'fac_status'=>$rows['factory_status']);
            
        }        
        return $data_factory;
        exit();
        
        
    }
    
    
    public function getThaimonth(){
        $query = $this->db->get('monthly');
        
        return $query->result_array();
        
    }
    
    public function getYearly(){
       
       $str = "SELECT YEAR (order_date) AS orderYear FROM orders GROUP BY YEAR (order_date)";
       
        $qr = $this->db->query($str);
        
        return $qr->result_array();
        
        //return 
        
    }
    
   
    
    public function getNamefactory($factory_id){
        
        $strSql = "SELECT DISTINCT factory_name,factory_code FROM transport_factory
WHERE factory_id=$factory_id";

        $query =$this->db->query($strSql);
        
        foreach($query->result() as $row){
            
            $factory_name = $row->factory_name;
            $factory_code = $row->factory_code;
            
        }//---/foreach-//
        
        $fac_name = $factory_name."(".$factory_code.")";
        
        return $fac_name;
        
    }// End of function getNamefactory
    
    
    
    
    
}//End of Model


?>