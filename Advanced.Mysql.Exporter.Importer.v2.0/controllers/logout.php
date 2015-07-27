<?php

class Logout extends Controller {

	function __construct() {
		parent::__construct();	
	}
	
	function index() {
        Session::logout();
		Tools::redirect('login');
	}
	

}