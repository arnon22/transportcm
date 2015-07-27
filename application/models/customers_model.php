<?php
class Customers_model extends CI_Model{
    
    public function __construct(){
        
        parent::__construct();
    }
    
    public function getNumCustomers(){
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
    
    public function getCustomer(){
        $query = $this->db->get('transport_customers');
        return $query->result_array();
    }
    
    public function getCustomer_name($customer_id){
        
        $str = "SELECT customers_name FROM transport_customers WHERE customer_id ='$customer_id' ";
        
        $query = $this->db->query($str);
        
         foreach ($query->result() as $row){
            
            $result = $row->customers_name;
         }        
        
        return $result;
        
    }
    
    public function getCustomer_oil(){
        
        $str = "SELECT customer_id,customers_name FROM transport_customers WHERE customer_type_id =2";
        
        $query = $this->db->query($str);        
        
        return $query->result_array();
    }
    
    public function add_cus($str){
        $str_sql = $str;
        
        $this->db->query($str_sql);
        $num_action = $this->db->affected_rows();
        if($num_action >0 ){
            return true;
        }
        
        
    }
    
    function insert_users($data){
       // $query = $this->db->insert('customer', $data);
        return $this->db->insert('customer', $data);

    }
    
    
    public function add_customers($data_customer){
        
        $this->db->insert('transport_customers',$data_customer);
        
        $num_action = $this->db->affected_rows();
        
        return $num_action;
        
        
    } //end of function add_customer()



}// end of class



?>