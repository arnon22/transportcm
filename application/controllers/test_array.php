<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Test_array extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
    
    $this->load->model('order_model', 'orders');
    
    
    }
    
    
    
    
    public function index(){
        
        echo "TEST OK";
        
        $start_date = '2013-01-01';
        $end_date = '2014-12-31';
        $factory =2;
        
        
        $result = $this->orders->order_report_select_summary2($start_date,$end_date,$factory);
        
        foreach($result as $row){
            
            echo "<p>".$row['dp_number']."<p>";
        }
        
        
    }
    
    
    
}