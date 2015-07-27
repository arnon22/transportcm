<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
// Create by anon

class Cardetail extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->lang->load('thai');

        $this->load->model('income_model', 'dropdrown');
        $this->load->model('dropdown_model', 'cus_drop');
        $this->load->model('cars_model', 'car');

        $this->load->library('jqgridnow_lib');
    } // end of construct

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('car-detail-view', $output);
    }


    public function index()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {


            $car = $this->car->get_Allcar();


            $g = new jqgrid();

            $carNumber = $this->input->post('carNumber');

            if (!empty($carNumber))
            {

                //print_r($_POST);

                $dateStart = $this->input->post('startDate');
                $dateEnd = $this->input->post('endDate');
                
                /*Old*/
                #$startDate = $this->engDate($dateStart);
                #$endDate = $this->engDate($dateEnd);
                /*New*/
                #$date = $this->str2Datetime($dateStart);
                $startDate = $this->str2Datetime($dateStart);
                $endDate = $this->str2Datetime($dateEnd);


                $mktime = $date;
                
            
                $totalReceive = $this->car->total_recive($carNumber, $startDate, $endDate);
                $totalExpense = $this->car->total_expense($carNumber, $startDate, $endDate);
                $totalOil_Expense = $this->car->expense_oil($carNumber, $startDate, $endDate);

                //
                $Count_Order = $this->car->total_NumRecive($carNumber, $startDate, $endDate);

                $order_all = $this->car->carDetail_Orders($carNumber, $startDate, $endDate);

                $SellOil_List = $this->car->Cardetail_oilsellList($carNumber, $startDate, $endDate);

                $expensecar_list = $this->car->expense_car($carNumber, $startDate, $endDate);

                $sumTotalExpense = $totalExpense + $totalOil_Expense;

                //Summary
                $totalSummary[] = $this->car->SummaryOrders($carNumber, $startDate, $endDate);
                $totalDistance = 0;
                $totalCubic = 0;
                $totalUseoil = 0;

                $car_number = $this->car->getCar_number($carNumber);
                foreach ($totalSummary as $rows)
                {
                    $totalDistance = $rows['total_distance'];
                    $totalCubic = $rows['total_cubic'];
                    $totalUseoil = $rows['total_useoil'];
                    //$car_number = $rows['car_number'];

                }

                if ($totalDistance != "" and $totalCubic != "" and $Count_Order != "")
                {
                    $aver_oil_distance = ($totalUseoil / $totalDistance);
                    $aver_oil_cubic = ($totalUseoil / $totalCubic);
                    $aver_oil_countOrder = ($totalUseoil / $Count_Order);
                    $aver_cubic_countOrder = ($totalCubic / $Count_Order);
                } else
                {
                    $aver_oil_distance = 0;
                    $aver_oil_cubic = 0;
                    $aver_oil_countOrder = 0;
                    $aver_cubic_countOrder = 0;
                    $totalDistance = 0;
                    $totalCubic = 0;
                    $totalUseoil = 0;
                }


            } //End if

            if ($carNumber == "" || $startDate == "" || $endDate == "")
            {
                $carNumber = 0;
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d');
            }

            $carDetails[] = array(
                "Car_number" => $car_number,
                "startDate" => $dateStart,
                "endDate" => $dateEnd,
                "ReciveAmount" => $totalReceive,
                "expenseAmount" => $totalExpense,
                "sumTotalExpense" => $sumTotalExpense,
                "OiltotalAmount" => $totalOil_Expense,
                "Count_Order" => $Count_Order,
                "totalDistance" => $totalDistance,
                "totalCubic" => $totalCubic,
                "totalUseoil" => $totalUseoil,
                "aver_oil_distance" => $aver_oil_distance,
                "aver_oil_cubic" => $aver_oil_cubic,
                "aver_oil_countOrder" => $aver_oil_countOrder,
                "aver_cubic_countOrder" => $aver_cubic_countOrder);


            $g->table = $carDetails;


            $opts['autowidth'] = true;
            $opts['caption'] = "รายงาน";
            $opts['height'] = "100";
            #$opts['width'] = "990";
            // $grid["sortname"] = 'client_id'; // by default sort grid by this field
            $opts["sortorder"] = "desc"; // ASC or DESC
            $opts["caption"] = $this->lang->line('summary_per_car'); // caption of grid
            $opts["autowidth"] = true; // expand grid to screen width
            $opts["multiselect"] = false; // allow you to multi-select through checkboxes
            $opts["rowNum"] = 100; // allow you to multi-select through checkboxes
            $opts["rowList"] = array(
                100,
                200,
                500);


            $g->set_options($opts);


            //*End odf*/

            $col = array();
            $col["title"] = $this->lang->line('car_number');
            $col["name"] = "Car_number";
            $col["width"] = "40";
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('start_date');
            $col["name"] = "startDate";
            $col["width"] = "40";
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('end_date');
            $col["name"] = "endDate";
            $col["width"] = "40";
            $cols[] = $col;


            $col = array();
            $col["title"] = $this->lang->line('ReciveAmount');
            $col["name"] = "ReciveAmount";
            $col["width"] = "40";
            $col['align'] = "right";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('expenseAmount');
            $col["name"] = "expenseAmount";
            $col["width"] = "40";
            $col['align'] = "right";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('OiltotalAmount');
            $col["name"] = "OiltotalAmount";
            $col["width"] = "40";
            $col['align'] = "right";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('sumTotalExpense');
            $col["name"] = "sumTotalExpense";
            $col["width"] = "50";
            $col['align'] = "right";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('Count_Order');
            $col["name"] = "Count_Order";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('totalDistance');
            $col["name"] = "totalDistance";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('totalCubic');
            $col["name"] = "totalCubic";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('totalUseoil');
            $col["name"] = "totalUseoil";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('aver_oil_distance');
            $col["name"] = "aver_oil_distance";
            $col["width"] = "40";
            $col["formatter"] = "number";
            $col['align'] = "center";
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('aver_oil_cubic');
            $col["name"] = "aver_oil_cubic";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('aver_oil_countOrder');
            $col["name"] = "aver_oil_countOrder";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";

            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('aver_cubic_countOrder');
            $col["name"] = "aver_cubic_countOrder";
            $col["width"] = "40";
            $col['align'] = "center";
            $col["formatter"] = "number";

            $cols[] = $col;

            $g->set_columns($cols);

            //Group
            $g->set_group_header(array("useColSpanStyle" => true, "groupHeaders" => array(array
                        (
                        "startColumnName" => 'expenseAmount', // group starts from this column
                        "numberOfColumns" => 3, // group span to next 2 columns
                        "titleText" => 'รายจ่าย' // caption of group header
                            ), array(
                        "startColumnName" => 'Count_Order', // group starts from this column
                        "numberOfColumns" => 8, // group span to next 2 columns
                        "titleText" => $this->lang->line('Other_Average') // caption of group header
                            ))));


            $g->set_actions(array(
                "add" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'add'), // allow/disallow add
                "edit" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'edit'), // allow/disallow edit
                "delete" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'delete'), // allow/disallow delete
                "rowactions" => true,
                "export" => false,
                "autofilter" => false, // show/hide autofilter for search
                "search" => false));

            $out_master = $g->render("list1");


            if (isset($order_all))
            {
                $g2 = new jqgrid();

                //Column Option
                #date
                $col2 = array();
                $col2['title'] = $this->lang->line("date");
                $col2['name'] = "Order_date";
                $col2['width'] = "120";
                $cols2[] = $col2;

                #dpNumber
                $col2 = array();
                $col2['title'] = $this->lang->line("dp_number");
                $col2['name'] = "Dpnumber";
                $col2['width'] = "80";
                $col2['align'] = "left";
                $cols2[] = $col2;

                #FactoryCode
                $col2 = array();
                $col2['title'] = $this->lang->line("factory_code");
                $col2['name'] = "FactoryCode";
                $col2['width'] = "80";
                $col2['align'] = "center";
                $cols2[] = $col2;

                #DistanceCode
                $col2 = array();
                $col2['title'] = $this->lang->line("distance_code");
                $col2['name'] = "DistanceCode";
                $col2['width'] = "80";
                $col2['align'] = "center";
                $cols2[] = $col2;

                #RealDistance
                $col2 = array();
                $col2['title'] = $this->lang->line('real_distance');
                $col2['name'] = "RealDistance";
                $col2['width'] = "80";
                $col2['align'] = "center";
                $cols2[] = $col2;

                #cubic_code
                $col2 = array();
                $col2['title'] = $this->lang->line('cubic_code');
                $col2['name'] = "cubic_value";
                $col2['width'] = "80";
                $col2['align'] = "center";
                $cols2[] = $col2;

                #car_number
                $col2 = array();
                $col2['title'] = $this->lang->line('car_number');
                $col2['name'] = "car_number";
                $col2['width'] = "80";
                $col2['align'] = "center";
                $cols2[] = $col2;

                #driver_name
                $col2 = array();
                $col2['title'] = $this->lang->line('driver');
                $col2['name'] = "driver_name";
                $col2['width'] = "120";
                $cols2[] = $col2;

                #Select Table
                $g2->table = $order_all;


                $g2->set_columns($cols2);

                //$opt['width'] ="770";
                $opt['rowNum'] = 10;
                $opt['height'] = "300";
                $opt['rowList'] = array(
                    10,
                    20,
                    30);

                $g2->set_options($opt);


                $out_order = $g2->render("list2");
            }

            //Oil Detail
            if (isset($SellOil_List))
            {
                $g3 = new jqgrid();

                #set Column
                $col3 = array();
                $col3['title'] = $this->lang->line('date');
                $col3['name'] = "Date";
                $cols3[] = $col3;

                #Factory_code
                $col3 = array();
                $col3['title'] = $this->lang->line('factory_code');
                $col3['name'] = "Factory_code";
                $cols3[] = $col3;

                #Factory_code
                $col3 = array();
                $col3['title'] = $this->lang->line('factory_name');
                $col3['name'] = "factory_name";
                $cols3[] = $col3;

                #Ref_Number
                $col3 = array();
                $col3['title'] = $this->lang->line('reference_number');
                $col3['name'] = "ref_number";
                $cols3[] = $col3;

                #Details
                $col3 = array();
                $col3['title'] = $this->lang->line('stock_details');
                $col3['name'] = "Details";
                $cols3[] = $col3;

                #Oil Value
                $col3 = array();
                $col3['title'] = $this->lang->line('sell_oil');
                $col3['name'] = "SellOil";
                $col3['align'] = "center";
                $col3['formatter'] = "number";
                $col3["formatoptions"] = array(
                    "prefix" => "",
                    "suffix" => '',
                    "thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => '2');
                $cols3[] = $col3;

                #oil_price
                $col3 = array();
                $col3['title'] = $this->lang->line('list_per_price');
                $col3['name'] = 'Sell_price';
                $col3['align'] = "right";
                $col3['formatter'] = "currency";
                $col3["formatoptions"] = array(
                    "prefix" => "",
                    "suffix" => '',
                    "thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => '2');
                $cols3[] = $col3;

                #total_mount
                $col3 = array();
                $col3['title'] = $this->lang->line('total_amount');
                $col3['name'] = 'TotalAmount';
                $col3['align'] = "right";
                $col3['formatter'] = "currency";
                $col3["formatoptions"] = array(
                    "prefix" => "",
                    "suffix" => '',
                    "thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => '2');
                $cols3[] = $col3;


                #Carnumber
                $col3 = array();
                $col3['title'] = $this->lang->line('car_number');
                $col3['name'] = "Carnumber";
                #$cols3[] = $col3;


                #select table
                $g3->table = $SellOil_List;
                #set column

                $g3->set_columns($cols3);

                /*Option*/
                $opt3["caption"] = $this->lang->line('sell_oil_list');
                #$opt3["sortname"] = 'stock_id';
                # $opt3["sortorder"] = "desc";
                $opt3["height"] = "250";
                $opt3["width"] = "920";
                $opt3['rowNum'] = 10;
                $opt3['rowList'] = array(
                    10,
                    20,
                    30);
                //$opt3["width"] = "600";
                #$opt3["autowidth"] = true;

                $g3->set_options($opt3);

                $out_oilList = $g3->render("list3");
            }

            // Other Expense for car
            if (isset($expensecar_list))
            {
                $g4 = new jqgrid();

                $col4 = array();
                $col4['title'] = $this->lang->line('date');
                $col4['name'] = "Date";
                $cols4[] = $col4;


                $col4 = array();
                $col4['title'] = $this->lang->line('factory_code');
                $col4['name'] = "FactoryCode";
                $cols4[] = $col4;

                $col4 = array();
                $col4['title'] = $this->lang->line('reference_number');
                $col4['name'] = "Ref.Number";
                $cols4[] = $col4;

                $col4 = array();
                $col4['title'] = $this->lang->line('Details');
                $col4['name'] = "Details";
                $cols4[] = $col4;

                $col4 = array();
                $col4['title'] = $this->lang->line('total_amount');
                $col4['name'] = "TotalAmount";
                $cols4[] = $col4;

                $col4 = array();
                $col4['title'] = $this->lang->line('remark');
                $col4['name'] = "Remark";
                $cols4[] = $col4;


                $g4->table = $expensecar_list;

                $g4->set_columns($cols4);

                $opt4['height'] = "250";
                $opt4["width"] = "920";
                $opt4['rowNum'] = 10;
                $opt4['rowList'] = array(
                    10,
                    20,
                    30);
                $g4->set_options($opt4);

                $out_expensecarList = $g4->render("list4");

            } // end if


            //Display
            $this->_example_output((object)array(
                'output' => '',
                'car' => $car,
                'mktime' => $mktime,
                'out_master' => $out_master,
                'car_detail' => $carDetails,
                'out_oilList' => $out_oilList,
                'out_expensecarList' => $out_expensecarList,
                'totalSummary' => $totalSummary,
                "out_order" => $out_order));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    } // end of dunction index


    public function thaiDate($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2] - 543;

        $dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;

        return $dateThai;

    } //thaiDate

    public function thaiDate2($date)
    {

        $dt = explode('-', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $year = $dt[0];
        $mouht = $dt[1];
        $date = $dt[2];

        $dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;

        return $dateThai;

    } //thaiDate2

    public function strToDateTime($date, $format)
    {
        if (!($date = strToDate($date, $format)))
            return;
        $dateTime = array(
            'sec' => 0,
            'min' => 0,
            'hour' => 0,
            'day' => 0,
            'mon' => 0,
            'year' => 0,
            'timestamp' => 0);
        foreach ($date as $key => $val)
        {
            switch ($key)
            {
                case 'd':
                case 'j':
                    $dateTime['day'] = intval($val);
                    break;
                case 'D':
                    $dateTime['day'] = intval(date('j', $val));
                    break;

                case 'm':
                case 'n':
                    $dateTime['mon'] = intval($val);
                    break;
                case 'M':
                    $dateTime['mon'] = intval(date('n', $val));
                    break;

                case 'Y':
                    $dateTime['year'] = intval($val);
                    break;
                case 'y':
                    $dateTime['year'] = intval($val) + 2000;
                    break;

                case 'G':
                case 'g':
                case 'H':
                case 'h':
                    $dateTime['hour'] = intval($val);
                    break;

                case 'i':
                    $dateTime['min'] = intval($val);
                    break;

                case 's':
                    $dateTime['sec'] = intval($val);
                    break;
            }
        }
        $dateTime['timestamp'] = mktime($dateTime['hour'], $dateTime['min'], $dateTime['sec'],
            $dateTime['mon'], $dateTime['day'], $dateTime['year']);
        return $dateTime;
    }

    public function engDate($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2];

        $dateEng = $year . "-" . $mouht . "-" . $date;

        return $dateEng;

    } //engDate

    public function str2Datetime($datetime)
    {
        
        $d1 = str_replace(" ","/",$datetime);
        $d2 = str_replace(":","/",$d1);
        
        
        $dt = explode('/', $d2);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2];
        $h = $dt[3];
        $m = $dt[4];

        $dateEng = $year . "-" . $mouht . "-" . $date." ".$h.":".$m;

        return $dateEng;

    } //engDate

    public function engDate2($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2] - 543;

        $dateEng = $year . "-" . $mouht . "-" . $date;

        return $dateEng;

    } //engDate


} // End of Class
