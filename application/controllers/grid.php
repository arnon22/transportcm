<?php 
       require_once("./dhtmlx/connector/grid_connector.php");
       require_once("./dhtmlx/connector/db_phpci.php");
 
       class Grid extends CI_Controller {
          // here you should place all your functions
       }
       
       public function index()
{
      $this->load->view('grid');
}

public function data()
{
	//data feed
	$this->load->database();
 
	$connector = new GridConnector($this->db, "phpCI");
	$connector->configure("events", "event_id", "start_date, end_date, event_name");
	$connector->render();
}
