<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Orders extends CI_Controller
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
            
            $col = array();
            $col['title'] = "cubic value";
            $col['name'] = "cubic_id";
            $col['dbname'] = "orders.cubic_id";
            $col["editable"] = true;
            $col["formatter"] = "select";
            $col["editable"] = true;
            $col["edittype"] = "select";
            $str = $g->get_dropdown_values("SELECT DISTINCT cubic_id AS k, cubic_value AS v FROM transport_cubiccode WHERE cubic_status=1");
            //$col["editoptions"] = array("value"=>":;".$str); 
            $col["editoptions"] = array("value"=>$str);  
            $col["formatter"] = "select"; // display label, not value  
            $cols[] = $col;

            
            
            /**Option Form */
            $opt["sortname"] = 'id';
            $opt["sortorder"] = "desc";
            $opt["caption"] = $this->lang->line('Order_Transportation');
            $opt['rowNum'] = 10;
            $opt['rowList'] = array(
                10,
                20,
                30);
            $opt['height'] = "300";
            $opt["autowidth"] = true;
            $opt["multiselect"] = false;
            $opt["scroll"] = true;


            $opt["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $opt["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');

            $opt["add_options"]["afterShowForm"] =
                'function(formid) { jQuery("#dp_number").focus(); }';
            $opt["altRows"] = true;
            $opt["altclass"] = "myAltRowClass";


            $g->set_options($opt);


            $g->set_actions(array(
                "add" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'add'), // allow/disallow add
                "edit" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'edit'), // allow/disallow edit
                "delete" => $this->cizacl->check_isAllowed($i_rule, 'truckorder', 'delete'), // allow/disallow delete
                "rowactions" => true,
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
	orders.cubic_id,
    cubic.cubic_value,
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

            $e["on_after_insert"] = array(
                "after_insert",
                null,
                true);

            $e["on_update"] = array(
                "do_update",
                null,
                true);
          /*      
            $e["on_insert"] = array(
                "add_order",
                null,
                true);
            */    
            $e["on_data_display"] = array("filter_display", null, true);

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
                $order_price = $obj->pricelist->get_order_Price($factory_id, $cubid_id, $distance_id,$order_date);


                if ($order_price == null)
                {
                    $str = ob_get_clean();
                    $str = "ไม่มีการกำหนดราคาค่าขนส่ง";
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
                $order_price = $obj->pricelist->get_order_Price($factory_id, $cubid_id, $distance_id,$order_date);

                if ($order_price == null)
                {
                    $str = ob_get_clean();
                    $str = "ไม่มีการกำหนดราคาค่าขนส่ง";
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
                $order_price = $obj->pricelist->get_order_Price($factory_id, $cubid_id, $distance_id,$order_date);


                $str = "UPDATE orders SET price ='$order_price' 
                    WHERE id = {$data["id"]}";
                mysql_query($str);
            }
            
            function filter_display($data)
            {

                foreach ($data["params"] as &$d)
                {
                    foreach ($d as $k => $v)
                        $d[$k] = strtoupper($d[$k]);
                }
            }


            // pass the cooked columns to grid
            $g->set_columns($cols);

            // generate grid output, with unique grid name as 'list1'
            $out = $g->render("list1");

            $iprice = $this->price->get_order_Price(2, 2, 2);


            //display
            $this->_example_output((object)array(
                'output' => "",
                'out' => $out,
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
