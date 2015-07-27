<?php
 if (!defined('BASEPATH')) exit('No direct script access allow');
 
 class Car_driver extends CI_Controller{
    
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai');
        
    } // end of __construct()
    
    
    public function index(){
        
       $this->load->model('factory_model','factory');        
        $this->load->model('setting_model','province');
        
        
        $data['province'] = $this->province->get_province();
        $data['factory'] = $this->factory->getFactory();
        //$data['customers'] = $this->customers->showCustomers();
        
        
        
        
        $this->load->view('common/header');
        
        $this->load->view('car-driver-view',$data);
        
        $this->load->view('common/footer');
        
        
        
    }// end of index()
    
    
    
    
    
 }

