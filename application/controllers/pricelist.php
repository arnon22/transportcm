<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');

class Pricelist extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->lang->load('thai');
        $this->load->model('pricelist_model', 'pricelist');
        $this->load->model('price_model', 'price');

        //jqgrid
        $this->load->library('jqgridnow_lib');


    }

    public function _example_output($output = null)
    {
        //$this->load->view('orders_view',$output);
        $this->load->view('pricelist', $output);
    }


    public function index()
    {
        if ($this->session->userdata('user_name'))
        {
            $g = new jqgrid();


            $dispyPrice = $this->price->dispalyPrice();
            $titke_cubic = $this->price->header_cubic();
            $row_distance = $this->price->row_distance();

            $i = 0;

            foreach ($row_distance as $key => $val)
            {
                // $i = $val['distance_id'];

                foreach ($titke_cubic as $row)
                {

                    $data[$i]["id"] = $i;
                    $data[$i]["distacne"] = $dispyPrice[$i]['distance'];
                    $data[$i]['cubic'][$row->cubic_id] = 2 + $i; //$dispyPrice[$i][$row->cubic_id];
                    $data[$i]["pricelist_id"] = $dispyPrice[$row->id];


                }


                $i = $val['distance_id'];

            }


            $g->table = $data;
            // ห$g->table = $pricelist;


            $col = array();
            $col["title"] = "id"; // caption of column
            $col["name"] = "id";
            $col["width"] = "250";
            $col["sorttype"] = int;
            $col['editable'] = true;
            $col['hidden'] = true;
            $cols[] = $col;

            $col = array();
            $col["title"] = "pricelist_id"; // caption of column
            $col["name"] = "pricelist_id";
            $col["width"] = "250";
            $col["sorttype"] = int;
            $col['editable'] = true;
            #$col['hidden'] = true;
            //$cols[] = $col;

            $col = array();
            $col["title"] = "Cubic /<br/> Distance"; // caption of column
            $col["name"] = "distacne";
            $col["width"] = "350";
            $cols[] = $col;


            foreach ($titke_cubic as $row)
            {
                $col = array();
                $col['title'] = "$row->cubic_value";
                $col['name'] = "cubic[$row->cubic_id]";
                $col['editable'] = true;
                $col['search'] = false;
                $cols[] = $col;
            }


            $g->set_columns($cols);
            
            

            $e["js_on_select_row"] = "do_onselect";
            
            $e["on_update"] = array(
                "do_update",
                null,
                true);
            $e["on_data_display"] = array(
                "filter_display",
                null,
                true);

            $g->set_events($e);
            
            function filter_display($data)
            {
                /*
                These comments are just to show the input param format 
                Array 
                ( 
                [params] => Array 
                ( 
                [0] => Array 
                ( 
                [client_id] => 1 
                [name] => Client 1 
                [gender] => My custom malea 
                [company] => My custom Client 1 Company 1 
                ) 

                [1] => Array 
                ( 
                [client_id] => 2 
                [name] => Client 2 
                [gender] => male 
                [company] => Client 2 Com2pany 11 
                ) 
                
                ....... 
                */
                foreach ($data["params"] as &$d)
                {
                    foreach ($d as $k => $v)
                        $d[$k] = strtoupper($d[$k]);
                }
            }

            function do_update(&$data)
            {
                //  $obj = &get_instance();

                print_r($data);

                $id = intval($_REQUEST["id"]);


            }


            $g->set_actions(array(
                "add" => false, // allow/disallow add
                "edit" => true, // allow/disallow edit
                "bulkedit" => true, // allow/disallow edit
                "delete" => true, // allow/disallow delete
                "rowactions" => true,
                "autofilter" => true,
                "search" => "simple"));
            $opt['caption'] = "d";
            $opt["sortname"] = 'id'; // by default sort grid by this field
            $opt["sortorder"] = "asc"; // ASC or DESC
            $opt['rowNum'] = 30;

            $opt["autowidth"] = true;
            $opt["cellEdit"] = true;

            $g->set_options($opt);


            //Display
            $pricetable = $g->render("list1");


            $this->_example_output((object)array(
                'output' => '',
                'out' => $out,
                'dispyPrice' => $dispyPrice,
                'list_row' => $num_row,
                'pricelist' => $pricelist,
                'pricetable' => $pricetable));

        } else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }


    } //End of Index()


} // End of class
