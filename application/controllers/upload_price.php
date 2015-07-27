<?php

class Upload_price extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->helper(array('form', 'url'));
       //$this->lang->load('thai');
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload()
    
	{
 $this->lang->load('thai');
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xls|xlsx|cvs';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);
        
        //print_r($config['upload_path']); 

		
        if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('upload_success', $data);
		}
        
        
        
	}
}
?>