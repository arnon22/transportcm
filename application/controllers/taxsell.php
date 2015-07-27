<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Taxsell extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('jqgridnow_lib');
    }

    public function _example_output($output = null)
    {
        //$this->load->view('income',$output);
        $this->load->view('taxsell', $output);
    }

    public function index()
    {
        $grid = new jqgrid();
        $col = array();
        $col["title"] = "Id"; // caption of column
        $col["name"] = "tax_id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias)
        $col["width"] = "10";
        $cols[] = $col;        



// this db table will be used for add,edit,delete
        $g->table = "taxsell";

// pass the cooked columns to grid
$g->set_columns($cols);

// generate grid output, with unique grid name as 'list1'
$out = $g->render("list1"); 
        
       $this->_example_output((object)array('output' => '' ,'out'=>$out));


    }

}


//** end Controller **//
