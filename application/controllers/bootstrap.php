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
        $this->load->model('factory_model','factory');
        $this->load->model('customers_model','customer');
        $this->load->model('distance_model','distance');
        $this->load->model('cubiccode_model','cubic');
        $this->load->model('cardriver_model','cars');
        
        
       
        $this->load->library("pagination");                  
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        $this->load->library('grocery_CRUD');
        
    }
    
    public function _example_output($output = null)
	{
		//$this->load->view('orders_view',$output);
        $this->load->view('common/bootstrap',$output);
	}
    
    /*
    public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
    
    */
    
    public function index(){
        
         //check login
    if($this->session->userdata('user_name'))
  {
     #$session_data = $this->session->userdata('logged_in');
     
     #$data['username'] = $session_data['username'];
     
        // Grid
        $this->load->library("jqgridnow_lib");
        
        $g = new jqgrid();
 
    
        
        
        
        //display
        $this->_example_output((object)array('output' => '' ,'out'=>$out_index, 'js_files' => array() , 'css_files' => array()));
      
     
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
/*
   public function number_customer($post_array,$primary_key){
        
       // $post_array['order_id'];        
        
        $order_code = "C".date('y'). date('m').sprintf('%05d',$primary_key);
        
        $user_logs_insert = array(
        "customers_code" => $order_code,
        "status"=>1       
    );
    
    $this->db->where('customer_id',$primary_key);
    $this->db->update('transport_customers',$user_logs_insert); 
 
    //$this->db->insert('order',$user_logs_insert);
 
    return true;
        
 
    }//
    
*/
    
    
    
    
    function logout()
 {
   $this->session->unset_userdata('logged_in');
   $this->session->sess_destroy();
   //session_destroy();
   redirect('bootstrap', 'refresh');
 }
 
 
 

    
    
    
    
    
    
}// end of class