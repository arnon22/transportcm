<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Setting_factory extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');    
        $this->load->model('factory_model','factory');   
              
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        
        $this->load->library("pagination");
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        
        
    }
    
    
    
    public function index(){
        
        
        
         //check login
    if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     
     $config = array();
        $config["base_url"] = base_url() . "setting_factory/index";
        $config["total_rows"] = $this->factory->record_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
     
            $data["results"] = $this->factory->fetch_factory($config["per_page"], $page);
            
            $data["links"] = $this->pagination->create_links();
            
            $data["pagination_links"] = $this->pagination->create_links();

            $this->load->view("setting/factory-view", $data);
     
     
     
     
        
            
        
  // $data['res_fac'] = $this->factory->getFactory();
     
   //$this->load->view('setting/factory-view',$data);
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