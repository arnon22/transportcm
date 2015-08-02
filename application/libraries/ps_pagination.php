<?php
/**
 * PHPSense Pagination Class
 *
 * PHP tutorials and scripts
 *
 * @package		PHPSense
 * @author		Jatinder Singh Thind
 * @copyright	Copyright (c) 2006, Jatinder Singh Thind
 * @link		http://www.phpsense.com
 * @modification		Mike Dalisay
 * @link				http://www.codeofaninja.com
 */

// ------------------------------------------------------------------------

class PS_Pagination {
	var $php_self;
	var $rows_per_page = 10; //Number of records to display per page
	var $total_rows = 0; //Total number of rows returned by the query
	var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $debug = false;
	var $conn = false;
	var $page = 1;
	var $max_pages = 0;
	var $offset = 0;
	
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */
	
	function PS_Pagination($connection, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "") {
		$this->conn = $connection;
		$this->sql = $sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		if (isset($_GET['page'] )) {
			$this->page = intval($_GET['page'] );
		}
	}
	
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate(){
		
		if(mysqli_connect_errno()) {
			echo "Error: Could not connect to database.";
			exit;
		}

		//Find total number of rows
		$all_rs = $this->conn->query( $this->sql);

		if (!$all_rs){
			echo "Error: Unable to query. " . $this->sql;
			return false;
		}
		
		$this->total_rows = $all_rs->num_rows;
		
		//Return FALSE if no rows found
		if ($this->total_rows == 0) {
			echo "No rows found.";
			return false;
		}
		

		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page - 1);
		
		$query = $this->sql . " limit " . $this->offset . ", " . $this->rows_per_page;
		$all_rs = $this->conn->query( $query );
		
		if(!$all_rs){
			echo "Error: Unable to execute query >> " . $query;
			return false;
		}
		return $all_rs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == 1) {
			return "$tag ";
		} else {
			//return '<a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a> ';
            //default to one (1)
            return " <a href='javascript:void(0);' OnClick='getdata( 1 )' title='First Page'>$tag</a> ";
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == $this->max_pages) {
			return $tag;
		} else {
			//return ' <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';
            $pageno = $this->max_pages;
            return " <a href='javascript:void(0);' OnClick='getdata( $pageno )' title='Last Page'>$tag</a> ";
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = '&gt;&gt;') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page < $this->max_pages) {
			//return '<a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '" title=\'next to\'>' . $tag . '</a>';
            $pageno = $this->page + 1;
            return " <a href='javascript:void(0);' OnClick='getdata( $pageno )' title='Next Page'>$tag</a> ";
		} else {
			return $tag;
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&lt;&lt;') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page > 1) {
			//return ' <a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a>';
            $pageno = $this->page - 1;
            return " <a href='javascript:void(0);' OnClick='getdata( $pageno )' title='Previous Page'>$tag</a> ";
		} else {
			return " $tag ";
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<span class="page_link">', $suffix = '</span>') {
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page) {
		//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= $prefix . " $i " . $suffix;                                       
			} else {
				//$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';
                //$pageno = $this->page + 1;
                $links .= " <a href='javascript:void(0);' OnClick='getdata( $i )' title='Another page'>$i</a> ";
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {
        //echo $this->renderFirst() . " " . $this->renderPrev();
        
		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>