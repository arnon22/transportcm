<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Expense2 extends CI_Controller
{

    private $main_menu;

    public function __construct()
    {

        parent::__construct();
        $this->load->library('jqgridnow_lib');

        $this->lang->load('thai');

        $this->load->model('Mainmenu_model', 'mainmenu');

        $this->load->model('income_model', 'getdrop');


    }

    public function _example_output($output = null)
    {
        //$this->load->view('income',$output);
        $this->load->view('expense2', $output);
    }


    public function index()
    {

        //check login
        if ($this->session->userdata('user_name'))
        {

            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'income'))
            {

                $g = new jqgrid();
                $opt["caption"] = $this->lang->line('factory');
                $opt["detail_grid_id"] = "list2";

                $opt['autowidth'] = true;
                $opt['height'] = "60";
                // extra params passed to detail grid, column name comma separated
                //$opt["subgridparams"] = "client_id,gender,company";
                $opt["subgridparams"] = "factory_id,factory_code,factory_name";
                $opt["export"]["range"] = "filtered";
                $g->set_options($opt);
                $g->table = "transport_factory";

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

                $col["editable"] = false;
                $cols[] = $col;

                $col = array();
                $col['title'] = $this->lang->line('factory_name');
                $col['name'] = "factory_name";
                //$col["width"] = "10";
                $col["editable"] = false;
                $cols[] = $col;

                $g->set_columns($cols);

                $g->set_actions(array(
                    "add" => false, // allow/disallow add
                    "edit" => false, // allow/disallow edit
                    "delete" => false, // allow/disallow delete
                    "rowactions" => false, // show/hide row wise edit/del/save option
                    "autofilter" => false, // show/hide autofilter for search
                    "search" => "advance"
                        // show single/multi field search condition (e.g. simple or advance)
                        ));

                $out_master = $g->render("list1");

                // detail grid
                $grid = new jqgrid();

                $opt = array();
                $opt["sortname"] = 'id'; // by default sort grid by this field
                $opt["sortorder"] = "desc"; // ASC or DESC
                $opt["height"] = 300; // autofit height of subgrid
                $opt["rowNum"] = 10; // by default 20
                $opt['rowList'] = array(
                    10,
                    20,
                    30,
                    100,
                    1000);
                $opt["autowidth"] = true;
                $opt['form']['position'] = "left";
                $opt['form']['nav'] = true;
                $opt["caption"] = $this->lang->line('expense_list'); // caption of grid
                $opt["multiselect"] = false; // allow you to multi-select through checkboxes
                //footer
                $opt["footerrow"] = true;
                $opt["reloadedit"] = true;


                // Check if master record is selected before detail addition
                $opt["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('Please select master record first'); return false; } }";
                $opt["add_options"]["afterShowForm"] =
                    'function(formid) { jQuery("#ref_number").focus(); }';

                // excel visual params
               // $opt["cellEdit"] = true; // inline cell editing, like spreadsheet
                $opt["rownumbers"] = true;
                $opt["rownumWidth"] = 30;


                $grid->set_options($opt);

                // disable all dialogs except edit
                $grid->navgrid["param"]["edit"] = false;
                $grid->navgrid["param"]["add"] = false;
                $grid->navgrid["param"]["del"] = false;
                $grid->navgrid["param"]["search"] = false;
                $grid->navgrid["param"]["refresh"] = true;

                $grid->set_actions(array(
                    "add" => $this->cizacl->check_isAllowed($i_rule, 'expense', 'add_expense'), // allow/disallow add
                    "edit" => $this->cizacl->check_isAllowed($i_rule, 'expense', 'edit_expense'), // allow/disallow edit
                    "delete" => $this->cizacl->check_isAllowed($i_rule, 'expense', 'del_expense'), // allow/disallow delete
                    "rowactions" => true, // show/hide row wise edit/del/save option
                    "export" => false, // show/hide export to excel option
                    "autofilter" => true, // show/hide autofilter for search
                    "search" => "advance"
                        // show single/multi field search condition (e.g. simple or advance)
                        ));


                // enable inline editing buttons
                $grid->set_actions(array("inline" => true, "rowactions" => true));

                // set database table for CRUD operations

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

                // and use in sql for filteration
                //$grid->select_command = "SELECT id,client_id,invdate,amount,tax,total,'$company' as 'company' FROM invheader WHERE client_id = $cid";
                //$grid->select_command = "SELECT id,income_date,factory_id,ref_number,total_amount,note FROM `income` WHERE factory_id=$cid";

                //$grid->select_command = "SELECT id,expense_date,factory_id,car_id,ref_number,expense_details,total_amount,	note,(SELECT SUM(total_amount)FROM	expense WHERE factory_id = $cid	) AS sumtotals FROM	`expense`WHERE	factory_id = $cid";
                // this db table will be used for add,edit,delete
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
	factory_id = $fac_id AND expense.car_id=0";

                //$grid->table = "invheader";
                $grid->table = "expense";

                #ID
                $col = array();
                $col["title"] = $this->lang->line('id'); // caption of column
                $col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col['hidden'] = true;
                $cols2[] = $col;

                #Expanse date
                $col = array();
                $col["title"] = $this->lang->line('date');
                $col["name"] = "expense_date";
                $col["width"] = "20";
                $col["editable"] = true; // this column is editable
                //$col["editoptions"] = array("size" => 20, "defaultValue" => date('d-m-Y')); // with default display of textbox with size 20
                $col["editoptions"] = array("size" => 20); // with default display of textbox with size 20
                $col["editrules"] = array("required" => true); // and is required
                # format as date
                $col["formatter"] = "date";
                # opts array can have these options: http://api.jqueryui.com/datepicker/
                $col["formatoptions"] = array(
                    "srcformat" => 'Y-m-d',
                    "newformat" => 'd-m-Y',
                    "opts" => array("changeYear" => false));
                $cols2[] = $col;

                /*
                $col = array();
                $col["title"] = $this->lang->line('reference_number'); // caption of column
                $col["name"] = "ref_number"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col["editable"] = true;
                $cols2[] = $col;
                */
                # Descriptionns
                $col = array();
                $col["title"] = $this->lang->line('desc'); // caption of column
                $col["name"] = "expense_details"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "100";
                $col['edittype'] = "textarea";
                $col['editoptions'] = array("rows" => '2', "cols" => '60');
                $col["editrules"] = array("required" => true);
                #$col["formatter"] = "autocomplete"; // autocomplete
                /*
                $col["formatoptions"] = array(
                "sql" => "SELECT DISTINCT expense_details as k, expense_details as v FROM expense",
                "search_on" => "expense_details",
                "update_field" => "expense_details");
                */

                $col["editable"] = true;

                $cols2[] = $col;


                $col = array();
                $col["title"] = $this->lang->line('amount');
                $col["name"] = "total_amount";
                $col["width"] = "30";
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

                #Not Remarl
                $col = array();
                $col["title"] = $this->lang->line('note'); // caption of column
                $col["name"] = "note"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "40";
                $col['edittype'] = "textarea";
                $col['editoptions'] = array("rows" => '2', "cols" => '20');
                $col["editable"] = true;
                /*
                $col["formatter"] = "autocomplete"; // autocomplete
                $col["formatoptions"] = array(
                "sql" => "SELECT DISTINCT note as k, note as v FROM expense",
                "search_on" => "note",
                "update_field" => "note");
                */
                $cols2[] = $col;


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
                    $data["params"]["car_id"] = 0;
                }

                // generate grid output, with unique grid name as 'list1'
                $out_detail = $grid->render("list2");

                // Head Title
                $h2_title = $this->lang->line('expense');

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


} // End of Class
