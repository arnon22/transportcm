<?php

class Import extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (Tools::isPost('submitImportTable')) {
            if ($this->checkImportForm()) {
                /** @var Import_Model $this->model */
                $this->model->importSingleTable();
            }
        }

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->model->getTablesList();
            $this->view->render('import/csv/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Importing tables');
            Tools::redirect('dbconfig/index/import/csv');
        }
    }

    public function csv()
    {
        $this->index();
    }

    public function csv_fields()
    {
        $tableName = Tools::post('tableName');
        $this->view->tableName = $tableName;
        $this->view->fieldsList = $this->model->getFieldsList($tableName);
        $this->view->render('import/csv/fields/index', true);
    }

    public function checkImportForm()
    {
        $tableName = Tools::post('imported_table');
        $fieldsList = Tools::post('imported_fields');
        $csvSeparator = Tools::post('csv_separator');
        $aError = array();
        if ($tableName == "") {
            $aError[] = "You must choose Table Name !";
        }
        if (count($fieldsList) == 0) {
            $aError[] = "You must choose at least one column !";
        }
        if ($csvSeparator == "") {
            $aError[] = "You must choose CSV Separator !";
        }
        if ($_FILES['csv_file']['tmp_name'] == "") {
            $aError[] = "You must choose CSV File !";
        }

        /*
         * Check Errors
         * */
        if (count($aError) == 0) {
            return true;
        } else {
            FlashSession::setFlash('error', implode('<br>', $aError));
            return false;
        }
    }

    public function checkImportExcelForm()
    {
        $tableName = Tools::post('imported_table_xls');
        $fieldsList = Tools::post('imported_fields');
        $aError = array();
        if ($tableName == "") {
            $aError[] = "You must choose Table Name !";
        }
        if (count($fieldsList) == 0) {
            $aError[] = "You must choose at least one column !";
        }

        if ($_FILES['xls_file']['tmp_name'] == "") {
            $aError[] = "You must choose Excel File !";
        }

        /*
         * Check Errors
         * */
        if (count($aError) == 0) {
            return true;
        } else {
            FlashSession::setFlash('error', implode('<br>', $aError));
            return false;
        }
    }

    public function excel()
    {
        if (Tools::isPost('submitImportTable')) {
            if ($this->checkImportExcelForm()) {
                /** @var Import_Model $this->model */
                $this->model->importExcelTable();
            }
        }

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->model->getTablesList();
            $this->view->render('import/excel/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Importing tables');
            Tools::redirect('dbconfig/index/import/excel');
        }
    }

    public function excel_fields()
    {
        $tableName = Tools::post('tableName');
        $this->view->tableName = $tableName;
        $this->view->fieldsList = $this->model->getFieldsList($tableName);
        $this->view->render('import/excel/fields/index', true);
    }

}