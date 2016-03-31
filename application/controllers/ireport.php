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

                $title_form = $this->lang->line('h2_report_order_summary_month');
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


    /**
     *
     */
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

             #$mk_date ='2015-01-30';
            $st_date = $this->conv_date->eng2engDatedot($start_Date);
            $en_date = $this->conv_date->eng2engDatedot($end_Date);
            //$factory_id = 2;
            // $dthai = $this->conv_date->DateThai2($c_date);

            //$this->pdf->AliasNbPages('tp');
            $this->pdf->AliasNbPages();
            //$this->pdf->AddPage('L', 'A4');
            $this->pdf->SetMargins(5, 5, 5);
            $this->pdf->AddPage('P', 'A4');
            //**** กำหนดขนาด Space ของ Footer
            $height_of_cell = 42; // mm
            $page_height = 297; // 210 x 297mm (portrait letter)
            $bottom_margin = 0; // mm


            #$title_report = "รายงาน รายรับ วันที่ " . $this->conv_date->DateThai3($st_date) .
                " ถึง " . $this->conv_date->DateThai2($en_date);
            $title_report = "รายงาน รายรับ";
            $head_report = iconv('UTF-8', 'TIS-620', $title_report);
            $right_report = "วันที่ ".$this->conv_date->DateThai2($en_date)." ถึง ".$this->conv_date->DateThai2($en_date);

            #Header
            //Header Report
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
            $this->pdf->Header();
            $this->pdf->SetX(80);
            $this->pdf->Cell(50, 10, $head_report, 'C');
            $this->pdf->Ln();
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);
            $this->pdf->SetX(-60);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
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
            $this->pdf->SetFont('THNiramitAS', '', 15);
            $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
                        
            #Title
            /*Update Code Multi Cell*/
            $this->pdf->SetWidths(array(
                22,
                15,
                95,
                28,
                40));

            $this->pdf->SetAligns(array(
                "C",
                "C",
                "C",
                "C",
                "C"));
            $this->pdf->mRows(array(
                "$Date_title",
                "$factory_title",
                "$List_title",
                "$Amount_title",
                "$Remark_title"));


            $check_report = $this->report->check_numreport($factory_id, $start_Date, $end_Date,$select_note);

            if ($check_report == '0') {


                echo "<script>
window.location.href='" . base_url() . "ireport/report_income';
alert('There are no fields to generate a report');
</script>";

                //redirect("ireport/report_income","refresh");
                exit();


            } else {
                //$result = $this->report->report_income($factory_id, $start_Date, $end_Date);
                $result = $this->report->report_income($factory_id, $start_Date, $end_Date,$select_note);


                if ($result) {
                    //income_date,factory_code,ref_number,income_details,total_amount,note
                    $i = 0;
                    $p = $this->pdf->totalpage();
                    //$finalpage = intval($p);
                    $c_page = $this->pdf->PageNo();

                    $sumline_amount = 0;

                    foreach ($result as $row) {

                        //$incom_date = $this->conv_date->thaiDate2($row['income_date']);
                        $incom_date = $this->conv_date->eng2engDate($row['income_date']);
                        $ref_number = iconv('utf-8', 'tis-620', $row['ref_number']);
                        $factory = iconv('utf-8', 'tis-620', $row['factory_code']);
                        $deatil = iconv('utf-8', 'tis-620', $row['income_details']);
                        $amount = number_format($row['total_amount'], 2, '.', ',');
                        $totals = number_format($row['totals'], 2, '.', ',');
                        $remark = iconv('utf-8', 'tis-620', $row['note']);

                        $detail_no_space = trim($deatil);

                        $sumline_amount = $sumline_amount + $row['total_amount'];

                        $space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page
                        /*Update Code Multi Cell*/
                        $this->pdf->SetWidths(array(
                            22,
                            15,
                            95,
                            28,
                            40));

                        $this->pdf->SetAligns(array(
                            "L",
                            "C",
                            "L",
                            "R",
                            "L"));
                        $this->pdf->mRows(array(
                            "$incom_date",
                            "$factory",
                            "$detail_no_space",
                            "$amount",
                            "$remark"));


                        #if ($i == 48) {
                        if ($height_of_cell > $space_left) {

                            $sub_total = number_format($sumline_amount, 2, '.', ',');
                            /*
                            $this->pdf->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                            $this->pdf->Cell(132, 5, $sub_total_title, 1, 0, "C", true);
                            $this->pdf->Cell(28, 5, $sub_total, 1, 0, "R", true);
                            $this->pdf->Cell(40, 5, $Baht, 1, 0, "C", true);
                            */
                            $this->pdf->SetWidths(array(
                                132,
                                28,
                                40
                            ));
                            $this->pdf->SetAligns(array(
                                "C",
                                "R",
                                "L"
                            ));
                            $this->pdf->mRows(array(
                                "$sub_total_title",
                                "$sub_total",
                                ""
                            ));


                            $sumline_amount = 0;

                            #New Page
                            $this->pdf->AddPage();
                            #Header
                            //Header Report
                            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                            $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                            $this->pdf->Header();
                            $this->pdf->SetX(80);
                            $this->pdf->Cell(50, 10, $head_report, 'C');
                            $this->pdf->Ln();
                            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                            $this->pdf->SetFont('THNiramitAS', '', 15);
                            $this->pdf->SetX(-60);
                            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
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
                            $this->pdf->SetFont('THNiramitAS', '', 15);
                            $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);

                            #Title
                            /*Update Code Multi Cell*/
                            $this->pdf->SetWidths(array(
                                22,
                                15,
                                95,
                                28,
                                40));

                            $this->pdf->SetAligns(array(
                                "C",
                                "C",
                                "C",
                                "C",
                                "C"));
                            $this->pdf->mRows(array(
                                "$Date_title",
                                "$factory_title",
                                "$List_title",
                                "$Amount_title",
                                "$Remark_title"));
                            $i = 0;
                        } //End if
                        $i++;


                    } // end for each
                } // end if

                if ('{nb}' == $p) {

                    $sub_total = number_format($sumline_amount, 2, '.', ',');
                    /*
                    $this->pdf->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                    $this->pdf->Cell(132, 5, $sub_total_title, 1, 0, "C", true);
                    $this->pdf->Cell(28, 5, $sub_total, 1, 0, "R", true);
                    $this->pdf->Cell(40, 5, "", 1, 0, "C", true);
                    */
                    $this->pdf->SetWidths(array(
                        132,
                        28,
                        40
                    ));
                    $this->pdf->SetAligns(array(
                        "C",
                        "R",
                        "L"
                    ));
                    $this->pdf->mRows(array(
                        "$sub_total_title",
                        "$sub_total",
                        ""
                    ));


                }

                $this->pdf->SetY(267);
                /*
                $this->pdf->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                $this->pdf->Cell(132, 5, $totals_title, 1, 0, "C", true);
                $this->pdf->Cell(28, 5, $totals, 1, 0, "R", true);
                $this->pdf->Cell(40, 5, $Baht, 1, 0, "C", true);
                */
                #Footer
                $this->pdf->SetWidths(array(
                    132,
                    28,
                    40
                ));
                $this->pdf->SetAligns(array(
                    "C",
                    "R",
                    "L"
                ));
                $this->pdf->mRows(array(
                    "$totals_title",
                    "$totals",
                    ""
                ));

                #


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


    public function oilexpenditure_report()
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


    } // end of function oilexpenditure_report()

    public function listCars_oil($oilCustomer_id)
    {


    } // end of function listCars_oil()
    function ajax_call()
    {
        //Checking so that people cannot go to the page directly.
        if (isset($_POST) && isset($_POST['oilcustomer'])) {
            $customer_id = $_POST['oilcustomer'];
            if ($customer_id == "All") {
                $customer_id = 0;
            }
            $arrCar = $this->car->get_listcar_oil($customer_id);

            foreach ($arrCar as $rs) {
                $arrFinal["All"] = "ทั้งหมด";
                $arrFinal[$rs->car_id] = $rs->car_number;
            }


            //Using the form_dropdown helper function to get the new dropdown.
            print form_dropdown('caroil', $arrFinal);
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
                    #$oilType = "receive";#$this->input->post('oilType');
                    $oilType = $this->input->post('oilType');
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

                    if (!empty($_POST['caroil'])) {
                        $car_number = $this->input->post('caroil');
                    } else {
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

            $oiltype = $this->session->userdata('oiltype');
            $factory = $this->session->userdata('factory');
            $startdate = $this->session->userdata('startdate');
            $s_start = $this->conv_date->eng2engDatedot($startdate);
            $enddate = $this->session->userdata('enddate');
            $e_date = $this->conv_date->eng2engDatedot($enddate);

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
            $right_report = "วันที่  " . $this->conv_date->DateThai2($s_start). " ถึง " .
                $this->conv_date->DateThai2($e_date);


            $result = $this->report->check_oil_receive_sell_number($factory, $oiltype, $car_number,
                $customer, $startdate, $enddate, $method);

            //var_dump($result);

            // Create PDf Report
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AliasNbPages();
            $p = $this->pdf->totalpage();

            //**** กำหนดขนาด Space ของ Footer
            $height_of_cell = 30; // mm
            $page_height = 297; //210 x 297  mm (portrait letter)
            $bottom_margin = 0; // mm


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
            $this->pdf->SetFont('THNiramitAS', '', 15);
            //$this->pdf->SetX(3);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
            $this->pdf->SetX(-60);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
            $this->pdf->Ln();
            /*Title Report*/

            $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);

            $dateTime = iconv('utf-8', 'tis-620', $this->lang->line('date_time'));
            $refNum = iconv('utf-8', 'tis-620', $this->lang->line('ref.number'));
            $carNumber = iconv('utf-8', 'tis-620', $this->lang->line('car_number'));
            $details = iconv('utf-8', 'tis-620', $this->lang->line('detail'));
            $oilValue = iconv('utf-8', 'tis-620', $this->lang->line('oil_value'));
            $priceList = iconv('utf-8', 'tis-620', $this->lang->line('price_per_lits'));
            $priceAmount = iconv('utf-8', 'tis-620', $this->lang->line('price_amount'));
            $remark = iconv('utf-8', 'tis-620', $this->lang->line('remark'));
            $this->pdf->SetX(5);
            /* Title */
            $this->pdf->SetWidths(array(
                34,
                20,
                18,
                45,
                20,
                15,
                22,
                27));

            $this->pdf->SetAligns(array(
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C"));
            $this->pdf->mRows(array(
                "$dateTime",
                "$refNum",
                "$carNumber",
                "$details",
                "$oilValue",
                "$priceList",
                "$priceAmount",
                "$remark"));


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
                $this->pdf->SetX(5);
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
                $oil_date = $this->conv_date->eng2engDate($date);
                $oil_time = date("H:i", strtotime($row['stock_date']));
                $oil_ref = iconv('utf-8', 'tis-620', $row['ref_number']);
                $oil_car = iconv('utf-8', 'tis-620', $row['car_number']);
                $oil_detail = iconv('utf-8', 'tis-620', $row['stock_details']);
                $oil_val = number_format($oil, 2, '.', ',');
                $oil_price = number_format($price, 2, '.', ',');
                $oil_amount = number_format($amount, 2, '.', ',');
                $oil_note = iconv('utf-8', 'tis-620', $row['note']);

                /*กำหนดค่า Space ด้าน ด้านซ้าย*/
                $space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page

                /*Update Code Multi Cell*/
                $this->pdf->SetWidths(array(
                    22,
                    12,
                    20,
                    18,
                    45,
                    20,
                    15,
                    22,
                    27));

                $this->pdf->SetAligns(array(
                    "L",
                    "L",
                    "L",
                    "L",
                    "L",
                    "R",
                    "R",
                    "R",
                    "L"));
                $this->pdf->mRows(array(
                    "$oil_date",
                    "$oil_time",
                    "$oil_ref",
                    "$oil_car",
                    "$oil_detail",
                    "$oil_val",
                    "$oil_price",
                    "$oil_amount",
                    "$oil_note"));


                //if ($i == 48) {
                if ($height_of_cell > $space_left) {
                    $i = 0;
                    // Total
                    $this->pdf->Ln(1);
                    $this->pdf->SetFillColor(192, 192, 192);
                    $this->pdf->SetX(5);
                    $this->pdf->Cell(72, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),
                        1, 0, "C", true);
                    $this->pdf->Cell(65, 5, number_format($sub_oil, 2, '.', ','), 1, 0, "R");
                    $this->pdf->Cell(15, 5, iconv('utf-8', 'tis-620', "-"), 1, 0, "R");
                    $this->pdf->Cell(22, 5, number_format($sub_amount, 2, '.', ','), 1, 0, "R");
                    //$this->pdf->Cell(35, 5, iconv('utf-8','tis-620',$row['oil_type']), 1, 0, "C");
                    $this->pdf->Cell(27, 5, "", 1, 0, "C");
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
                    $this->pdf->SetFont('THNiramitAS', '', 15);
                    //$this->pdf->SetX(3);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                    $this->pdf->SetX(-60);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                    $this->pdf->Ln();
                    $this->pdf->SetX(5);
                    /*Title Report*/
                    /* Title */
                    $this->pdf->SetWidths(array(
                        34,
                        20,
                        18,
                        45,
                        20,
                        15,
                        22,
                        27));

                    $this->pdf->SetAligns(array(
                        "L",
                        "L",
                        "L",
                        "L",
                        "L",
                        "L",
                        "L",
                        "L",
                        "L"));
                    $this->pdf->mRows(array(
                        "$dateTime",
                        "$refNum",
                        "$carNumber",
                        "$details",
                        "$oilValue",
                        "$priceList",
                        "$priceAmount",
                        "$remark"));

                    $sub_oil = 0;
                    $sub_price = 0;
                    $sub_amount = 0;


                }


            } //End foreach

            if ('{nb}' == $p) {
                // Total
                $this->pdf->Ln(1);
                $this->pdf->SetFillColor(192, 192, 192);
                $this->pdf->SetX(5);
                $this->pdf->Cell(72, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),
                    1, 0, "C", true);
                $this->pdf->Cell(65, 5, number_format($sub_oil, 2, '.', ','), 1, 0, "R");
                $this->pdf->Cell(15, 5, iconv('utf-8', 'tis-620', "-"), 1, 0, "R");
                $this->pdf->Cell(22, 5, number_format($sub_amount, 2, '.', ','), 1, 0, "R");
                $this->pdf->Cell(27, 5, "", 1, 0, "C");
                $this->pdf->Ln();
            }


            // Total
            $this->pdf->Ln(1);
            $this->pdf->SetFillColor(192, 192, 192);
            $this->pdf->SetX(5);
            $this->pdf->Cell(72, 5, iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                1, 0, "C", true);
            $this->pdf->Cell(65, 5, number_format($total_oil, 2, '.', ','), 1, 0, "R");
            $this->pdf->Cell(15, 5, iconv('utf-8', 'tis-620', "-"), 1, 0, "R");
            $this->pdf->Cell(22, 5, number_format($total_amount, 2, '.', ','), 1, 0, "R");
            $this->pdf->Cell(27, 5, "", 1, 0, "C");
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
                $this->pdf->SetFont('THNiramitAS', '', 15);
                //$this->pdf->SetX(3);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                $this->pdf->SetX(-40);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                $this->pdf->Ln();


                /*Title Report*/
                /*
                $this->pdf->SetFillColor(95, 158, 160); //$this->pdf->SetFillColor(200,220,255);
                $this->pdf->Cell(30, 8, iconv('utf-8', 'tis-620', $this->lang->line('date')), 1,
                    0, "C", true);
                $this->pdf->Cell(43, 8, iconv('utf-8', 'tis-620', $this->lang->line('pricetotal_per_day')),
                    1, 0, "C", true);
                $this->pdf->Cell(43, 8, iconv('utf-8', 'tis-620', $this->lang->line('vat_7_percent')),
                    1, 0, "C", true);
                $this->pdf->Cell(43, 8, iconv('utf-8', 'tis-620', $this->lang->line('vat_3_percent')),
                    1, 0, "C", true);
                $this->pdf->Cell(43, 8, iconv('utf-8', 'tis-620', $this->lang->line('net_total')),
                    1, 0, "C", true);
                $this->pdf->Ln();
                */


                $title_date =  iconv('utf-8', 'tis-620', $this->lang->line('date'));
                $title_pricetotlal_per_day = iconv('utf-8', 'tis-620', $this->lang->line('pricetotal_per_day'));
                $title_vat7 = iconv('utf-8', 'tis-620', $this->lang->line('vat_7_percent'));
                $title_vat3 = iconv('utf-8', 'tis-620', $this->lang->line('vat_3_percent'));
                $title_net_total = iconv('utf-8', 'tis-620', $this->lang->line('net_total'));

                #$this->pdf->SetWidths
                $this->pdf->SetWidths(array(
                    30,
                    43,
                    43,
                    43,
                    43,
                    43
                ));
                #$this->pdf->SetAligns
                $this->pdf->SetAligns(array(
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C"
                ));
                #$this->pdf->mRows
                $this->pdf->mRows(array(
                    "$title_date",
                    "$title_pricetotlal_per_day",
                    "$title_vat7",
                    "$title_vat3",
                    "$title_net_total"
                ));

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

                        $order_date = date('Y-m-d', strtotime($rs['order_date']));
                        $orderDate = $this->conv_date->eng2engDate($order_date);

                        /*
                        $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', $order_date), 1, 0, "L");
                        $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($sum_price, 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($sub_vat7, 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($sub_vat3, 2,
                            '.', ',')), 1, 0, "R");
                        $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($sub_day_total,2, '.', ',')), 1, 0, "R");
                        $this->pdf->Ln();
                        */
                        #Content Report
                        $rs_orderDate = $orderDate;
                        $rs_sumprice = number_format($sum_price,2);
                        $rs_sub_vat7 = number_format($sub_vat7,2);
                        $rs_sub_vat3 = number_format($sub_vat3,2);
                        $rs_sub_day_total = number_format($sub_day_total,2);
                        $this->pdf->SetWidths(array(
                            30,
                            43,
                            43,
                            43,
                            43
                        ));
                        $this->pdf->setAligns(array(
                            "L",
                            "R",
                            "R",
                            "R",
                            "R"
                        ));
                        $this->pdf->mRows(array(
                            "$rs_orderDate",
                            "$rs_sumprice",
                            "$rs_sub_vat7",
                            "$rs_sub_vat3",
                            "$rs_sub_day_total"

                        ));


                    }


                } // End foreach
                /*
                $this->pdf->SetFillColor(145, 168, 140);
                $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                    1, 0, "C", true);
                $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($total_price, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($total_vat7, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($total_vat3, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(43, 5, iconv('utf-8', 'tis-620', number_format($sum_total, 2,
                    '.', ',')), 1, 0, "R", true);
                $this->pdf->Ln();
                */
                #Summary Footer
                $title_total = iconv('utf-8', 'tis-620', $this->lang->line('totals'));
                $rs_totalPrice = number_format($total_price,2);
                $rs_totalVat7 = number_format($total_vat7,2);
                $rs_totalVat3 = number_format($total_vat3,2);
                $rs_sumTotal = number_format($sum_total,2);
                $this->pdf->SetWidths(array(
                    30,
                    43,
                    43,
                    43,
                    43
                ));
                $this->pdf->setAligns(array(
                    "L",
                    "R",
                    "R",
                    "R",
                    "R"
                ));
                $this->pdf->mRows(array(
                    "$title_total",
                    "$rs_totalPrice",
                    "$rs_totalVat7",
                    "$rs_totalVat3",
                    "$rs_sumTotal"

                ));



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

                //**** กำหนดขนาด Space ของ Footer
                $height_of_cell = 30; // mm
                $page_height = 210; // mm (portrait letter) A4 210 x 297
                $bottom_margin = 0; // mm


                //Header Report
                $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                $this->pdf->SetFont('THNiramitAS-Bold', '', 16);
                //$this->pdf->Header();
                $this->pdf->SetX(60);
                $this->pdf->Cell(50, 10, $head_report, 'C');
                $this->pdf->Ln();
                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 15);
                //$this->pdf->SetX(3);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                $this->pdf->SetX(-40);
                $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                $this->pdf->Ln();


                /*Title Report*/
                /*
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
                */
                /*Title Report*/
                $this->pdf->SetWidths(array(
                    25,
                    20,
                    20,
                    22,
                    22,
                    22,
                    30,
                    42));
                $this->pdf->SetAligns(array(
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C"));
                $this->pdf->mRows(array(
                    iconv('utf-8', 'tis-620', $this->lang->line('date')),
                    iconv('utf-8', 'tis-620', $this->lang->line('distance_code_report')),
                    iconv('utf-8', 'tis-620', $this->lang->line('cubic_per_order')),
                    iconv('utf-8', 'tis-620', $this->lang->line('order_count')),
                    iconv('utf-8', 'tis-620', $this->lang->line('cubic_sum_report')),
                    iconv('utf-8', 'tis-620', $this->lang->line('price_per_order')),
                    iconv('utf-8', 'tis-620', $this->lang->line('price_amount')),
                    iconv('utf-8', 'tis-620', $this->lang->line('remark')),
                    iconv('utf-8', 'tis-620', "$rs_remark")));


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

                        #$order_date = $this->conv_date->thaiDate2($rs['order_date']);
                        $order_date = date('Y-m-d', strtotime($rs['order_date']));
                        $rs_Date = $this->conv_date->eng2engDate($order_date);

                        /*

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
                        
                        */

                        $rs_distance = $rs['distance_code'];
                        $rs_cubic = $rs['cubic_value'];
                        $rs_countOrder = $rs['count_order'];
                        $rs_sumCubic = number_format($rs['sum_cubic'], 2, '.', ',');
                        $rs_price = number_format($rs['price'], 2, '.', ',');
                        $rs_sum_price = number_format($rs['sum_price'],2);
                        $rs_remark = iconv('utf-8', 'tis-620', $rs['remark']);

                        /*กำหนดค่า Space ด้าน ด้านซ้าย*/
                        $space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page
                        /*information Report*/
                        $this->pdf->SetWidths(array(
                            25,
                            20,
                            20,
                            22,
                            22,
                            22,
                            30,
                            42));
                        $this->pdf->SetAligns(array(
                            "L",
                            "C",
                            "R",
                            "R",
                            "R",
                            "R",
                            "R",
                            "L"));
                        $this->pdf->mRows(array(
                            "$rs_Date",
                            "$rs_distance",
                            "$rs_cubic",
                            "$rs_countOrder",
                            "$rs_sumCubic",
                            "$rs_price",
                            $rs_sum_price,
                            "$rs_remark"));

                    }

                    $this->pdf->SetFillColor(165, 168, 160);
                    $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $this->lang->line('sub_total')),
                        1, 0, "L", true);
                    $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                    $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', $sub_count_order), 1, 0, "R", true);
                    $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', number_format($sub_count_cubic,
                        2, '.', ',')), 1, 0, "R", true);
                    $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "R", true);
                    $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', number_format($sub_count_sumprice,
                        2, '.', ',')), 1, 0, "R", true);
                    $this->pdf->Cell(42, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "L", true);
                    $this->pdf->Ln();

                    $sub_count_order = 0;
                    $sub_count_cubic = 0;
                    $sub_count_sumprice = 0;


                } // End foreach
                /*
                $this->pdf->SetFillColor(145, 168, 140);
                $this->pdf->Cell(25, 5, iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                    1, 0, "L", true);
                $this->pdf->Cell(40, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "C", true);
                $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', $total_cout_order), 1, 0, "R", true);
                $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', number_format($total_count_cubic,
                    2, '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(22, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "R", true);
                $this->pdf->Cell(30, 5, iconv('utf-8', 'tis-620', number_format($total_count_sumprice,
                    2, '.', ',')), 1, 0, "R", true);
                $this->pdf->Cell(42, 5, iconv('utf-8', 'tis-620', ""), 1, 0, "L", true);
                $this->pdf->Ln();
                */
                #Total Footer
                $this->pdf->SetWidths(array(
                    25,
                    40,
                    22,
                    22,
                    22,
                    30,
                    42
                ));
                $this->pdf->SetAligns(array(
                    "L",
                    "C",
                    "R",
                    "R",
                    "R",
                    "R"
                ));
                $this->pdf->mRows(array(
                    iconv('utf-8', 'tis-620', $this->lang->line('totals')),
                    "",
                    number_format($total_cout_order),
                    number_format($total_count_cubic,2),
                    "",
                    number_format($total_count_sumprice,2),
                    ""

                ));

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

            // Create PDf Report
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AliasNbPages();
            $this->pdf->AddPage('L', 'A4');
            $p = $this->pdf->totalpage();
            //**** กำหนดขนาด Space ของ Footer
            $height_of_cell = 30; // mm
            $page_height = 210; // A4 = 210 x 297mm (portrait letter)
            $bottom_margin = 0; // mm

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
            /*
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 15);
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
            */
            /*Title Report*/
            $title_date = iconv('utf-8', 'tis-620', 'วันที่');
            $title_ref = iconv('utf-8', 'tis-620', "เล่มที่/\nเลขที่");
            $title_detail = iconv('utf-8', 'tis-620', 'รายการ');
            $title_recive = iconv('utf-8', 'tis-620',"รับ\n(ลิตร)");
            $title_price_per_lit = iconv('utf-8', 'tis-620',"ราคา/\nลิตร");
            $title_summary = iconv('utf-8', 'tis-620',"รวมเงิน\n(บาท)");
            $title_pay = iconv('utf-8', 'tis-620',"จ่าย\n(ลิตร)");
            $title_total = iconv('utf-8', 'tis-620',"คงเหลือ\n(ลิตร)");
            $title_foot_total = iconv('utf-8', 'tis-620', "รวมทั้งสิ้น");
            #set font size normal 15
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);

            $this->pdf->SetWidths(array(
                22,
                20,
                65,
                20,
                15,
                24,
                20,
                15,
                24,
                27,
                27));

            $this->pdf->SetAligns(array(
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C"));
            $this->pdf->mRows(array(
                "$title_date",
                "$title_ref",
                "$title_detail",
                "$title_recive",
                "$title_price_per_lit",
                "$title_summary",
                "$title_pay",
                "$title_price_per_lit",
                "$title_summary",
                "$title_total",
                "$title_summary"));

            /*Content*/
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);

            $y = 28;
            $i = 0;
            $subtotal_sellOil = 0;
            $subtotal_sellAmount = 0;
            $subtotal_receiveOil = 0;
            $subtotal_receiveAmount = 0;
            $t_sellOil_amount = 0;

            foreach ($result as $row) {
                #$stock_date = date('d-m-Y', strtotime("{$row['stock_date']}"));
                $st_date = date('Y-m-d', strtotime("{$row['stock_date']}"));
                $stock_date = $this->conv_date->eng2engDate($st_date);
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


                /*detail*/

                $ref_no = iconv('utf-8', 'tis-620', "{$row['ref_number']}");
                if ($oilType == "1") {
                    $stock_detail = iconv('utf-8', 'tis-620', "{$row['stock_details']}");
                } else {
                    $stock_detail = iconv('utf-8', 'tis-620', "{$row['stock_details']} {$row['car_number']}");
                }

                $recive_oil = iconv('utf-8', 'tis-620', "{$row['receive_oil']}");
                $recive_price =number_format($row['receive_price'],2, '.', ',');
                $receive_amount =number_format($row['receive_amount'],2, '.', ',');
                $sell_oil = iconv('utf-8', 'tis-620', "{$row['sell_oil']}");
                $sell_price =number_format($row['sell_price'],2,'.', ',');
                $sell_amount =number_format($row['sell_amount'],2,'.', ',');


                /*กำหนดค่า Space ด้าน ด้านซ้าย*/
                $space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page

                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 15);

                $this->pdf->SetWidths(array(
                    22,
                    20,
                    65,
                    20,
                    15,
                    24,
                    20,
                    15,
                    24,
                    27,
                    27));

                $this->pdf->SetAligns(array(
                    "L",
                    "L",
                    "L",
                    "R",
                    "R",
                    "R",
                    "R",
                    "R",
                    "R",
                    "R",
                    "R"));
                $this->pdf->mRows(array(
                    "$stock_date",
                    "$ref_no",
                    "$stock_detail",
                    "$recive_oil",
                    "$recive_price",
                    "$receive_amount",
                    "$sell_oil",
                    "$sell_price",
                    "$sell_amount",
                    "",
                    ""));

                //if ($i == 18) {
                if ($height_of_cell > $space_left) {

                    //Sub Total
                    /*
                    $this->pdf->SetX(10);
                    $this->pdf->Cell(107, 8, iconv('utf-8', 'tis-620', "ผลรวมของหน้านี้"), 1, 'C');
                    $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', number_format($subtotal_receiveOil,2, '.', ',')), 1, 'R');
                    $this->pdf->Cell(15, 8, iconv('utf-8', 'tis-620', "-"), 1, 'R');
                    $this->pdf->Cell(24, 8, iconv('utf-8', 'tis-620', number_format($subtotal_receiveAmount,2, '.', ',')), 1, 'R');
                    $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', number_format($subtotal_sellOil,2, '.', ',')), 1, 'L');
                    $this->pdf->Cell(15, 8, iconv('utf-8', 'tis-620', "-"), 1, 'R');
                    $this->pdf->Cell(24, 8, iconv('utf-8', 'tis-620', number_format($subtotal_sellAmount,2, '.', ',')), 1, 'R');
                    $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', "-"), 1, 'R');
                    $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', "-"), 1, 'R');
                    */
                    #Sub total
                    $this->pdf->SetWidths(array(
                        107,
                        20,
                        15,
                        24,
                        20,
                        15,
                        24,
                        27,
                        27
                    ));
                    $this->pdf->SetAligns(array(
                        "C",
                        "R",
                        "R",
                        "R",
                        "R",
                        "R",
                        "R",
                        "R",
                        "R"
                    ));
                    $this->pdf->mRows(array(
                        iconv('utf-8', 'tis-620', "ผลรวมของหน้านี้"),
                        number_format($subtotal_receiveOil,2),
                        "",
                        number_format($subtotal_receiveAmount,2),
                        number_format($subtotal_sellOil,2),
                        "",
                        number_format($subtotal_sellAmount,2),
                        "",
                        ""

                    ));


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

                    $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->pdf->SetFont('THNiramitAS', '', 15);
                    //$this->pdf->SetXY(5, 20);

                    $this->pdf->SetWidths(array(
                        22,
                        20,
                        65,
                        20,
                        15,
                        24,
                        20,
                        15,
                        24,
                        27,
                        27));

                    $this->pdf->SetAligns(array(
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C"));

                    $this->pdf->mRows(array(
                        "$title_date",
                        "$title_ref",
                        "$title_detail",
                        "$title_recive",
                        "$title_price_per_lit",
                        "$title_summary",
                        "$title_pay",
                        "$title_price_per_lit",
                        "$title_summary",
                        "$title_total",
                        "$title_summary"));

                    $i = 0;
                    $y = 20;


                }

                $t_sellOil_amount = $t_sellOil_amount+ $sell_amount;
                $y = $y + 8;
                $i++;

            } // End for each

            if ('{nb}' == $p) {

                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 15);
                /*
                $this->pdf->SetWidths(array(
                    22,
                    20,
                    65,
                    20,
                    15,
                    24,
                    20,
                    15,
                    24,
                    27,
                    27));

                $this->pdf->SetAligns(array(
                    "L",
                    "L",
                    "L",
                    "L",
                    "R",
                    "R",
                    "L",
                    "R",
                    "R",
                    "L",
                    "R"));
                $this->pdf->mRows(array(
                    "$stock_date",
                    "$ref_no",
                    "$stock_detail",
                    "$recive_oil",
                    "$recive_price",
                    "$receive_amount",
                    "$sell_oil",
                    "$sell_price",
                    "$sell_amount",
                    "",
                    ""));
    */


            }

            /*Sum footer*/

            //$this->pdf->SetXY(10, 170);


            #$this->pdf->Cell(107, 8, iconv('utf-8', 'tis-620', "ยอดยกมา"), 1, 'C');

           # $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
           # $this->pdf->SetFont('THNiramitAS', '', 15);
            /*
            $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(15, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(24, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(20, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(15, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(24, 8, iconv('utf-8', 'tis-620', "-"), 1, 'C');
            $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', number_format($Balance_receiveOil,
                2, '.', ',')), 1, 'C');
            $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', $Balance_Amount), 1, 'C');
            $this->pdf->Ln();
            */
            $title_sub_total = iconv('utf-8', 'tis-620', "ยอดยกมา");
            $footer_sub_Balance_receiveOil = number_format($Balance_receiveOil,2, '.', ',');
            $this->pdf->SetWidths(array(
                107,
                20,
                15,
                24,
                20,
                15,
                24,
                27,
                27));
            $this->pdf->SetAligns(array(
                "L",
                "R",
                "R",
                "R",
                "R",
                "R",
                "R",
                "R",
                "R"));
            $this->pdf->mRows(array(
                "$title_sub_total",
                "-",
                "-",
                "-",
                "-",
                "-",
                "-",
                "$Balance_receiveOil",
                "$Balance_Amount"));

            $this->pdf->SetX(10);
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);
            #$this->pdf->Cell(107, 8, iconv('utf-8', 'tis-620', "รวมทั้งสิ้น"), 1, 'C');
            #$this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            #$this->pdf->SetFont('THNiramitAS', '', 15);


            $t_recive_oil = number_format($total_receiveoil,2);
            $t_rec_amount = number_format($total_receiveamount,2);
            $t_sale_oil = number_format($total_selloil,2);
            $t_sell_amount = number_format($total_sellamount,2);
            $al_total_oil = number_format($all_totalOilAmount,2);

            $this->pdf->SetWidths(array(
                107,
                20,
                15,
                24,
                20,
                15,
                24,
                27,
                27));
            $this->pdf->SetAligns(array(
                "L",
                "R",
                "R",
                "R",
                "R",
                "R",
                "R",
                "R",
                "R"));
            $this->pdf->mRows(array(
                "$title_foot_total",
                "$t_recive_oil",
                "-",
                "$t_rec_amount",
                "$t_sale_oil",
                "-",
                "$t_sell_amount",
                "$al_total_oil",
                ""));

            #Out Report
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

            $title_index = iconv('utf-8', 'tis-620', $this->lang->line('index'));
            $title_date = iconv('utf-8', 'tis-620', $this->lang->line('date'));
            $title_time = iconv('utf-8', 'tis-620', $this->lang->line('time'));
            $title_dp = iconv('utf-8', 'tis-620', $this->lang->line('dp_number'));
            $title_customer = iconv('utf-8', 'tis-620', $this->lang->line('customer'));
            $title_distance = iconv('utf-8', 'tis-620', $this->lang->line('distance_code'));
            $title_cubic = iconv('utf-8', 'tis-620', $this->lang->line('cubic_value'));
            $title_carNumber = iconv('utf-8', 'tis-620', $this->lang->line('car_number'));
            $title_driver = iconv('utf-8', 'tis-620', $this->lang->line('car_driver'));
            $title_oilRecive = iconv('utf-8', 'tis-620', $this->lang->line('oil_recived'));
            $title_note = iconv('utf-8', 'tis-620', $this->lang->line('remark'));


            // Create PDf Report
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->AliasNbPages();
            $p = $this->pdf->totalpage();

            //**** กำหนดขนาด Space ของ Footer
            $height_of_cell = 30; // mm
            $page_height = 210; // mm (portrait letter)
            $bottom_margin = 0; // mm


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
            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);
            //$this->pdf->SetX(3);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
            $this->pdf->SetX(-65);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
            $this->pdf->Ln();
            /*Title Report*/
            $this->pdf->SetWidths(array(
                12,
                22,
                14,
                25,
                76,
                14,
                14,
                18,
                55,
                16,
                24));

            $this->pdf->SetAligns(array(
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C",
                "C"));
            $this->pdf->mRows(array(
                "$title_index",
                "$title_date",
                "$title_time",
                "$title_dp",
                "$title_customer",
                "$title_distance",
                "$title_cubic",
                "$title_carNumber",
                "$title_driver",
                "$title_oilRecive",
                "$title_note"));

            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);

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
                $order_time = date('H:i', strtotime($row['order_date']));
                $sub_usedoil = $sub_usedoil + $row['use_oil'];
                $sub_cubicvalue = $sub_cubicvalue + $row['cubic_value'];
                $total_cubicvalue = $total_cubicvalue + $row['cubic_value'];
                $total_usedoil = $total_usedoil + $row['use_oil'];
                //$d_name = $row['driver_name'];
                $d_name = iconv('utf-8', 'tis-620', "{$row['driver_name']}");
                $driver_name = $this->conv_date->truncateStr($d_name, 18, '...');

                /*Data for show on report*/
                $ir_date = $this->conv_date->eng2engDate($order_date);
                $ir_dp = iconv('utf-8', 'tis-620', "{$row['dp_number']}");
                $ir_customer = iconv('utf-8', 'tis-620', "{$row['customers_name']}");
                $ir_note = iconv('utf-8', 'tis-620', "{$row['remark']}");
                $ir_oil = number_format($row['use_oil'], 2, '.', ',');
                $ir_subOil = number_format($sub_usedoil, 2, '.', ',');
                $ir_totalOil = number_format($total_usedoil, 2, '.', ',');
                $ir_subtotal = iconv('utf-8', 'tis-620', "ผลรวมหน้านี้");
                $ir_subcubicvalue = number_format($sub_cubicvalue, 2, '.', ',');
                $ir_totalcubicValue = number_format($total_cubicvalue, 2, '.', ',');
                $ir_txtTotal = iconv('utf-8', 'tis-620', "รวมทั้งหมด");

                $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                $this->pdf->SetFont('THNiramitAS', '', 15);

                /*กำหนดค่า Space ด้าน ด้านซ้าย*/
                $space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page
                /*Update Code Multi Cell*/
                $this->pdf->SetWidths(array(
                    12,
                    22,
                    14,
                    25,
                    76,
                    14,
                    14,
                    18,
                    55,
                    16,
                    24));

                $this->pdf->SetAligns(array(
                    "C",
                    "L",
                    "L",
                    "L",
                    "L",
                    "C",
                    "R",
                    "C",
                    "L",
                    "R",
                    "L"));
                $this->pdf->mRows(array(
                    "$i",
                    "$ir_date",
                    "$order_time",
                    "$ir_dp",
                    "$ir_customer",
                    "{$row['distance_code']}",
                    "{$row['cubic_value']}",
                    "{$row['car_number']}",
                    "$d_name",
                    "$ir_oil",
                    "$ir_note"));


                //if ($r == 27) {

                if ($height_of_cell > $space_left) {

                    /* Sub Footer*/
                    $this->pdf->SetWidths(array(
                        149,
                        14,
                        14,
                        18,
                        55,
                        16,
                        24));

                    $this->pdf->SetAligns(array(
                        "C",
                        "C",
                        "R",
                        "C",
                        "L",
                        "R",
                        "L"));
                    $this->pdf->mRows(array(
                        "$ir_subtotal",
                        "-",
                        "$ir_subcubicvalue",
                        "-",
                        "-",
                        "$ir_subOil",
                        "-"));

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
                    $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->pdf->SetFont('THNiramitAS', '', 15);
                    //$this->pdf->SetX(3);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
                    $this->pdf->SetX(-65);
                    $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                    $this->pdf->Ln();

                    $this->pdf->SetWidths(array(
                        12,
                        22,
                        14,
                        25,
                        76,
                        14,
                        14,
                        18,
                        55,
                        16,
                        24));

                    $this->pdf->SetAligns(array(
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C",
                        "C"));
                    $this->pdf->mRows(array(
                        "$title_index",
                        "$title_date",
                        "$title_time",
                        "$title_dp",
                        "$title_customer",
                        "$title_distance",
                        "$title_cubic",
                        "$title_carNumber",
                        "$title_driver",
                        "$title_oilRecive",
                        "$title_note"));


                    $r = 0;
                    $sub_cubicvalue = 0;
                    $sub_usedoil = 0;

                } //End if


                $i++;
                $r++;
            } //foreach

            if ('{nb}' == $p) {
                /*
                $this->pdf->Cell(139, 6, iconv('utf-8', 'tis-620', "ผลรวมหน้านี้"), 1, 0, "C");
                $this->pdf->Cell(18, 6, iconv('utf-8', 'tis-620', "$sub_cubicvalue"), 1, 0, "C");
                $this->pdf->Cell(14, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Cell(17, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Cell(16, 6, iconv('utf-8', 'tis-620', "$sub_usedoil"), 1, 0, "C");
                $this->pdf->Cell(56, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
                $this->pdf->Ln();
                */

                $this->pdf->SetWidths(array(
                    149,
                    14,
                    14,
                    18,
                    55,
                    16,
                    24));

                $this->pdf->SetAligns(array(
                    "C",
                    "C",
                    "R",
                    "C",
                    "L",
                    "R",
                    "L"));
                $this->pdf->mRows(array(
                    "$ir_subtotal",
                    "-",
                    "$ir_subcubicvalue",
                    "-",
                    "-",
                    "$ir_subOil",
                    "-"));
            }
            /*Sum footer*/
            /*ยอดยกมา*/
            $this->pdf->SetXY(3, 196);
            #$this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            #$this->pdf->SetFont('THNiramitAS-Bold', '', 14);

            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);
            /*
            $this->pdf->Cell(139, 6, iconv('utf-8', 'tis-620', "รวมทั้งหมด"), 1, 'C');
            $this->pdf->Cell(18, 6, iconv('utf-8', 'tis-620', "$total_cubicvalue"), 1, 0,
            "C");
            $this->pdf->Cell(14, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
            $this->pdf->Cell(17, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
            $this->pdf->Cell(30, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
            $this->pdf->Cell(16, 6, iconv('utf-8', 'tis-620', "$total_usedoil"), 1, 0, "C");
            $this->pdf->Cell(56, 6, iconv('utf-8', 'tis-620', "-"), 1, 0, "C");
            */
            $this->pdf->SetWidths(array(
                149,
                28,
                18,
                71,
                24));

            $this->pdf->SetAligns(array(
                "C",
                "R",
                "C",
                "R",
                "L"));
            $this->pdf->mRows(array(
                iconv('utf-8', 'tis-620', "รวมทั้งหมด"),
                "$ir_totalcubicValue",
                "",
                "$ir_totalOil",
                "",
                ""));


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
            $this->pdf->SetFont('THNiramitAS-Bold', '', 15);
            //$this->pdf->SetX(3);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $left_report), 'C');
            $this->pdf->Ln(6);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $tax_id), 'C');
            $this->pdf->SetX(-53);
            $this->pdf->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
            $this->pdf->Ln();

            /*Title Report*/

            $this->pdf->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);

            #Title
            $title_taxDate = iconv('utf-8', 'tis-620', "วันที่ \n  ");
            $title_ref_number = iconv('utf-8', 'tis-620', "เล่มที่/เลขที่");
            $title_i = iconv('utf-8', 'tis-620', "ลำดับที่\nเอกสาร");
            $title_tax_detail = iconv('utf-8', 'tis-620', "รายการ \n ");
            $title_total_price = iconv('utf-8', 'tis-620', "มูลค่าสินค้า\nหรือบริการ");
            $title_total_vat = iconv('utf-8', 'tis-620', "จำนวนเงิน\nภาษีมูลค่าเพิ่ม");
            $title_total_amount = iconv('utf-8', 'tis-620', "จำนวนเงิน\nรวมทั้งสิ้น");

            /*Update Code Multi Cell*/
            $this->pdf->SetWidths(array(
                22,
                20,
                15,
                63,
                27,
                27,
                27));

            $this->pdf->SetAligns(array(
                "L",
                "L",
                "L",
                "L",
                "R",
                "R",
                "R"));
            $this->pdf->mRows(array(
                "$title_taxDate",
                "$title_ref_number",
                "$title_i",
                "$title_tax_detail",
                "$title_total_price",
                "$title_total_vat",
                "$title_total_amount"));

            #Detail Result
            $result = $this->report->report_taxs($taxsell_month, $taxsell_year, $tax_type, $method);

            $this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->pdf->SetFont('THNiramitAS', '', 15);
            $this->pdf->SetX(5);
            $i = 1;
            $sum_totalprice = 0;
            $sum_totalvat = 0;
            $sum_totalamount = 0;

            foreach ($result as $row) {
                $sum_totalprice = $sum_totalprice + $row['total_price'];
                $sum_totalvat = $sum_totalvat + $row['total_vat'];
                $sum_totalamount = $sum_totalamount + $row['total_amount'];

                #$taxDate = date('d-m-Y', strtotime($row['tax_date']));
                $taxDate = $this->conv_date->eng2engDate(date('Y-m-d', strtotime($row['tax_date'])));
                $ref_number = trim(iconv('utf-8','tis-620',$row['ref_number']));
                $tax_detail = trim(iconv('utf-8','tis-620',$row['tax_details']));
                $total_price = number_format($row['total_price'],2,'.',',');
                $total_vat = number_format($row['total_vat'],2,'.',',');
                $total_amount = number_format($row['total_amount'],2,'.',',');


                #Title
                /*Update Code Multi Cell*/
                $this->pdf->SetWidths(array(
                    22,
                    20,
                    15,
                    63,
                    27,
                    27,
                    27));

                $this->pdf->SetAligns(array(
                    "L",
                    "L",
                    "C",
                    "L",
                    "R",
                    "R",
                    "R"));
                $this->pdf->mRows(array(
                    "$taxDate",
                    "$ref_number",
                    "$i",
                    "$tax_detail",
                    "$total_price",
                    "$total_vat",
                    "$total_amount"));

                $i++;
            } //End foreach


            #total
            $this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
            $this->pdf->SetFont('THNiramitAS-Bold', '', 15);
            $this->pdf->Cell(120, 8, iconv('utf-8', 'tis-620', "รวมทั้งสิ้น"), R, 0, "R");
            $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', number_format($sum_totalprice,
                2, '.', ',')), 1, 0, "R");
            $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', number_format($sum_totalvat, 2,
                '.', ',')), 1, 0, "R");
            $this->pdf->Cell(27, 8, iconv('utf-8', 'tis-620', number_format($sum_totalamount,
                2, '.', ',')), 1, 0, "R");


            $this->pdf->Output();


        } //print_taxsell


    } //print_receive_pay_oil


} // End of Ireport
