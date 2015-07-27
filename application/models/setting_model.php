<?php
class Setting_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
    
      public function record_count($data_table) {
        return $this->db->count_all($data_table);
    }
    
    public function fetch_datatable($data_table,$limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($data_table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   public function fetch_customer($limit, $start){
    
    
    
        $this->db->select('*');
        $this->db->from('transport_customers');
        $this->db->join('province', 'transport_customers.province1 = province.PROVINCE_ID','left');
        $this->db->join('amphur', 'transport_customers.aumpher1 = amphur.AMPHUR_ID','left');
        $this->db->join('customers_type', 'transport_customers.group_customer_id = customers_type.customer_type_id','left');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
    
         if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    
    
   }//End of fetch_customer
   
   
   
   
   
   public function res_company(){
    
    $query = $this->db->get('transport_company_info');
    
    return $query->result_array();
    
    
   }
   
   
   public function my_company(){
        
        $query = $this->db->get('transport_company_info');
        
        if($query->num_rows() > 0){
            
            foreach($query->result() as $row){
                $data[]=$row;
            }
            return $data;
        }
        return false;
        
   }
    
    
    
    
    public function show_product($data_table){
        $table_name = $data_table;
        //$this->db->select($table_name);
        $query = $this->db->get($table_name);
        return $query->result_array();
    }
    
    public function get_province(){
        $query = $this->db->get('province');
        return $query->result_array();
    }
    
 public function get_amphur($id,$type){
       
       if($type=='Province'){
        $strSql = "SELECT PROVINCE_ID,PROVINCE_NAME FROM province";
        
        $query = $this->db->query($strSql);
        
        foreach($query->result_array() as $rows){
            
            $data_province[] = array('province_id'=>$rows['PROVINCE_ID'],'province_name'=>$rows['PROVINCE_NAME']);
        }
        
        return $data_province;
        exit();
        
       } // End If Province
       
       if($type=="Amphur"){
        $strSql= "SELECT amp.AMPHUR_ID,amp.AMPHUR_NAME FROM amphur AS amp LEFT JOIN province AS prov ON (amp.PROVINCE_ID=prov.PROVINCE_ID) WHERE prov.PROVINCE_ID=$id";
        
        $query = $this->db->query($strSql);
        
        foreach($query->result_array() AS $rows){
            
            $data_amphur[] = array('amphur_id'=>$rows['AMPHUR_ID'],'amphur_name'=>$rows['AMPHUR_NAME']); 
        }
         
        return $data_amphur;
        exit();
       }// end iif Amphur
       
       if($type=="District"){
        $strSql = "SELECT dis.DISTRICT_ID,POSTCODE,DISTRICT_NAME FROM district AS dis LEFT JOIN amphur AS amp ON dis.AMPHUR_ID=amp.AMPHUR_ID
WHERE amp.AMPHUR_ID =$id";

        $query = $this->db->query($strSql);
        
        foreach($query->result_array() AS $rows){
            $data_district[] = array('district_id'=>$rows['DISTRICT_ID'],'district_postcode'=>$rows['POSTCODE'],'district_name'=>$rows['DISTRICT_NAME']);
        }
        
        return $data_district;
        exit();
        
       }//District
       
       
       

        
        
        
       
    } // end get_amphur
    
    
    
    
    
    
}


?>