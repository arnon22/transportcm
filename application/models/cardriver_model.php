<?php
class Cardriver_model extends CI_Model{
    
    public function __construct(){
        
        parent::__construct();
    }
    
  /*  public function getNumCustomers(){
        $rw = $this->db->get('customer');
        $row = $rw->num_rows();
        
        return $row;
    }
    
    public function showCustomers(){ 

        $query = $this->db->get('transport_customers');
        return $query->result_array();
    }
    
    public function showData($data_table){
        $table_name = $data_table;
        //$this->db->select($table_name);
        $query = $this->db->get($table_name);
        return $query->result_array();
    }
    */
    
    public function getDriver(){
        $query = $this->db->get('transport_driver');
        return $query->result_array();
    }
    
    
    public function getCars(){
        
        $query = $this->db->get('transport_cars');
        return $query->result_array();       
        
    }
    
}// End of Class



?>