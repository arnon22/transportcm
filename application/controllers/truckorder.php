<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Truckorder extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->lang->load('thai');
        $this->load->library("jqgridnow_lib");

        $this->load->model("price_model", "price");
        

    }


    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('truckorder', $output);
    }


    public function index()
    {
        
        if ($this->session->userdata('user_name'))
        {
            $i_rule = $this->session->userdata('user_cizacl_role_id');

            $this->load->model('income_model', 'dropdrown');
            $this->load->model('dropdown_model', 'cus_drop');
            date_default_timezone_set('Asia/Bangkok');
           

            $g = new jqgrid();


            $col = array();
            $col["title"] = "Id"; // caption of column
            $col["name"] = "id";
            $col["width"] = "10";
            $col["fixed"] = true;
            $col["search"] = false;
            $col["editable"] = false;
            $col["export"] = false;
            $col["hidden"] = true;
            $cols[] = $col;

            #Date
            $col = array();
            $col["title"] = $this->lang->line('date');
            $col["name"] = "order_date";
            $col["fixed"] = true;
            $col["width"] = "150";
            $col["editable"] = true; // this column is editable
            $col["editoptions"] = array("size" => 20, "defaultValue" => date("d-m-Y H:i:s")); // with default display of textbox with size 20
            $col["editrules"] = array("required" => true); // and is required
            $col["formatter"] = "datetime"; // format as date
            $col["formatoptions"] = array(
                "srcformat" => 'Y-m-d H:i:s',
                "newformat" => 'd-m-Y H:i:s',
                "opts" => array("changeYear" => false, "timeFormat" => "hh:mm tt"));
            $col["search"] = true;
            $cols[] = $col;

            #DP Number
            $col = array();
            $col["title"] = $this->lang->line('dp_number'); // caption of column
            $col["name"] = "dp_number";
            $col["fixed"] = true;
            $col["width"] = "100";
            $col["search"] = true;
            $col["editrules"] = array("required" => true);
            $col['editoptions'] = array(
                "defaultValue" => "",
                "min" => "1",
                "max" => "10",
                "maxlength" => "10");
            $col["editable"] = true;
            $cols[] = $col;

            #Customer
            $col = array();
            $col["title"] = "customer_id";
            $col["name"] = "customer_id";
            $col["width"] = "10";
            $col["editable"] = true;
            $col["export"] = false;
            $col["hidden"] = true;
            $cols[] = $col;

            #Customer name
            $col = array();
            $col["title"] = $this->lang->line('customer');
            $col["name"] = "cid";
            $col["dbname"] = "cus.customers_name"; // this is required as we need to search in name field, not id
            $col["fixed"] = true;
            $col["width"] = "200";
            $col["align"] = "left";
            $col["editrules"] = array("required" => true);
            $col["search"] = true;
            $col["editable"] = true;
            $col["formatter"] = "autocomplete"; // autocomplete

            $col["formatoptions"] = array(
                "sql" => "SELECT * FROM (SELECT customer_id as k, customers_name  as v FROM transport_customers where customer_type_id=1 GROUP BY customers_name) o",
                "search_on" => "v",
                "update_field" => "customer_id");

            $cols[] = $col;

            #factory
            $col = array();
            $col["title"] = $this->lang->line('factory');
            $col["name"] = "factory_id";
            $col["dbname"] = "fac.factory_code"; // this is required as we need to search in name field, not id
            $col["fixed"] = true;
            $col["width"] = "100";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["editrules"] = array("required" => true);
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            //$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
            $str = $this->dropdrown->get_factory_dropdown();
            $col["editoptions"] = array("value" => $str);
            $col["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ $('select[name=factory_id]').select2({width:'80%', dropdownCssClass: 'ui-widget ui-jqdialog'}); },200); }";
            $col["formatter"] = "select"; // display label, not value


            $cols[] = $col;

            #Real Distance
            $col = array();
            $col['title'] = $this->lang->line('real_distance');
            $col['name'] = "real_distance";
            $col["fixed"] = true;
            $col['align'] = "center";
            $col['width'] = "65";
            $col["search"] = false;
            $col["editrules"] = array("required" => true, "number" => true);
            $col["editable"] = true; // this column is editable
            // $col["editoptions"] = array("defaultValue" => 1);
            $col["editoptions"] = array("defaultValue" => 1, "onchange" => array("sql" =>
                        "SELECT DISTINCT distance_id AS k,distance_code AS v FROM distancecode
WHERE range_min <= '{real_distance}'	AND range_max >='{real_distance}' ",
                        "update_field" => "distance_id"));
            $cols[] = $col;

            #dis Distance_code
            $col = array();
            $col['title'] = $this->lang->line('distance_code');
            $col['name'] = "distance_id";
            $col['dbname'] = "dis.distance_code";
            $col["fixed"] = true;
            $col['width'] = "80";
            $col["search"] = false;
            $col['align'] = "center";
            $col["editable"] = true;
            $col["editrules"] = array("required" => true);
            $col["edittype"] = "select"; // render as select
            $str = $this->cus_drop->get_distancecode_dropdown();
            $col["editoptions"] = array("value" => $str);
            #$col["formatter"] = "select"; // display label, not value

            // initially load 'note' of that client_id
            $col["editoptions"]["onload"]["sql"] =
                "SELECT DISTINCT distance_id AS k,distance_code AS v FROM distancecode
WHERE range_min <= '{real_distance}'	AND range_max >='{real_distance}' ";

            $col["formatter"] = "select"; // display label, not value
            $col["stype"] = "select"; // enable dropdown search
            $col["searchoptions"] = array("value" => ":;" . $str);

            $cols[] = $col;

            /*Cubic*/
            
            $col = array();
            $col['title'] = $this->lang->line('cubic_value');
            $col["name"] = "cubic_id";
            $col["dbname"] = "orders.cubic_id"; // this is required as we need to search in name field, not id
            $col['width'] = "80";
            $col["fixed"] = true;
            $col["align"] = "center";
            $col["search"] = false;
            $col["editable"] = true;
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            $str = $g->get_dropdown_values("select distinct cubic_id as k, cubic_value as v from transport_cubiccode where cubic_status=1");
            //$str = $this->cus_drop->get_cubiccode_dropdown();
            $col["editoptions"] = array("value" => ":;" . $str);
            $col["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ $('select[name=cubic_id]').select2({width:'80%', dropdownCssClass: 'ui-widget ui-jqdialog'}); },200); }";

            $cols[] = $col;
            
            #price
            $col = array();
            $col['title'] = $this->lang->line('price');
            $col['name'] = "price";
            $col['align'] = "right";
            $col["fixed"] = true;
            $col['width'] = "80";
            //$col["editrules"] = array("number" => true);
            $col['editoptions'] = array("defaultValue" => "0","readonly"=>true);
            #$col['hidden'] = true;
            $col["show"] = array("list"=>true, "add"=>false, "edit"=>false, "view"=>true); 
            $col['editable'] = true;
            $col['search'] = false;
            $cols[] = $col;

            /*End Cubic*/

            #car
            $col = array();
            $col["title"] = $this->lang->line('car_number');
            $col['name'] = "car_id";
            $col['dbname'] = "car.car_number";
            $col["fixed"] = true;
            $col['align'] = "center";
            $col['width'] = "85";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $col['edittype'] = "select";
            $str = $this->cus_drop->get_car_dropdown();
            $col["editoptions"] = array("value" => $str, "onchange" => array("sql" =>
                        "SELECT DISTINCT driver_id as k, driver_name as v  FROM driver WHERE car_id = '{car_id}'",
                        "update_field" => "driver_id"));


            $col['formatter'] = "select";
            //$col["stype"] = "select"; // enable dropdown search
            //$col["searchoptions"] = array("car_id" => ":;".$str);

            $cols[] = $col;

            #Driver
            $col = array();
            $col["title"] = $this->lang->line('driver');
            $col['name'] = "driver_id";
            $col['dbname'] = "dri.driver_name";
            $col["fixed"] = true;
            $col['width'] = "150";
            $col['search'] = true;
            $col['editable'] = true;
            $col['edittype'] = "select";
            $col["editrules"] = array("required" => true);
            $str = $this->cus_drop->get_drivers_dropdown();
            $col['editoptions'] = array("value" => $str);
            $col['formatter'] = "select";
            $col["searchoptions"] = array("car_id" => ":;" . $str);
            $cols[] = $col;

            #OilUse
            $col = array();
            $col['title'] = $this->lang->line('use_oil');
            $col['name'] = "use_oil";
            $col['dbname'] = "orders.use_oil";
            $col["fixed"] = true;
            $col['align'] = "center";
            $col['width'] = "70";
            $col["editoptions"] = array("number" => true, "defaultValue" => '0');
            $col['editrules'] = array("number" => true);
            $col['formater'] = "number";
            $col['editable'] = true;
            $cols[] = $col;

            #Remark
            $col = array();
            $col['title'] = $this->lang->line('remark');
            $col['name'] = "remark";
            $col['dbname'] = "orders.remark";
            $col["fixed"] = true;
            $col['width'] = "120";
            $col["edittype"] = "textarea";
            $col["editoptions"] = array("rows" => 2, "cols" => 20);
            $col['editable'] = true;
            $cols[] = $col;

            

            /*Grid Option*/
            $opt["sortname"] = 'id';
            $opt["sortorder"] = "desc";
            $opt["caption"] = $this->lang->line('Order_Transportation');
            $opt['rowNum'] = 10;
            $opt['rowList'] = array(
                10,
                20,
                30);
            $opt['height'] = "360";
            $opt["autowidth"] = true;
            $opt["multiselect"] = true;
            $opt["scroll"] = true;
            $opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420');
            $opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420');
            $opt["add_options"]["afterShowForm"] =
                'function(formid) { jQuery("#dp_number").focus();}';
            $opt["edit_options"]["afterShowForm"] =
                'function(formid) { jQuery("#dp_number").focus();}';                
            $opt["altRows"] = true;
            $opt["altclass"] = "myAltRowClass";
            $opt["form"]["position"] = "center"; // or "all" 
           
            $g->set_options($opt);


            $g->set_actions(array(
                "add" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'add'), // allow/disallow add
                "edit" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'edit'), // allow/disallow edit
                "delete" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'delete'), // allow/disallow delete
                "rowactions" => false,
                "export" => true,
                "autofilter" => true, // show/hide autofilter for search
                "search" => "advance"));


            $g->select_command = "SELECT
	id,
	dp_number,
	orders.customer_id,
    cus.customers_name AS cid,
    orders.factory_id,
	fac.factory_code,
	real_distance,
	orders.distance_id,
	dis.distance_code,	
    cubic.cubic_value as cubic_id,
    orders.price AS price,
	orders.use_oil,
    orders.car_id,
	car.car_number,
	orders.driver_id,
	dri.driver_name,
    order_date,
    orders.delivery_datetime,
    orders.remark

FROM
	`orders` AS orders
LEFT JOIN transport_factory AS fac ON (
	orders.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	orders.customer_id = cus.customer_id
)
LEFT JOIN transport_cubiccode AS cubic ON (
	orders.cubic_id = cubic.cubic_id
)
LEFT JOIN distancecode AS dis ON (
	orders.distance_id = dis.distance_id
)
LEFT JOIN transport_cars AS car ON (
orders.car_id = car.car_id
)
LEFT JOIN driver AS dri ON (
	orders.driver_id = dri.driver_id
)";

            // this db table will be used for add,edit,delete
            $g->table = "orders";
            
             $e["on_insert"] = array(
                "add_order",
                null,
                true);

            $e["on_after_insert"] = array(
                "after_insert",
                null,
                true);

            $e["on_update"] = array(
                "do_update",
                null,
                true);
          
            $e["on_data_display"] = array(
                "filter_display",
                null,
                true);

            $g->set_events($e);

            function add_order(&$data)
            {
                //print_r($data);
                $obj = &get_instance();

                $obj->load->model("price_model", "pricelist");

                //$id = intval($_REQUEST["id"]);
                $factory_id = $data["params"]["factory_id"];
                $distance_id = $data["params"]["distance_id"];
                $cubid_id = $data["params"]["cubic_id"];
                $order_date = $data["params"]["order_date"];

                #get price
                $order_price = $obj->pricelist->get_order_Price($factory_id, $cubid_id, $distance_id,
                    $order_date);


                if ($order_price == null)
                {
                    $str = ob_get_clean();
                    $str = "ยังไม่มีการกำหนดราคาค่าขนส่ง";
                    phpgrid_error($str);
                }

                /*check DP NUmber*/
                $check_sql = "SELECT count(*) as c from orders where LOWER(`dp_number`) = '" .
                    strtolower($data["params"]["dp_number"]) . "'";

                $rs = mysql_fetch_assoc(mysql_query($check_sql));

                if ($rs["c"] > 0)
                {
                    phpgrid_error("หมายเลข DP Number ซ้ำ");
                }
                /*End Check DP Number*/


                //$str = "UPDATE orders SET price ='{$data["parmas"]["price"]}' WHERE id = '{$data["id"]}'";
                //mysql_query($str);

            }

            function do_update(&$data)
            {
                //print_r($data);
                $obj = &get_instance();

                $obj->load->model("price_model", "pricelist");

                $id = intval($_REQUEST["id"]);
                $factory_id = $data["params"]["factory_id"];
                $distance_id = $data["params"]["distance_id"];
                $cubid_id = $data["params"]["cubic_id"];
                $order_date = $data["params"]["order_date"];

                #get price
                $order_price = $obj->pricelist->get_order_Price($factory_id, $cubid_id, $distance_id,
                    $order_date);

                if ($order_price == null)
                {
                    $str = ob_get_clean();
                    $str = "ยังไม่มีการกำหนดราคาค่าขนส่ง";
                    phpgrid_error($str);
                } else
                {
                    $data["params"]["price"] = $order_price;
                    $str = "UPDATE orders SET price ='{$data["parmas"]["price"]}' WHERE id = '{$data["id"]}'";
                    mysql_query($str);
                }


                //$str = "UPDATE orders SET price ='{$data["parmas"]["price"]}' WHERE id = '{$data["id"]}'";
                //mysql_query($str);

            }

            function after_insert(&$data)
            {
                //print_r($data);
                $obj = &get_instance();

                $obj->load->model("price_model", "pricelist");

                $id = $data["id"];
                $factory_id = $data["params"]["factory_id"];
                $distance_id = $data["params"]["distance_id"];
                $cubid_id = $data["params"]["cubic_id"];
                $order_date = $data["params"]["order_date"];

                #get price
                $order_price = $obj->pricelist->get_order_Price($factory_id, $cubid_id, $distance_id,
                    $order_date);


                $str = "UPDATE orders SET price ='$order_price' 
                    WHERE id = {$data["id"]}";
                mysql_query($str);
            }

            function filter_display(&$data)
            {

                foreach($data["params"] as &$d)
                    {
                        foreach($d as $k=>$v){
                            $d[$k] = strtoupper($d[$k]);
                            }
                        } 
            }


            // pass the cooked columns to grid
            $g->set_columns($cols);

            // generate grid output, with unique grid name as 'list1'
            $out = $g->render("list1");

            $iprice = $this->price->get_order_Price(2, 2, 2);

            $h2_title = $this->lang->line('order_car_truck');
            //display
            $this->_example_output((object)array(
                'output' => "",
                'out' => $out,
                'h2_title'=>$h2_title,
                'iprice' => $iprice,
                'js_files' => array(),
                'css_files' => array()));

            //$this->_example_output();

        } else
        {
            redirect('login', 'refresh');
        } //end if


    } // /index


} // end class Truckorder

/// End of Class
