<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Carservice extends CI_Controller
{

    private $main_menu;

    public function __construct()
    {

        parent::__construct();
        $this->load->library('jqgridnow_lib');

        $this->lang->load('thai');

        $this->load->model('Mainmenu_model', 'mainmenu');

        $this->load->model('income_model', 'getdrop');


        $this->load->library('grocery_CRUD');

    }

    public function _example_output($output = null)
    {
        //$this->load->view('income',$output);
        $this->load->view('carservice-view', $output);
    }


    public function index()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'income'))
            {

                $grid = new jqgrid();
                $opt["caption"] = $this->lang->line('factory');
                $opt["detail_grid_id"] = "list2";
                
                $opt["autowidth"] = true;
                // extra params passed to detail grid, column name comma separated
                //$opt["subgridparams"] = "factory_id,factory_code,factory_name";
                $opt["subgridparams"] = "factory_id,factory_code,factory_name";
                $opt["export"] = array(
                    "filename" => "my-file",
                    "sheetname" => "test",
                    "format" => "pdf");
                $opt["export"]["range"] = "filtered";
                $grid->set_options($opt);

                $grid->table = "transport_factory";

                $col = array();
                $col["title"] = $this->lang->line('id'); // caption of column
                $col["name"] = "factory_id"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "10";
                $col['hidden'] = true;
                $col["editable"] = false;
                $cols[] = $col;

                $col = array();
                $col['title'] = $this->lang->line('factory_code');
                $col['name'] = "factory_code";
                $col["width"] = "35";
                $col["editable"] = false;
                $cols[] = $col;
                
                $col = array();
                $col['title'] = $this->lang->line('factory_name');
                $col['name'] = "factory_name";                
                $col["editable"] = false;
                $cols[] = $col;

                $grid->set_columns($cols);

                $grid->set_actions(array(
                    "add" => false, // allow/disallow add
                    "edit" => false, // allow/disallow edit
                    "delete" => false, // allow/disallow delete
                    "rowactions" => false, // show/hide row wise edit/del/save option
                    "autofilter" => true, // show/hide autofilter for search
                    "search" => "advance"
                        // show single/multi field search condition (e.g. simple or advance)
                        ));

                $out_master = $grid->render("list1");

                // detail grid
                $grid = new jqgrid();

                $opt = array();
                $opt["sortname"] = 'id'; // by default sort grid by this field
                $opt["sortorder"] = "desc"; // ASC or DESC
                $opt["height"] = 400; // autofit height of subgrid
                $opt["rowNum"] = 10; // by default 20
                $opt['rowList'] = array(
                    10,
                    20,
                    30,
                    100);
                $opt["autowidth"] = true;
                $opt["caption"] = $this->lang->line('expense_list');
                $opt["multiselect"] = true;
                $opt['height'] = '350';
                //footer
                $opt["footerrow"] = true;
                $opt["reloadedit"] = true;

                $opt["export"] = array(
                    "filename" => "my-file",
                    "sheetname" => "test",
                    "format" => "pdf"); // export to excel parameters
                $opt["export"]["range"] = "filtered";
                // Check if master record is selected before detail addition
                $opt["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('Please select master record first'); return false; } }";
                
                
                
                
                $opt["add_options"] = array(
                    "recreateForm" => true,
                    "closeAfterEdit" => true,
                    'width' => '320');
                $opt["edit_options"] = array(
                    "recreateForm" => true,
                    "closeAfterEdit" => true,
                    'width' => '320');
                $opt["add_options"]["topinfo"] = "บันทึกรายการซ่อม";
                //$opt["add_options"]["bottominfo"] = "This text is dialog footer text";

                $opt["form"]["position"] = "left";
                $opt["add_options"]["afterShowForm"] =
                'function(formid) { jQuery("#ref_number").focus(); }';

                $grid->set_options($opt);
                

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


                // $id = intval($_GET["rowid"]);
                //$factory_code = $_GET["factory_code"];
                //$company = $_GET["factory_name"];
                //$cid = intval($_GET["factory_id"]);

                if (!empty($_REQUEST))
                {
                    $id = intval($_GET["rowid"]);
                    $factory_code = $_GET["factory_code"];
                    $company = $_GET["factory_name"];
                    $cid = intval($_GET["factory_id"]);

                    $this->session->set_userdata('facs_id', $cid);
                }

                $fac_id = $this->session->userdata('facs_id');


                // for non-int fields as PK
                // $id = (empty($_GET["rowid"])?0:$_GET["rowid"]);

                $grid->select_command = "SELECT
	id,
	expense_date,
	factory_id,
	expense.car_id,
	car_number,
	ref_number,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id = $fac_id
	) AS sumtotals
FROM
	`expense`
LEFT JOIN transport_cars ON(expense.car_id=transport_cars.car_id)
WHERE
	factory_id = $fac_id AND expense.car_id !=0";

                //$grid->table = "invheader";
                $grid->table = "expense";


                $col = array();
                $col["title"] = $this->lang->line('id'); // caption of column
                $col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col['hidden'] = true;
                $cols2[] = $col;

                $col = array();
                $col["title"] = $this->lang->line('date');
                $col["name"] = "expense_date";
                $col["width"] = "20";                
                $col["resizable"] = false;
                $col["editable"] = true; // this column is editable
                $col["editoptions"] = array("size" => 20, "defaultValue" => date('Y-m-d')); // with default display of textbox with size 20
                $col["editrules"] = array("required" => true); // and is required
                # format as date
                $col["formatter"] = "date";
                # opts array can have these options: http://api.jqueryui.com/datepicker/
                $col["formatoptions"] = array(
                    "srcformat" => 'Y-m-d',
                    "newformat" => 'd-m-Y',
                    "opts" => array("changeYear" => false));
                $cols2[] = $col;
                
                //car
                $col = array();
                $col["title"] = $this->lang->line('car_number');
                $col["name"] = "car_id";
                $col["dbname"] = "transport_cars.car_number"; // this is required as we need to search in name field, not id
                $col["width"] = "20";
                $col["align"] = "center";
                $col["search"] = true;
                $col["editable"] = true;
                $col["edittype"] = "select"; // render as select
                # fetch data from database, with alias k for key, v for value
                //$str = $g->get_dropdown_values("select distinct client_id as k, name as v from clients");
                $str = $this->getdrop->grid_dropdown("SELECT distinct car_id AS k,car_number AS v FROM `transport_cars`");
                $col["editoptions"] = array("value" => $str);
                $col["formatter"] = "select"; // display label, not value
                $cols2[] = $col;
                
                #ref_number
                /*
                $col = array();
                $col["title"] = $this->lang->line('reference_number'); // caption of column
                $col["name"] = "ref_number"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col["editable"] = true;
                $cols2[] = $col;
                */
                # Detail
                $col = array();
                $col["title"] = $this->lang->line('desc'); // caption of column
                $col["name"] = "expense_details"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "70";
                $col['edittype'] = "textarea";
                $col['editoptions'] = array("rows" => '2', "cols" => '50');
                $col["editrules"] = array("required" => true);
                $col["editable"] = true;
                $col["formatter"] = "autocomplete"; // autocomplete
                $col["formatoptions"] = array(
                "sql" => "SELECT DISTINCT expense_details as k, expense_details as v FROM expense",
                "search_on" => "expense_details",
                "update_field" => "expense_details");
                $cols2[] = $col;
                

                # Total Amount
                $col = array();
                $col["title"] = $this->lang->line('amount');
                $col["name"] = "total_amount";
                $col["width"] = "20";
                $col['align'] = "right";
                $col['formatter'] = "currency";
                $col["formatoptions"] = array(
                    "prefix" => "",
                    "suffix" => '',
                    "thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => '2');
                $col["editable"] = true; // this column is editable
                $col["editoptions"] = array("size" => 20); // with default display of textbox with size 20
                $col["editrules"] = array("required" => true, "number" => true); // and is required
                $cols2[] = $col;
                
                #Note Remark
                $col = array();
                $col["title"] = $this->lang->line('note'); // caption of column
                $col["name"] = "note"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col['edittype'] = "textarea";
                $col['editoptions'] = array("rows" => '2', "cols" => '20');
                $col["editable"] = true;
                $col["formatter"] = "autocomplete"; // autocomplete
                $col["formatoptions"] = array(
                "sql" => "SELECT DISTINCT note as k, note as v FROM expense",
                "search_on" => "note",
                "update_field" => "note");
                $cols2[] = $col;


                # Render set columns
                $grid->set_columns($cols2);


                $e["js_on_load_complete"] = "grid2_onload";
                $e["on_insert"] = array(
                    "add_client",
                    null,
                    true);
                $grid->set_events($e);

                function add_client(&$data)
                {

                    $id = intval($_GET["rowid"]);
                    $data["params"]["factory_id"] = $id;
                }

                // generate grid output, with unique grid name as 'list1'
                $out_detail = $grid->render("list2");

                // Head Title
                $h2_title = $this->lang->line('car_service');

                $this->_example_output((object)array(
                    'output' => '',
                    'out_detail' => $out_detail,
                    'out_master' => $out_master,
                    'js_files' => array(),
                    'css_files' => array(),
                    'h2_title' => $h2_title));

            } else
            {
                $this->_example_output();
            } //end if


        } else
        {
            redirect('login', 'refresh');
        }

    } // End of Function index


    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //session_destroy();
        redirect('bootstrap', 'refresh');
    }


} // end of class
