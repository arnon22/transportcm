<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Ireport extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('pdf');

        $this->pdf->fontpath = 'font/';

        $this->lang->load('thai');
        //Loadmodel
        $this->load->model('income_model', 'income');
        $this->load->model('dropdown_model', 'dropdown');
        $this->load->model('factory_model', 'factory');
        $this->load->model('cars_model', 'car');

        $this->load->library('conv_date');
        $this->load->library('jqgridnow_lib');
    }


    public function _example_output($output = null)
    {
        $this->load->view('ireport', $output);

    }

    public function show_order_output($output = null)
    {
        $this->load->view('reports/orders', $output);

    }

    public function show_report_form($viewpage, $ourput = null)
    {

        $this->load->view("reports/" . $viewpage, $ourput);

    }


    //End View


    public function index()
    {

        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');


                //Display
                $this->_example_output((object)array(
                    'output' => '',
                    'h2_title' => $h2_title,
                    'out' => $out));


            } //end if


        } else {
            redirect('login', 'refresh');
        } //end if


    } //end of index


    public function thaiDate($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2] - 543;

        $dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;

        return $dateThai;

    }

    public function thaiDate2($date)
    {

        $dt = explode('-', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $year = $dt[0];
        $mouht = $dt[1];
        $date = $dt[2];

        $dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;

        return $dateThai;

    }

    public function engDate($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2] - 543;

        $dateEng = $year . "-" . $mouht . "-" . $date;

        return $dateEng;

    }

    public function orders_report()
    {
        $factory = $this->factory->getFactory();
        $car = $this->car->get_Allcar();


        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');

                //$factory = $this->factory->getFactory();
                //$car = $this->car->get_Allcar();

                $this->load->model('report_model', 'report');


                if (isset($_POST['submit'])) {


                    $factory_id = $this->input->post('factory');
                    $stratDate = $this->input->post('startDate');
                    $endDate = $this->input->post('endDate');
                    $carType = $this->input->post('carType');
                    $carLicense = $this->input->post('carLicense');
                    $carNumber = $this->input->post('carNumber');
                    $method = "check";

                    /*0000-00-00*/
                    $start_date = $this->engDate($stratDate);
                    $end_date = $this->engDate($endDate);

                    // echo $factory_select ; exit();
                    $data_report = array(
                        'factory' => $factory_id,
                        'startDate' => $start_date,
                        'endDate' => $end_date,
                        'carType' => $carType,
                        'carLicense' => trim($carLicense),
                        'carNumber' => $carNumber,
                        'method' => "report");


                    $check_num = $this->report->check_order_report($factory_id, $carNumber, $start_date,
                        $end_date, $method);

                    if ($check_num == 0 || $check_num == '') {
                        $data_report = array(
                            'factory' => '',
                            'startDate' => '',
                            'endDate' => '',
                            'carType' => '',
                            'carLicense' => '',
                            'carNumber' => '',
                            'method' => "");
                        $this->session->unset_userdata($data_report);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ</div>";
                    } else {
                        $data_report = array(
                            'factory' => $factory_id,
                            'startDate' => $start_date,
                            'endDate' => $end_date,
                            'carType' => $carType,
                            'carLicense' => trim($carLicense),
                            'carNumber' => $carNumber,
                            'method' => "report");

                        $this->session->set_userdata($data_report);

                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check_num รายการ <a href=\"iReports\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";


                    }


                }


                //Display
                $this->show_order_output((object)array(
                    'output' => 'orders_report',
                    'h2_title' => $h2_title,
                    'factory' => $factory,
                    'car' => $car,
                    'report_status' => $report_status,
                    'out' => $out));


            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // order_report


    public function report_order_month()
    {
        $this->load->model('report_model', 'report');
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');


            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');
                $factory = $this->factory->getFactory();
                $car_number = $this->car->get_Allcar();
                // $thaimonth = $this->factory->getThaimonth();
                // $myYear = $this->factory->getYearly();

                $action = $this->input->post('submit');

                if (isset($action) && $action != "") {

                    $factory_id = $this->input->post('factory');
                    $monthYear_post = $this->input->post('monthYear');
                    $carNumber = $this->input->post('carNumber');
                    $y_d = $this->conv_date->yearMonth($monthYear_post);


                    $selectMonth = intval($y_d['Month']);
                    $selectYear = intval($y_d['Year']);
                    $method = "check";

                    $checknum_report = $this->report->orders_by_month_report($factory_id, $carNumber,
                        $selectMonth, $selectYear, $method);

                    $data_report = array(
                        'factory_id' => $factory_id,
                        'carNumber' => $carNumber,
                        'selectMonth' => $selectMonth,
                        'selectYear' => $selectYear,
                        'method' => "report");


                    if ($checknum_report == "" || $checknum_report == 0) {

                        $data_report = array(
                            'factory_id' => "",
                            'carNumber' => "",
                            'selectMonth' => "",
                            'selectYear' => "",
                            'method' => "report");

                        $this->session->unset_userdata($data_report);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ</div>";

                    } else {
                        $data_report = array(
                            'factory_id' => $factory_id,
                            'selectMonth' => $selectMonth,
                            'carNumber' => $carNumber,
                            'selectYear' => $selectYear,
                            'method' => "report");

                        $this->session->set_userdata($data_report);

                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $checknum_report รายการ <a href=\"print_orders_by_month\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    }


                } //End if

                $title_form = $this->lang->line('h2_report_order_month');
                //display
                $viewpage = "report_order_month";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'title_form' => $title_form,
                    'factory' => $factory,
                    'thaimonth' => $thaimonth,
                    'car_number' => $car_number,
                    'myYear' => $myYear,
                    'report_status' => $report_status));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // order_report


    public function report_summary_order_month()
    {
        $this->load->model('report_model', 'report');
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');


            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');
                $factory = $this->factory->getFactory();
                // $thaimonth = $this->factory->getThaimonth();
                // $myYear = $this->factory->getYearly();

                $action = $this->input->post('submit');

                if (isset($action) && $action != "") {

                    $factory_id = $this->input->post('factory');
                    $monthYear_post = $this->input->post('monthYear');
                    $y_d = $this->conv_date->yearMonth($monthYear_post);


                    $selectMonth = intval($y_d['Month']);
                    $selectYear = intval($y_d['Year']);
                    $method = "check";

                    $checknum_report = $this->report->orders_summary_by_month_report($factory_id, $selectMonth,
                        $selectYear, $method);

                    $data_report = array(
                        'factory_id' => $factory_id,
                        'selectMonth' => $selectMonth,
                        'selectYear' => $selectYear,
                        'method' => "report");


                    if ($checknum_report == "" || $checknum_report == 0) {

                        $data_report = array(
                            'factory_id' => "",
                            'selectMonth' => "",
                            'selectYear' => "",
                            'method' => "report");

                        $this->session->unset_userdata($data_report);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ</div>";

                    } else {
                        $data_report = array(
                            'factory_id' => $factory_id,
                            'selectMonth' => $selectMonth,
                            'selectYear' => $selectYear,
                            'method' => "report");

                        $this->session->set_userdata($data_report);

                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $checknum_report รายการ <a href=\"print_orders_by_month_summary_report\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    }


                } //End if

                $title_form = $this->lang->line('h2_report_order_month');
                //display
                $viewpage = "orders-by-month";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'title_form' => $title_form,
                    'factory' => $factory,
                    'thaimonth' => $thaimonth,
                    'myYear' => $myYear,
                    'report_status' => $report_status));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // order_report

    public function report_income_expense()
    {

        $factory = $this->factory->getFactory();
        $car = $this->car->get_Allcar();
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');

                $this->load->library('cmdf');
                $ipdf = $this->cmdf->load('th', 'A4', '0', 'THSaraban');


                $html = "<B>HTML กำใด<B>";
                // $ipdf->SetAutoFont();
                $ipdf->WriteHTML($html);


                $ipdf->Output();

                //display
                $viewpage = "income-expense-per-car";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'factory' => $factory,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // order_report income-expense.php

    public function report_car_driver()
    {
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');
                $factory = $this->factory->getFactory();
                $thaimonth = $this->factory->getThaimonth();
                $myYear = $this->factory->getYearly();


                //display
                $viewpage = "car-driver";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'factory' => $factory,
                    'thaimonth' => $thaimonth,
                    'myYear' => $myYear,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // order_report icar_driver


    public function report_income()
    {

        $factory = $this->factory->getFactory();

        if ($this->session->userdata('user_name')) {
            $this->load->model("report_model", "report");

            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');
                //display Remark

                $note = "income";
                $show_note = $this->report->display_note($note);

                //display
                //$c_date = "01/01/2014";

                if (!empty($_REQUEST['submit'])) {
                    $select_note = "";
                    $check = "";

                    $startDate = $this->input->post('startDate'); //d-m-Y
                    $endDate = $this->input->post('endDate'); //d-m-Y
                    $factory_id = $this->input->post('factory');
                    $select_note = $this->input->post('income_remark'); #20/07/2015 add Remark filter
                    /*Y-m-d*/
                    $st_date = $this->conv_date->eng2engDate($startDate);
                    $et_date = $this->conv_date->eng2engDate($endDate);

                    // $check = $this->report->check_numreport($factory_id, $st_date, $et_date);
                    $check = $this->report->check_numreport($factory_id, $st_date, $et_date, $select_note);


                    $income_data = array(
                        'start_date' => $st_date,
                        'end_date' => $et_date,
                        'factory_id' => $factory_id,
                        'select_note' => $select_note,
                        'method' => 'report');

                    $this->session->set_userdata($income_data);

                    if ($check == "0" || $check_report = '') {
                        #Unset Sesssion
                        $income_data = array(
                            'start_date' => '',
                            'end_date' => '',
                            'factory_id' => '',
                            'select_note' => '',
                            'method' => '');
                        $this->session->unset_userdata($income_data);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {
                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"gen_income_report\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    } //end if


                }


                $date = $this->conv_date->eng2engDate($endDate);

                $viewpage = "income";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'factory' => $factory,
                    'h2_title' => $h2_title,
                    'remark' => $show_note,
                    'income_remark' => $select_note,
                    'report_status' => $report_status,
                    'date' => $date,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // report_income


    public function gen_income_report()
    {


        //Load Model
        $this->load->model("report_model", "report");

        $method = $this->session->userdata('method');
        if (isset($method) && $method == "report") {


            $start_Date = $this->session->userdata('start_date');
            $end_Date = $this->session->userdata('end_date');
            $factory_id = $this->session->userdata('factory_id');
            $select_note = $this->session->userdata('select_note');


            //$factory_id = 2;
            // $dthai = $this->conv_date->DateThai2($c_date);

            //$this->pdf->AliasNbPages('tp');
            $this->pdf->AliasNbPages();
            //$this->pdf->AddPage('L', 'A4');
            $this->pdf->SetMargins(5, 5, 5);
            $this->pdf->AddPage('P', 'A4');

            $title_report = "รายงาน รายรับ วันที่ " . $this->conv_date->DateThai2($start_Date) .
                " ถึง " . $this->conv_date->DateThai2($end_Date);
            $head_report = iconv('UTF-8', 'TIS-620', $title_report);

            #Header
            //Header Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
            $this->pdf->Header();
            $this->pdf->SetX(50);
            $this->pdf->Cell(50, 10, $head_report, 'C');
            $this->pdf->Ln();

            #hearder Table
            $factory_title = iconv('utf-8', 'tis-620', $this->lang->line('factory_code'));
            //$ref_title = iconv('utf-8', 'tis-620', $this->lang->line('reference_number'));
            $Date_title = iconv('utf-8', 'tis-620', $this->lang->line('date'));
            $List_title = iconv('utf-8', 'tis-620', $this->lang->line('list'));
            $Amount_title = iconv('utf-8', 'tis-620', $this->lang->line('amount'));
            $Remark_title = iconv('utf-8', 'tis-620', $this->lang->line('remark'));

            #footer
            $Baht = iconv('utf-8', 'tis-620', $this->lang->line('baht'));
            $sub_total_title = iconv('utf-8', 'tis-620', $this->lang->line('sub_total'));
            $totals_title = iconv('utf-8', 'tis-620', $this->lang->line('totals'));

            #TITLE
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);
            $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
            $this->pdf->Cell(20, 5, $Date_title, 1, 0, "C", true);
            $this->pdf->Cell(15, 5, $factory_title, 1, 0, "C", true);
            //$this->pdf->Cell(17, 5, $ref_title, 1, 0, "C", true);
            $this->pdf->Cell(100, 5, $List_title, 1, 0, "C", true);
            $this->pdf->Cell(20, 5, $Amount_title, 1, 0, "C", true);
            $this->pdf->Cell(45, 5, $Remark_title, 1, 0, "C", true);
            $this->pdf->Ln();


            $check_report = $this->report->check_numreport($factory_id, $start_Date, $end_Date,
                $select_note);

            if ($check_report == '0') {


                echo "<script>
window.location.href='" . base_url() . "ireport/report_income';
alert('There are no fields to generate a report');
</script>";

                //redirect("ireport/report_income","refresh");
                exit();


            } else {
                //$result = $this->report->report_income($factory_id, $start_Date, $end_Date);
                $result = $this->report->report_income($factory_id, $start_Date, $end_Date);


                if ($result) {
                    //income_date,factory_code,ref_number,income_details,total_amount,note
                    $i = 0;
                    $p = $this->pdf->totalpage();
                    //$finalpage = intval($p);
                    $c_page = $this->pdf->PageNo();

                    $sumline_amount = 0;

                    foreach ($result as $row) {

                        $incom_date = $this->conv_date->thaiDate2($row['income_date']);
                        $ref_number = iconv('utf-8', 'tis-620', $row['ref_number']);
                        $factory = iconv('utf-8', 'tis-620', $row['factory_code']);
                        $deatil = iconv('utf-8', 'tis-620', $row['income_details']);
                        $amount = number_format($row['total_amount'], 2, '.', ',');
                        $totals = number_format($row['totals'], 2, '.', ',');
                        $remark = iconv('utf-8', 'tis-620', $row['note']);

                        $sumline_amount = $sumline_amount + $row['total_amount'];
                        /*
                        $this->pdf->Cell(20, 5, $incom_date, 1, 0, "L");
                        $this->pdf->Cell(15, 5, $factory, 1, 0, "C");
                        $this->pdf->Cell(85, 5, $deatil, 1, 0, "L");
                        $this->pdf->Cell(25, 5, $amount, 1, 0, "R");
                        $this->pdf->Cell(57, 5, $remark, 1, 0, "L");
                        $this->pdf->Ln();
                        */
                        //$this->pdf->Cell(25, 5, $sumlineamounr, 1, 0,"R");

                        /*Update Code Multi Cell*/
                        $this->pdf->SetWidths(array(
                            20,
                            15,
                            100,
                            20,
                            45));

                        $this->pdf->SetAligns(array(
                            "C",
                            "C",
                            "L",
                            "R",
                            "L"));
                        $this->pdf->mRows(array(
                            "$incom_date",
                            "$factory",
                            "$deatil",
                            "$amount",
                            "$remark"));


                        if ($i == 48) {

                            $sub_total = number_format($sumline_amount, 2, '.', ',');

                            $this->pdf->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                            $this->pdf->Cell(120, 5, $sub_total_title, 1, 0, "C", true);
                            $this->pdf->Cell(25, 5, $sub_total, 1, 0, "R", true);
                            $this->pdf->Cell(57, 5, $Baht, 1, 0, "C", true);


                            $sumline_amount = 0;

                            $this->pdf->AddPage();
                            $title_report = "รายงาน รายรับ วันที่ " . $this->conv_date->DateThai2($startDate) .
                                " ถึง " . $this->conv_date->DateThai2($endDate);
                            $head_report = iconv('UTF-8', 'TIS-620', $title_report);

                            #Header
                            //Header Report
                            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                            $this->pdf->Header();
                            $this->pdf->SetX(50);
                            $this->pdf->Cell(50, 10, $head_report, 'C');
                            $this->pdf->Ln();
                            #hearder Table
                            $factory_title = iconv('utf-8', 'tis-620', $this->lang->line('factory_code'));
                            $ref_title = iconv('utf-8', 'tis-620', $this->lang->line('reference_number'));
                            $Date_title = iconv('utf-8', 'tis-620', $this->lang->line('date'));
                            $List_title = iconv('utf-8', 'tis-620', $this->lang->line('list'));
                            $Amount_title = iconv('utf-8', 'tis-620', $this->lang->line('amount'));
                            $Remark_title = iconv('utf-8', 'tis-620', $this->lang->line('remark'));
                            #TITLE
                            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                            $this->pdf->SetFont('THNiramitAS', '', 12);
                            $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
                            $this->pdf->Cell(20, 5, $Date_title, 1, 0, "C", true);
                            $this->pdf->Cell(15, 5, $factory_title, 1, 0, "C", true);
                            $this->pdf->Cell(100, 5, $List_title, 1, 0, "C", true);
                            $this->pdf->Cell(20, 5, $Amount_title, 1, 0, "C", true);
                            $this->pdf->Cell(45, 5, $Remark_title, 1, 0, "C", true);
                            $this->pdf->Ln();
                            $i = 0;
                        } //End if
                        $i++;


                    } // end for each
                } // end if

                if ('{nb}' == $p) {
                    $sub_total = number_format($sumline_amount, 2, '.', ',');
                    $this->pdf->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                    $this->pdf->Cell(135, 5, $sub_total_title, 1, 0, "C", true);
                    $this->pdf->Cell(20, 5, $sub_total, 1, 0, "R", true);
                    $this->pdf->Cell(45, 5, $Baht, 1, 0, "C", true);


                }

                $this->pdf->SetY(270);
                $this->pdf->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                $this->pdf->Cell(150, 5, $totals_title, 1, 0, "C", true);
                $this->pdf->Cell(25, 5, $totals, 1, 0, "R", true);
                $this->pdf->Cell(25, 5, $Baht, 1, 0, "C", true);


                // $this->pdf->WriteHTML($htmlTable);


                $file_name = "รายงานรายรับ";


                $r_name = $this->conv_date->name_report($file_name, $start_Date, $end_Date);

                //$this->pdf->AutoPrint(true);
                $this->pdf->Output();

            } // End if


        } else {
            redirect("ireport/report_income", "refresh");
        } //end if

        // echo "$c_date";


    } //End of Function


    public function report_expense()
    {

        if ($this->session->userdata('user_name')) {
            $car = $this->car->get_Allcar();

            $factory = $this->factory->getFactory();

            $this->load->model("report_model", "report");


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');


                //display
                //$c_date = "01/01/2014";

                if (!empty($_REQUEST['submit'])) {


                    $startDate = $this->conv_date->eng2engDate($this->input->post('startDate'));
                    $endDate = $this->conv_date->eng2engDate($this->input->post('endDate'));
                    $factory_id = $this->input->post('factory');
                    $expenseType = $this->input->post('expenseType');
                    $car_number = $this->input->post('car_number');
                    $remark = $this->input->post('remark');
                    $car_remark = $this->input->post('car_remark');

                    $newdata = array(
                        'factory' => '',
                        'startDate' => '',
                        'endDate' => '',
                        'expenseType' => '',
                        'car_number' => '',
                        'remark' => '',
                        'car_remark' => '');


                    $check = $this->report->check_numreport_expense($factory_id, $startDate, $endDate,
                        $expenseType, $remark, $car_number, $car_remark);


                    if ($check == 0) {
                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {

                        $newdata = array(
                            'factory' => $factory_id,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                            'expenseType' => $expenseType,
                            'car_number' => $car_number,
                            'remark' => $remark,
                            'car_remark' => $car_remark);
                        $this->session->set_userdata($newdata);

                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"genexpense_report\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    }


                } //End if

                $date = $this->conv_date->eng2engDate($endDate);

                $viewpage = "expense";

                $normal_remark = $this->report->expense_normal_remark();
                $car_remark = $this->report->expense_car_remark();


                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'factory' => $factory,
                    'h2_title' => $h2_title,
                    'car' => $car,
                    'report_status' => $report_status,
                    'normal_remark' => $normal_remark,
                    'car_remark' => $car_remark,
                    'date' => $date,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // report_expense

    /*รายงานรายจ่ายทั่วไป*/
    public function genexpense_report()
    {

        //Source :: factory=All&startDate=01-04-2014&endDate=09-04-2014&expenseType=car&remark=+&car_number=1&action=send

        $this->load->model("report_model", "report");
        $this->load->helper('download');


        $factory = $this->session->userdata('factory');
        $startDate = $this->session->userdata('startDate'); //format '00-00-0000'
        $endDate = $this->session->userdata('endDate'); //format '00-00-0000'
        $expenseType = $this->session->userdata('expenseType');
        $remark = $this->session->userdata('remark');
        $car_number = $this->session->userdata('car_number');
        $car_remark = $this->session->userdata('car_remark');

        //Conver Date '00-00-0000' to '0000-00-00'
        $start_date = $this->conv_date->eng2engDate($startDate); // format '0000-00-00'
        $end_date = $this->conv_date->eng2engDate($endDate); // format '0000-00-00'

        //echo $factory." ".$startDate." ".$endDate." ".$expenseType." ".$remark." ".$car_number." ".$car_remark;
        //exit();


        //Check Num Report
        if ($expenseType == "normal") {

            //$num_expense = $this->report->check_numreport_expense($factory, $start_date,$end_date,$expenseType,$remark);
            $num_expense = $this->report->check_numreport_expense($factory, $startDate, $endDate,
                $expenseType, $remark, $car_number, $car_remark);
        } else {
            //$num_expense = $this->report->check_numreport_expense($factory, $start_date, $end_date,$expenseType,$remark,$car_number);
            $num_expense = $this->report->check_numreport_expense($factory, $startDate, $endDate,
                $expenseType, $remark, $car_number, $car_remark);
        }


        if ($num_expense == 0 || $num_expense == '' || $num_expense == '0') {

            $status = array("STATUS" => "false");


        } else {
            if ($expenseType == "normal") {

                //Result Expense form Post data form
                $rs = $this->report->report_expense($factory, $startDate, $endDate, $expenseType,
                    $remark, $car_number, $car_remark);
            } else {
                $rs = $this->report->report_expense($factory, $startDate, $endDate, $expenseType,
                    $remark, $car_number, $car_remark);
            }

            $head = array("expense_detail" => "detail", "expense_date" => "date");

            $title_column = array(
                "factory_code_title" => $this->lang->line('factory_code'),
                "ref_number_title" => $this->lang->line('reference_number'),
                "date_title" => $this->lang->line('date'),
                "detail_title" => $this->lang->line('list'),
                "amount_title" => $this->lang->line('amount'),
                "remark_title" => $this->lang->line('remark'));

            $this->pdf->expense_pdf($rs);

            $status = array("STATUS" => "true");
        }


        // echo json_encode($status);


    } // End of function


    public function gen_expense_report()
    {

        //Source :: factory=All&startDate=01-04-2014&endDate=09-04-2014&expenseType=car&remark=+&car_number=1&action=send
        $formAction = $this->input->post('action');
        $this->load->model("report_model", "report");
        $this->load->helper('download');

        if ($formAction == 'send') {

            $factory_id = intval($this->input->post('factory'));
            $startDate = $this->input->post('startDate'); //format '00-00-0000'
            $endDate = $this->input->post('endDate'); //format '00-00-0000'
            $expenseType = $this->input->post('expenseType');
            $remark = $this->input->post('remark');
            $car_number = $this->input->post('car_number');
            $car_remark = $this->input->post('car_remark');

            //Conver Date '00-00-0000' to '0000-00-00'
            $start_date = $this->conv_date->eng2engDate($startDate); // format '0000-00-00'
            $end_date = $this->conv_date->eng2engDate($endDate); // format '0000-00-00'


            //Check Num Report
            if ($expenseType == "normal") {

                //$num_expense = $this->report->check_numreport_expense($factory, $start_date,$end_date,$expenseType,$remark);
                $num_expense = $this->report->check_numreport_expense($factory, $start_date, $end_date,
                    $expenseType, $remark, $car_number, $car_remark);
            } else {
                //$num_expense = $this->report->check_numreport_expense($factory, $start_date, $end_date,$expenseType,$remark,$car_number);
                $num_expense = $this->report->check_numreport_expense($factory, $start_date, $end_date,
                    $expenseType, $remark, $car_number, $car_remark);
            }


            if ($num_expense == 0 || $num_expense == '' || $num_expense == '0') {

                $status = array("STATUS" => "false");


            } else {
                if ($expenseType == "normal") {

                    //Result Expense form Post data form
                    $rs = $this->report->report_expense($factory, $start_date, $end_date, $expenseType,
                        $remark);
                } else {

                }

                $head = array("expense_detail" => "detail", "expense_date" => "date");

                $title_column = array(
                    "factory_code_title" => $this->lang->line('factory_code'),
                    "ref_number_title" => $this->lang->line('reference_number'),
                    "date_title" => $this->lang->line('date'),
                    "detail_title" => $this->lang->line('list'),
                    "amount_title" => $this->lang->line('amount'),
                    "remark_title" => $this->lang->line('remark'));

                $this->pdf->expense_pdf($rs);

                $status = array("STATUS" => "true");
            }


            echo json_encode($status);


        }


    } // End of function

    public function report_expense_car()
    {
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');


                //display
                $viewpage = "expense-car";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // report_expense_car


public function oilexpenditure_report(){
    $this->load->model('customers_model', 'customer');
    $this->load->model('report_model', 'report');
    
    if ($this->session->userdata('user_name')) {
            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');

                $this->session->set_userdata('oilType', "receive");


                // Set fill form
                $factory_form = $this->factory->getFactory();
                $customer_form = $this->customer->getCustomer_oil();
                $car_number_form = $this->car->get_Allcar();


                if (!empty($_POST['submit'])) {
                    //* Receive POST Value
                    $oilType = $this->input->post('oilType');
                    $factory = $this->input->post('factory');
                    $startDate = $this->input->post('startDate'); // d-m-Y
                    $endDate = $this->input->post('endDate'); // d-m-Y
                    $customer = $this->input->post('customer');
                    $car_number = $this->input->post('car_number');

                    //Convert Date y-m-d
                    $start_date = $this->conv_date->eng2engDate($startDate);
                    $end_date = $this->conv_date->eng2engDate($endDate);

                    $method = "check";


                    $data = array(
                        'oiltype' => $oilType,
                        'factory' => $factory,
                        'startdate' => $start_date,
                        'enddate' => $end_date,
                        'customer' => $customer,
                        'car_number' => $car_number,
                        'method' => "report");


                    $check = $this->report->check_oil_receive_sell_number($factory, $oilType, $car_number,
                        $customer, $start_date, $end_date);
                    if ($check == '0') {
                        $data = array(
                            'oiltype' => "",
                            'factory' => "",
                            'startdate' => "",
                            'enddate' => "",
                            'customer' => "",
                            'car_number' => "",
                            'method' => "");

                        $this->session->unset_userdata($data);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {

                        $this->session->set_userdata($data);


                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"print_receive_pay_oil\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    } // End if else check


                    // $report_status ="OK".$oilType;

                    $this->session->set_userdata('oilType', $oilType);

                }


                //display
                $viewpage = "oil-income-expense";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'report_status' => $report_status,
                    'factory' => $factory_form,
                    'customer' => $customer_form,
                    'car_number' => $car_number_form,
                    'data' => $data,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }
    
    
} // end of function oilexpenditure_report()

public function listCars_oil($oilCustomer_id){
    
    
    
} // end of function listCars_oil()
function ajax_call() {
        //Checking so that people cannot go to the page directly.
        if (isset($_POST) && isset($_POST['oilcustomer'])) {
            $customer_id = $_POST['oilcustomer'];
            if($customer_id=="All"){
                $customer_id =0;
            }
            $arrCar = $this->car->get_listcar_oil($customer_id);
             
             foreach($arrCar as $rs){
                $arrFinal["All"]="ทั้งหมด";
                $arrFinal[$rs->car_id]=$rs->car_number;
             }
            
             
            //Using the form_dropdown helper function to get the new dropdown.
            print form_dropdown('caroil',$arrFinal);
            //echo json_encode($arrFinal);
            //echo "JOE $customer_id";
        }
    }


    public function oilrecive_report()
    {
        $this->load->model('customers_model', 'customer');
        $this->load->model('report_model', 'report');

        if ($this->session->userdata('user_name')) {
            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');

                $this->session->set_userdata('oilType', "receive");


                // Set fill form
                $factory_form = $this->factory->getFactory();
                $customer_form = $this->customer->getCustomer_oil();
                $car_number_form = $this->car->get_AllcarOil();


                if (!empty($_POST['submit'])) {
                    //* Receive POST Value
                    $oilType = "receive";#$this->input->post('oilType');
                    $factory = $this->input->post('factory');
                    $startDate = $this->input->post('startDate'); // d-m-Y
                    $endDate = $this->input->post('endDate'); // d-m-Y
                    $customer = $this->input->post('customer');
                    /*
                    if(!empty($_POST['customer_oil'])){
                        $customer = $this->input->post('customer_oil');
                    }else{
                        $customer = "All";
                    }
                    */
                    
                    if(!empty($_POST['caroil'])){
                        $car_number = $this->input->post('caroil');
                    }else{
                        $car_number = "All";
                    }
                    
                    

                    //Convert Date y-m-d
                    $start_date = $this->conv_date->eng2engDate($startDate);
                    $end_date = $this->conv_date->eng2engDate($endDate);

                    $method = "check";


                    $data = array(
                        'oiltype' => $oilType,
                        'factory' => $factory,
                        'startdate' => $start_date,
                        'enddate' => $end_date,
                        'customer' => $customer,
                        'car_number' => $car_number,
                        'method' => "report");


                    $check = $this->report->check_oil_receive_sell_number($factory, $oilType, $car_number,
                        $customer, $start_date, $end_date);
                    if ($check == '0') {
                        $data = array(
                            'oiltype' => "",
                            'factory' => "",
                            'startdate' => "",
                            'enddate' => "",
                            'customer' => "",
                            'car_number' => "",
                            'method' => "");

                        $this->session->unset_userdata($data);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {

                        $this->session->set_userdata($data);


                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"print_receive_pay_oil\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    } // End if else check


                    // $report_status ="OK".$oilType;

                    $this->session->set_userdata('oilType', $oilType);

                }


                //display
                $viewpage = "oil-recived-report";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'report_status' => $report_status,
                    'factory' => $factory_form,
                    'customer' => $customer_form,
                    'car_number' => $car_number_form,
                    'data' => $data,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } //end of function oilrecive_report

    public function report_oli()
    {
        $this->load->model('customers_model', 'customer');
        $this->load->model('report_model', 'report');

        if ($this->session->userdata('user_name')) {
            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                $h2_title = $this->lang->line('report_menu');

                $this->session->set_userdata('oilType', "receive");


                // Set fill form
                $factory_form = $this->factory->getFactory();
                $customer_form = $this->customer->getCustomer_oil();
                $car_number_form = $this->car->get_Allcar();


                if (!empty($_POST['submit'])) {
                    //* Receive POST Value
                    $oilType = $this->input->post('oilType');
                    $factory = $this->input->post('factory');
                    $startDate = $this->input->post('startDate'); // d-m-Y
                    $endDate = $this->input->post('endDate'); // d-m-Y
                    $customer = $this->input->post('customer');
                    $car_number = $this->input->post('car_number');

                    //Convert Date y-m-d
                    $start_date = $this->conv_date->eng2engDate($startDate);
                    $end_date = $this->conv_date->eng2engDate($endDate);

                    $method = "check";


                    $data = array(
                        'oiltype' => $oilType,
                        'factory' => $factory,
                        'startdate' => $start_date,
                        'enddate' => $end_date,
                        'customer' => $customer,
                        'car_number' => $car_number,
                        'method' => "report");


                    $check = $this->report->check_oil_receive_sell_number($factory, $oilType, $car_number,
                        $customer, $start_date, $end_date);
                    if ($check == '0') {
                        $data = array(
                            'oiltype' => "",
                            'factory' => "",
                            'startdate' => "",
                            'enddate' => "",
                            'customer' => "",
                            'car_number' => "",
                            'method' => "");

                        $this->session->unset_userdata($data);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {

                        $this->session->set_userdata($data);


                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"print_receive_pay_oil\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    } // End if else check


                    // $report_status ="OK".$oilType;

                    $this->session->set_userdata('oilType', $oilType);

                }


                //display
                $viewpage = "oil-income-expense";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'report_status' => $report_status,
                    'factory' => $factory_form,
                    'customer' => $customer_form,
                    'car_number' => $car_number_form,
                    'data' => $data,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } //end of report_oli

    public function oil_stock()
    {
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                //Load Model
                $this->load->model('report_model', 'report');
                $h2_title = $this->lang->line('report_menu');
                $factory = $this->factory->getFactory();
                $thaimonth = $this->factory->getThaimonth();
                $myYear = $this->factory->getYearly();


                if (!empty($_POST['submit'])) {
                    // var_dump($_POST);
                    $monthYear = $this->input->post('monthYear');
                    $y_d = $this->conv_date->yearMonth($monthYear);

                    $oil_type = $this->input->post('oil_type');
                    $selectMonth = intval($y_d['Month']);
                    $selectYear = intval($y_d['Year']);
                    $factory_id = $this->input->post('factory');

                    //ตรวจสอบข้อมูลรายงานที่ร้องขอ
                    $check = $this->report->check_oilreport($selectMonth, $selectYear, $oil_type, $factory_id);

                    $data_oilstock = array(
                        'oilstock_month' => $selectMonth,
                        'oilstock_year' => $selectYear,
                        'oil_factory_id' => $factory_id,
                        'monthYear' => $monthYear);
                    $this->session->set_userdata($data_oilstock);

                    if ($check == '0') {

                        $data_oilstock = array(
                            'oilstock_month' => '',
                            'oilstock_year' => '',
                            'oil_factory_id' => '',
                            'monthYear' => '');
                        $this->session->set_userdata($data_oilstock);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {


                        $report_status = "มีข้อมูล" . $check . "รายการ";
                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"print_oilstock\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    }


                    //$report_status = "ไม่มีข้อมูล";
                }


                //display
                $viewpage = "oil-stock";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'factory' => $factory,
                    'thaimonth' => $y_d,
                    'myYear' => $myYear,
                    'report_status' => $report_status,
                    'selectMonth' => $selectMonth,
                    'selectYear' => $selectYear,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // oil_stock


    public function print_receive_pay_oil()
    {
        $this->load->model('report_model', 'report');
        $this->load->model('factory_model', 'factory');
        $this->load->model('customers_model', 'customer');


        if ($this->session->userdata('method') == "report") {

            /* Data from  Session
            $data = array(
            'oiltype'=>$oilType,
            'factory'=>$factory,
            'startdate'=>$start_date,
            'enddate'=>$end_date,
            'customer'=>$customer,
            'car_number'=>$car_number,
            'method'=>"report"                    
            );
            */

            $oiltype = $this->session->userdata('oiltype');
            $factory = $this->session->userdata('factory');
            $startdate = $this->session->userdata('startdate');
            $enddate = $this->session->userdata('enddate');
            $customer = $this->session->userdata('customer');
            $car_number = $this->session->userdata('car_number');
            $method = $this->session->userdata('method');

            if ($factory == "All") {
                $factory_name = "ทั้งหมด";
            } else {
                $factory_name = $this->factory->getNamefactory($factory);
            }


            //**/
            if ($oiltype == 'receive') {
                $head_report = iconv('utf-8', 'tis-620', "รายงานรับน้ำมัน $factory_name");
            } else {
                $head_report = iconv('utf-8', 'tis-620', "รายงานจ่ายน้ำมัน $factory_name");
            }


            if ($customer == "All") {
                $left_report = "ลูกค้า : ทั้งหมด";
            } else {
                $left_report = "ลูกค้า : " . $this->customer->getCustomer_name($customer);
            }
            $right_report = "วันที่  " . $this->conv_date->DateThai2($startdate) . " ถึง " .
                $this->conv_date->DateThai2($enddate);


            $result = $this->report->check_oil_receive_sell_number($factory, $oiltype, $car_number,
                $customer, $startdate, $enddate, $method);

            //var_dump($result);

            // Create PDf Report
            $this->pdf->AliasNbPages();
            $p = $this->pdf->totalpage();
            //$finalpage = intval($p);
            $c_page = $this->pdf->PageNo();
            $this->pdf->SetMargins(3, 3, 3);
            $this->pdf->AddPage('P', 'A4');
            //Header Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
            //$this->pdf->Header();
            $this->pdf->SetX(80);
            $this->pdf->Cell(50, 10, $head_report, 'C');
            $this->pdf->Ln();
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);
            //$this->pdf->SetX(3);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
            $this->pdf->SetX(-50);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
            $this->pdf->Ln();
            /*Title Report*/
            $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
            $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('date_time')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('ref.number')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('car_number')),
                1, 0, "C", true);
            $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', $this->lang->line('detail')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('oil_value')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('price_per_lits')),
                1, 0, "C", true);
            $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $this->lang->line('price_amount')),
                1, 0, "C", true);
            $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('remark')),
                1, 0, "C", true);
            $this->pdf->Ln();
            /*Content*/

            $sub_oil = 0;
            $sub_price = 0;
            $sub_amount = 0;
            $total_oil = 0;
            $total_price = 0;
            $total_amount = 0;

            $i = 0;

            foreach ($result as $row) {

                $i = $i + 1;

                if ($oiltype == 'receive') {
                    $oil = intval($row['receive_oil']);
                    $price = intval($row['receive_price']);
                    $amount = intval($row['receive_amount']);
                } else {
                    $oil = intval($row['sell_oil']);
                    $price = intval($row['sell_price']);
                    $amount = intval($row['sell_amount']);
                }

                $sub_oil = $sub_oil + $oil;
                $sub_price = $sub_price + $price;
                $sub_amount = $sub_amount + $amount;
                /**/
                $total_oil = $total_oil + $oil;
                $total_price = $total_price + $price;
                $total_amount = $total_amount + $amount;

                $date = date('Y-m-d', strtotime($row['stock_date']));

                $this->pdf->Cell(20, 5, $this->conv_date->thaiDate2($date), 1, 0, "L");
                $this->pdf->Cell(15, 5, date("H:i:s", strtotime($row['stock_date'])), 1, 0, "L");
                $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $row['ref_number']), 1, 0, "L");
                $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $row['car_number']), 1, 0, "C");
                $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', $row['stock_details']), 1, 0,
                    "L");
                $this->pdf->Cell(20, 5, number_format($oil, 2, '.', ','), 1, 0, "C");
                $this->pdf->Cell(20, 5, number_format($price, 2, '.', ','), 1, 0, "R");
                $this->pdf->Cell(25, 5, number_format($amount, 2, '.', ','), 1, 0, "R");
                //$this->pdf->Cell(35, 5, iconv('utf-8','tis-620',$row['oil_type']), 1, 0, "C");
                $this->pdf->Cell(35, 5, $i, 1, 0, "C");
                $this->pdf->Ln();

                if ($i == 48) {
                    $i = 0;
                    // Total
                    $this->pdf->Ln(1);
                    $this->pdf->SetFillColor(192, 192, 192);
                    $this->pdf->Cell(105, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 5, number_format($sub_oil, 2, '.', ','), 1, 0, "C");
                    $this->pdf->Cell(20, 5, number_format($sub_price, 2, '.', ','), 1, 0, "R");
                    $this->pdf->Cell(25, 5, number_format($sub_amount, 2, '.', ','), 1, 0, "R");
                    //$this->pdf->Cell(35, 5, iconv('utf-8','tis-620',$row['oil_type']), 1, 0, "C");
                    $this->pdf->Cell(35, 5, "", 1, 0, "C");
                    $this->pdf->Ln();

                    $this->pdf->SetMargins(3, 3, 3);
                    $this->pdf->AddPage('P', 'A4');
                    //Header Report
                    $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                    //$this->pdf->Header();
                    $this->pdf->SetX(80);
                    $this->pdf->Cell(50, 10, $head_report, 'C');
                    $this->pdf->Ln();
                    $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->pdf->SetFont('THNiramitAS', '', 12);
                    //$this->pdf->SetX(3);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                    $this->pdf->SetX(-50);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                    $this->pdf->Ln();
                    /*Title Report*/
                    $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
                    $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('date_time')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('ref.number')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('car_number')),
                        1, 0, "C", true);
                    $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', $this->lang->line('detail')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('oil_value')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $this->lang->line('price_per_lits')),
                        1, 0, "C", true);
                    $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $this->lang->line('price_amount')),
                        1, 0, "C", true);
                    $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('remark')),
                        1, 0, "C", true);
                    $this->pdf->Ln();

                    $sub_oil = 0;
                    $sub_price = 0;
                    $sub_amount = 0;


                }


            } //End foreach

            if ('{nb}' == $p) {
                // Total
                $this->pdf->Ln(1);
                $this->pdf->SetFillColor(192, 192, 192);
                $this->pdf->Cell(105, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),
                    1, 0, "C", true);
                $this->pdf->Cell(20, 5, number_format($sub_oil, 2, '.', ','), 1, 0, "C");
                $this->pdf->Cell(20, 5, number_format($sub_price, 2, '.', ','), 1, 0, "R");
                $this->pdf->Cell(25, 5, number_format($sub_amount, 2, '.', ','), 1, 0, "R");
                //$this->pdf->Cell(35, 5, iconv('utf-8','tis-620',$row['oil_type']), 1, 0, "C");
                $this->pdf->Cell(35, 5, "", 1, 0, "C");
                $this->pdf->Ln();
            }


            // Total
            $this->pdf->Ln(1);
            $this->pdf->SetFillColor(192, 192, 192);
            $this->pdf->Cell(105, 5, iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 5, number_format($total_oil, 2, '.', ','), 1, 0, "C");
            $this->pdf->Cell(20, 5, number_format($total_price, 2, '.', ','), 1, 0, "R");
            $this->pdf->Cell(25, 5, number_format($total_amount, 2, '.', ','), 1, 0, "R");
            //$this->pdf->Cell(35, 5, iconv('utf-8','tis-620',$row['oil_type']), 1, 0, "C");
            $this->pdf->Cell(35, 5, "", 1, 0, "C");
            $this->pdf->Ln();


            $this->pdf->Output();


        }


    } //print_receive_pay_oil

    public function print_orders_by_month_summary_report()
    {

        if ($this->session->userdata('user_name')) {
            $this->load->model('report_model', 'report');
            $this->load->model('factory_model', 'factory');
            $this->load->library('mycompany');
            $this->load->model('company_model', 'company');


            if ($this->session->userdata('method') == "report") {
                /**
                 * $data_report = array(
                 * 'factory_id' => $factory_id,
                 * 'carNumber'=>$carNumber,
                 * 'selectMonth' => $selectMonth,
                 * 'selectYear'=> $selectYear,
                 * 'method' => "report"
                 * );
                 * 
                 */


                $factory_id = $this->session->userdata('factory_id');
                $selectMonth = $this->session->userdata('selectMonth');
                $selectYear = $this->session->userdata('selectYear');

                if ($factory_id == "All") {
                    $factory_name = "ทั้งหมด";
                } else {
                    $factory_name = $this->factory->getNamefactory($factory_id);
                }


                $left_report = "โรงงาน : $factory_name";

                $monthYear = date("$selectYear-$selectMonth");

                $lastday = date('F', strtotime($date));
                //$lastday = date("2014-02-t");

                $head_report = iconv('utf-8', 'tis-620', $this->lang->line('order_price_summarty_report_title'));
                //$head_report_2 = $this->company->getCompany_name();
                $head_report_2 = $this->mycompany->company_name();
                //$right_report = iconv('utf-8','tis-620',$this->conv_date->monthYearThai($monthYear) );
                $right_report = "เดือน " . $this->conv_date->monthYearThai($monthYear);

                // Create PDf Report
                $this->pdf->AliasNbPages();
                $p = $this->pdf->totalpage();
                //$finalpage = intval($p);
                $c_page = $this->pdf->PageNo();
                $this->pdf->SetMargins(3, 3, 3);
                $this->pdf->AddPage('P', 'A4');
                //Header Report
                $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                //$this->pdf->Header();
                $this->pdf->SetX(60);
                $this->pdf->Cell(50, 10, $head_report . " $head_report_2", 'C');
                $this->pdf->Ln();
                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 12);
                //$this->pdf->SetX(3);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                $this->pdf->SetX(-40);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                $this->pdf->Ln();


                /*Title Report*/
                $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
                $this->pdf->Cell(35, 8, iconv('utf-8', 'tis-620', $this->lang->line('date')), 1,
                    0, "C", true);

                $this->pdf->Cell(40, 8, iconv('utf-8', 'tis-620', $this->lang->line('pricetotal_per_day')),
                    1, 0, "C", true);
                $this->pdf->Cell(40, 8, iconv('utf-8', 'tis-620', $this->lang->line('vat_7_percent')),
                    1, 0, "C", true);
                $this->pdf->Cell(40, 8, iconv('utf-8', 'tis-620', $this->lang->line('vat_3_percent')),
                    1, 0, "C", true);
                $this->pdf->Cell(40, 8, iconv('utf-8', 'tis-620', $this->lang->line('net_total')),
                    1, 0, "C", true);
                $this->pdf->Ln();


                /*Content*/
                $date_rs = $this->report->orders_summary_by_month_report($factory_id, $selectMonth,
                    $selectYear);

                $index = array();
                //$date2 = "";
                $i = 0;

                if ($this->session->userdata('mydate')) {
                    $this->session->unset_userdata('mydate');
                }


                foreach ($date_rs as $rs) {
                    $data1[$rs['inday']][] = array(
                        'order_date' => $rs['order_date'],
                        'distance_code' => $rs['distance_code'],
                        'cubic_value' => $rs['cubic_value'],
                        'count_order' => $rs['count_order'],
                        'sum_cubic' => $rs['sum_cubic'],
                        'price' => $rs['price'],
                        'sum_price' => $rs['sum_price']);
                }


                $sum_total = 0;
                $total_price = 0;
                $total_vat7 = 0;
                $total_vat3 = 0;
                foreach ($data1 as $key => $val) {
                    //$this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $key), 1, 0, "C");
                    foreach ($val as $rs) {

                        $sum_price = $rs['sum_price'];
                        $sub_vat7 = ($sum_price) * 0.07;
                        $sub_vat3 = ($sum_price) * 0.03;
                        $sub_day_total = (($sum_price + $sub_vat7) - $sub_vat3);

                        $total_price = $total_price + $sum_price;
                        $total_vat7 = $total_vat7 + $sub_vat7;
                        $total_vat3 = $total_vat3 + $sub_vat3;
                        $sum_total = $sum_total + $sub_day_total;


                        $order_date = $this->conv_date->thaiDate2($rs['order_date']);

                        $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $order_date), 1, 0, "C");
                        $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($sum_price, 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($sub_vat7, 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($sub_vat3, 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($sub_day_total,
                            2, '.', ',')), 1, 0, "R");

                        $this->pdf->Ln();

                    }

                    /*
                    $this->pdf->SetFillColor(165, 168, 160);
                    $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),1, 0, "C",true);
                    $this->pdf->Cell(44, 5, iconv('utf-8', 'tis-620', ""),1, 0, "C",true);
                    $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $sub_count_order), 1, 0,"C",true);
                    $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', $sub_count_cubic), 1, 0,"C",true);
                    $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', ""), 1, 0,"C",true);
                    $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', number_format($sub_count_sumprice,2,'.',',') ), 1, 0,"R",true);
                    $this->pdf->Cell(33, 5, iconv('utf-8', 'tis-620', ""), 1, 0,"C",true); 
                    $this->pdf->Ln();
                    $sub_count_order = 0;
                    $sub_count_cubic = 0;
                    $sub_count_sumprice =0;
                    */

                } // End foreach

                $this->pdf->SetFillColor(145, 168, 140);
                $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                    1, 0, "C", true);
                $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($total_price, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($total_vat7, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($total_vat3, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', number_format($sum_total, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Ln();


                $this->pdf->Output();

            } else {
                redirect("ireport/report_order_month", "refresh");
            } //end if else


        } else {
            redirect('login', 'refresh');
        }


    }


    //End Summary_order_by_month_report

    public function print_orders_by_month()
    {

        if ($this->session->userdata('user_name')) {
            $this->load->model('report_model', 'report');
            $this->load->model('factory_model', 'factory');


            if ($this->session->userdata('method') == "report") {
                /**
                 * $data_report = array(
                 * 'factory_id' => $factory_id,
                 * 'carNumber'=>$carNumber
                 * 'selectMonth' => $selectMonth,
                 * 'selectYear'=> $selectYear,
                 * 'method' => "report"
                 * );
                 * 
                 */


                $factory_id = $this->session->userdata('factory_id');
                $selectMonth = $this->session->userdata('selectMonth');
                $selectYear = $this->session->userdata('selectYear');
                $carNumber = $this->session->userdata('carNumber');

                if ($factory_id == "All") {
                    $factory_name = "ทั้งหมด";
                } else {
                    $factory_name = $this->factory->getNamefactory($factory_id);
                }

                if ($carNumber == "All") {
                    $car_number = "ทั้งหมด";
                } else {
                    $car_number = $this->car->getCar_number($carNumber);
                }

                $left_report = "โรงงาน : $factory_name";

                $right_report = "หมายเลขรถ : $car_number";

                $monthYear = date("$selectYear-$selectMonth");
                //$lastdayOfmonth = date("$selectYear-$selectMonth-t");
                $lastday = date('F', strtotime($date));
                //$lastday = date("2014-02-t");

                $head_report = iconv('utf-8', 'tis-620', "รายงานค่าขนส่ง ประจำเดือน " . $this->
                    conv_date->monthYearThai($monthYear) . " ");


                // Create PDf Report
                $this->pdf->AliasNbPages();
                $p = $this->pdf->totalpage();
                //$finalpage = intval($p);
                $c_page = $this->pdf->PageNo();
                $this->pdf->SetMargins(3, 3, 3);
                $this->pdf->AddPage('P', 'A4');
                //Header Report
                $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                //$this->pdf->Header();
                $this->pdf->SetX(60);
                $this->pdf->Cell(50, 10, $head_report, 'C');
                $this->pdf->Ln();
                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 12);
                //$this->pdf->SetX(3);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                $this->pdf->SetX(-35);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                $this->pdf->Ln();


                /*Title Report*/
                $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
                $this->pdf->Cell(35, 8, iconv('utf-8', 'tis-620', $this->lang->line('date')), 1,
                    0, "C", true);

                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', $this->lang->line('distance_code_report')),
                    1, 0, "C", true);
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', $this->lang->line('cubic_per_order')),
                    1, 0, "C", true);
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', $this->lang->line('order_count')),
                    1, 0, "C", true);
                $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', $this->lang->line('cubic_sum_report')),
                    1, 0, "C", true);
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', $this->lang->line('price_per_order')),
                    1, 0, "C", true);
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', $this->lang->line('price_amount')),
                    1, 0, "C", true);
                $this->pdf->Cell(33, 8, iconv('utf-8', 'tis-620', $this->lang->line('remark')),
                    1, 0, "C", true);
                $this->pdf->Ln();


                /*Content*/
                $date_rs = $this->report->orders_by_month_report($factory_id, $carNumber, $selectMonth,
                    $selectYear);

                $index = array();
                //$date2 = "";
                $i = 0;

                if ($this->session->userdata('mydate')) {
                    $this->session->unset_userdata('mydate');
                }


                foreach ($date_rs as $rs) {
                    $data1[$rs['inday']][] = array(
                        'order_date' => $rs['order_date'],
                        'distance_code' => $rs['distance_code'],
                        'cubic_value' => $rs['cubic_value'],
                        'count_order' => $rs['count_order'],
                        'sum_cubic' => $rs['sum_cubic'],
                        'price' => $rs['price'],
                        'sum_price' => $rs['sum_price']);
                }

                $sub_count_order = 0;
                $sub_count_cubic = 0;
                $sub_count_sumprice = 0;
                $total_cout_order = 0;
                $total_count_cubic = 0;
                $total_count_sumprice = 0;
                foreach ($data1 as $key => $val) {
                    //$this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $key), 1, 0, "C");
                    foreach ($val as $rs) {
                        $sub_count_order = $sub_count_order + $rs['count_order'];
                        $sub_count_cubic = $sub_count_cubic + $rs['sum_cubic'];
                        $sub_count_sumprice = $sub_count_sumprice + $rs['sum_price'];

                        $total_cout_order = $total_cout_order + $rs['count_order'];
                        $total_count_cubic = $total_count_cubic + $rs['sum_cubic'];
                        $total_count_sumprice = $total_count_sumprice + $rs['sum_price'];

                        $order_date = $this->conv_date->thaiDate2($rs['order_date']);

                        $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $order_date), 1, 0, "C");
                        $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', $rs['distance_code']), 1, 0,
                            "C");
                        $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', $rs['cubic_value']), 1, 0, "C");
                        $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $rs['count_order']), 1, 0, "C");
                        $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', number_format($rs['sum_cubic'],
                            2, '.', ',')), 1, 0, "C");
                        $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', number_format($rs['price'], 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', number_format($rs['sum_price'],
                            2, '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(33, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C");
                        $this->pdf->Ln();

                    }

                    $this->pdf->SetFillColor(165, 168, 160);
                    $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),
                        1, 0, "C", true);
                    $this->pdf->Cell(44, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                    $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $sub_count_order), 1, 0, "C", true);
                    $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', number_format($sub_count_cubic,
                        2, '.', ',')), 1, 0, "C", true);
                    $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                    $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', number_format($sub_count_sumprice,
                        2, '.', ',')), 1, 0, "R", true);
                    $this->pdf->Cell(33, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                    $this->pdf->Ln();
                    $sub_count_order = 0;
                    $sub_count_cubic = 0;
                    $sub_count_sumprice = 0;


                } // End foreach

                $this->pdf->SetFillColor(145, 168, 140);
                $this->pdf->Cell(35, 5, iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                    1, 0, "C", true);
                $this->pdf->Cell(44, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $total_cout_order), 1, 0, "C", true);
                $this->pdf->Cell(20, 5, iconv('utf-8', 'tis-620', number_format($total_count_cubic,
                    2, '.', ',')), 1, 0, "C", true);
                $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', number_format($total_count_sumprice,
                    2, '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(33, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                $this->pdf->Ln();


                $this->pdf->Output();

            } else {
                redirect("ireport/report_order_month", "refresh");
            } //end if else


        } else {
            redirect('login', 'refresh');
        }


    } //print_orders_by_month

    public function print_oilstock()
    {

        $this->load->model('report_model', 'report');
        $this->load->model('factory_model', 'factory');

        $month = $this->session->userdata('oilstock_month');
        $year = $this->session->userdata('oilstock_year');
        $factory_id = $this->session->userdata('oil_factory_id');
        //$monthYear = $this->session->userdata('monthYear');

        if ($factory_id == "All") {
            $factory_name = "(ทั้งหมด)";
        } else {
            $factory_name = $this->factory->getNamefactory($factory_id);
        }

        $monthYear = date("$year-$month-01");
        $lastdayOfmonth = date("$year-$month-t");


        if (!empty($month) && !empty($year)) {
            /*Print PDF*/


            $result = $this->report->oilstock_report($month, $year, $factory_id);

            $this->pdf->AliasNbPages();
            $this->pdf->AddPage('L', 'A4');


            $p = $this->pdf->totalpage();


            /*Head */

            //Header Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
            //$this->pdf->Header();
            $this->pdf->SetX(80);
            $head_report = iconv('utf-8', 'tis-620', "รายงานสต๊อกน้ำมัน $factory_name " . $this->
                conv_date->DateThai2($monthYear) . " ถึง " . $this->conv_date->DateThai2($lastdayOfmonth) .
                " ");
            $this->pdf->Cell(50, 10, $head_report, 'C');
            $this->pdf->Ln();
            //Title Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
            $this->pdf->SetXY(5, 20);
            $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', 'วันที่'), 1, 0, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'เล่มที่/เลขที่'), 1, 0, 'C');
            $this->pdf->Cell(45, 8, iconv('utf-8', 'tis-620', 'รายการ'), 1, 0, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'รับ(ลิตร)'), 1, 0, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'ราคา/ลิตร'), 1, 0, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'รวมเงิน(บาท)'), 1, 0, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'จ่าย(ลิตร)'), 1, 0, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'ราคา/ลิตร'), 1, 0, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'รวมเงิน(บาท)'), 1, 0, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'คงเหลือ(ลิตร)'), 1, 0, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'รวมเงิน(บาท)'), 1, 0, 'C');
            $this->pdf->Ln();
            /*Content*/

            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);

            $y = 28;
            $i = 0;
            $subtotal_sellOil = 0;
            $subtotal_sellAmount = 0;
            $subtotal_receiveOil = 0;
            $subtotal_receiveAmount = 0;


            foreach ($result as $row) {

                $stock_date = date('d-m-Y', strtotime("{$row['stock_date']}"));
                $oilType = $row['oil_type'];

                $receive_oil = intval($row['receive_oil']);
                $receive_amount = intval($row['receive_amount']);
                $sell_oil = intval($row['sell_oil']);
                $sell_amount = intval($row['sell_amount']);

                //@ ของเดือนที่เลือก
                $total_receiveoil = intval($row['total_reciveoil']); //ยอดรวมรับน้ำมันของเดือนที่เลืือก
                $total_receiveamount = intval($row['total_reciveAmount']);
                $total_selloil = intval($row['total_selloil']);
                $total_sellamount = intval($row['total_sellamount']);
                $total_amount = $total_sellamount - $total_receiveamount; // คงเหลือ
                $total_oilAmount = $total_receiveoil - $total_selloil;

                /*All all_receiveOil*/
                $all_receiveOil = intval($row['all_receiveOil']);
                $all_receiveAmount = intval($row['all_receiveAmount']);
                $all_sellOil = intval($row['all_sellOil']);
                $all_sellAmount = intval($row['all_sellAmount']);
                $all_tatalAmount = ($all_sellAmount - $all_receiveAmount);

                /*ผลรวย่อยแต่ละหน้า*/
                $subtotal_receiveOil = $subtotal_receiveOil + $receive_oil;
                $subtotal_receiveAmount = $subtotal_receiveAmount + $receive_amount;
                $subtotal_sellOil = $subtotal_sellOil + $sell_oil;
                $subtotal_sellAmount = $subtotal_sellAmount + $sell_amount;

                /*ยอดยกมา*/
                $Balance_receiveOil = ($all_receiveOil - $all_sellOil) - $total_oilAmount;
                $Balance_Amount = ($all_tatalAmount - $total_amount);
                $all_totalOilAmount = $Balance_receiveOil + $total_oilAmount;
                $all_totalAmount = $Balance_Amount + $total_amount;


                $this->pdf->SetXY(5, $y);
                $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', $stock_date), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "{$row['ref_number']}"), 1,
                    'C');
                if ($oilType == "1") {
                    $this->pdf->Cell(45, 8, iconv('utf-8', 'tis-620', "{$row['stock_details']}"), 1,
                        'C');
                } else {
                    $this->pdf->Cell(45, 8, iconv('utf-8', 'tis-620', "{$row['stock_details']} {$row['car_number']}"),
                        1, 'C');
                }

                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "{$row['receive_oil']}"), 1,
                    'C');
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($row['receive_price'],
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['receive_amount'],
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "{$row['sell_oil']}"), 1, 'C');
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($row['sell_price'],
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['sell_amount'],
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', ""), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', ""), 1, 'C');
                $this->pdf->Ln();


                if ($i == 18) {

                    //Sub Total
                    $this->pdf->SetX(5);
                    $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
                    $this->pdf->Cell(90, 8, iconv('utf-8', 'tis-620', "ผลรวมของหน้านี้"), 1, 'C');
                    $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->pdf->SetFont('THNiramitAS', '', 12);
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($subtotal_receiveOil,
                        2, '.', ',')), 1, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($subtotal_receiveAmount,
                        2, '.', ',')), 1, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($subtotal_sellOil,
                        2, '.', ',')), 1, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($subtotal_sellAmount,
                        2, '.', ',')), 1, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');

                    $subtotal_receiveOil = 0;
                    $subtotal_receiveAmount = 0;
                    $subtotal_sellOil = 0;
                    $subtotal_sellAmount = 0;

                    $this->pdf->AddPage('L', 'A4');
                    $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                    //$this->pdf->Header();
                    $this->pdf->SetX(100);
                    $head_report = iconv('utf-8', 'tis-620', "รายงานสต๊อกน้ำมัน " . $this->
                        conv_date->DateThai2($monthYear) . " ถึง " . $this->conv_date->DateThai2($lastdayOfmonth) .
                        " ");
                    $this->pdf->Cell(50, 10, $head_report, 'C');
                    $this->pdf->Ln();
                    $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->pdf->SetFont('THNiramitAS-Bold', '', 14);

                    $this->pdf->SetXY(5, 20);
                    $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', 'วันที่'), 1, 0, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'เล่มที่/เลขที่'), 1, 0, 'C');
                    $this->pdf->Cell(45, 8, iconv('utf-8', 'tis-620', 'รายการ'), 1, 0, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'รับ(ลิตร)'), 1, 0, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'ราคา/ลิตร'), 1, 0, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'รวมเงิน(บาท)'), 1, 0, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'จ่าย(ลิตร)'), 1, 0, 'C');
                    $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', 'ราคา/ลิตร'), 1, 0, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'รวมเงิน(บาท)'), 1, 0, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'คงเหลือ(ลิตร)'), 1, 0, 'C');
                    $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', 'รวมเงิน(บาท)'), 1, 0, 'C');
                    $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->pdf->SetFont('THNiramitAS', '', 12);
                    $this->pdf->Ln();
                    $i = 0;
                    $y = 20;


                }


                $y = $y + 8;
                $i++;

            } // End for each

            if ('{nb}' == $p) {

                $this->pdf->SetX(5);
                $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
                $this->pdf->Cell(90, 8, iconv('utf-8', 'tis-620', "ผลรวมย่อย"), 1, 'C');
                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 12);
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($subtotal_receiveOil,
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($subtotal_receiveAmount,
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($subtotal_sellOil,
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($subtotal_sellAmount,
                    2, '.', ',')), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
                $this->pdf->Ln();
            }

            /*Sum footer*/
            /*ยอดยกมา*/
            $this->pdf->SetXY(5, 170);
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
            $this->pdf->Cell(90, 8, iconv('utf-8', 'tis-620', "ยอดยกมา"), 1, 'C');
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($Balance_receiveOil,
                2, '.', ',')), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', $Balance_Amount), 1, 'C');
            $this->pdf->Ln();
            $this->pdf->SetX(5);
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
            $this->pdf->Cell(90, 8, iconv('utf-8', 'tis-620', "รวมทั้งสิ้น"), 1, 'C');
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($total_receiveoil)),
                1, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($total_receiveamount,
                2, '.', ',')), 1, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($total_selloil,
                2, '.', ',')), 1, 'C');
            $this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($total_sellamount,
                2, '.', ',')), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($all_totalOilAmount,
                2, '.', ',')), 1, 'C');
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', $all_totalAmount), 1, 'C');


            $this->pdf->output();

        } else {
            redirect('ireport/oil_stock', 'refresh');
            exit();
        }


    } // print_oilstock


    //Strat Report Method


    public function iReports()
    {

        $this->load->model('report_model', 'report');

        /*
        $data_report = array(
        'factory' => $factory_id,
        'startDate' => $start_date,
        'endDate' => $end_date,
        'carType' => $carType,
        'carLicense' => trim($carLicense),
        'carNumber' => $carNumber,
        'method'=>"report");
        */

        $method = $this->session->userdata('method');

        if ($method == "report") {
            $factory_id = $this->session->userdata('factory');
            $car_id = $this->session->userdata('car_id');
            $start_date = $this->session->userdata('startDate');
            $end_date = $this->session->userdata('endDate');
            $car_id = $this->session->userdata('carNumber');

            $head_report = iconv('utf-8', 'tis-620', 'รายงานสรุปการใช้รถโม่');
            if ($factory_id == "All") {
                $left_report = "ทั้งหมด";
            } else {
                $left_report = $this->factory->getNamefactory($factory_id);
            }

            $s_date = $this->conv_date->DateThai2($start_date);
            $e_date = $this->conv_date->DateThai2($end_date);
            $right_report = "เริ่มวันที่ $s_date ถึง $e_date";

            #lang Title
            $title_index = iconv('utf-8', 'tis-620', $this->lang->line('index'));
            $dp_number = $this->lang->line('dp_number');
            $customer_site = $this->lang->line('customer_site');
            $distance_code = $this->lang->line('distance_code');
            $cubic_value = $this->lang->line('cubic_value');
            $car_number = $this->lang->line('car_number');
            $date = $this->lang->line('date');
            $time = $this->lang->line('time');
            $car_driver = $this->lang->line('car_driver');
            $oil_recived = $this->lang->line('oil_recived');
            $remark = $this->lang->line('remark');


            // Create PDf Report
            $this->pdf->AliasNbPages();
            $p = $this->pdf->totalpage();

            //$finalpage = intval($p);
            $c_page = $this->pdf->PageNo();
            $this->pdf->SetMargins(3, 3, 3);
            $this->pdf->AddPage('L', 'A4');
            //Header Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
            //$this->pdf->Header();
            $this->pdf->SetX(120);
            $this->pdf->Cell(50, 10, $head_report, 'C');
            $this->pdf->Ln();
            //$this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            //$this->pdf->SetFont('THNiramitAS', '', 12);
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 12);
            //$this->pdf->SetX(3);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
            $this->pdf->SetX(-60);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
            $this->pdf->Ln();
            /*Title Report*/
            $this->pdf->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
            $this->pdf->Cell(15, 6, iconv('utf-8', 'tis-620', $this->lang->line('index')), 1,
                0, "C", true);
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('date')), 1,
                0, "C", true);
            $this->pdf->Cell(15, 6, iconv('utf-8', 'tis-620', $this->lang->line('time')), 1,
                0, "C", true);
            $this->pdf->Cell(25, 6, iconv('utf-8', 'tis-620', $this->lang->line('dp_number')),
                1, 0, "C", true);
            $this->pdf->Cell(55, 6, iconv('utf-8', 'tis-620', $this->lang->line('customer')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('distance_code')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('cubic_value')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('car_number')),
                1, 0, "C", true);
            $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', $this->lang->line('car_driver')),
                1, 0, "C", true);
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('oil_recived')),
                1, 0, "C", true);
            $this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', $this->lang->line('remark')),
                1, 0, "C", true);
            $this->pdf->Ln();
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);

            // Get Result Report
            $result = $this->report->check_order_report($factory_id, $car_id, $start_date, $end_date);
            $i = 1;
            $r = 1;

            $sub_cubicvalue = 0;
            $total_cubicvalue = 0;
            $sub_usedoil = 0;
            $total_usedoil = 0;

            foreach ($result as $row) {
                $order_date = date('Y-m-d', strtotime($row['order_date']));
                $order_time = date('H:i:s', strtotime($row['order_date']));
                $sub_usedoil = $sub_usedoil + $row['use_oil'];
                $sub_cubicvalue = $sub_cubicvalue + $row['cubic_value'];
                $total_cubicvalue = $total_cubicvalue + $row['cubic_value'];
                $total_usedoil = $total_usedoil + $row['use_oil'];
                //$d_name = $row['driver_name'];
                $d_name = iconv('utf-8', 'tis-620', "{$row['driver_name']}");
                $driver_name = $this->conv_date->truncateStr($d_name, 18, '...');


                // $this->pdf->Cell(50, 10, "{$row['dp_number']}", 'C');
                $this->pdf->Cell(15, 6, iconv('utf-8', 'tis-620', $i), 1, 0, "C");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->conv_date->eng2engDate
                    ($order_date)), 1, 0, "C");
                $this->pdf->Cell(15, 6, iconv('utf-8', 'tis-620', $order_time), 1, 0, "C");
                $this->pdf->Cell(25, 6, iconv('utf-8', 'tis-620', "{$row['dp_number']}"), 1, 0,
                    "C");
                $this->pdf->Cell(55, 6, iconv('utf-8', 'tis-620', "{$row['customers_name']}"), 1,
                    0, "L");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "{$row['distance_code']}"), 1,
                    0, "C");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "{$row['cubic_value']}"), 1, 0,
                    "C");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "{$row['car_number']}"), 1, 0,
                    "C");
                /*
                $this->pdf->Cell(25, 6, iconv('utf-8', 'tis-620', $driver_name), 1, 0,
                "L");
                */

                $this->pdf->Cell(30, 6, $driver_name, 1, 0, "L");

                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "{$row['use_oil']}"), 1, 0,
                    "C");
                //$this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', "{$row['remark']}"), 1, 0, "C");
                $this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', "{$row['remark']}"), 1, 0, "C");

                $this->pdf->Ln();


                if ($r == 25) {

                    $this->pdf->Cell(150, 6, iconv('utf-8', 'tis-620', "ผลรวมหน้านี้"), 1, 0, "C");
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "$sub_cubicvalue"), 1, 0, "C");
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                    $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "$sub_usedoil"), 1, 0, "C");
                    $this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");

                    $this->pdf->AddPage('L', 'A4');
                    //Header Report
                    $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                    //$this->pdf->Header();
                    $this->pdf->SetX(120);
                    $this->pdf->Cell(50, 10, $head_report, 'C');
                    $this->pdf->Ln();
                    //$this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    //$this->pdf->SetFont('THNiramitAS', '', 12);
                    $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->pdf->SetFont('THNiramitAS-Bold', '', 12);
                    //$this->pdf->SetX(3);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                    $this->pdf->SetX(-60);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                    $this->pdf->Ln();
                    /*Title Report*/
                    $this->pdf->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                    $this->pdf->Cell(15, 6, iconv('utf-8', 'tis-620', $this->lang->line('index')), 1,
                        0, "C", true);
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('date')), 1,
                        0, "C", true);
                    $this->pdf->Cell(15, 6, iconv('utf-8', 'tis-620', $this->lang->line('time')), 1,
                        0, "C", true);
                    $this->pdf->Cell(25, 6, iconv('utf-8', 'tis-620', $this->lang->line('dp_number')),
                        1, 0, "C", true);
                    $this->pdf->Cell(55, 6, iconv('utf-8', 'tis-620', $this->lang->line('customer')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('distance_code')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('cubic_value')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('car_number')),
                        1, 0, "C", true);
                    $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', $this->lang->line('car_driver')),
                        1, 0, "C", true);
                    $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', $this->lang->line('oil_recived')),
                        1, 0, "C", true);
                    $this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', $this->lang->line('remark')),
                        1, 0, "C", true);
                    $this->pdf->Ln();
                    $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->pdf->SetFont('THNiramitAS', '', 12);
                    $r = 0;
                    $sub_cubicvalue = 0;
                    $sub_usedoil = 0;

                } //End if


                $i++;
                $r++;
            } //foreach

            if ('{nb}' == $p) {
                $this->pdf->Cell(150, 6, iconv('utf-8', 'tis-620', "ผลรวมหน้านี้"), 1, 0, "C");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "$sub_cubicvalue"), 1, 0, "C");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "$sub_usedoil"), 1, 0, "C");
                $this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Ln();
            }
            /*Sum footer*/
            /*ยอดยกมา*/
            $this->pdf->SetXY(3, 183);
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
            $this->pdf->Cell(150, 6, iconv('utf-8', 'tis-620', "รวมทั้งหมด"), 1, 'C');
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "$total_cubicvalue"), 1, 0,
                "C");
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
            $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
            $this->pdf->Cell(20, 6, iconv('utf-8', 'tis-620', "$total_usedoil"), 1, 0, "C");
            $this->pdf->Cell(45, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");


            #display
            $this->pdf->output();

        } else {
            redirect("ireport/orders_report", 'refresh');

        }


    }

    public function summary_usedtruck()
    {

        $this->lang->Load('report');

        $this->pdf->AliasNbPages('tp');
        $this->pdf->AddPage('L', 'A4');
        $this->pdf->Ln(8);

        $this->pdf->output();


    } // end of summary_usedtruck

    public function taxsell()
    {
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                //Load Model
                $this->load->model('report_model', 'report');
                $h2_title = $this->lang->line('report_menu');
                $factory = $this->factory->getFactory();
                $thaimonth = $this->factory->getThaimonth();
                $myYear = $this->factory->getYearly();


                if (!empty($_POST['submit'])) {
                    // var_dump($_POST);
                    $monthYear = $this->input->post('monthYear');
                    $y_d = $this->conv_date->yearMonth($monthYear);

                    $selectMonth = intval($y_d['Month']);
                    $selectYear = intval($y_d['Year']);
                    $factory_id = $this->input->post('factory');

                    //ตรวจสอบข้อมูลรายงานที่ร้องขอ
                    //$check = $this->report->check_oilreport($selectMonth, $selectYear, $oil_type, $factory_id);
                    $method = "check";
                    $tax_type = 'taxsell';

                    $check = $this->report->report_taxs($selectMonth, $selectYear, $tax_type, $method);

                    $data_taxsell = array(
                        'taxsell_month' => $selectMonth,
                        'taxsell_year' => $selectYear,
                        'tax_type' => $tax_type,
                        'method' => 'report');

                    $this->session->set_userdata($data_taxsell);

                    if ($check == '0') {

                        $data_taxsell = array(
                            'taxsell_month' => '',
                            'taxsell_year' => '',
                            'type_tax' => '',
                            'method' => '');

                        $this->session->set_userdata($data_taxsell);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {


                        $report_status = "มีข้อมูล" . $check . "รายการ";
                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"print_taxsell\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    }


                    //$report_status = "ไม่มีข้อมูล";
                }


                //display
                $viewpage = "orders-by-month";
                $title_form = "รายงานภาษีขาย";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'factory' => $factory,
                    'thaimonth' => $y_d,
                    'myYear' => $myYear,
                    'report_status' => $report_status,
                    'title_form' => $title_form,
                    'selectMonth' => $selectMonth,
                    'selectYear' => $selectYear,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // End of Taxsell


    public function taxbuy()
    {
        if ($this->session->userdata('user_name')) {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'ireport')) {
                //Load Model
                $this->load->model('report_model', 'report');
                $h2_title = $this->lang->line('report_menu');
                $factory = $this->factory->getFactory();
                $thaimonth = $this->factory->getThaimonth();
                $myYear = $this->factory->getYearly();


                if (!empty($_POST['submit'])) {
                    // var_dump($_POST);
                    $monthYear = $this->input->post('monthYear');
                    $y_d = $this->conv_date->yearMonth($monthYear);

                    $selectMonth = intval($y_d['Month']);
                    $selectYear = intval($y_d['Year']);
                    $factory_id = $this->input->post('factory');

                    //ตรวจสอบข้อมูลรายงานที่ร้องขอ
                    //$check = $this->report->check_oilreport($selectMonth, $selectYear, $oil_type, $factory_id);
                    $method = "check";
                    $tax_type = 'taxbuy';

                    $check = $this->report->report_taxs($selectMonth, $selectYear, $tax_type, $method);

                    $data_taxsell = array(
                        'taxsell_month' => $selectMonth,
                        'taxsell_year' => $selectYear,
                        'tax_type' => $tax_type,
                        'method' => 'report');

                    $this->session->set_userdata($data_taxsell);

                    if ($check == '0') {

                        $data_taxsell = array(
                            'taxsell_month' => '',
                            'taxsell_year' => '',
                            'type_tax' => '',
                            'method' => '');

                        $this->session->set_userdata($data_taxsell);

                        $report_status = "<div class=\"alert\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> ไม่มีข้อมูลที่ร้องขอ.
</div>";
                    } else {


                        $report_status = "มีข้อมูล" . $check . "รายการ";
                        $report_status = "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Warning!</strong> มีข้อมูลที่ร้องขอทั้งหมด $check รายการ <a href=\"print_taxsell\" target=\"_blank\">" .
                            img('Printer-icon32.png', array("title" => "Click เพื่อพิมพ์รายงาน")) . "</a>.
</div>";
                    }


                    //$report_status = "ไม่มีข้อมูล";
                }


                //display
                $viewpage = "orders-by-month";
                $title_form = "รายงานภาษีซื้อ";
                $this->show_report_form($viewpage, (object)array(
                    'output' => "order_report",
                    'h2_title' => $h2_title,
                    'factory' => $factory,
                    'thaimonth' => $y_d,
                    'myYear' => $myYear,
                    'report_status' => $report_status,
                    'title_form' => $title_form,
                    'selectMonth' => $selectMonth,
                    'selectYear' => $selectYear,
                    'out' => $out));

            } //end if


        } else {
            redirect('login', 'refresh');

        }

    } // End of Taxsell


    public function print_taxsell()
    {
        $this->load->model('report_model', 'report');
        //$this->load->model('customers_model', 'customer');

        //$data_taxsell = array('taxsell_month' => $selectMonth, 'taxsell_year' => $selectYear,'tax_type'=>$tax_type,'method'=>'report');

        if ($this->session->userdata('method') == "report") {


            $taxsell_month = $this->session->userdata('taxsell_month');
            $taxsell_year = $this->session->userdata('taxsell_year');
            $method = $this->session->userdata('method');
            $tax_type = $this->session->userdata('tax_type');
            if ($tax_type == "taxsell") {
                $head_tax = "รายงานภาษีขาย";
            } else {
                $head_tax = "รายงานภาษีซื้อ";
            }

            $head_report = iconv('utf-8', 'tis-620', "$head_tax");

            $year_month_report = "$taxsell_year-$taxsell_month-01";

            $report_monthYear = $this->conv_date->monthYearThai($year_month_report);

            $right_report = "ประจำเดือน $report_monthYear ";

            $left_report = "ชื่อผู้ประกอบกิจการ บริษัท ธ.นุชาพร จำกัด";
            $tax_id = "เลขประจำตัวผู้เสียภาษี 3 0306 3244 9";


            // Create PDf Report
            $this->pdf->AliasNbPages();
            $p = $this->pdf->totalpage();
            //$finalpage = intval($p);
            $c_page = $this->pdf->PageNo();
            $this->pdf->SetMargins(5, 5, 5);
            $this->pdf->AddPage('P', 'A4');
            //Header Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
            //$this->pdf->Header();
            $this->pdf->SetX(90);
            $this->pdf->Cell(50, 10, $head_report, 'C');
            $this->pdf->Ln();

            //$this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            //$this->pdf->SetFont('THNiramitAS', '', 12);
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
            //$this->pdf->SetX(3);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
            $this->pdf->Ln(6);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $tax_id), 'C');
            $this->pdf->SetX(-50);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
            $this->pdf->Ln();

            /*Title Report*/

            $this->pdf->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
            /*
            $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $this->lang->line('date')),1, 0, "C", true);
            $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', $this->lang->line('ref.number')),1, 0, "C", true);
            $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $this->lang->line('index_document')),1, 0, "C", true);
            $this->pdf->Cell(50, 5, iconv('utf-8', 'tis-620', $this->lang->line('list')),1, 0, "C", true);
            */
            $this->pdf->SetXY(5, 32);
            $this->pdf->MultiCell(20, 8, iconv('utf-8', 'tis-620', "วันที่ \n  "), LTR, "C", true);
            $this->pdf->SetXY(25, 32);
            $this->pdf->MultiCell(25, 8, iconv('utf-8', 'tis-620', "เล่มที่ / เลขที่\n "),
                LTR, "C", true);
            $this->pdf->SetXY(50, 32);
            $this->pdf->MultiCell(20, 8, iconv('utf-8', 'tis-620', "ลำดับที่\nเอกสาร"), LTR,
                "C", true);
            $this->pdf->SetXY(70, 32);
            $this->pdf->MultiCell(60, 8, iconv('utf-8', 'tis-620', "รายการ \n "), LTR, "C", true);
            $this->pdf->SetXY(130, 32);
            $this->pdf->MultiCell(25, 8, iconv('utf-8', 'tis-620', "มูลค่าสินค้า\nหรือบริการ"),
                LTR, "C", true);
            $this->pdf->SetXY(155, 32);
            $this->pdf->MultiCell(25, 8, iconv('utf-8', 'tis-620', "จำนวนเงิน\nภาษีมูลค่าเพิ่ม"),
                LTR, "C", true);
            $this->pdf->SetXY(180, 32);
            $this->pdf->MultiCell(25, 8, iconv('utf-8', 'tis-620', "จำนวนเงิน\nรวมทั้งสิ้น"),
                LTR, "C", true);

            #Detail Result
            $result = $this->report->report_taxs($taxsell_month, $taxsell_year, $tax_type, $method);


            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 12);
            $this->pdf->SetX(5);
            $i = 1;
            $sum_totalprice = 0;
            $sum_totalvat = 0;
            $sum_totalamount = 0;

            foreach ($result as $row) {

                $sum_totalprice = $sum_totalprice + $row['total_price'];
                $sum_totalvat = $sum_totalvat + $row['total_vat'];
                $sum_totalamount = $sum_totalamount + $row['total_amount'];

                $taxDate = date('d-m-Y', strtotime($row['tax_date']));
                $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', "$taxDate"), 1, 0, "C");
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "{$row['ref_number']}"), 1, 0,
                    "C");
                $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', "$i"), 1, 0, "C");
                $this->pdf->Cell(60, 8, iconv('utf-8', 'tis-620', "{$row['tax_details']}"), 1, 0,
                    "L");
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['total_price'],
                    2, '.', ',')), 1, 0, "R");
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['total_vat'],
                    2, '.', ',')), 1, 0, "R");
                $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['total_amount'],
                    2, '.', ',')), 1, 0, "R");
                $this->pdf->Ln();
                $i++;
            } //End foreach


            #total
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 14);
            $this->pdf->Cell(125, 8, iconv('utf-8', 'tis-620', "รวมทั้งสิ้น"), R, 0, "R");
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($sum_totalprice,
                2, '.', ',')), 1, 0, "R");
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($sum_totalvat, 2,
                '.', ',')), 1, 0, "R");
            $this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($sum_totalamount,
                2, '.', ',')), 1, 0, "R");


            $this->pdf->Output();


        } //print_taxsell


    } //print_receive_pay_oil


} // End of Ireport
