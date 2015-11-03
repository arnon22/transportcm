<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Oil extends CI_Controller
{

    private $main_menu;

    public function __construct()
    {

        parent::__construct();


        $this->lang->load('thai');
        $this->load->model('income_model', 'income');
        $this->load->model('dropdown_model', 'dropdrown');
        $this->load->model('factory_model', 'factory');


        $this->load->library('jqgridnow_lib');

    }

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('oil/oil-view', $output);
    }


    public function index()
    {

        //check login
        if ($this->session->userdata('user_name')) {

            $g = new jqgrid();

            $opt["caption"] = "รายการรับ - จ่าย น้ำมัน";
            // following params will enable subgrid -- by default first column (PK) of parent is passed as param 'id'
            $opt["detail_grid_id"] = "list2,list3";
            $opt["subgridparams"] = "factory_id";
            $opt["height"] = "90";
            $opt['autowidth'] = true;

            $g->set_options($opt);


            $col = array();

            $col['title'] = "id";
            $col['name'] = "factory_id";
            $col['hidden'] = true;
            // $col['dbname'] = "fac.factory_id";
            $cols[] = $col;


            #factory Name
            $col = array();
            $col['title'] = $this->lang->line('factory_name');
            $col['name'] = "factory_name";
            //$col['dbnaem'] = "fac.factory_name";
            $col["search"] = false;
            $cols[] = $col;

            #factory Code
            $col = array();
            $col['title'] = $this->lang->line('factory_code');
            $col['name'] = "factory_code";
            $col['dbnaem'] = "fac.factory_code";
            $col["search"] = false;
            $cols[] = $col;

            #Recived Oil
            $col = array();
            $col['title'] = $this->lang->line('sum_recived_oil');
            $col['name'] = "receive_oil";
            $col["search"] = false;
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => 2);
            $cols[] = $col;

            #Sell Oil
            $col = array();
            $col['title'] = $this->lang->line('sum_sell_oil');
            $col['name'] = "sell_oil";
            $col["search"] = false;
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => 2);
            $cols[] = $col;

            #Total Amount
            $col = array();
            $col['title'] = $this->lang->line("oil_total_amount");
            ;
            $col['name'] = "total_amount";
            $col["search"] = false;
            $col["formatter"] = "number";
            $col["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => 2);
            $cols[] = $col;


            // Command 1

            $g->select_command = "SELECT
     factory_id,
     factory_code,
     factory_name,
     SUM(receive_oil) AS receive_oil,
     SUM(sell_oil) AS sell_oil,
     oil_type,
     SUM(receive_oil - sell_oil) AS total_amount,
		 factory_status
FROM
     (
          SELECT
               t1.factory_id,
               t1.factory_code,
               t1.factory_name,
							 t1.factory_status,
               t2.receive_oil,
               t2.sell_oil,
               t2.oil_type
          FROM
               transport_factory AS t1
          LEFT JOIN oilstock AS t2 ON t1.factory_id = t2.factory_id
          UNION
               SELECT
                    t1.factory_id,
                    t1.factory_code,
                    t1.factory_name,
										t1.factory_status,
                    t2.receive_oil,
                    t2.sell_oil,
                    t2.oil_type
               FROM
                    transport_factory AS t1
               RIGHT JOIN oilstock AS t2 ON t1.factory_id = t2.factory_id
     ) oilstock
GROUP BY
     factory_id
HAVING factory_status =1";


            $g->table = "transport_factory";

            $g->set_columns($cols);

            $g->set_actions(array(
                "add" => false,
                "edit" => false,
                "delete" => false,
                "rowactions" => false,
                "autofilter" => false));

            // render grid and get html/js output
            $out_master = $g->render("list1");

            /*
            if (!empty($_REQUEST["factory_id"]))
            {
            $_SESSION["factory_id"] = intval($_REQUEST["factory_id"]);
            }

            if (isset($_SESSION['factory_id']))
            {
            $fac_id = $_SESSION["factory_id"];
            } else
            {
            $fac_id = "0";
            }
            */
            $fac_id = intval($_GET["factory_id"]);


            #Detail Oil Recive **รับน้ำมัน
            $g2 = new jqgrid();

            /*Option*/
            $opt2["caption"] = $this->lang->line("recived_oil_list");
            $opt2["sortname"] = 'stock_id';
            $opt2["sortorder"] = "desc";
            $opt2["height"] = "250";
            $opt2['rowNum'] = 10;
            $opt2['rowList'] = array(
                10,
                20,
                30);
            $opt2["width"] = "979";
            //$opt2["autowidth"] = true;
            //$opt3['hidegrid'] = true;

            $opt2["form"]["position"] = "center";
            $opt2["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $opt2["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');

            /*
            $opt2["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('จำเป็นต้องเลือกโรงงาน'); return false; } }";
            $opt2["add_options"]["afterSubmit"] = "function(){jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); return true;}";
            $opt2["edit_options"]["afterSubmit"] = "function(){jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); return true;}";
            $opt2["delete_options"]["afterSubmit"] = "function(){jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); return true;}";
            $opt2["add_options"]["afterShowForm"] =
            'function(formid) { jQuery("#ref_number").focus(); }';
            */
            // Check if master record is selected before detail addition
            $opt2["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('คุณยังไม่ได้เลือกโรงงาน'); return false; } }";
            // reload master after detail update
            $opt2["onAfterSave"] = "function(){ jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); }";


            $g2->set_options($opt2);


            #id
            $col2 = array();
            $col2['title'] = "id";
            $col2['name'] = 'stock_id';
            $col2['hidden'] = true;
            $col2['editable'] = true;
            $cols2[] = $col2;

            #stick date
            $col2 = array();
            $col2['title'] = $this->lang->line('date');
            $col2['name'] = 'stock_date';
            $col2['editable'] = true;
            $col2["editrules"] = array("required" => true); // and is required
            //$col2["editoptions"] = array("size" => 20, "defaultValue" => date("d-m-Y H:i")); // with default display of textbox with size 20

            $col2["searchoptions"]["sopt"] = array("cn"); // contains search for easy searching
            # to make it date time
            $col2["formatter"] = "datetime";
            # opts array can have these options: http://trentrichardson.com/examples/timepicker/#tp-options
            $col2["formatoptions"] = array(
                "srcformat" => 'Y-m-d H:i:s',
                "newformat" => 'Y-m-d H:i',
                "opts" => array("timeFormat" => "HH:mm"));
            $col2["show"] = array(
                "list" => true,
                "add" => true,
                "edit" => true,
                "view" => true);

            $cols2[] = $col2;

            #Ref No.
            $col2 = array();
            $col2['title'] = $this->lang->line('reference_number');
            $col2['name'] = 'ref_number';
            $col2['editable'] = true;
            $cols2[] = $col2;

            $col2 = array();
            $col2['title'] = $this->lang->line('customer_type');
            $col2['name'] = "customer_type_id";
            $col2['dbname'] = "oil.customer_type_id";
            $col2["editable"] = true;
            $col2["edittype"] = "select";
            $col2["editrules"] = array("required" => true);
            $str = $g2->get_dropdown_values("SELECT DISTINCT customer_type_id AS k,customer_type_title AS v FROM transport_customer_type WHERE customer_type_status = '2'");
            $col2["editoptions"] = array("value" => ":;" . $str);

            $col2["editoptions"] = array("value" => $str, "onchange" => array("sql" =>
                        "SELECT DISTINCT customer_id AS k , customer_name AS v FROM transport_oilcustomers WHERE customer_type_id ='{customer_type_id}' ",
                        "update_field" => "customer_id"));

            $col2["formatter"] = "select"; // display label, not value
            $col2["stype"] = "select"; // enable dropdown search
            $col2["searchoptions"] = array("value" => ":;" . $str);
            $cols2[] = $col2;

            # Customer Name
            $col2 = array();
            $col2['title'] = $this->lang->line('customer_br');
            $col2['name'] = "customer_id";
            $col2['dbname'] = "oil.customer_id";
            $col2["editable"] = true;
            $col2["edittype"] = "select";
            $col2["editrules"] = array("required" => true);
            $str = $g2->get_dropdown_values("SELECT DISTINCT customer_id AS k , customer_name AS v FROM transport_oilcustomers ");
            $col2["editoptions"] = array("value" => ":;" . $str);


            $col2["editoptions"] = array("value" => $str, "onchange" => array("sql" =>
                        "SELECT DISTINCT car_id AS k,car_number AS v FROM `transport_oilcars` WHERE customer_id ='{customer_id}' AND `status`=1",
                        "update_field" => "car_id"));

            $col2["editoptions"]["onload"]["sql"] =
                "SELECT DISTINCT customer_id AS k , customer_name AS v FROM transport_oilcustomers WHERE customer_type_id ='{customer_type_id}' AND `status` =1";

            $col2["formatter"] = "select"; // display label, not value
            $col2["stype"] = "select"; // enable dropdown search
            $col2["searchoptions"] = array("value" => ":;" . $str);
            $cols2[] = $col2;

            #Car Number
            $col2 = array();
            $col2['title'] = $this->lang->line('car_number');
            $col2['name'] = "car_id";
            $col2['dbname'] = "car.car_id";
            $col2["editable"] = true;
            $col2["edittype"] = "select";
            $col2["editrules"] = array("required" => true);
            $str = $g2->get_dropdown_values("SELECT DISTINCT car_id AS k, car_number AS v FROM transport_oilcars WHERE  `status` =1");
            $col2["editoptions"] = array("value" => ":;" . $str);

            // initially load 'note' of that
            $col2["editoptions"]["onload"]["sql"] =
                "SELECT DISTINCT car_id AS k, car_number AS v FROM transport_oilcars WHERE customer_id = '{customer_id}' AND `status` =1";

            $col2["formatter"] = "select"; // display label, not value
            $col2["stype"] = "select"; // enable dropdown search
            $col2["searchoptions"] = array("value" => ":;" . $str);
            $cols2[] = $col2;

            #stock_details
            $col2 = array();
            $col2['title'] = $this->lang->line('stock_details');
            $col2['name'] = 'stock_details';
            $col2['editable'] = true;
            $col2["edittype"] = "textarea";
            $col2["editoptions"] = array("rows" => 2, "cols" => 20);
            $col2["formatter"] = "autocomplete"; // autocomplete
            $col2["formatoptions"] = array(
                "sql" => "SELECT DISTINCT stock_details as k, stock_details as v FROM oilstock",
                "search_on" => "stock_details",
                "update_field" => "stock_details");

            $cols2[] = $col2;

            #oil_value
            $col2 = array();
            $col2['title'] = $this->lang->line('recived_oil');
            $col2['name'] = 'receive_oil';
            $col2['editable'] = true;
            $col2['search'] = false;
            $col2["editrules"] = array("required" => true, "number" => true);
            $col2["editoptions"] = array("onblur" => "update_reciveValue()", "defaultValue" =>
                    '0');
            $col2['formatter'] = "number";
            $col2["formatoptions"] = array(
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols2[] = $col2;

            #oil_value
            $col2 = array();
            $col2['title'] = $this->lang->line('list_per_price');
            $col2['name'] = 'receive_price';
            $col2['align'] = "right";
            $col2['editable'] = true;
            $col2['formatter'] = "number";
            $col2['search'] = false;
            $col2["editrules"] = array("required" => true, "number" => true);
            $col2["editoptions"] = array("onblur" => "update_reciveValue()", "defaultValue" =>
                    '0');
            $col2['formatter'] = "currency";
            $col2["formatoptions"] = array(
                "prefix" => "",
                "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');

            $cols2[] = $col2;

            #total_mount
            $col2 = array();
            $col2['title'] = $this->lang->line('total_amount');
            $col2['name'] = 'receive_amount';
            $col2['align'] = "right";
            $col2['editable'] = true;
            $col2["editrules"] = array("required" => true);
            # $col2['editoptions'] = array("readonly" => "readonly");
            $col2['search'] = false;
            $col2['formatter'] = "currency";
            $col2["formatoptions"] = array(
                "prefix" => "",
                "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => 2);
            $cols2[] = $col2;


            // $id = intval($_GET["rowid"]);

            /*
            $g2->select_command = "SELECT
            stock_id,
            stock_date,
            ref_number,
            oil.customer_type_id,
            cus_type.customer_type_title,
            oil.customer_id,
            cus.customers_name,
            oil.car_id,
            car.car_number,	
            stock_details,
            
            receive_oil,
            receive_price,
            receive_amount
            FROM
            oilstock AS oil
            LEFT JOIN transport_cars AS car ON (oil.car_id = car.car_id)
            LEFT JOIN transport_customers AS cus ON (
            oil.customer_id = cus.customer_id
            )
            LEFT JOIN transport_customer_type AS cus_type ON (
            cus.customer_type_id = cus_type.customer_type_id
            )
            WHERE
            oil.factory_id = '$fac_id'
            AND oil_type = 1";

            */

            $g2->select_command = "SELECT
	stock_id,
	stock_date,
	ref_number,
	oil.customer_type_id,
	cus_type.customer_type_title,
	oil.customer_id,
	cus.customer_name,
	oil.car_id,
	car.car_number,	
    stock_details,
	
	receive_oil,
	receive_price,
	receive_amount
FROM
	oilstock AS oil
LEFT JOIN transport_cars AS car ON (oil.car_id = car.car_id)
LEFT JOIN transport_oilcustomers AS cus ON (
	oil.customer_id = cus.customer_id
)
LEFT JOIN transport_customer_type AS cus_type ON (
	cus.customer_type_id = cus_type.customer_type_id
)
WHERE
	oil.factory_id = '$fac_id'
AND oil_type = 1";

            #select table
            $g2->table = "oilstock";
            #$g2->table = "oil_receive";

            $e["on_insert"] = array(
                "add_client",
                null,
                true);
            $g2->set_events($e);

            function add_client(&$data)
            {
                $id = intval($_GET["rowid"]);
                $data["params"]["factory_id"] = $id;
                $data["params"]["oil_type"] = 1;

            }

            $g2->set_actions(array(
                "add" => true,
                "edit" => true,
                "delete" => true,
                "view" => false,
                "rowactions" => false,
                "autofilter" => true,
                "search" => "advance",
                "inlineadd" => false,
                "showhidecolumns" => false));

            $g2->set_columns($cols2);
            #display Grid2
            $out_list2 = $g2->render("list2");


            /*Grid3 รายการจ่ายน้ำมัน*/

            $g3 = new jqgrid();

            /*Option*/
            $opt3["caption"] = $this->lang->line('sell_oil_list');
            $opt3["sortname"] = 'stock_id';
            $opt3["sortorder"] = "desc";
            $opt3["height"] = "250";
            $opt3['rowNum'] = 10;
            $opt3['rowList'] = array(
                10,
                20,
                30);
            $opt3["width"] = "979";
            //$opt3["autowidth"] = true;
            //$opt3['hidegrid'] = true;

            $opt3["form"]["position"] = "center";
            $opt3["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $opt3["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            /*
            $opt3["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('จำเป็นต้องเลือกโรงงาน'); return false; } }";
            $opt3["add_options"]["afterSubmit"] = "function(){jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); return true;}";
            $opt3["edit_options"]["afterSubmit"] = "function(){jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); return true;}";
            $opt3["delete_options"]["afterSubmit"] = "function(){jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); return true;}";
            $opt3["add_options"]["afterShowForm"] =
            'function(formid) { jQuery("#ref_number").focus(); }';
            */

            // Check if master record is selected before detail addition
            $opt3["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('คุณยังไม่ได้เลือกโรงงาน'); return false; } }";
            // reload master after detail update
            $opt3["onAfterSave"] = "function(){ jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); }";


            $g3->set_options($opt3);

            #id
            $col3 = array();
            $col3['title'] = "id";
            $col3['name'] = 'stock_id';
            $col3['hidden'] = true;
            $col3['editable'] = true;
            $cols3[] = $col3;

            #stick date
            $col3 = array();
            $col3['title'] = $this->lang->line('date');
            $col3['name'] = 'stock_date';
            $col3['editable'] = true;
            $col3["editrules"] = array("required" => true); // and is required
            //$col2["editoptions"] = array("size" => 20, "defaultValue" => date("d-m-Y H:i")); // with default display of textbox with size 20

            $col3["searchoptions"]["sopt"] = array("cn"); // contains search for easy searching
            # to make it date time
            $col3["formatter"] = "datetime";
            # opts array can have these options: http://trentrichardson.com/examples/timepicker/#tp-options
            $col3["formatoptions"] = array(
                "srcformat" => 'Y-m-d H:i:s',
                "newformat" => 'Y-m-d H:i',
                "opts" => array("timeFormat" => "HH:mm"));
            $col3["show"] = array(
                "list" => true,
                "add" => true,
                "edit" => true,
                "view" => true);

            $cols3[] = $col3;

            #Ref No.
            $col3 = array();
            $col3['title'] = $this->lang->line('reference_number');
            $col3['name'] = 'ref_number';
            $col3['editable'] = true;
            $cols3[] = $col3;

            $col3 = array();
            $col3['title'] = $this->lang->line('customer_type');
            $col3['name'] = "customer_type_id";
            $col3['dbname'] = "oil.customer_type_id";
            $col3["editable"] = true;
            $col3["edittype"] = "select";
            $col3["editrules"] = array("required" => true);
            $str = $g3->get_dropdown_values("SELECT DISTINCT customer_type_id AS k,customer_type_title AS v FROM transport_customer_type WHERE customer_type_status = '2'");
            $col3["editoptions"] = array("value" => ":;" . $str);

            $col3["editoptions"] = array("value" => $str, "onchange" => array("sql" =>
                        "SELECT DISTINCT customer_id AS k , customer_name AS v FROM transport_oilcustomers WHERE customer_type_id ='{customer_type_id}' ",
                        "update_field" => "customer_id"));

            $col3["formatter"] = "select"; // display label, not value
            $col3["stype"] = "select"; // enable dropdown search
            $col3["searchoptions"] = array("value" => ":;" . $str);
            $cols3[] = $col3;

            # Customer Name
            $col3 = array();
            $col3['title'] = $this->lang->line('customer_br');
            $col3['name'] = "customer_id";
            $col3['dbname'] = "oil.customer_id";
            $col3["editable"] = true;
            $col3["edittype"] = "select";
            $col3["editrules"] = array("required" => true);
            $str = $g3->get_dropdown_values("SELECT DISTINCT customer_id AS k , customer_name AS v FROM transport_oilcustomers ");
            $col3["editoptions"] = array("value" => ":;" . $str);


            $col3["editoptions"] = array("value" => $str, "onchange" => array("sql" =>
                        "SELECT DISTINCT car_id AS k,car_number AS v FROM `transport_oilcars` WHERE customer_id ='{customer_id}' AND `status`=1",
                        "update_field" => "car_id"));

            $col3["editoptions"]["onload"]["sql"] =
                "SELECT DISTINCT customer_id AS k , customer_name AS v FROM transport_oilcustomers WHERE customer_type_id ='{customer_type_id}' AND `status` =1";

            $col3["formatter"] = "select"; // display label, not value
            $col3["stype"] = "select"; // enable dropdown search
            $col3["searchoptions"] = array("value" => ":;" . $str);
            $cols3[] = $col3;

            #Car Number
            $col3 = array();
            $col3['title'] = $this->lang->line('car_number');
            $col3['name'] = "car_id";
            $col3['dbname'] = "car.car_id";
            $col3["editable"] = true;
            $col3["edittype"] = "select";
            $col3["editrules"] = array("required" => true);
            $str = $g3->get_dropdown_values("SELECT DISTINCT car_id AS k, car_number AS v FROM transport_oilcars WHERE  `status` =1");
            $col3["editoptions"] = array("value" => ":;" . $str);

            // initially load 'note' of that
            $col3["editoptions"]["onload"]["sql"] =
                "SELECT DISTINCT car_id AS k, car_number AS v FROM transport_oilcars WHERE customer_id = '{customer_id}' AND `status` =1";

            $col3["formatter"] = "select"; // display label, not value
            $col3["stype"] = "select"; // enable dropdown search
            $col3["searchoptions"] = array("value" => ":;" . $str);
            $cols3[] = $col3;


            #stock_details
            $col3 = array();
            $col3['title'] = $this->lang->line('stock_details');
            $col3['name'] = 'stock_details';
            $col3['editable'] = true;
            $col3["edittype"] = "textarea";
            $col3["editoptions"] = array("rows" => 2, "cols" => 20);
            $col3["formatter"] = "autocomplete"; // autocomplete
            $col3["formatoptions"] = array(
                "sql" => "SELECT DISTINCT stock_details as k, stock_details as v FROM oilstock",
                "search_on" => "stock_details",
                "update_field" => "stock_details");

            $cols3[] = $col3;

            #oil_value
            $col3 = array();
            $col3['title'] = $this->lang->line('sell_oil');
            $col3['name'] = 'sell_oil';
            $col3['search'] = false;
            $col3['editable'] = true;
            $col3["editrules"] = array("required" => true, "number" => true);
            $col3["editoptions"] = array("onblur" => "update_oilvalue()", "defaultValue" =>
                    '0');
            $col3['formatter'] = "number";
            $col3["formatoptions"] = array(
               # "prefix" => "",
                #"suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols3[] = $col3;

            #oil_price
            $col3 = array();
            $col3['title'] = $this->lang->line('list_per_price');
            $col3['name'] = 'sell_price';
            $col3['align'] = "right";
            $col3['editable'] = true;
            $col3['search'] = false;
            $col3["editrules"] = array("required" => true, "number" => true);
            $col3["editoptions"] = array("onblur" => "update_oilvalue()", "defaultValue" =>
                    '0');
            $col3['formatter'] = "currency";
            $col3["formatoptions"] = array(
                #"prefix" => "",
               # "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols3[] = $col3;

            #total_mount
            $col3 = array();
            $col3['title'] = $this->lang->line('total_amount');
            $col3['name'] = 'sell_amount';
            $col3['align'] = "right";
            $col3['editable'] = true;
            $col3['search'] = false;
            $col3["editrules"] = array("required" => true);
            #$col3['editoptions'] = array("readonly" => "readonly");
            $col3['formatter'] = "currency";
            $col3["formatoptions"] = array(
               # "prefix" => "",
               # "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $cols3[] = $col3;

            //$fac_id = intval($_REQUEST["rowid"]);

            /*
            $g3->select_command = "SELECT
            stock_id,
            stock_date,
            ref_number,
            oil.customer_type_id,
            cus_type.customer_type_title,
            oil.customer_id,
            cus.customers_name,
            oil.car_id,
            car.car_number,
            stock_details,
            sell_oil,
            sell_price,
            sell_amount
            FROM
            oilstock AS oil
            LEFT JOIN transport_cars AS car ON (oil.car_id = car.car_id)
            LEFT JOIN transport_customers AS cus ON (
            oil.customer_id = cus.customer_id
            )
            LEFT JOIN transport_customer_type AS cus_type ON (
            cus.customer_type_id = cus_type.customer_type_id
            )
            WHERE
            oil.factory_id = '$fac_id'
            AND oil_type = 2";
            */

            $g3->select_command = "SELECT
	stock_id,
	stock_date,
	ref_number,
	oil.customer_type_id,
	cus_type.customer_type_title,
	oil.customer_id,
	cus.customer_name,
	oil.car_id,
	car.car_number,
	stock_details,
	sell_oil,
	sell_price,
	sell_amount
FROM
	oilstock AS oil
LEFT JOIN transport_cars AS car ON (oil.car_id = car.car_id)
LEFT JOIN transport_oilcustomers AS cus ON (
	oil.customer_id = cus.customer_id
)
LEFT JOIN transport_customer_type AS cus_type ON (
	cus.customer_type_id = cus_type.customer_type_id
)
WHERE
	oil.factory_id = '$fac_id'
AND oil_type = 2";

            $g3->table = "oilstock";

            $e["on_insert"] = array(
                "add_oiltype",
                null,
                true);
            $g3->set_events($e);

            function add_oiltype(&$data)
            {
                $id = intval($_GET["rowid"]);
                $data["params"]["factory_id"] = $id;
                $data["params"]["oil_type"] = 2;

            }


            $g3->set_columns($cols3);


            $g3->set_actions(array(
                "add" => true,
                "edit" => true,
                "delete" => true,
                "view" => false,
                "rowactions" => true,
                "autofilter" => true,
                "search" => "advance",
                "inlineadd" => false,
                "showhidecolumns" => false));

            #display Grid2
            $out_list3 = $g3->render("list3");


            //display
            $this->_example_output((object)array(
                'output' => '',
                'out_master' => $out_master,
                'out_list2' => $out_list2,
                'out_list3' => $out_list3));

            //$this->load->view('oil/oil-view');


        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    }


    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //session_destroy();
        redirect('bootstrap', 'refresh');
    }


} // end of class
