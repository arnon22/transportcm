<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('inc/jqgrid_dist.php');

class Jqgridnow_lib extends jqgrid{
    
    private $CI;
   
    
   public function __construct(){
        //$this->CI =& get_instance();
        $this->CI =& get_instance();
   
        //$conn =& get_instance();
        //$CI->load->helper('database');
   }
   
   public function get_dropdown_values($sql){
        //$CI =& get_instance();
        $this->CI->load->model('income_model','income');
        
        $this->CI->income->grid_dropdown($sql);
   }
   
   	/*function get_dropdown_values($sql)
	{
		$str = array();
		$result = $this->execute_query($sql);

		if ($this->con)
		{
			$arr = $result->GetRows();
			
			// fix for mssql utf8 fix
			if (strpos($this->db_driver,"mssql") !== false)
				$arr = array_utf8_encode_recursive($arr);
	
			foreach($arr as $rs)
			{
				$rs["k"] = (!empty($rs["K"])) ? $rs["K"] : $rs["k"];
				$rs["v"] = (!empty($rs["V"])) ? $rs["V"] : $rs["v"];

				$str[] = $rs["k"].":".$rs["v"];
			}
		}
		else
		{
			while($rs = mysql_fetch_array($result,MYSQL_ASSOC))
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
		}
				
		$str = implode($str,";");
		return $str;
	}
   */
   
   
    
}

