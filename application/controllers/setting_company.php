<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Setting_company extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');  
        //$this->load->model('cardriver_model','driver');
        $this->load->model('setting_model','setting');
        //$this->load->library("pagination");     
              
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        
        
        
        
        
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        
        
    }
    
    
    
    public function index(){
        
         //check login
    if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     
     $data['results'] = $this->setting->my_company();
     $data['company_info'] = $this->setting->res_company();
     
     

        $this->load->view("setting/company-view.php",$data);
     
     
     
     
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