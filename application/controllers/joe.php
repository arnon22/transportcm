<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Joe extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        
    }
    
    public function _example_output($output = null)
	{
		//$this->load->view('income',$output);
        $this->load->view('income-new',$output);
	}
    
 
    
    public function index(){
        
        echo "Joe";
    }
    
    
    
    
    
}// end of class