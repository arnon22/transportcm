<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
    
    
class Mycompany{
    
   public function __construct(){
    
    //$obj = &get_instance();
   }
    
    
    public function company_name(){
       $obj = &get_instance();
        
       $obj->load->model('company_model','company');
        
       $comapnyName = $obj->company->getCompany_name();
        
        $rs = iconv('utf-8','tis-620',$comapnyName);
        
       return $rs;        
        
        
    }    
    
    
}// End of Class    


?>