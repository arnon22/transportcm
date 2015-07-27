<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
// Create by anon

class Customeroil2 extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->lang->load('thai');
        $this->load->model('income_model', 'dropdrown');
        $this->load->model('dropdown_model', 'cus_drop');

        $this->load->library('jqgridnow_lib');


    } // end of construct

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('oil/customer-oil', $output);
    }


    public function index()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            $i_rule = $this->session->userdata('user_cizacl_role_id');

            $g = new jqgrid();
            #ID
            $col = array();
            $col['title'] = "ID";
            $col['name'] = "customer_id";
            $col['hidden'] = true;
            $col['isnull'] = true;
            $cols[] = $col;

            #Factory
            $col = array();
            $col["title"] = $this->lang->line("factory_name");
            $col["name"] = "factory_id";
            $col["dbname"] = "fac.factory_id"; // this is required as we need to search in name field, not id
            $col["width"] = "100";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            $str = $g->get_dropdown_values("select distinct factory_id as k, factory_name as v from transport_factory  where factory_status =1");

            $col["editoptions"] = array("value" => ":;" . $str);
            $col["formatter"] = "select"; // display label, not value
            $col["editrules"] = array("required" => true);

            $col["editoptions"] = array("value" => $str);


            $col["formatter"] = "select"; // display label, not value
            $col["stype"] = "select"; // enable dropdown search
            $col["searchoptions"] = array("value" => ":;" . $str);

            $cols[] = $col;

            #Customer_Type
            $col = array();
            $col["title"] = $this->lang->line('customer_type');
            $col["name"] = "customer_type_id";
            $col["dbname"] = "cus_type.customer_type_title"; // this is required as we need to search in name field, not id
            $col["fixed"] = true;
            //$col["width"] = "65";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            //$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
            $str = $g->get_dropdown_values("SELECT DISTINCT customer_type_id AS k, customer_type_title AS v FROM `transport_customer_type` WHERE customer_type_status ='2'");
            #$str = $this->dropdrown->get_customer_type();
            $col["editoptions"] = array("value" => $str);
            $col["formatter"] = "select"; // display label, not value
            $cols[] = $col;

            #Customer name
            $col = array();
            $col['title'] = $this->lang->line('customer_agancy');
            $col['name'] = "customer_name";
            $col["editrules"] = array("required" => true);
            $col["search"] = true;
            $col['editable'] = true;
            $cols[] = $col;

            #remark
            $col = array();
            $col['title'] = $this->lang->line('note');
            $col['name'] = "remark";
            $col['editable'] = true;
            $col['edittype'] = "textarea";
            $col["viewable"] = false;

            $col['editoptions'] = array("rows" => "2", "cols" => "20");
            $cols[] = $col;


            // $cols[] = $col;

            $e["on_insert"] = array(
                "add_client",
                null,
                true);
            $e["on_delete"] = array(
                "delete_client",
                null,
                true);

            #$e["on_delete"] = array("del_client", null, true);

            $g->set_events($e);

            $g->select_command = "SELECT
	customer_id,
	customer_name,
	o_c.factory_id,
	o_c.customer_type_id,
	customer_type_title,
    o_c.remark as remark
FROM
	transport_oilcustomers AS o_c
LEFT JOIN transport_factory AS fac ON (
	o_c.factory_id = fac.factory_id
)
LEFT JOIN transport_customer_type AS cus_type ON (
	o_c.customer_type_id = cus_type.customer_type_id
)
WHERE
	o_c.`status` = 1";


            function add_client(&$data)
            {
                $check_sql = "SELECT count(*) as c from transport_oilcustomers where factory_id =".$data["params"]["factory_id"]." AND LOWER(`customer_name`) = '" .
                    strtolower($data["params"]["customer_name"]) . "'";

                $rs = mysql_fetch_assoc(mysql_query($check_sql));

                if ($rs["c"] > 0)
                {
                    phpgrid_error("ข้อมูลลูกค้าซ้ำ");
                }


            } // end of sub function


            function delete_client(&$data)
            {

                ob_start();
                print_r($data);
                $str = ob_get_clean();
                $str = "UPDATE `transport_oilcustomers` SET `status`='0' WHERE (`customer_id`='{$data["id"]}')";

                mysql_query($str);


            }

            //Use Table
            $g->table = "transport_oilcustomers";

            // pass the cooked columns to grid


            $g->set_columns($cols);

            $opt["sortname"] = 'customer_name';
            $opt["sortorder"] = "asc";
            $opt["detail_grid_id"] = "list2";
            $opt["multiselect"] = false;
            $opt["subgridparams"] = "customer_id";
            $opt["rowList"] = array(
                10,
                20,
                30);
            $opt["caption"] = $this->lang->line('customer');
            $opt["autowidth"] = true;
            $opt["multiselect"] = false;
            $opt["autowidth"] = true;
            $opt["view_options"]['width'] = '520';
            $opt["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $opt["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $opt["edit_options"]["beforeSubmit"] = "function(post,form){ return validate_form_once(post,form); }";

            $g->set_options($opt);


            $g->set_actions(array(
                "add" => $this->cizacl->check_isAllowed($i_rule, 'customer', 'add_customer'), // allow/disallow add
                "edit" => $this->cizacl->check_isAllowed($i_rule, 'customer', 'edit_customer'), // allow/disallow edit
                "delete" => $this->cizacl->check_isAllowed($i_rule, 'customer', 'del_customer'), // allow/disallow delete
                "export" => false, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "advance"));


            // set database table for CRUD operations


            // render grid and get html/js output
            $out_index = $g->render("list1");


            // detail grid
            $grid = new jqgrid();


            $id = intval($_GET["rowid"]);
            $opt2 = array();
            $opt2["sortname"] = 'car_id'; // by default sort grid by this field
            $opt2["sortorder"] = "desc"; // ASC or DESC
            $opt2["height"] = ""; // autofit height of subgrid
            $opt2["width"] = "640";
            $opt2["caption"] = $this->lang->line('car_details'); // caption of grid
            $opt2["multiselect"] = true; // allow you to multi-select through checkboxes
            $opt2["rowList"] = array(
                10,
                20,
                30);
            // Check if master record is selected before detail addition
            $opt2["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('กรุณาเลือกหน่วยงานของรถ'); return false; } }";
            $grid->set_options($opt2);

            $grid->set_actions(array(
                "add" => true, // allow/disallow add
                "edit" => true, // allow/disallow edit
                "delete" => true, // allow/disallow delete
                "rowactions" => true, // show/hide row wise edit/del/save option
                "export" => false, // show/hide export to excel option
                "autofilter" => true, // show/hide autofilter for search
                "search" => "advance"
                    // show single/multi field search condition (e.g. simple or advance)
                    ));

            #ID
            $col2 = array();
            $col2['title'] = "ID";
            $col2['name'] = "car_id";
            $col2['hidden'] = true;
            $col2['isnull'] = true;
            $cols2[] = $col2;


            $col2 = array();
            $col2['title'] = $this->lang->line('car_number');
            $col2['name'] = "car_number";
            $col2['editable'] = true;
            $col2["formatter"] = "autocomplete"; // autocomplete
            $col2["formatoptions"] = array(
                "sql" => "SELECT car_number AS k,car_number AS v FROM `transport_cars` WHERE `status`=1",
                "search_on" => "car_number",
                "update_field" => "car_number");


            $cols2[] = $col2;
            $col2 = array();
            $col2['title'] = $this->lang->line('car_license');
            $col2['name'] = "car_license";
            $col2['editable'] = true;
            $cols2[] = $col2;

            $col2 = array();
            $col2['name'] = "customer_id";
            $col2['title'] = "customer_id";
            $col2['editable'] = true;
            $col2['hidden'] = true;
            $cols2[] = $col2;


            $grid->select_command =
                "SELECT car_id,car_number,car_license,customer_id FROM transport_oilcars WHERE customer_id =$id";

            $grid->table = "transport_oilcars";

            $grid->set_columns($cols2);

            $e["on_insert"] = array(
                "oilcars",
                null,
                true);
            $e["on_after_insert"] = array(
                "after_insert",
                null,
                true); // return last inserted id for further working

            $grid->set_events($e);

            function oilcars(&$data)
            {
                $id = intval($_GET["rowid"]);
                $data["params"]["customer_id"] = $id;
                
                    $check_sql = "SELECT count(*) as c from transport_oilcars WHERE customer_id = $id and LOWER(`car_number`) = '" .
                    strtolower($data["params"]["car_number"]) . "'";

                $rs = mysql_fetch_assoc(mysql_query($check_sql));

                if ($rs["c"] > 0)
                {
                    phpgrid_error("หมายเลขรถซ้ำ");
                }
                
            }

            function after_insert($data)
            {
                /*
                These comments are just to show the input $data format 
                Array 
                ( 
                [client_id] => 99 
                [params] => Array 
                ( 
                [client_id] =>  
                [name] => Test 
                [gender] => male 
                [company] => Comp Test 
                ) 

                )     
                */
                /*
                ob_start(); 
                print_r($data); 
                $str = ob_get_clean(); 
                phpgrid_error($str); 
                */
                
                $car_number = $data['params']['car_number'];
                
                
                
                
                
            }


           $out_detail = $grid->render("list2");


            $h2_title = $this->lang->line('customeroils');

            //display
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out_index,
                'out_detail' => $out_detail,
                'h2_title' => $h2_title,
                'js_files' => array(),
                'css_files' => array()));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    } // end of dunction index


} // Buytax
