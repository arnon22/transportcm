<?php

if (!defined('BASEPATH'))
    exit('No direct script access allow');
    
class Import extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('import_model',"import");
    }

    
    public function index()
  {
        if (!empty($_POST['submitImportTable'])) {
            
            if ($this->checkImportExcelForm()) {
                /** @var Import_Model $this->model */
                //$this->import->importExcelTable();
            }
        }
        $tableName = "transport_pricelist";
        $data['fieldsList'] = $this->import->getFieldsList($tableName);
        
        $this->load->view('import/excel/index',$data);
        
        
        
        
        /*

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->import->getTablesList();
           $this->load->view('import/excel/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Importing tables');
            Tools::redirect('dbconfig/index/import/excel');
        }
        
        */
    } //end of index
    
    
    public function csv()
    {
        $this->index();
    }

    public function csv_fields()
    {
        $tableName = $this->input->post('tableName');
        $this->view->tableName = $tableName;
        $this->view->fieldsList = $this->import->getFieldsList($tableName);
       $this->load->view('import/csv/fields/index', true);
    }

    public function checkImportForm()
    {
        $tableName = $this->input->post('imported_table');
        $fieldsList = $this->input->post('imported_fields');
        $csvSeparator = $this->input->post('csv_separator');
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
        $tableName = $this->input->post('imported_table_xls');
        $fieldsList = $this->input->post('imported_fields');
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
                $this->import->importExcelTable();
            }
        }

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->import->getTablesList();
           $this->load->view('import/excel/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Importing tables');
            Tools::redirect('dbconfig/index/import/excel');
        }
    }

    public function excel_fields()
    {
        $tableName = $this->input->post('tableName');
        //$this->view->tableName = $tableName;
        $data['fieldsList'] = $this->import->getFieldsList($tableName);
       $this->load->view('import/excel/fields/index',$data,true);
    }

}