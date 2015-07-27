<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Pricelist2 extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->lang->load('thai');
        $this->load->model('pricelist_model', 'pricelist');
        $this->load->model('price_model', 'price');

        //jqgrid
        $this->load->library('jqgridnow_lib');


    }

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('pricelist', $output);
    }


    public function index()
    {
        if ($this->session->userdata('user_name'))
        {
            $g = new jqgrid();


            $g->select_command =
                "SELECT id,fac.factory_code as factory_id ,dis.distance_code as distance_id,cubic.cubic_value as cubic_id,pr.price, start_date,end_date FROM pricelist as pr 
LEFT JOIN transport_factory as fac ON(pr.factory_id=fac.factory_id)
LEFT JOIN transport_cubiccode as cubic ON(pr.cubic_id = cubic.cubic_id)
LEFT JOIN distancecode as dis ON(pr.distance_id=dis.distance_id)";

            $g->table = "pricelist";

            $col = array();
            $col["title"] = "id";
            $col["name"] = "id";
            //$col["dbname"] = "pr.pricelist_id";
            $col["width"] = "10";
            $col["hidden"] = true;
            $col["editable"] = false;
            $cols[] = $col;


            $col = array();
            $col["title"] = $this->lang->line('factory_code'); // caption of column
            $col["name"] = "factory_id";
            $col["dbname"] = "pr.factory_id";
            $col["width"] = "10";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["editrules"] = array("required" => true);
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            $str = $g->get_dropdown_values("SELECT DISTINCT factory_id AS k,factory_code AS v FROM transport_factory");
            $col["editoptions"] = array("value" => ":;" . $str);

            // multi-select in search filter
            $col["stype"] = "select-multiple";
            $col["searchoptions"]["value"] = $str;
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('distance_code'); // caption of column
            $col["name"] = "distance_id";
            $col["dbname"] = "pr.distance_id";
            $col["width"] = "10";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["editrules"] = array("required" => true);
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            $str = $g->get_dropdown_values("SELECT DISTINCT distance_id AS k,distance_code AS v FROM distancecode WHERE distance_status=1");
            $col["editoptions"] = array("value" => ":;" . $str);

            // multi-select in search filter
            $col["stype"] = "select-multiple";
            $col["searchoptions"]["value"] = $str;
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('cubic_value'); // caption of column
            $col["name"] = "cubic_id";
            $col["dbname"] = "pr.cubic_id";
            $col["width"] = "10";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["editrules"] = array("required" => true);
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            $str = $g->get_dropdown_values("SELECT DISTINCT cubic_id AS k,cubic_value AS v FROM transport_cubiccode WHERE cubic_status=1");
            $col["editoptions"] = array("value" => ":;" . $str);

            // multi-select in search filter
            $col["stype"] = "select-multiple";
            $col["searchoptions"]["value"] = $str;
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('price'); // caption of column
            $col["name"] = "price";
            $col["editable"] = true;
            $col["width"] = "10";
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('start_date'); // caption of column
            $col["name"] = "start_date";
            $col["formatter"] = "date"; // format as date
            $col["formatoptions"] = array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'); // http://docs.jquery.com/UI/Datepicker/formatDate
            $col["width"] = "10";
            $col["editrules"] = array("required" => true);
            $col["editable"] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('end_date'); // caption of column
            $col["name"] = "end_date";
            $col["formatter"] = "date"; // format as date
            $col["formatoptions"] = array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'); // http://docs.jquery.com/UI/Datepicker/formatDate
            $col["width"] = "10";
            $col["editrules"] = array("required" => true);
            $col["editable"] = true;
            $cols[] = $col;


            $g->set_columns($cols);


            $g->set_actions(array(
                "add" => true, // allow/disallow add
                "edit" => true, // allow/disallow edit
                "delete" => true, // allow/disallow delete
                "clone" => true, // allow/disallow clone
                "rowactions" => true, // show/hide row wise edit/del/save option
                "search" => "advance", // show single/multi field search condition (e.g. simple or advance)
                "showhidecolumns" => false));

            // $grid["url"] = ""; // your paramterized URL -- defaults to REQUEST_URI
            $grid["rowNum"] = 50; // by default 20
            $grid["sortname"] = 'id'; // by default sort grid by this field
            $grid["sortorder"] = "desc"; // ASC or DESC
            $grid["caption"] = $this->lang->line('pricelist'); // caption of grid
            $grid["autowidth"] = true; // expand grid to screen width
            $grid["multiselect"] = true; // allow you to multi-select through checkboxes
            $grid["form"]["position"] = "center";
            $grid["altRows"] = true;
            $grid["altclass"] = "myAltRowClass";
            
            $grid["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420');
            $grid["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420'); 
            
            
            $g->set_options($grid);
                
              
               $e["on_update"] = array(
                "update_price",
                null,
                true);
              
                $e["on_insert"] = array(
                "add_price",
                null,
                true);
                
            $g->set_events($e); 
            
            function add_price(&$data)
            {
                $factory_id = $data["params"]["factory_id"];
                $distance_id = $data["params"]["distance_id"];
                $cubic_id = $data["params"]["cubic_id"];
                $start_date = $data["params"]["start_date"];
                $end_date = $data["params"]["end_date"];
                $check_sql = "SELECT COUNT(*) AS c
FROM
	pricelist
WHERE
	factory_id = '$factory_id'
AND distance_id = '$distance_id'
AND cubic_id = '$cubic_id'
AND ( (start_date='0000-00-00' || start_date <= DATE_FORMAT('$start_date','%Y-%m-%d')) 
AND (end_date='0000-00-00' || end_date >= DATE_FORMAT('$start_date','%Y-%m-%d'))) 
AND ( (start_date='0000-00-00' || start_date <= DATE_FORMAT('$end_date ','%Y-%m-%d')) 
AND (end_date='0000-00-00' || end_date >= DATE_FORMAT('$end_date','%Y-%m-%d')))";

                $rs = mysql_fetch_assoc(mysql_query($check_sql));

                if ($rs["c"] > 0)
                {
                    phpgrid_error("ข้อมูลราคาซ้ำ ไม่สามารถบันทึกได้");
                }
                
                


            } // end of sub function
            
            function update_price(&$data)
            {
                
                
                //print_r($data);
                
                $obj = &get_instance();
                $obj->load->model("price_model", "price");
               $obj->load->library('conv_date');
                
                $price_id = $data["params"]["id"];
                
                //$startdate = date('Y-m-d',strtotime($data['params']['start_date']));
                $startdate = $data['params']['start_date'];
                $enddate = $data['params']['start_date'];
                
                               
                 $c_stdate = $obj->price->check_before_update_price($price_id);
                 //$c_endate = $obj->price->check_before_update_price($price_id,$en);
                 $st_date =  $c_stdate['start_date'];
                 $en_date =  $c_stdate['end_date'];
                 //$ed_date = $c_endate;
                 
                $m_date = $obj->conv_date->compareDate($startdate,$st_date);                
                $e_date = $obj->conv_date->compareDate($enddate,$st_date);
              
                  //$m_date ="E";
                 if($m_date!=="E" && $e_date!=="E"){
                    $check_sql = "SELECT COUNT(*) as c

FROM
	pricelist
WHERE
	factory_id = '{$data["params"]["factory_id"]}'
AND cubic_id = '{$data["params"]["cubic_id"]}'
AND distance_id = '{$data["params"]["distance_id"]}'
AND ( (start_date='0000-00-00' || start_date <= DATE_FORMAT('{$data["params"]["start_date"]}','%Y-%m-%d')) 
AND (end_date='0000-00-00' || end_date >= DATE_FORMAT('{$data["params"]["start_date"]}','%Y-%m-%d'))) 
OR
( (start_date='0000-00-00' || start_date <= DATE_FORMAT('{$data["params"]["end_date"]}','%Y-%m-%d')) 
AND (end_date='0000-00-00' || end_date >= DATE_FORMAT('{$data["params"]["end_date"]}','%Y-%m-%d'))) LIMIT 1";

                $rs = mysql_fetch_assoc(mysql_query($check_sql));

                if ($rs["c"] > 0)
                {
                    phpgrid_error("ข้อมูลราคาซ้ำ ไม่สามารถบันทึกได้");
                }
                 }
                 
               
            } // End of  function update_price


            //Display
             $pricetable = $g->render("list1");
             $h2_title = "Price Setting";
             
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out,
                'dispyPrice' => $dispyPrice,
                'h2_title'=>$h2_title,             
                'list_row' => $num_row,
                'pricelist' => $pricelist,
                'pricetable' => $pricetable));

        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    } //End of Index()


} // End of class
