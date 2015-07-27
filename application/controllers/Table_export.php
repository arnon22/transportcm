<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Table_export extends CI_Controller {
 
    public function __construct(){
        
        parent::__construct();
    }
    
    
    
    public function index(){
        
        //$this->load->model('getPricelist','pricelist');
        
        $this->load->library('excel');
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('test worksheet');
//set cell A1 content with some text
$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
//change the font size
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//make the font become bold
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//merge cell A1 until D1
$this->excel->getActiveSheet()->mergeCells('A1:D1');
//set aligment to center for that merged cell (A1 to D1)
$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$filename='just_some_random_name.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');
    }
    
    
    public function excel_reader(){
        
        $this->load->library('Excel','excel');
        $this->load->library('IOFactory',false);
        
        $inputFileType = 'Excel5';
        //$inputFileName = ."transport_pricelist.xls";
        $inputFileName = "C:/xampp/htdocs/truck-transport/assets/upload/transport_pricelist2.xls";
        echo $inputFileName;
        echo "<p>".BASEPATH."</p>";
        echo "<p>".base_url()."</p>";
        
        $this->excel=PHPExcel_IOFactory::createReader($inputFileType);
        $this->excel = PHPExcel_IOFactory::load($inputFileName);
       //$objPHPExcel= $this->excel->load($inputFileName);
       
       
       
       
       echo '<hr />';

        $sheetData = $this->excel->getActiveSheet()->toArray(null,true,true,true);
       // var_dump($sheetData);
       
       foreach($sheetData as $rows){
            $dataprice ="";
        
            $dataprice= array(
                      'pricelist_id'=>null,
                      'factory_id'=>$rows['B'],
                      'cubic_id'=>$rows['C'],
                      'distance_id'=>$rows['D'],
                      'start_date'=>date('Y-m-d',strtotime($rows['E'])), 
                      'end_date'=>date('Y-m-d',strtotime($rows['F'])),
                      'pricelist_status'=>$rows['G'],
                        'create_date'=>date('Y-m-d',strtotime($rows['H'])),
                        'modified_date'=>date('Y-m-d',strtotime($rows['I'])),
                            'price'=>$rows['J'] 
            );
            
            $this->db->insert('pricelist',$dataprice);
            $num = $this->db->affected_rows();
            if($num>0){
        
        echo "NOM=".$num;
        
      }
        
       }
       
      // print_r($dataprice);
      
     /* $this->db->insert('pricelist',$dataprice);
      
      $num = $this->db->affected_rows();
      
      if($num>0){
        
        echo "NOM=".$num;
        
      }*/
      
      
      
       
        /*
        foreach ($sheetData as $row){
            $data_price[] = array(
            'pricelist_id'=>null,
            'site_id'=>$row['B'],
            'cubic_id'=>$row['C'],
            'distance_id'=>$row['D'],
            'start_date'=>$row['E'],
            'end_date'=>$row['F'],
            'status_pricelist'=>$row['G'],
            'create_date'=>$row['H'],
            'modified_date'=>$row['I'],
            'price'=>$row['J']
            
            )
            //echo "Pricelist_id = ".$row['A']."Site_id = ".$row['B']."Cubic_ID=".$row['C']."Distance_id=".$row['D']."Start Date=".$row['E']."End Date=".$row['F']."Status=".$row['G']."Price = ".$row['J']."</br>";
            
            
        }
            
            $query = $this->db->insert('pricelist',$data_price);
            
            $num = $query->affected_rows();
            
            if($num!=null){
                echo $num;
            }
       
            exit();
            
            */
       
       
        
        //$this->excel->Load($inputFileName);
        
        
        
        //$objReader = $this->Excel_IOFactory->createReader($inputFileType);
        //$this->excel2->load($inputFileName); 
       
        //$objReader = PHPExcel_IOFactory::createReader($inputFileType);
        //$objreader = $this->IOFactory::createReader($inputFileType);
        // $objPHPExcel = $objReader->load($inputFileName);
        //$objPHPExcel = $objreader->load($inputFileName);
        
        //echo upload_path() ;
        //echo upload_url()."example1.xls";
        
        
        
        
        
    }
    
    
    public function data_to_excel($data_table){
        $query = $this->db->get($data_table);
            if(!$query)
            return false;
// Starting the PHPExcel library
                //$this->load->library('PHPExcel');
                //$this->load->library('PHPExcel/IOFactory');
                
        $this->load->library('Excel','excel');
        $this->load->library('IOFactory',false);
        
        
//$objPHPExcel = new PHPExcel();
//$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
$this->excel->getProperties()->setTitle("Export")->setDescription("none");

//$objPHPExcel->setActiveSheetIndex(0);
$this->excel->setActiveSheetIndex(0);

// Field names in the first row
$fields = $query->list_fields();
$col = 0;
foreach ($fields as $field)
{
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field );
$col++;
}
// Fetching the table data
$row = 2;
foreach($query->result() as $data)
{
$col = 0;
foreach ($fields as $field)
{
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$data->$field);
$col++;
}
$row++;
}
//$objPHPExcel->setActiveSheetIndex(0);
$this->excel->setActiveSheetIndex(0);


//$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 

$objWriter = IOFactory::createWriter($this->excel, 'Excel5');

// Sending headers to force the user to download the file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');

        
        
    } // End of pricelist_to_excel()
    
    
    public function read_excel2mysql(){
        
        //load libary PHPExcel
        $this->load->library('Excel','excel');
        $this->load->library('IOFactory',false);
        
        
        $inputFileType = 'Excel5';
        $inputFileName = "C:/xampp/htdocs/truck-transport/assets/upload/transport_pricelist.xls";
        
        $this->excel = IOFactory::identify($inputFileName);
        $this->excel = IOFactory::createReader();
        $this->excel->setReadDataOnly(true);
        $this->excel->load($inputFileName);
        
        $this->excel->setActiveSheetIndex(0);
        
    
            
        
        
        
        
        
        
        
    }
    
    
    public function time_str(){
        
        $ts = strtotime("5/15/2013");
        $d = date('Y-m-d',$ts);
        
        $days = date('Y-m-d',strtotime("5/15/2013"));
        
        echo "TS=".$ts;
        echo "<p>".$d."</p>";
        echo "<p>$days</p>";
        
    }
    

    
    
    
 
}// end of class