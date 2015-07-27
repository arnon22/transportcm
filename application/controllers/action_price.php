<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Action_price extends CI_Controller {
    
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');
        $this->load->model('pricelist_model','pricelist');
    }
    
    
    public function listprice(){
        
         $resu = $this->pricelist->show_pricelist2();
         
         echo $resu;
        
    }
    
    
    
    
    
    
    
}