<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Setting extends CI_Controller
{

    private $main_menu;

    public function __construct()
    {

        parent::__construct();

        $this->lang->load('thai');

        $this->load->model('income_model', 'income');
        $this->load->model('dropdown_model', 'dropdown');
        $this->load->library("jqgridnow_lib");


        $this->lang->load('cizacl', $this->config->item('language'));
        if (!class_exists('CI_cizacl'))
            show_error($this->lang->line('library_not_loaded'));
        $this->load->model('cizacl_mdl');


    }

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('setting', $output);
    }


    public function index()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            // Grid
            $this->load->library("jqgridnow_lib");

            $g = new jqgrid();

            $col = array();
            $col["title"] = $this->lang->line('id'); // caption of column
            $col["name"] = "factory_id";
            $col["width"] = "10";
            $col["search"] = false;
            $col["editable"] = false;
            $col["hidden"] = true;
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('factory_name');
            $col['name'] = "factory_name";
            $col['width'] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('factory_code');
            $col['name'] = "factory_code";
            $col['width'] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('factory_note');
            $col['name'] = "factory_note";
            $col['width'] = "40";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;


            //properties grid
            $grid["sortname"] = 'factory_id';
            $grid["sortorder"] = "desc";
            $grid["caption"] = $this->lang->line('factory_setting');
            $grid["autowidth"] = true;
            $grid["multiselect"] = false;

            $grid["rownumbers"] = true;

            $g->set_options($grid);

            $g->select_command = "SELECT
	factory_id,
	factory_name,
	factory_code,
	factory_note,
	factory_status,
	status_name
FROM
	transport_factory AS fac
LEFT JOIN allstatus AS st ON (fac.factory_status = st.id)
WHERE
	factory_status = 1";

            $g->set_columns($cols);


            $e["on_delete"] = array(
                "delete_factory",
                null,
                true);

            $g->set_events($e);

            function delete_factory($data)
            {

                $str_ch = "UPDATE transport_factory SET factory_status ='0' WHERE (factory_id ='{$data["factory_id"]}')";

                phpgrid_error($str_ch);

                //mysql_query($str_ch);
            }


            $g->table = "transport_factory";

            // render grid and get html/js output
            $out_index = $g->render("list1");


            //display
            $this->_example_output((object)array('output' => '', 'out' => $out_index));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        } // end if


    } // End of Function index


    public function company_info()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            // Grid
            $this->load->library("jqgridnow_lib");

            $g = new jqgrid();

            $col = array();
            $col["title"] = $this->lang->line('id'); // caption of column
            $col["name"] = "company_id";
            $col["width"] = "10";
            $col["search"] = false;
            $col['editable'] = true;
            $col["hidden"] = true;
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_name');
            $col['name'] = "company_name";
            $col['width'] = "30";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_address1');
            $col['name'] = "company_address1";
            $col['width'] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["edittype"] = "textarea";
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_address2');
            $col['name'] = "company_address2";
            $col['width'] = "20";
            $col['search'] = true;
            $col['editable'] = true;
            $col["edittype"] = "textarea";
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_province');
            $col['name'] = "company_province";
            $col['width'] = "20";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_postcode');
            $col['name'] = "company_postcode";
            $col['width'] = "20";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;

            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_tel');
            $col['name'] = "company_tel";
            $col['width'] = "20";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;

            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_fax');
            $col['name'] = "company_fax";
            $col['width'] = "20";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;

            $cols[] = $col;

            $col = array();
            $col['title'] = $this->lang->line('company_tax_id10');
            $col['name'] = "company_tax_id";
            $col['width'] = "40";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit

            $cols[] = $col;


            //properties grid
            $grid["sortname"] = 'company_id';
            $grid["sortorder"] = "desc";
            $grid["caption"] = $this->lang->line('factory_setting');
            $grid["autowidth"] = true;
            $grid["multiselect"] = false;

            $grid["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $grid["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
                
            $grid["rownumbers"] = true;    

            $g->set_options($grid);


            $g->table = "transport_company_info";

            $g->set_columns($cols);

            // render grid and get html/js output
            $out_index = $g->render("list1");


            //display
            $this->_example_output((object)array('output' => '', 'out' => $out_index));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        } // end if


    }


    public function cars()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            // Grid
            $this->load->library("jqgridnow_lib");

            $g = new jqgrid();

            $col = array();
            $col['title'] = $this->lang->line('id');
            $col['name'] = "car_id";
            $col["width"] = "10";
            $col["search"] = false;
            $col['editable'] = true;
            $col["hidden"] = true;
            $cols[] = $col;

            //car_license
            $col = array();
            $col['title'] = $this->lang->line('car_license');
            $col['name'] = "car_license";
            $col['width'] = "45";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            //car_number
            $col = array();
            $col['title'] = $this->lang->line('car_number');
            $col['name'] = "car_number";
            $col['width'] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col['editrules'] = array("required" => true);
            $cols[] = $col;

            // Car typr
            #car
            $col = array();
            $col["title"] = $this->lang->line('car_type');
            $col['name'] = "car_type_id";
            $col['dbname'] = "car_type.car_type_name";
            $col['width'] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col['edittype'] = "select";
            $str = $this->dropdown->get_cartype_dropdown();
            $col['editoptions'] = array("value" => $str);
            $col['formatter'] = "select";
            $cols[] = $col;

            //note
            $col = array();
            $col['title'] = $this->lang->line('factory_note');
            $col['name'] = "note";
            $col['width'] = "60";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;


            //properties grid
            $grid["sortname"] = 'car_id';
            $grid["sortorder"] = "desc";
            $grid["caption"] = $this->lang->line('car_setting');
            $grid["autowidth"] = true;
            $grid["multiselect"] = false;
            $grid["rownumbers"] = true;

            $g->set_options($grid);


            $g->select_command =
                "SELECT car_id,car_license,car_number,car.car_type_id,car_type.car_type_name,note FROM `transport_cars` AS car
LEFT JOIN transport_car_type AS car_type ON(car.car_type_id=car_type.car_type_id)";

            // set database table for CRUD operations
            $g->table = "transport_cars";

            $g->set_columns($cols);

            // render grid and get html/js output
            $out_index = $g->render("list1");


            //display
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out_index,
                'js_files' => array(),
                'css_files' => array()));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        } // end if


    } // End of Function cars

    public function drivers()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            // Grid
            $this->load->library("jqgridnow_lib");

            $g = new jqgrid();

            //properties grid
            $grid["sortname"] = 'driver_id';
            $grid["sortorder"] = "desc";
            $grid["caption"] = $this->lang->line('driver_setting');
            $grid["autowidth"] = true;
            $grid["multiselect"] = false;
            $grid["rownumbers"] = true;

            $grid["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');
            $grid["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '420');

            $g->set_options($grid);

            //id
            $col = array();
            $col['title'] = $this->lang->line('id');
            $col['name'] = "driver_id";
            $col["width"] = "20";
            $col["search"] = false;
            $col['editable'] = true;
            $col["hidden"] = true;
            $cols[] = $col;

            // driver name
            $col = array();
            $col['title'] = $this->lang->line('driver_name');
            $col['name'] = "driver_name";
            $col["width"] = "50";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            // citizen_number
            $col = array();
            $col['title'] = $this->lang->line('citizen_number');
            $col['name'] = "citizen_number";
            $col["width"] = "45";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            // driver name
            $col = array();
            $col["title"] = $this->lang->line('factory');
            $col["name"] = "factory_id";
            $col["dbname"] = "fac.factory_code"; // this is required as we need to search in name field, not id
            $col["width"] = "30";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            //$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
            $str = $this->income->get_factory_dropdown();
            $col["editoptions"] = array("value" => $str);
            $col["formatter"] = "select"; // display label, not value
            $cols[] = $col;


            // Car
            $col = array();
            $col["title"] = $this->lang->line('car');
            $col["name"] = "car_id";
            $col["dbname"] = "cars.car_number"; // this is required as we need to search in name field, not id
            $col["width"] = "30";
            $col["align"] = "left";
            $col["search"] = true;
            $col["editable"] = true;
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            //$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
            $str = $this->dropdown->get_car_dropdown();
            $col["editoptions"] = array("value" => $str);
            $col["formatter"] = "select"; // display label, not value
            $cols[] = $col;

            //address1
            $col = array();
            $col['title'] = $this->lang->line('address1');
            $col['name'] = "address1";
            $col['width'] = "80";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;

            // phone_number
            $col = array();
            $col['title'] = $this->lang->line('phone_number');
            $col['name'] = "phone";
            $col["width"] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            //note
            $col = array();
            $col['title'] = $this->lang->line('note');
            $col['name'] = "note";
            $col['width'] = "40";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;

            $col = array();
            $col["title"] = $this->lang->line('status');
            $col["name"] = "driver_status";
            $col["dbname"] = "d_status.status_description"; // this is required as we need to search in name field, not id
            $col["width"] = "30";
            $col["align"] = "left";
            $col["search"] = false;
            $col["editable"] = true;
            $col["edittype"] = "select"; // render as select
            # fetch data from database, with alias k for key, v for value
            //$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
            $str = $this->dropdown->get_status();
            $col["editoptions"] = array("value" => $str);
            $col["formatter"] = "select"; // display label, not value
            $cols[] = $col;


            // Commond
            $g->select_command =
                "SELECT driver_id,driver_name,drivers.factory_id,fac.factory_code,citizen_number,drivers.car_id,cars.car_number,address1,phone,drivers.note,driver_status,d_status.status_description FROM `driver` AS drivers
LEFT JOIN transport_cars AS cars ON(drivers.car_id=cars.car_id)
LEFT JOIN transport_factory AS fac ON(drivers.factory_id=fac.factory_id)
LEFT JOIN driver_status AS d_status ON (drivers.driver_status=d_status.id)";

            // set database table for CRUD operations
            $g->table = "driver";

            $g->set_columns($cols);

            // render grid and get html/js output
            $out_index = $g->render("list1");


            //display
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out_index,
                'js_files' => array(),
                'css_files' => array()));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        } // end if


    } // End of Function Drivers


    public function cubic()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            // Grid
            $this->load->library("jqgridnow_lib");

            $g = new jqgrid();

            //id
            $col = array();
            $col['title'] = $this->lang->line('id');
            $col['name'] = "cubic_id";
            $col["width"] = "10";
            $col["search"] = false;
            $col["editable"] = true;
            $col["hidden"] = true;
            $cols[] = $col;

            // Cubic Code
            $col = array();
            $col['title'] = $this->lang->line('cubic_code');
            $col['name'] = "cubic_code";
            $col["width"] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            // cubic Value
            $col = array();
            $col['title'] = $this->lang->line('cubic_value');
            $col['name'] = "cubic_value";
            $col["width"] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true, "number" => true);
            $cols[] = $col;

            //note
            $col = array();
            $col['title'] = $this->lang->line('factory_note');
            $col['name'] = "cubic_note";
            $col['width'] = "60";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;


            //properties grid
            $grid["sortname"] = 'cubic_value';
            $grid["sortorder"] = "asc";
            $grid["caption"] = $this->lang->line('cubic_h2_title');
            $grid["autowidth"] = true;
            $grid["multiselect"] = false;
            $grid["rownumbers"] = true;
            $grid["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420'); 
            $grid["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420'); 
            
            
            $g->set_options($grid);
            
            $g->set_actions(array(     
                        "add"=>true, // allow/disallow add 
                        "edit"=>true, // allow/disallow edit 
                        "delete"=>false, // allow/disallow delete 
                        "rowactions"=>true, // show/hide row wise edit/del/save option 
                        "autofilter" => true, // show/hide autofilter for search 
                    )  
                ); 


            $g->select_command =
                "SELECT cubic_id,cubic_code,cubic_value,cubic_note,cub.cubic_status,alls.status_name FROM transport_cubiccode AS cub
LEFT JOIN allstatus as alls ON (cub.cubic_status=alls.id)";

            // set database table for CRUD operations
            $g->table = "transport_cubiccode";

            $g->set_columns($cols);

            // render grid and get html/js output
            $out_index = $g->render("list1");

            //display
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out_index,
                'js_files' => array(),
                'css_files' => array()));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        } // end if


    } // End of Function Cubic


    public function distance()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            // Grid
            $this->load->library("jqgridnow_lib");

            $g = new jqgrid();

            //properties grid
            $grid["sortname"] = 'range_min';
            $grid["sortorder"] = "ASC";
            $grid["caption"] = $this->lang->line('distance_setting');
            $grid["autowidth"] = true;
            $grid["multiselect"] = false;
            $grid["rownumbers"] = true;
            $grid["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420'); 
            $grid["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'420');
            
            
            $g->set_options($grid);

            //id
            $col = array();
            $col['title'] = $this->lang->line('id');
            $col['name'] = "distance_id";
            $col["width"] = "10";
            $col["search"] = false;
            $col["editable"] = true;
            $col["hidden"] = true;
            $cols[] = $col;

            // Distance
            $col = array();
            $col['title'] = $this->lang->line('distance_code');
            $col['name'] = "distance_code";
            $col["width"] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            // cubic Value
            $col = array();
            $col['title'] = $this->lang->line('range_min');
            $col['name'] = "range_min";
            $col["width"] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true, "number" => true);
            $cols[] = $col;

            // cubic Value
            $col = array();
            $col['title'] = $this->lang->line('range_max');
            $col['name'] = "range_max";
            $col["width"] = "40";
            $col['search'] = true;
            $col['editable'] = true;
            $col["editrules"] = array("required" => true, "number" => true);
            $cols[] = $col;

            //note
            $col = array();
            $col['title'] = $this->lang->line('factory_note');
            $col['name'] = "distance_name";
            $col['width'] = "60";
            $col["sortable"] = false; // this column is not sortable
            $col["search"] = false; // this column is not searchable
            $col["editable"] = true;
            $col["edittype"] = "textarea"; // render as textarea on edit
            $col["editoptions"] = array("rows" => 2, "cols" => 30); // with these attributes
            $cols[] = $col;
            
            $g->set_actions(array(     
                        "add"=>true, // allow/disallow add 
                        "edit"=>true, // allow/disallow edit 
                        "delete"=>false, // allow/disallow delete 
                        "rowactions"=>true, // show/hide row wise edit/del/save option 
                        "autofilter" => true, // show/hide autofilter for search 
                    )  
                );

            $g->select_command =
                "SELECT distance_id,distance_code,range_min,range_max,distance_name FROM distancecode";

            // set database table for CRUD operations
            $g->table = "distancecode";

            $g->set_columns($cols);
            // render grid and get html/js output
            $out_index = $g->render("list1");


            //display
            $this->_example_output((object)array(
                'output' => '',
                'out' => $out_index,
                'js_files' => array(),
                'css_files' => array()));


        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        } // end if


    } // End of Function distance


    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //session_destroy();
        redirect('bootstrap', 'refresh');
    }


} // end of class
