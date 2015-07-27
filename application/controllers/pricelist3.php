<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Pricelist3 extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->lang->load('thai');
        $this->load->model('pricelist_model', 'pricelist');
        $this->load->model('price_model', 'price');
        $this->load->library('conv_date');
        $this->load->model('factory_model', 'factory');

        //jqgrid
        $this->load->library('jqgridnow_lib');


    }

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('pricelist3', $output);
    }


    public function index()
    {
        if ($this->session->userdata('user_name'))
        {
            $this->load->model('factory_model', 'factory');

            $factory = $this->factory->getFactory();

            if (isset($_REQUEST['submit']))
            {


                //$startDate = '2014-10-01';
                // $endDate = '2014-10-31';

                $factory_id = $this->input->get_post('factory');
                $startDate = $this->input->post('startDate');
                $endDate = $this->input->post('endDate');
                $factory_name = $this->factory->getNamefactory($factory_id);
                
                
                /*0000-00-00*/
                $start_date = $this->conv_date->thai2engDate($startDate);
                $end_date = $this->conv_date->thai2engDate($endDate);


                $dispyPrice = $this->price->dispalyPrice($factory_id, $start_date, $end_date);
                $dispyPrice2 = $this->price->dispalyPrice($factory_id, $start_date, $end_date);
                

                $dataFilter = array(
                    'pricelist_factory' => $factory_id,
                    'select_startDate' => $startDate,
                    'select_endDate' => $endDate,
                    'selected_start_date' => $start_date,
                    'selected_end_date' => $end_date);

                $this->session->set_userdata($dataFilter);
                
                
                
                $_SESSION['factory'] = $factory_id;
                $_SESSION['startDate'] = $start_date;
                $_SESSION['endDate'] = $end_date;
                

                


            } // End if

            if ($this->session->userdata('pricelist_factory'))
            {
                $selected_factory_id = $this->session->userdata('pricelist_factory');
                $selected_startDate = $this->session->userdata('select_startDate');
                $selected_endDate = $this->session->userdata('select_endDate');
                
                
            }


            $head_title = "ตารางราคาเดินรถ $factory_name ระหว่าง $startDate ถึง $endDate";

            //Display Pricelist Detail

            $g = new jqgrid();


            //$dispyPrice = $this->price->dispalyPrice($factory_id,$startDate,$endDate);
            $titke_cubic = $this->price->header_cubic();
            $row_distance = $this->price->row_distance();
            $title_distance = $this->price->row_distanceName();

            //$i = 0;

            foreach ($row_distance as $key => $val)
            {
                
                $i = $val['distance_id'];
                foreach ($titke_cubic as $row)
                {

                    $data[$i]["id"] = $i;
                    $data[$i]["distacne"] = $title_distance[$i]; //$dispyPrice[$i]['distance'];
                    $data[$i]["cubic[$row->cubic_id]"] = $dispyPrice[$i][$row->cubic_id];
                    $data[$i]["factory_id"] = $selected_factory_id;
                    $data[$i]['start_date'] = $selected_startDate;
                    $data[$i]['end_date'] = $selected_endDate;


                }


               // $i = $val['distance_id'];

            }


            $g->table = $data;
            //$g->table = "pricelist";
            // ห$g->table = $pricelist;


            $col = array();
            $col["title"] = "id"; // caption of column
            $col["name"] = "id";
            $col["width"] = "60";
            $col["sorttype"] = int;
            $col['editable'] = true;
            $col['hidden'] = true;
            $cols[] = $col;


            $col = array();
            $col["title"] = $this->lang->line('cubic_and_distance'); // caption of column
            $col["name"] = "distacne";
            $col["width"] = "350";
            $col['editable'] = false;
          
            $cols[] = $col;

            $col = array();
            $col["title"] = "factory_id"; // caption of column
            $col["name"] = "factory_id";
            $col["width"] = "350";
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $col['hidden'] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "start_date"; // caption of column
            $col["name"] = "start_date";
            $col["width"] = "350";
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $col['hidden'] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "end_date"; // caption of column
            $col["name"] = "end_date";
            $col['editable'] = true;
             $col["editrules"] = array("required" => true);
            $col['hidden'] = true;
            $col["width"] = "350";
            $cols[] = $col;


            foreach ($titke_cubic as $row)
            {
                $col = array();
                $col['title'] = "$row->cubic_value";
                $col['name'] = "cubic[$row->cubic_id]";
                $col['editable'] = true;
                $col["editrules"] = array("number" => true);
                $col["formatter"] = "number";
                $col["formatoptions"] = array(
                    "thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => '2');
                $col['search'] = false;

                $cols[] = $col;
            }


            $g->set_columns($cols);


            $g->set_actions(array(
                "add" => false, // allow/disallow add
                "edit" => true, // allow/disallow edit
                "bulkedit" => false, // allow/disallow edit
                "delete" => true, // allow/disallow delete
                "rowactions" => false,
                "autofilter" => true,
                "search" => "simple"));
            $opt['caption'] = "$head_title";
            $opt["sortname"] = 'id'; // by default sort grid by this field
            $opt["sortorder"] = "asc"; // ASC or DESC
            $opt['rowNum'] = 30;

            $opt["autowidth"] = true;
            $opt["cellEdit"] = true;

            // excel visual params
            $opt["cellEdit"] = true; // inline cell editing, like spreadsheet
            $opt["rownumbers"] = true;
            $opt["rownumWidth"] = 30;

            $g->set_options($opt);


            //$e["on_insert"] = array("add_client", null, true);
            $e["on_update"] = array(
                "update_prices",
                null,
                true);
            //$e["on_delete"] = array("delete_client", null, true);
            //$e["on_after_insert"] = array("after_insert", null, true); // return last inserted id for further working
            //$e["on_data_display"] = array("filter_display", null, true);
            $g->set_events($e);

            function update_prices(&$data)
            {
                global $_SESSION;

                /*
                These comments are just to show the input param format

                $data => Array
                (
                [client_id] => 2
                [params] => Array
                (
                [client_id] => 2
                [name] => Client 2
                [gender] => male
                [company] => Client 2 Company
                )

                )
                */
                /*
                Array
                (
                [id] => 1
                [params] => Array
                (
                [cubic] => Array
                (
                [3] => 50
                )

                [id] => 1
                )

                )
                */
                // ob_start();
                $str = ob_get_clean();
                
                $obj = &get_instance();
                
                $obj->load->model("price_model", "price");
                
               $data['params']['factory_id'] =  $_SESSION['factory'];
               $data['params']['start_date'] = $_SESSION['startDate'];
               $data['params']['end_date'] =  $_SESSION['endDate'];
                
                
                $price_id = $data['params']['id'];
                $price_data = $data['params']['cubic'];
                
                foreach($price_data as $k=>$v){
                    
                    $data['params']['cubic_id'] = $k;
                    $data['params']['price'] = $v;
                }
                
                $factory_id = $data['params']['factory_id'];
                $distance_id = $data['params']['id'];
                $cubic_id = $data['params']['cubic_id'];
                $price = $data['params']['price'];
                $start_date = $data['params']['start_date'];
                $end_date = $data['params']['end_date'];
                
               //$m = $obj->price->recursive($mm,$factory_id,$start_date,$end_date);
               
               $mm = $obj->price->check_price_id($factory_id,$distance_id,$cubic_id,$start_date,$end_date);
                
                
                if($mm==0){
                     $str = ob_get_clean();
                     $str ="INSERT INTO `pricelist` (
	`factory_id`,
	`cubic_id`,
	`distance_id`,
	`price`,
	`start_date`,
	`end_date`
)
VALUES
	(
		'$factory_id',
		'$cubic_id',
		'$distance_id',
		'$price',
		'$start_date',
		'$end_date'
	)";
                    
                }else{
                     $str = ob_get_clean();
                     $str = "UPDATE `pricelist` SET `price`='$price' WHERE (`id`='$mm')";
                }
                              
                              
               //$str = $obj->price->recursive_price($factory_id,$distance_id,$cubic_id,$price,$start_date,$end_date);
               
            mysql_query($str);
                
            print_r($data);


            } // End of function


            //Display
            $pricetable = $g->render("list1");
            $pricelist2 = $this->price->displayPrice2();
            
            
            
            


            $this->_example_output((object)array(
                'output' => '',
                'out' => $out,
                'dispyPrice' => $dispyPrice,
                'dispyPrice2' => $dispyPrice2,
                'list_row' => $num_row,
                'factory' => $factory,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'pricelist2' => $pricelist2,
                'pricetable' => $pricetable));

        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    } //End of Index()


} // End of class
