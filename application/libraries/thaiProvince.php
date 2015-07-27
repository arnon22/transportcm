<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class thaiProvince {
    
    protected $id;
    protected $type;

    public function __construct(){
        $this->id = $id;
        $this->type = $type;
        
        $this->ci =&get_instance();
        
        
    }
    
    public function getProvince($id,$type){
        
        $this->ci->load->model('setting_model','amphur');
        
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
}

}/* End of file Someclass.php */


