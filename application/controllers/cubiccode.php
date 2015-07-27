<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Cubiccode extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->lang->load('thai');
        $this->load->model('cubiccode_model', 'cubic');
    }

    public function index()
    {


        $data['rs'] = $this->cubic->show_cubiccode();


        $this->load->view('common/header');


        $this->load->view('setting/cubic', $data);

        $this->load->view('common/footer');
    }


    public function add_cubic()
    {

        $data_cubic = array(
            'cubic_code' => $this->input->post('cubic_code'),
            'cubic_value' => $this->input->post('cubic_value'),
            'cubic_note' => $this->input->post('cubic_note'),
            'cubic_status' => $this->input->post('cubic_status')
            
            );
            
            $result = $this->cubic->insert_cubiccode($data_cubic);
            
            if($result!=null){
                $result_all = $this->cubic->getJson_cubiccodes();
                
                $json = json_encode($result_all);
                
                echo $json;
                
                exit();
            }


    } // end of add_cubic()
    
    
    public function del_cubic($id){
        
        $result = $this->cubic->delete_cubic($id);
        
        echo $result;
        
    }
    


}// end of class

?>