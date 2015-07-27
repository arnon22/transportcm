<?php
/**
 * @author Anon
 * @copyright 2013
 * @category Controller products
 */
 
 if (!defined('BASEPATH')) exit('No direct script access allow');
 
class Distance extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        //load distabce_model
        $this->load->model('distance_model','distance');
        
    }
    
    
    public function index(){
        echo "joe";
    }
    
    
    public function get_json_distance(){
        
        $distance_id = $this->input->post('distance_id');
        
        $result = $this->distance->getDistances($distance_id);
        
        
        $json = json_encode($result);
        
        echo $json;
        exit();
        
    }// end of function get_json_distance()
    
    
  public function update_distance(){        
        $data_distance = array(
            "distance_code"=>$this->input->post('distance_code'),
             "distance_name"=>$this->input->post('distance_name'),
              "range_min"=>$this->input->post('distance_start'),
               "range_max"=>$this->input->post('distance_end'),
                "distance_status"=>$this->input->post('distance_status')
        );
        
        $distance_id = $this->input->post('distance_id');
        
        
        $result = $this->distance->Update_distance($data_distance,$distance_id);
        
        if($result>0){
            $rs = $this->distance->getJson_Distance();
            
            $json = json_encode($rs);
            
            echo $json;
            exit();
            
        }else{
            echo("Insert Seccess");
         exit();
        }
        
         //echo("Insert Seccess");
         //exit();
    
    }
}//end class
