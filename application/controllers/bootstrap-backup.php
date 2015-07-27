<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Bootstrap extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');
        
         $this->load->model('order_model','order');
       
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
     
     $config = array();
        $config["base_url"] = base_url() . "bootstrap/index";
        $config["total_rows"] = $this->order->record_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
     
     $data["results"] = $this->order->show_order_list($config['per_page'],$page); //$this->setting->fetch_datatable($data_table,$config["per_page"], $page);
            
           // $data["links"] = $this->pagination->create_links();
            
     $data["pagination_links"] = $this->pagination->create_links();
     
     $data['date'] = date('m');  
            

           $this->load->view('common/bootstrap',$data);
    
     
      
        //$this->load->view('common/bootstrap',$data);
    
     
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