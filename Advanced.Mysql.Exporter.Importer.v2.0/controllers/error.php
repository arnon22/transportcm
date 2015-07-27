<?php

class Error extends Controller {

    public function __construct() {
		parent::__construct();
	}

    public function index() {
		$this->view->msg = 'This page doesnt exist';
		$this->view->render('error/index');
	}

}