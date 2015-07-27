<?php

class Login extends Controller {

	function __construct() {
		parent::__construct();	
	}
	
	function index() {
        if(Session::get(ADMIN_SESSION_NAME)){
            Tools::redirect('home');
        }
		$this->view->render('login/index');
	}
	

}