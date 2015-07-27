<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	   $this->load->model('factory_model','factory');
       $this->load->model('customers_model','customer');
       $this->load->model('order_model','order');
       $this->load->model('cardriver_model','driver');
       $this->load->model('cubiccode_model','cubiccode');
       
       $data['factory'] = $this->factory->getFactory();
       $data['customer'] = $this->customer->getCustomer();
       $data['cubiccode'] = $this->order->getCubic();
       $data['driver'] = $this->driver->getDriver();
       $data['cubic'] = $this->cubiccode->getCubiccode();
	   
	   $this->lang->load('thai');
		//$this->load->view('welcome_message');
        $this->load->view('common/header');
        $this->load->view('welcome',$data);
        $this->load->view('common/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */