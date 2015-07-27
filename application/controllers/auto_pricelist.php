<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Auto_pricelist extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');
        $this->load->model('pricelist_model','pricelist');
        
         $this->load->model('order_model','order');
       
        $this->load->library("pagination");                  
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        
        
    }
    
    public function _example_output($output = null)
	{
		$this->load->view('orders_view',$output);
        //$this->load->view('common/bootstrap',$output);
	}
    
    
    public function Pricelistshowtable2(){
        
        $data['pricelist'] = $this->pricelist->Pricelist_showtable();
        
        
    }
    
    public function d_d(){        
        
        return $data['distance']=$this->pricelist->show_feild();
        
    }
    
    
    public function index(){
        
         //check login
    if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
     $data['username'] = $session_data['username'];
     //$data['output'] = "ss";
    // $data['js_files'] = array();
     //$data['css_files'] = array();
     
     $start_date = '2013-07-01';
     $end_date = '2013-07-30';
     $factory = 2;
     $some_data = $this->pricelist->Pricelist_showtable2();
     $some_data2 = $this->pricelist->show_pricelist2();
     $some_data3 =$this->pricelist->showtable3();
     $data = array(     
          'pricelist' => $some_data,
          'distance'=>$some_data3,
          'price3'=>$some_data2,
          'js_files' => array(),
          'css_files' => array(),
          'output'=>"ss"
     );
     
     
     $this->_example_output($data);
     
    // $this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
     
  /*
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
    
    */ 
      
        //$this->load->view('Auto-pricelist-view.php',$data);
    
     
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
    
    public function check_price(){
        
        
        
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
 
 
 
 //action
 public function check_real_distance(){
    
    
    
    
        if($this->input->post('real_distance')!=""){
            $real_distance = $this->input->post('real_distance');
            
            $result = $this->pricelist->result_realdistance($real_distance);
            
            $value_distance = json_encode($result);
            
            echo $value_distance;
            exit();
        }           
        //$real_distance = $this->input->post('real_distance');
        
        
        //$result = json_encode($real_distance);
        
        //exit();
 
    
    

    
 }

    
    
    
    
    
    
}// end of class