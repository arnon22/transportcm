<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
// Create by anon

class Saletax extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->lang->load('thai');
        $this->load->model('income_model', 'income');
        $this->load->model('dropdown_model', 'dropdrown');

        $this->load->library('jqgridnow_lib');
    } // end of construct

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('tax', $output);
    }


    public function index()
    {

        //check login

        if ($this->session->userdata('user_name'))
        {
            $i_rule = $this->session->userdata('user_cizacl_role_id');
            
            ob_clean();
            $g = new jqgrid();

            $col = array();
            $col["title"] = $this->lang->line('id'); // caption of column
            $col["name"] = "id";
            $col["search"] = false;
            $col["editable"] = false;
            $col["hidden"] = true;
            $cols[] = $col;

            #tax date
            $col = array();
            $col['title'] = $this->lang->line('date');
            $col['name'] = "tax_date";
            $col["width"] = "170";
            $col["editable"] = true; // this column is editable
            $col["editoptions"] = array("size" => 20, "defaultValue" => date("d-m-Y")); // with default display of textbox with size 20
            $col["editrules"] = array("required" => true); // and is required
            $col["formatter"] = "date"; // format as date
            $col["formatoptions"] = array(
                "srcformat" => 'Y-m-d',
                "newformat" => 'd-m-Y',
                "opts" => array("changeYear" => false));
            $cols[] = $col;


            #ref_number
            $col = array();
            $col['title'] = $this->lang->line('ref_no');
            $col['name'] = "ref_number";
            $col["editable"] = true; // this column is editable
            $col["editrules"] = array("required" => true);
            $cols[] = $col;

            #tax Datail

            $col = array();
            $col['title'] = $this->lang->line('tax_detail');
            $col['name'] = "tax_details";
            $col["width"] = "170";
            $col["editable"] = true; // this column is editable
            $col["editrules"] = array("required" => true);
            $col["search"] = true;
            $col["formatter"] = "autocomplete"; // autocomplete
            $col["formatoptions"] = array(
                "sql" => "SELECT DISTINCT tax_details as k, tax_details as v FROM taxsell",
                "search_on" => "tax_details",
                "update_field" => "tax_details");
            $cols[] = $col;

            #Price
            $col = array();
            $col['title'] = $this->lang->line('total_price');
            $col['name'] = "total_price";
            $col["editable"] = true;
            $col["editrules"] = array("number" => true, "required" => true);
            $col["editoptions"] = array("onblur" => "update_vat()");
            $col["align"] = "right";
            $col['formatter'] = "currency";
            $col["formatoptions"] = array(
                "prefix" => "",
                "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $col["search"] = false;
            $cols[] = $col;

            #vat
            $col = array();
            $col['title'] = $this->lang->line('vat');
            $col['name'] = "total_vat";
            $col["editable"] = true;
            $col["editrules"] = array("number" => true, "required" => true);
           # $col["editoptions"] = array("onblur" => "update_vat()");
            $col["align"] = "right";
            $col['formatter'] = "currency";
            $col["formatoptions"] = array(
                "prefix" => "",
                "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $col["search"] = false;
            $cols[] = $col;

            #Total
            $col = array();
            $col['title'] = $this->lang->line('total_amount');
            $col["align"] = "right";
            $col['name'] = "total_amount";
            $col["editrules"] = array("number" => true, "required" => true);
            $col["editable"] = true;
            $col['formatter'] = "currency";
            $col["formatoptions"] = array(
                "prefix" => "",
                "suffix" => '',
                "thousandsSeparator" => ",",
                "decimalSeparator" => ".",
                "decimalPlaces" => '2');
            $col["search"] = false;
            $cols[] = $col;

            #Note
            $col = array();
            $col["title"] = $this->lang->line('remark');
            $col["name"] = "note";
            $col["width"] = "150";
            $col['editable'] = true;
            $col["edittype"] = "textarea";
            $col["editoptions"] = array("rows" => 2, "cols" => 20);
            $cols[] = $col;


            //Use Table
            $g->table = "taxsell";

            // pass the cooked columns to grid
            $g->set_columns($cols);


            #Custom Event
            $e["js_on_load_complete"] = "grid1_onload";
            $g->set_events($e);

            $opt["sortname"] = 'id';
            $opt["sortorder"] = "desc";
            $opt['rowNum'] = 10;
            $opt["rowList"] = array(
                10,
                20,
                30);
            $opt["caption"] = $this->lang->line('saletax_list');
            $opt["autowidth"] = true;       
            $opt["multiselect"] = false;

            $opt["add_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '400');
            $opt["edit_options"] = array(
                "recreateForm" => true,
                "closeAfterEdit" => true,
                'width' => '400');

            $opt["add_options"]["afterShowForm"] =
                'function(formid) { jQuery("#ref_number").focus(); }';
            $opt["footerrow"] = true;


            $g->set_options($opt);


            $g->set_actions(array(
                "add" => $this->cizacl->check_isAllowed($i_rule, 'saletax', 'add_saletax'),
                "edit" => $this->cizacl->check_isAllowed($i_rule, 'saletax', 'edit_saletax'),
                "delete" => $this->cizacl->check_isAllowed($i_rule, 'saletax', 'del_saletax'),
                "view" => false,
                "rowactions" => false,
                "autofilter" => true,
                "search" => "advance",
                "inlineadd" => false,
                "showhidecolumns" => false));

            // set database table for CRUD operations


            // render grid and get html/js output
            $out_index = $g->render("list1");

            $h2_title = $this->lang->line('saletax');

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
