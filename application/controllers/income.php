<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');


class Income extends CI_Controller
{

    private $main_menu;

    public function __construct()
    {

        parent::__construct();
        $this->load->library('jqgridnow_lib');

        $this->lang->load('thai');

        $this->load->model('Mainmenu_model', 'mainmenu');

        $this->load->model('order_model', 'order');
        $this->load->model('factory_model', 'factory');
        $this->load->model('customers_model', 'customer');
        $this->load->model('distance_model', 'distance');
        $this->load->model('cubiccode_model', 'cubic');
        $this->load->model('cardriver_model', 'cars');
        $this->load->model('income_model');


        $this->load->library("pagination");
        $this->main_menu = $this->mainmenu->Mainmenu_list();

        //$this->session->set_userdata($this->main_menu);


        // $this->load->library('grocery_CRUD');

        $this->lang->load('cizacl', $this->config->item('language'));
        if (!class_exists('CI_cizacl'))
            show_error($this->lang->line('library_not_loaded'));
        $this->load->model('cizacl_mdl');

    }

    public function _example_output($output = null)
    {
        //$this->load->view('income',$output);
        $this->load->view('income', $output);
    }

    public function is_logged_in()
    {
        $user = $this->session->userdata('user_name');
        return isset($user);
    }


    public function index()
    {
        //echo $this->session->userdata('user_id');

        if ($this->session->userdata('user_name'))
        {


            $i_rule = $this->session->userdata('user_cizacl_role_id');

            if ($this->cizacl->check_isAllowed($i_rule, 'income', 'index'))
            {
                // master grid
                $grid = new jqgrid();
                $opt["caption"] = $this->lang->line('factory');
                // following params will enable subgrid -- by default first column (PK) of parent is passed as param 'id'
                $opt["detail_grid_id"] = "list2";
                //$opt['width'] = 300;
                $opt['autowidth'] = true;
                $opt['height'] = "60";
                // extra params passed to detail grid, column name comma separated
                //$opt["subgridparams"] = "client_id,gender,company";
                $opt["subgridparams"] = "factory_id,factory_code,factory_name";

                #set Grid Option
                $grid->set_options($opt);

                $grid->select_command =
                    "SELECT * FROM transport_factory WHERE factory_status =1";

                #Select table
                $grid->table = "transport_factory";

                /*Define Column*/
                #ID
                $col = array();
                $col["title"] = $this->lang->line('id'); // caption of column
                $col["name"] = "factory_id"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "10";
                $col["editable"] = false;
                $col['hidden'] = true;
                $cols[] = $col;
                #Factory code
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

                $grid->set_columns($cols);

                $grid->set_actions(array(
                    "add" => false, // allow/disallow add
                    "edit" => false, // allow/disallow edit
                    "delete" => false, // allow/disallow delete
                    "rowactions" => false, // show/hide row wise edit/del/save option
                    "autofilter" => false // show/hide autofilter for search

                    // show single/multi field search condition (e.g. simple or advance)
                    ));
                //Display master
                $out_master = $grid->render("list1");

                // detail grid
                $grid = new jqgrid();

                $opt = array();
                $opt["sortname"] = 'income_date'; // by default sort grid by this field
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
                $opt["caption"] = $this->lang->line('income_invoice'); // caption of grid
                //$opt["multiselect"] = true; // allow you to multi-select through checkboxes
                //footer
                $opt["footerrow"] = true;
                $opt["reloadedit"] = true;


                // Check if master record is selected before detail addition
                $opt["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('Please select master record first'); return false; } }";

                $opt["add_options"] = array(
                    "recreateForm" => true,
                    "closeAfterEdit" => true,
                    'width' => '420');
                $opt["edit_options"] = array(
                    "recreateForm" => true,
                    "closeAfterEdit" => true,
                    'width' => '420');
                $opt["add_options"]["topinfo"] = $this->lang->line('income_title_from_add');
                $opt["add_options"]["bottominfo"] = $this->lang->line('remark_numberic');
                $opt["add_options"]["afterShowForm"] =
                    'function(formid) { jQuery("#ref_number").focus(); }';
                $opt["form"]["position"] = "left";
                $opt["form"]["nav"] = true;
                $opt["multiselect"] = false;
                $opt["rownumbers"] = true;
                // disable all dialogs except edit
                $grid->navgrid["param"]["edit"] = false;
                $grid->navgrid["param"]["add"] = false;
                $grid->navgrid["param"]["del"] = false;
                $grid->navgrid["param"]["search"] = false;
                $grid->navgrid["param"]["refresh"] = true;

                // enable inline editing buttons
                $grid->set_actions(array("inline" => true, "rowactions" => true));

                // Properties Grids
                $grid->set_options($opt);

                $grid->set_actions(array(
                    "add" => $this->cizacl->check_isAllowed($i_rule, 'income', 'add'), // allow/disallow add
                    "edit" => $this->cizacl->check_isAllowed($i_rule, 'income', 'edit'), // allow/disallow edit
                    "delete" => $this->cizacl->check_isAllowed($i_rule, 'income', 'delete'), // allow/disallow delete
                    "rowactions" => true, // show/hide row wise edit/del/save option
                    "export" => false, // show/hide export to excel option
                    "autofilter" => true, // show/hide autofilter for search
                    "search" => "advance"
                        // show single/multi field search condition (e.g. simple or advance)
                        ));


                $id = intval($_GET["rowid"]);
                $factory_code = $_GET["factory_code"];
                $company = $_GET["factory_name"];
                $cid = intval($_GET["factory_id"]);

                // for non-int fields as PK
                // $id = (empty($_GET["rowid"])?0:$_GET["rowid"]);

                // and use in sql for filteration
                //$grid->select_command = "SELECT id,client_id,invdate,amount,tax,total,'$company' as 'company' FROM invheader WHERE client_id = $cid";
                //$grid->select_command = "SELECT id,income_date,factory_id,ref_number,total_amount,note FROM `income` WHERE factory_id=$cid";

                $grid->select_command =
                    "SELECT id,income_date,factory_id,ref_number,income_details,total_amount,note,(SELECT SUM(total_amount)FROM	income WHERE factory_id = $cid	) AS table_total FROM	`income`WHERE	factory_id = $cid";
                // this db table will be used for add,edit,delete
                //Select database
                $grid->table = "income";

                /*Define column*/
                #id
                $col = array();
                $col["title"] = $this->lang->line('id'); // caption of column
                $col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col['hidden'] = true;
                $cols2[] = $col;

                #DATE
                $col = array();
                $col["title"] = $this->lang->line('date');
                $col["name"] = "income_date";
                $col["width"] = "50";
                $col["editable"] = true; // this column is editable
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

                # Reference Number
                $col = array();
                $col["title"] = $this->lang->line('reference_number'); // caption of column
                $col["name"] = "ref_number"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "30";
                $col["editable"] = true;
                $col['hidden'] = true;
                $cols2[] = $col;

                # Detail
                $col = array();
                $col["title"] = $this->lang->line('desc'); // caption of column
                $col["name"] = "income_details"; // field name, must be exactly same as with SQL prefix or db field
                $col["editrules"] = array("required" => true); // and is required
                $col["width"] = "60";
                $col["editable"] = true;
                $col['edittype'] = "textarea";
                $col['editoptions'] = array(
                    "rows" => '2',
                    "cols" => '50',
                    "defaultValue" => ' ');
                $col["formatter"] = "autocomplete"; // autocomplete
                $col["formatoptions"] = array(
                    "sql" => "SELECT DISTINCT income_details as k, income_details as v FROM income",
                    "search_on" => "income_details",
                    "update_field" => "income_details");
                $cols2[] = $col;


                #total Amount
                $col = array();
                $col["title"] = $this->lang->line('amount');
                $col["name"] = "total_amount";
                $col["width"] = "40";
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

                # Remark
                $col = array();
                $col["title"] = $this->lang->line('note'); // caption of column
                $col["name"] = "note"; // field name, must be exactly same as with SQL prefix or db field
                $col["width"] = "40";
                $col["editable"] = true;
                $col['edittype'] = "textarea";
                $col['editoptions'] = array(
                    "rows" => '2',
                    "cols" => '20',
                    "defaultValue" => ' ');
                $col["formatter"] = "autocomplete"; // autocomplete
                $col["formatoptions"] = array(
                    "sql" => "SELECT DISTINCT note as k, note as v FROM income",
                    "search_on" => "note",
                    "update_field" => "note");
                $cols2[] = $col;


                // virtual column for grand total
                $col = array();
                $col["title"] = "table_total";
                $col["name"] = "table_total";
                $col["width"] = "100";
                $col["hidden"] = true;
                $cols2[] = $col;

                // virtual column for running total
                $col = array();
                $col["title"] = "running_total";
                $col["name"] = "running_total";
                $col["width"] = "100";
                $col["hidden"] = true;
                $cols[] = $col;


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
                $h2_title = $this->lang->line('income');

                $js_script = $this->income_model->income_fect_assoc($data);

                // Used JS Script
                //$id2 = intval($_GET["jqgrid_page"]);
                $id3 = intval($_GET['jqgrid_page']);
                //$data["params"]["factory_id"] = $id2;
                $js_script = $id3;

                //display
                $this->_example_output((object)array(
                    'output' => '',
                    'out_detail' => $out_detail,
                    'out_master' => $out_master,
                    'js_files' => array(),
                    'css_files' => array(),
                    'js_script' => $js_script,
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
