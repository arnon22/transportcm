<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
    
class Incomenew extends CI_Controller {
    
    private $main_menu;
    
    public function __construct(){
        
        parent::__construct();
        $this->load->library('jqgridnow_lib');
        
        $this->lang->load('thai'); 
        
        $this->load->model('Mainmenu_model','mainmenu');
        
        $this->load->model('order_model','order');
        $this->load->model('factory_model','factory');
        $this->load->model('customers_model','customer');
        $this->load->model('distance_model','distance');
        $this->load->model('cubiccode_model','cubic');
        $this->load->model('cardriver_model','cars');
        
        
       
        $this->load->library("pagination");                  
        $this->main_menu= $this->mainmenu->Mainmenu_list();
        
        //$this->session->set_userdata($this->main_menu);
        
        
        
        $this->load->library('grocery_CRUD');
        
    }
    
    public function _example_output($output = null)
	{
		//$this->load->view('income',$output);
        $this->load->view('income-new',$output);
	}
    
 
    
    public function index(){
        
         //check login
    if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     
    
     
     /*$crud = new grocery_CRUD();
        
       	//$crud->set_theme('twitter-bootstrap');

		$crud->set_table('income');		
		$crud->set_subject('Income');
		$crud->set_relation('factory_id','transport_factory','factory_name');
 	    $crud->set_relation('car_id','transport_cars','car_number');
       
        $crud->limit(10);      
        $crud->unset_columns('user_id','note','income_id','car_id','created_datetime','modified_datetime');
        $crud->unset_fields('user_id','income_id');
		$output = $crud->render();
        */
        //$this->_example_output($output);
// master grid
$grid = new jqgrid();

$opt["caption"] = "Income::";
// following params will enable subgrid -- by default first column (PK) of parent is passed as param 'id'
$opt["detail_grid_id"] = "list2";
$opt['width']=300;


// extra params passed to detail grid, column name comma separated
//$opt["subgridparams"] = "client_id,gender,company";
$opt["subgridparams"] = "factory_id,factory_code,factory_name";
$opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf");
$opt["export"]["range"] = "filtered";
$grid->set_options($opt);
$grid->table = "transport_factory";

$col = array();
$col["title"] = "factory_id"; // caption of column
$col["name"] = "factory_id"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "10";
$col["editable"] = false;
$cols[] = $col;

$col =array();
$col['title']="factory code";
$col['name']="factory_code";
$col["width"] = "10";
$col["editable"] = false;
$cols[] = $col;

$grid->set_columns($cols);      

$grid->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>false, // show/hide row wise edit/del/save option						
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);
				
$out_master = $grid->render("list1");

// detail grid
$grid = new jqgrid();

$opt = array();
$opt["sortname"] = 'id'; // by default sort grid by this field
$opt["sortorder"] = "desc"; // ASC or DESC
$opt["height"] =400; // autofit height of subgrid
$opt["rowNum"] = 10; // by default 20 
$opt["autowidth"] = true;
$opt["caption"] = "Invoice Data"; // caption of grid
$opt["multiselect"] = true; // allow you to multi-select through checkboxes
//footer
$opt["footerrow"] = true;
$opt["reloadedit"] = true; 

$opt["export"] = array("filename"=>"my-file", "sheetname"=>"test", "format"=>"pdf"); // export to excel parameters
$opt["export"]["range"] = "filtered";
// Check if master record is selected before detail addition
$opt["add_options"]["beforeInitData"] = "function(formid){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); if (!selr) { alert('Please select master record first'); return false; } }";

//$opt["add_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'320');
//$opt["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 'width'=>'320');
//$opt["add_options"]["topinfo"] = "Add New Client Information. Enter client name, gender and company name.<br />&nbsp;";
//$opt["add_options"]["bottominfo"] = "This text is dialog footer text";


$grid->set_options($opt);

$grid->set_actions(array(	
						"add"=>true, // allow/disallow add
						"edit"=>true, // allow/disallow edit
						"delete"=>true, // allow/disallow delete
						"rowactions"=>true, // show/hide row wise edit/del/save option
						"export"=>true, // show/hide export to excel option
						"autofilter" => true, // show/hide autofilter for search
						"search" => "advance" // show single/multi field search condition (e.g. simple or advance)
					) 
				);



    
$id = intval($_GET["rowid"]);
$factory_code = $_GET["factory_code"];
$company = $_GET["factory_name"];
$cid = intval($_GET["factory_id"]);

// for non-int fields as PK
// $id = (empty($_GET["rowid"])?0:$_GET["rowid"]);

// and use in sql for filteration
//$grid->select_command = "SELECT id,client_id,invdate,amount,tax,total,'$company' as 'company' FROM invheader WHERE client_id = $cid";
//$grid->select_command = "SELECT id,income_date,factory_id,ref_number,total_amount,note FROM `income` WHERE factory_id=$cid";

//$grid->select_command = "SELECT id,income_date,factory_id,ref_number,income_details,total_amount,note,(SELECT SUM(total_amount)FROM	income WHERE factory_id = $cid	) AS table_total FROM	`income`WHERE	factory_id = $cid";

$grid->select_command = "SELECT
	id,
	income_date,
	ref_number,
	income_details,
	total_amount,
	note,
	(
		SELECT
			SUM(total_amount)
		FROM
			income
		WHERE
			income.factory_id = $cid
	) AS table_total
FROM
	`income` LEFT JOIN transport_factory AS fac ON(income.factory_id=fac.factory_id)
WHERE
	income.factory_id = $cid";
// this db table will be used for add,edit,delete

$grid->table = "income";


$col = array();
$col["title"] = "id"; // caption of column
$col["name"] = "id"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "30";
$cols2[] = $col;	

	
/*
$col = array();
$col["title"] = "Factory_id";
$col["name"] = "factory_code";
$col['dbname']="fac.factory_id";
$col["width"] = "10";
$col["editable"] = true;

$cols2[] = $col;		
*/

$col = array();
$col["title"] = "Date";
$col["name"] = "income_date";
$col["width"] = "40";
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true); // and is required
# format as date
$col["formatter"] = "date"; 
# opts array can have these options: http://api.jqueryui.com/datepicker/
$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => false)); 
$cols2[] = $col;

$col = array();
$col["title"] = "Ref.no"; // caption of column
$col["name"] = "ref_number"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "30";
$col["editable"] = true;
$cols2[] = $col;

$col = array();
$col["title"] = "Desc"; // caption of column
$col["name"] = "income_details"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "80";
$col["editable"] = true;
$cols2[] = $col;

$col = array();
$col["title"] = "note"; // caption of column
$col["name"] = "note"; // field name, must be exactly same as with SQL prefix or db field
$col["width"] = "30";
$col["editable"] = true;
$cols2[] = $col;

$col = array();
$col["title"] = "Amount";
$col["name"] = "total_amount";
$col["width"] = "50";
$col['align']="right";
$col['formatter']="number";
$col['formateroptions']=array("thousandsSeparator"=>",","decimalSeparator"=>".","decimalPlaces"=>'2');
$col["editable"] = true; // this column is editable
$col["editoptions"] = array("size"=>20); // with default display of textbox with size 20
$col["editrules"] = array("required"=>true,"number"=>true); // and is required
$cols2[] = $col;

// virtual column for running total
$col = array();
$col["title"] = "running_total";
$col["name"] = "running_total";
$col["width"] = "100";
$col["hidden"] = true;
$cols2[] = $col;

// virtual column for grand total
$col = array();
$col["title"] = "table_total";
$col["name"] = "table_total";
$col["width"] = "100";
$col["hidden"] = true;
$cols2[] = $col; 

$grid->set_columns($cols2);



$e = array();
//$e["on_data_display"] = array($this->pre_render($data),"",true);
#$e["on_data_display"] = array("pre_render","",true);
$e["on_insert"] = array("add_client", null, true);
$grid->set_events($e);

function add_client(&$data)
{

    $id = intval($_GET["rowid"]);
	$data["params"]["factory_id"] = $id;
}

 function pre_render()
{
   # $rows = $_GET["jqgrid_page"] * $_GET["rows"];
   # $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
   # $sord = $_GET['sord']; // get the direction
    
    // same sql as in select_command
    //$rs = mysql_fetch_assoc(mysql_query("SELECT SUM(total) as s FROM (SELECT total FROM invheader ORDER BY $sidx $sord LIMIT $rows) AS tmp"));
    
    #$str = "SELECT SUM(total_amount) as s FROM (SELECT total_amount FROM income ORDER BY $sidx $sord LIMIT $rows) AS tmp";
   # $rs = $this->db->query($str);
   # $rs->fetch_assoc();
    
    
    
    
   # foreach($data["params"] as &$d)
    #{
        #$d["running_total"] = $rs["s"];
   # }
}

//footer



// pass the cooked columns to grid

// running total calculation
 




// generate grid output, with unique grid name as 'list1'
$out_detail = $grid->render("list2");        
    
       $this->_example_output((object)array('output' => '' ,'out_detail'=>$out_detail ,'out_master'=>$out_master,'js_files' => array() , 'css_files' => array()));
     
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
        
   
    }// End of Function index
    
    
    
 public  function pre_render2($data)
{
    $rows = $_GET["jqgrid_page"] * $_GET["rows"];
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    
    // same sql as in select_command
    //$rs = mysql_fetch_assoc(mysql_query("SELECT SUM(total) as s FROM (SELECT total FROM invheader ORDER BY $sidx $sord LIMIT $rows) AS tmp"));
    
    $str = "SELECT SUM(total_amount) as s FROM (SELECT total_amount FROM income ORDER BY $sidx $sord LIMIT $rows) AS tmp";
    $rs = $this->db->query($str)->result_array();
    
    
    
    
    foreach($data["params"] as &$d)
    {
        $d["running_total"] = $rs["s"];
    }
}
    

    
    

        
        
        
        
    
    
    
    function logout()
 {
   $this->session->unset_userdata('logged_in');
   $this->session->sess_destroy();
   //session_destroy();
   redirect('bootstrap', 'refresh');
 }
 
 
 

    
    
    
    
    
    
}// end of class