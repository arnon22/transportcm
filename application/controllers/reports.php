<?php

if (!defined('BASEPATH')) exit('No direct script access allow');
 
class Reports extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('pdf');
        $this->pdf->fontpath = 'font/';
    }
    
    
    public function index(){
        $this->lang->load('thai');
        
        //view
        $this->load->view('common/header');
        $this->load->view('reports/report-index');
        $this->load->view('common/footer');
        
        
    }
    
    
    public function report_all_customer(){
        $this->lang->load('report');
        $this->load->model('customers_model','customer');
        
        $this->pdf->AliasNbPages('tp');
        $this->pdf->AddPage( 'L' ,'A4' );
        
        $report_title = $this->lang->line('report_title');
        $title_name = $this->lang->line('name');
        $title_lastname = $this->lang->line('lastname');
        $title_address = $this->lang->line('address');
        $title_tel = $this->lang->line('tel');
        $title_contact = $this->lang->line('contact_person');
        $title_index = $this->lang->line('index');
        $title_mobile = $this->lang->line('mobile');
        
        $this->pdf->AddFont('THNiramitAS-Bold','','THNiramit Bold.php');
        $this->pdf->SetFont('THNiramitAS-Bold','',18);
        
        
        $this->pdf->Header();
        //$this->pdf->SetX(20);
        $this->pdf->Cell(50,10,$report_title,'C');
        $this->pdf->Ln();
        
        $this->pdf->AddFont('THNiramitAS-Bold','','THNiramit Bold.php');
        $this->pdf->SetFont('THNiramitAS-Bold','',16);
        
        //Title Report
        $this->pdf->Cell(20,10,$title_index,1,0,'C');
        $this->pdf->Cell(40,10,$title_name,1,0,'C');
        $this->pdf->Cell(70,10,$title_address,1,0,"C");
        //$this->pdf->SetY(50);
        //$this->pdf->SetX(-40);
        $this->pdf->Cell(40,10,$title_tel,1,0,"C");
        $this->pdf->Cell(40,10,$title_contact,1,0,"C");
        $this->pdf->Cell(40,10,$title_mobile,1,0,"C");
        $this->pdf->Ln(10);
        
        $this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        $this->pdf->SetFont('THNiramitAS','',14);
       $data  = $this->customer->getCustomer();
       $i =1;
       foreach ($data as $rows){
        $customer_name = iconv('UTF-8','TIS-620',$rows['customers_name']);
        //$address1 = iconv('UTF-8','TIS-620',$rows['address1'])." Í.".iconv('UTF-8','TIS-620',$rows['aumpher1'])." ¨.".iconv('UTF-8','TIS-620',$rows['province1'])." ".iconv('UTF-8','TIS-620',$rows['postcode1']);
        $contact_person = iconv('UTF-8','TIS-620',$rows['contact_person']);
        $phone_number = iconv('UTF-8','TIS-620',$rows['phone_number']);
        $mobile_number = iconv('UTF-8','TIS-620',$rows['mobile_number']);
        $this->pdf->Cell(20,10,$i,1,0,"C");
        $this->pdf->Cell(40,10,$customer_name,1,0,"L");
        //$this->pdf->Cell(70,10,$address1,1,0,"C");
        $this->pdf->Cell(40,10,$phone_number,1,0,"C");
        $this->pdf->Cell(40,10,$contact_person,1,0,"C");
        $this->pdf->Cell(40,10,$mobile_number,1,0,"C");
        $this->pdf->Ln(10);
        $i++;
        
       }
       
        $this->pdf->Footer();
        $this->pdf->output();
        
        
    }//end of
    
    
    //For Order
    
    #1.Report Order Detail by item
    public function order_deatil_pdf($id){
        $this->lang->load('thai');
        $this->lang->load('report');
        $this->load->model('order_model','order');
        ///$this->load->library('pdf',array('P','mm','A4'));
        //$this->load->library('pdf');
        //$this->pdf->fontpath = 'font/';
        
        //$this->pdf->AddPage(); // Create Pdf file
        //$this->pdf->AliasNbPages('tb');
        $this->pdf->AliasNbPages('tp');
        $this->pdf->AddPage( 'L' ,'A4' );
        
        //$data = array();
        
        
        $order_datetime = $this->lang->line('order_date_time');
        $order_delivery_datetime = $this->lang->line('delivery_datetime');
        $order_number = $this->lang->line('order_number');
        $order_dp_number = $this->lang->line('number_dp');
        $order_concrete_plant = $this->lang->line('concrete_plant');
        
        
        //$this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        //$this->pdf->SetFont('THNiramitAS','',22);
        
        $this->pdf->AddFont('THNiramitAS-Bold','','THNiramit Bold.php');
        $this->pdf->SetFont('THNiramitAS-Bold','',22);
        
        
        $this->pdf->Header();
      
        $this->pdf->Cell(50,10,'Order Detail','C');
        $this->pdf->Ln();
        
        //$this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        //$this->pdf->SetFont('THNiramitAS','',16);
        
        $this->pdf->AddFont('THNiramitAS-Bold','','THNiramit Bold.php');
        $this->pdf->SetFont('THNiramitAS-Bold','',16);
        
        
        $this->pdf->SetY(20);
        $this->pdf->SetX(-80);        
        $this->pdf->Cell(50,10,$order_datetime,0,'C');
        
        $this->pdf->SetY(30);
        $this->pdf->SetX(-80);
        $this->pdf->Cell(50,10,$order_delivery_datetime,0,'C');
        
        $this->pdf->SetY(40);
        $this->pdf->SetX(-80);
        $this->pdf->Cell(80,10,$order_number,0,"C");
        
        $this->pdf->SetY(60);
        $this->pdf->SetX(10);
        $this->pdf->Cell(30,10,$order_dp_number,1,0,"C"); 
        $this->pdf->Cell(40,10,$order_concrete_plant,1,0,"C");
        $this->pdf->Cell(50,10,$this->lang->line('agencies'),1,0,"C");
        $this->pdf->Cell(40,10,$this->lang->line('real_distance'),1,0,"C");
        $this->pdf->Cell(40,10,$this->lang->line('cubic_number'),1,0,"C");
        
       //$this->pdf->Ln(30);
       $this->pdf->SetY(90);
       $this->pdf->SetX(10);
       $this->pdf->Cell(120,10,$this->lang->line('shipping_address'),1,0,"C");
       $this->pdf->Cell(50,10,$this->lang->line('contact_person'),1,0,"C");
       $this->pdf->Cell(40,10,$this->lang->line('phone_number'),1,0,"C");
       $this->pdf->Cell(40,10,$this->lang->line('moble_number'),1,0,"C");
       
       $this->pdf->SetY(120);
       $this->pdf->SetX(10);
       $this->pdf->Cell(50,10,$this->lang->line('driver_name'),1,0,"C");
       $this->pdf->Cell(40,10,$this->lang->line('car_number'),1,0,"C");
        
        $this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        $this->pdf->SetFont('THNiramitAS','',14);
       //$data  = $this->customers->showCustomers();
       $data  = $this->order->get_order_modal($id);
       
       foreach ($data as $order){
        
        $order_create_datetime = iconv('UTF-8','TIS-620',$order->created_datetime);
        $order_delivery = iconv('UTF-8','TIS-620',$order->delivery_datetime);
        $order_number = iconv('UTF-8','TIS-620',$order->order_number);
        $factory = $order->factory_name." (".$order->factory_code.")";
        
        
        $this->pdf->SetY(20);
         $this->pdf->SetX(-50);
        $this->pdf->Cell(40,10,$order_create_datetime,1,0,"L");
        
        $this->pdf->SetY(30);
        $this->pdf->SetX(-50);
        $this->pdf->Cell(40,10,$order_delivery,1,0,"L");
        
        $this->pdf->SetY(40);
        $this->pdf->SetX(-50);
        $this->pdf->Cell(40,10,$order_number,1,0,"L");
        
        $this->pdf->SetY(70);
        $this->pdf->SetX(10);
        $this->pdf->Cell(30,10,iconv('UTF-8','TIS-620',$order->dp_number),1,0,"C");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$factory),1,0,"C");
        $this->pdf->Cell(50,10,iconv('UTF-8','TIS-620',$order->customers_name),1,0,"C");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->real_distance),1,0,"C");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->cubic_code),1,0,"C");
   
        
        $this->pdf->SetY(100);
        $this->pdf->SetX(10);
        $this->pdf->Cell(120,10,iconv('UTF-8','TIS-620',$order->address1),1,0,"L");
        $this->pdf->Cell(50,10,iconv('UTF-8','TIS-620',$order->contact_person),1,0,"C");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->phone_number),1,0,"C");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->mobile_number),1,0,"C");
        
        $this->pdf->SetY(130);
        $this->pdf->SetX(10);
        $this->pdf->Cell(50,10,iconv('UTF-8','TIS-620',$order->driver_name),1,0,"L");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->car_number),1,0,"C");
        
                                
        //$this->pdf->Ln(10);
        //iconv('UTF-8','TIS-620',$vals['customer_name'])
       }
        
       
        
        //$this->pdf->Cell(50,20,'ÃÒÂ§Ò¹ÀÒÉÒä·Â');
        //$this->pdf->MultiCell(20,15,'ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í');
        //$this->pdf_footer();
        //$this->pdf_footer();
        //$footTltle = 'ÃÒÂ§Ò¹ÅÙ¡¤éÒ';
        //$this->pdf->title('dddd'); 
        
       // $filename = "dd".date('d');
        //$this->pdf->Footer();
        $this->pdf->output();
        
        
        
    }// end of function order_deatil_pdf($id)
    
    public function report_orders_summary(){
        $this->lang->load('thai');
        $this->lang->load('report');
        $this->load->model('order_model','order');
        
      $start_date = date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('start_datetime'))));
      $end_date = date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('end_datetime'))));
      $factory_id = $this->input->post('factory_id');
      $car_number = $this->input->post('car_number');  
        
      if($factory_id=='0'){
        
        $data  = $this->order->order_report_select_summary($start_date,$end_date);
        
      }
      
      if($factory_id!='0' and $car_number=='0'){
        $data  = $this->order->order_report_select_summary2($start_date,$end_date,$factory_id);
      }
      
       if($factory_id!='0' and $car_number!='0'){
        $data  = $this->order->order_report_select_summary3($start_date,$end_date,$factory_id,$car_number);
      } 
      
       if($factory_id=='0' and $car_number!='0'){
        $data  = $this->order->order_report_select_summary4($start_date,$end_date,$car_number);
      }   
        
      /*'start_datetime' => date('Y-m-d H:m:s',strtotime(str_replace('/','-',$this->input->post('start_date')))),
      'end_datetime'=>date('Y-m-d H:m:s',strtotime(str_replace('/','-',$this->input->post('end_date')))),
        */
      
      //$start_date = $this->input->post('start_date');
      //$end_date = $this->input->post('end_date');
      
      
      //$data  = $this->order->order_report_summary();
      
      //Gen pdf
      $this->lang->load('thai');
      $this->lang->load('report');
      $this->load->model('order_model','order');
        ///$this->load->library('pdf',array('P','mm','A4'));
        //$this->load->library('pdf');
        //$this->pdf->fontpath = 'font/';
        
        //$this->pdf->AddPage(); // Create Pdf file
        //$this->pdf->AliasNbPages('tb');
      $this->pdf->AliasNbPages('tp');
      $this->pdf->AddPage( 'L' ,'A4' );
        
        //$data = array();
        
        
        $order_datetime = $this->lang->line('order_date_time');
        $order_delivery_datetime = $this->lang->line('delivery_datetime');
        $order_number = $this->lang->line('order_number');
        $order_dp_number = $this->lang->line('number_dp');
        $order_concrete_plant = $this->lang->line('concrete_plant');
        $header_report = $this->lang->line('Order_transport_report');
      
        
        
        //$this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        //$this->pdf->SetFont('THNiramitAS','',22);
        
        $this->pdf->AddFont('THNiramitAS-Bold','','THNiramit Bold.php');
        $this->pdf->SetFont('THNiramitAS-Bold','',20);
        
        
        $this->pdf->Header();
      
        $this->pdf->Cell(40,10,$this->lang->line('Order_transport_report'),'C');
        $this->pdf->SetX(65);
        $this->pdf->Cell(12,10,$this->lang->line('date'),'C');
        $this->pdf->Cell(30,10,$start_date,'C');
        $this->pdf->Cell(10,10,$this->lang->line('to'),'C');
        $this->pdf->Cell(10,10,$end_date,'C');
        $this->pdf->Ln(10);
        
        //$this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        //$this->pdf->SetFont('THNiramitAS','',16);
        
        $this->pdf->AddFont('THNiramitAS-Bold','','THNiramit Bold.php');
        $this->pdf->SetFont('THNiramitAS-Bold','',14);
        
        
        //$this->pdf->SetY(20);
        //$this->pdf->SetX(-80); 
        $this->pdf->Cell(20,10,$this->lang->line('index'),1,0,'C');
        $this->pdf->Cell(30,10,$this->lang->line('number_dp'),1,0,'C');       
        $this->pdf->Cell(50,10,$this->lang->line('agencies'),1,0,"C");
        $this->pdf->Cell(30,10,$this->lang->line('distance_code'),1,0,'C');
        $this->pdf->Cell(20,10,$this->lang->line('cubic_number'),1,0,'C');
        $this->pdf->Cell(30,10,$this->lang->line('car_number'),1,0,'C');
        $this->pdf->Cell(40,10,$this->lang->line('driver_name'),1,0,'C');
        $this->pdf->Cell(40,10,$this->lang->line('date_time'),1,0,'C');
        $this->pdf->Cell(20,10,$this->lang->line('oil_recive'),1,0,'C');
        $this->pdf->Ln(10);
        
        $this->pdf->AddFont('THNiramitAS','','THNiramit.php');
        $this->pdf->SetFont('THNiramitAS','',13);
       //$data  = $this->customers->showCustomers();
       
         
         $i=1;
       foreach ($data as $order){
        
        $order_create_datetime = iconv('UTF-8','TIS-620',$order->created_datetime);
        $order_delivery = iconv('UTF-8','TIS-620',$order->delivery_datetime);
        $order_number = iconv('UTF-8','TIS-620',$order->order_number);
        $factory = $order->factory_name." (".$order->factory_code.")";
        
        //$this->pdf->SetY(30);
        //$this->pdf->SetX(10);
        
        $this->pdf->cell(20,10,$i,1,0,"C");
        $this->pdf->Cell(30,10,iconv('UTF-8','TIS-620',$order->dp_number),1,0,"C");
        $this->pdf->Cell(50,10,iconv('UTF-8','TIS-620',$order->customers_name),1,0,"L");
        $this->pdf->Cell(30,10,iconv('UTF-8','TIS-620',$order->distance_code),1,0,"C");
        $this->pdf->Cell(20,10,iconv('UTF-8','TIS-620',$order->cubic_value),1,0,"C");
        $this->pdf->Cell(30,10,iconv('UTF-8','TIS-620',$order->car_number),1,0,"C");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->driver_name),1,0,"L");
        $this->pdf->Cell(40,10,iconv('UTF-8','TIS-620',$order->created_datetime),1,0,"L");
        $this->pdf->Cell(20,10,iconv('UTF-8','TIS-620',""),1,0,"C");
        
      
        //$this->pdf->Cell(30,10,iconv('UTF-8','TIS-620',$order->customers_name),1,0,"C");
        //$this->pdf->Cell(30,10,iconv('UTF-8','TIS-620',$order->customers_name),1,0,"C");
        $this->pdf->Ln(10);
        
        
        $i++;
       }
       
       $this->pdf->Cell(20,10,$this->lang->line('total'),1,0,"C");
       $this->pdf->Cell(110,10,"",1,0,"C");
       $this->pdf->Cell(20,10,"",1,0,"C");
       $this->pdf->Cell(110,10,"",1,0,"C");
       $this->pdf->Cell(20,10,"",1,0,"C");
        
       
        
        //$this->pdf->Cell(50,20,'ÃÒÂ§Ò¹ÀÒÉÒä·Â');
        //$this->pdf->MultiCell(20,15,'ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í ÃÑ¡à¸Í');
        //$this->pdf_footer();
        //$this->pdf_footer();
        //$footTltle = 'ÃÒÂ§Ò¹ÅÙ¡¤éÒ';
        //$this->pdf->title('dddd'); 
        
       // $filename = "dd".date('d');
        //$this->pdf->Footer();
        $this->pdf->output();  
        
        
        
        
        
        
    }
    
    
    
    
    
    //end of order report
    
    
    
}//end of class
