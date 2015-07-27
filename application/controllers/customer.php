<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
// Create by anon

class Customer extends CI_Controller
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
        $this->load->view('customer-view', $output);
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
            $col["dbname"] = "cus.factory_id"; // this is required as we need to search in name field, not id
            $col["width"] = "100";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["edittype"] = "select";
            $col["editrules"] = array("required" => true);
            # fetch data from database, with alias k for key, v for value
            $str = $g->get_dropdown_values("select distinct factory_id as k, factory_name as v from transport_factory");
            $col["editoptions"] = array("value" => ":;" . $str);
            $col["formatter"] = "select"; // display label, not value
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
            $str = $this->dropdrown->get_customer_type();
            $col["editoptions"] = array("value" => $str);
            $col["formatter"] = "select"; // display label, not value
            $cols[] = $col;

            #Customer name
            $col = array();
            $col['title'] = $this->lang->line('customer_agancy');
            $col['name'] = "customers_name";
            $col["editrules"] = array("required" => true);
            $col["search"] = true;
            $col['editable'] = true;
            $cols[] = $col;

            #Address
            $col = array();
            $col['title'] = $this->lang->line('Address1');
            $col['name'] = "address1";
            $col['editable'] = true;
            $col["search"] = false;
            $col['edittype'] = "textarea";
            $col['editoptions'] = array("rows" => "2", "cols" => "20");
            $cols[] = $col;

            #Address
            /*
            $col = array();
            $col['title'] = $this->lang->line('Address2');
            $col['name'] = "address2";
            $col['editable'] = true;
            $col['edittype'] = "textarea";
            $col["search"] = false;
            $col['editoptions'] = array("rows" => "2", "cols" => "20");
            $cols[] = $col;
            */
            #Contact Person
            $col = array();
            $col['title'] = $this->lang->line('contact_person');
            $col['name'] = "contact_person";
            $col['editable'] = true;
            $col["viewable"] = false;  
            $cols[] = $col;

            # Tel
            $col = array();
            $col['title'] = $this->lang->line('tel');
            $col['name'] = "mobile_number";
            $col['editable'] = true;           
            $col["editrules"] = array("number" => true);
            $cols[] = $col;

            #remark
            $col = array();
            $col['title'] = $this->lang->line('note');
            $col['name'] = "remark";
            $col['editable'] = true;
            $col['edittype'] = "textarea";
            $col['editoptions'] = array("rows" => "2", "cols" => "20");
            $cols[] = $col;

            $e["on_insert"] = array(
                "add_client",
                null,
                true);

            #$e["on_delete"] = array("del_client", null, true);

            $g->set_events($e);

            $g->select_command = "SELECT
	customer_id,cus.customer_type_id,cus_type.customer_type_title,cus.factory_id,customers_name,address1,address2,contact_person,mobile_number,remark
FROM
	transport_customers AS cus
LEFT JOIN transport_factory AS fac ON (cus.factory_id = fac.factory_id)
LEFT JOIN transport_customer_type AS cus_type ON(cus.customer_type_id=cus_type.customer_type_id) WHERE cus.status=1 AND cus.customer_type_id=1";


            function add_client(&$data)
            {
                $check_sql = "SELECT count(*) as c from transport_customers where LOWER(`customers_name`) = '" .
                    strtolower($data["params"]["customers_name"]) . "'";

                $rs = mysql_fetch_assoc(mysql_query($check_sql));

                if ($rs["c"] > 0)
                {
                    phpgrid_error("ข้อมูลลูกค้าซ้ำ");
                }


            } // end of sub function

            function del_client(&$data)
            {
                $check_sql = "UPDATE `transport_customers` SET `status`='0' WHERE (`customer_id`='{$data["id"]}')";

                mysql_query($check_sql);


            }


            //Use Table
            $g->table = "transport_customers";

            // pass the cooked columns to grid

            $g->set_columns($cols);

            $opt["sortname"] = 'customer_id';
            $opt["sortorder"] = "desc";
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

            $h2_title = $this->lang->line('customers_list');

            //display
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out_index,
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
