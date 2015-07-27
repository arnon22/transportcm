<?php 
if (!defined('BASEPATH'))exit('No direct script access allow');

class Dashboard extends CI_Controller{
    
    public function __construct(){
        
        parent::__construct();
    }
    
    public function index(){
        
        $this->load->view('thin-admin/index');
    }
    
    
}// end if Dashboard 
    


// end Class