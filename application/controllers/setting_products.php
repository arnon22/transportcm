<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Setting_products extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');  
        $this->load->model('products_model','products');
        $this->load->model('setting_model','setting');
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
     
     $data_table ="transport_products";
     
     $config = array();
        $config["base_url"] = base_url() . "setting_products/index";
        $config["total_rows"] = $this->setting->record_count($data_table);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
     
            $data["results"] = $this->setting->fetch_datatable($data_table,$config["per_page"], $page);
            
           // $data["links"] = $this->pagination->create_links();
            
            $data["pagination_links"] = $this->pagination->create_links();

            $this->load->view("setting/products_view", $data);
     
     
     
     
     
     
     
    /* $data['username'] = $session_data['username'];
     $data['main_menu']=$this->main_menu;
     
     
     
     $this->load->model('factory_model','factory');
        
            
        
   $data['res_fac'] = $this->factory->getFactory();
     
   $this->load->view('setting/cubic_new_view',$data); */
     //$this->load->view('home_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
        


    }// end of index()
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function logout()
 {
   $this->session->unset_userdata('logged_in');
   $this->session->sess_destroy();
   //session_destroy();
   redirect('bootstrap', 'refresh');
 }

    
    
    
    
    
    
}// end of class