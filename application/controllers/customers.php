<?php
/**
 * @author Anon
 * @copyright 2013
 * @category Controller products
 */
 
 if (!defined('BASEPATH')) exit('No direct script access allow');
 
class Customers extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('customers_model','customers');
         $this->load->library('pdf');
        $this->pdf->fontpath = 'font/';
        $this->load->helper('date');        
        
    }
    
    public function getamphur(){
        $this->load->model('setting_model','amphur');        
        $id = $this->input->post('ID');
        $type = $this->input->post('TYPE');
        
        //$this->load->library('thaiprovince');
        
        
        //$result = $this->thaiprovince->getProvince($id,$type);
        $result = $this->amphur->get_amphur($id,$type);
        //$rs = new thai_province;
        
        //$result = $rs->getProvince($id,$type);
        
        
        $json = json_encode($result);
        
        echo $json; 

    }
    
    
    public function index(){
        $this->lang->load("thai");
        $this->load->model('factory_model','factory');        
        $this->load->model('setting_model','province');
        
        
        $data['province'] = $this->province->get_province();
        $data['factory'] = $this->factory->getFactory();
        $data['customers'] = $this->customers->showCustomers();
        
        
        
        //view
        $this->load->view('common/header');
        $this->load->view('customers/index',$data);        
        $this->load->view('common/footer');
    }
    
    public function add_customer(){
        $this->lang->load('thai');
        
        $data_array = array(
            'customers_code'=>$this->input->post('citizen'),
            'group_customer_id'=>1,
            'factory_id'=>$this->input->post('factory_id'),
            'customers_name'=>$this->input->post('customer_name'),
            'citizen'=>$this->input->post('citizen'),
            'address1'=>$this->input->post('address1'),
            'aumpher1'=>$this->input->post('aumpher1'),
            'province1'=>$this->input->post('provincy1'),
            'postcode'=>$this->input->post('postcode1'),
            'address2'=>$this->input->post('address2'),
            'aumpher2'=>$this->input->post('aumpher2'),
            'province2'=>$this->input->post('provincy2'),
            'postcode2'=>$this->input->post('postcode2'),
            'phone_number'=>$this->input->post('phone_number'),
            'mobile_number'=>$this->input->post('mobile_number'),
            'fax_number'=>$this->input->post('fax_number'),
            'contact_person'=>$this->input->post('contact_person'),
            'remark'=>$this->input->post('remark'),
            'status'=>1        
          
        );
        
        $result = $this->customers->add_customers($data_array);
        
        //$query = $this->db->insert('transport_customers',$data_array);
        
        //$rs = $query->db->insert_id();
        
        if($result>0){
        
            echo("insert-ok");
            exit();
            }
              
        
      }//end of function add_customer()

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
    
    public function report_pdf(){
        $this->lang->load('thai');
        $this->lang->load('report');
        ///$this->load->library('pdf',array('P','mm','A4'));
        //$this->load->library('pdf');
        //$this->pdf->fontpath = 'font/';
        
        //$this->pdf->AddPage(); // Create Pdf file
        //$this->pdf->AliasNbPages('tb');
        $this->pdf->AliasNbPages('tp');
        $this->pdf->AddPage( 'L' ,'A4' );
        
        //$data = array();
        
        
        $title_name = $this->lang->line('name');
        $title_lastname = $this->lang->line('lastname');
        $title_address = $this->lang->line('address');
        $title_tel = $this->lang->line('tel');
        $title_status = $this->lang->line('status');
        
        
        $this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        $this->pdf->SetFont('THNiramitAS','',18);
        
        
        $this->pdf->Header();
        //$this->pdf->SetX(20);
        $this->pdf->Cell(50,10,'Customer Report','C');
        $this->pdf->Ln();
        
        $this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        $this->pdf->SetFont('THNiramitAS','',16);
        
        $this->pdf->Cell(50,10,$title_name,1,0,'C');
        $this->pdf->Cell(50,10,$title_lastname,1,0,'C');
        $this->pdf->Cell(80,10,$title_address,1,0,"C");
        //$this->pdf->SetY(50);
        //$this->pdf->SetX(-40);
        $this->pdf->Cell(50,10,$title_tel,1,0,"C");
        $this->pdf->Cell(40,10,$title_status,1,0,"C");
        $this->pdf->Ln(10);
        //$data[] = $this->customers_model->showCustomers();
        //foreach($data['res'] as $key=>$vals){
        //$this->pdf->Cell(40,10,$key['$vals']);
        //$this->pdf->cel(45,10,$);
        //}
        
        $this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        $this->pdf->SetFont('THNiramitAS','',14);
       $data  = $this->customers->showCustomers();
       
       foreach ($data as $vals){
        $name = iconv('UTF-8','TIS-620',$vals['customers_name']);
        $lastname = iconv('UTF-8','TIS-620',$vals['address1']);
        $this->pdf->Cell(50,10,$name,1,0,"C");
        $this->pdf->Cell(50,10,$lastname,1,0,"C");
        $this->pdf->Ln(10);
        //iconv('UTF-8','TIS-620',$vals['customer_name'])
       }
        
       
        
        //$this->pdf->Cell(50,20,'ÃÒÂ§Ò¹ÀÒÉÒä·Â');
        //$this->pdf->MultiCell(20,15,'ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í');
        //$this->pdf_footer();
        //$this->pdf_footer();
        //$footTltle = 'ÃÒÂ§Ò¹ÅÙ¡¤éÒ';
        //$this->pdf->title('dddd'); 
        
       // $filename = "dd".date('d');
        $this->pdf->Footer();
        $this->pdf->output();
        
        
        
    }
    
   
}
