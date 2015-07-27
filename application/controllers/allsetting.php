<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Allsetting extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');
       
              
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        
        
    }
    
    
    
    public function index(){
        
         //check login
    if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     $data['main_menu']=$this->main_menu;
     
        $this->load->view('common/header-bootstrap',$data);
        $this->load->view('setting/all-setting-view');
        $this->load->view('common/footer-bootstap');
     //$this->load->view('home_view', $data);
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
    }// end of index()
    
    
    public function factory(){
        
        if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     $data['main_menu']=$this->main_menu;
     
        
        $this->load->view('setting/factory-view.php',$data);
       
     //$this->load->view('home_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
        
        
        
        /*
        $this->load->library('jquery_pagination');
        $this->load->model('factory_model');
        
        $data_table = "transport_factory";       
        
        
        $data['results'] = $this->factory_model->show_factory($data_table);
        $this->load->view('setting/factory',$data);
        
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