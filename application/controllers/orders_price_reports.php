<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class orders_price_reports extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');
        
        $this->load->model('order_model','order');
        $this->load->model('factory_model','factory');
        $this->load->model('customers_model','customer');
        $this->load->model('distance_model','distance');
        $this->load->model('cubiccode_model','cubic');
        $this->load->model('cardriver_model','cars');
        
        
       
        $this->load->library("pagination");                  
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        
        
    }
    
    
    
    public function index(){
        
         //check login
    if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     $data['car'] = $this->cars->getCars();
     $data['factory'] = $this->factory->getFactory();
  
    

    $this->load->view('summary_reports/order_price_report',$data);
    
     
      
     
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
        
        
        
        
        /*
        $this->load->view('common/header-bootstrap');
        $this->load->view('common/bootstrap');
        $this->load->view('common/footer-bootstap');
        */
    }
    
    public function add_oil_jobs(){
        
        if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     
        $this->load->view('common/header-bootstrap',$data);
        
        $this->load->view('oil/oil-form-view');        
        
        $this->load->view('common/footer-bootstap');
     //$this->load->view('home_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
        
        
        
        
    }
    
    function logout()
 {
   $this->session->unset_userdata('logged_in');
   $this->session->sess_destroy();
   //session_destroy();
   redirect('bootstrap', 'refresh');
 }

    
    
    
    
    
    
}// end of class