<?php
/**
 * @author Anon
 * @copyright 2013
 * @category Controller products
 */
 
 if (!defined('BASEPATH')) exit('No direct script access allow');
 
class Products extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
    }
    
    
    public function index(){
        $this->lang->load("thai");
        $this->load->view('common/header');
        $this->load->view('products/products-view');
        $this->load->view('common/footer');
    }
    
    public function add(){
        
        $this->load->view('common/header');
        $this->load->view('products/products-add');
        $this->load->view('common/footer');
    }
    
    public function delete(){
        
        $this->load->view('common/header');
        $this->load->view('products/products-del');
        $this->load->view('common/footer');
        
    }
    
    public function edit(){
        
        $this->load->view('common/header');
        $this->load->view('products/products-edit');
        $this->load->view('common/footer');
        
    }
    
    
    
   
}



?>