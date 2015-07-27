<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
class Onload {
     
    private $CI;
    
    public function __construct(){       
        
       // $this->CI =& get_instance();
        
        $this->CI =& get_instance();
        
       
    }
    
    
    public function check_login(){
        
        $controller = $this->CI->router->class;
   
        
        if($this->CI->session->userdata('logged_in'))
        {
            $session_data = $this->CI->session->userdata('logged_in');
            $data['username'] = $session_data['username'];
            
            
        }
                
     //$this->load->view('home_view', $data);

    
    }//End of check_login()
    
    
}// end of class



