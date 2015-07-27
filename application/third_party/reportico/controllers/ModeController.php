<?php
/*
** ModeController -
** Generates reportico in a number of different modes:0-
** - Admin
*/
class ModeController extends Controller
{
    public $engine = false;
    public $partialRender = false;
    public $defaultAction = 'admin';

    function __construct($id,$module=null) {
        $this->engine = $module->getReporticoEngine();
        $this->partialRender = Yii::app()->request->getQuery("partialReportico", false);
        parent::__construct($id,$module);
    }

    // Run reportico in admin mode
    public function actionAdmin() {
        $this->engine->access_mode = "FULL";
        $this->engine->initial_execute_mode = "ADMIN";
        $this->engine->initial_project = "admin";
        $this->engine->initial_report = false;
        $this->engine->clear_reportico_session = true;
	if ( $this->partialRender )
            $this->renderPartial('reportico.views.reportico.index');
        else
            $this->render('reportico.views.reportico.index');
    }

    // Generate output for a single report
    public function actionExecute() {
        $this->engine->access_mode = "REPORTOUTPUT";  // Run single report, no "return button"
        //$this->engine->access_mode = "SINGLEREPORT";  // Run single report, no access to other reports
        //$this->engine->Access_mode = "ONEPROJECT"; // Run single report, but with ability to access other reports

        $this->engine->initial_execute_mode = "EXECUTE";
        $this->engine->initial_project = Yii::app()->request->getQuery("project");
        $this->engine->initial_report = Yii::app()->request->getQuery("report");
        if ( !preg_match ( "/.xml$/", $this->engine->initial_report ) )
             $this->engine->initial_report .= ".xml" ;

        $this->engine->clear_reportico_session = true;
	if ( $this->partialRender )
            $this->renderPartial('reportico.views.reportico.index');
        else
            $this->render('reportico.views.reportico.index');
    }

    public function actionMenu() {
        $this->engine->access_mode = "ONEPROJECT";
        $this->engine->access_mode = "ALLPROJECTS";  // Run single project menu, with access to other reports in other projects
        //$this->engine->Access_mode = "ONEPROJECT"; // Run single report, but with ability to access other reports
        $this->engine->initial_execute_mode = "MENU";
        $this->engine->initial_project = Yii::app()->request->getQuery("project");

        $this->engine->clear_reportico_session = true;
	if ( $this->partialRender )
            $this->renderPartial('reportico.views.reportico.index');
        else
            $this->render('reportico.views.reportico.index');
    }

    public function actionPrepare()
    {
        $this->engine->access_mode = "SINGLEREPORT"; // Allows running of a single report only
        $this->engine->access_mode = "ONEPROJECT";  // Run single report, but allow access to reports in other projects

        //$this->engine->access_mode = "ONEPROJECT";
        $this->engine->initial_execute_mode = "PREPARE";
        $this->engine->initial_project = Yii::app()->request->getQuery("project");
        $this->engine->initial_report = Yii::app()->request->getQuery("report");
        if ( !preg_match ( "/.xml$/", $this->engine->initial_report ) )
            $this->engine->initial_report .= ".xml" ;

        $this->engine->clear_reportico_session = true;
	    if ( $this->partialRender )
            $this->renderPartial('reportico.views.reportico.index');
        else
            $this->render('reportico.views.reportico.index');
    }
}
