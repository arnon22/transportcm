<?php

class Export extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Export CSV
     * */
    function index()
    {
        if (Tools::isPost('submitExportCSV')) {
            if ($this->checkExportForm()) {
                $this->model->exportCSVTable();
            }
        }

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->model->getTablesList();
            $this->view->render('export/csv/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Exporting tables');
            Tools::redirect('dbconfig/index/export');
        }
    }

    public function csv()
    {
        $this->index();
    }

    function csv_fields()
    {
        $tableName = Tools::post('tableName');
        $this->view->tableName = $tableName;
        $this->view->fieldsList = $this->model->getFieldsList($tableName);
        $this->view->render('export/csv/fields/index', true);
    }

    public function checkExportForm()
    {
        $tableName = Tools::post('exported_table_csv');
        $fieldsList = Tools::post('exported_fields');
        $csvSeparator = Tools::post('csv_separator');
        $csv_file_name = Tools::post('csv_file_name');

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
        if ($csv_file_name == "") {
            $aError[] = "You must output File name!";
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

    public function checkExportExcelForm()
    {
        $tableName = Tools::post('exported_table_xls');
        $fieldsList = Tools::post('exported_fields');
        $xls_file_name = Tools::post('xls_file_name');

        $aError = array();
        if ($tableName == "") {
            $aError[] = "You must choose Table Name !";
        }
        if (count($fieldsList) == 0) {
            $aError[] = "You must choose at least one column !";
        }
        if ($xls_file_name == "") {
            $aError[] = "You must output File name!";
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

    /*
     * Export Excel
     * */
    public function excel()
    {
        if (Tools::isPost('submitExportXLS')) {
            if ($this->checkExportExcelForm()) {
                $this->model->exportXLSTable();
            }
        }

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->model->getTablesList();
            $this->view->render('export/excel/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Exporting tables');
            Tools::redirect('dbconfig/index/export/excel');
        }
    }

    public function excel_fields()
    {
        $tableName = Tools::post('tableName');
        $this->view->tableName = $tableName;
        $this->view->fieldsList = $this->model->getFieldsList($tableName);
        $this->view->render('export/excel/fields/index', true);
    }

    /*
     * Export Custom Query
     * */
    public function custom($type = 'csv')
    {
        if (!Session::get('dbConfigured')) {
            FlashSession::setFlash('error', 'You must configure your Database before Exporting tables');
            Tools::redirect('dbconfig/index/export/custom');
        }
        if ('csv' == $type) {
            $this->exportCustomCSV();
        } elseif ("excel" == $type) {
            $this->exportCustomExcel();
        } else {
            $this->exportCustomPDF();
        }
    }

    public function checkExportCustomCSV()
    {
        $custom_query = Tools::post('custom_query');
        $csvSeparator = Tools::post('csv_separator');
        $csv_file_name = Tools::post('csv_file_name');

        $aError = array();
        if ($custom_query == "") {
            $aError[] = "You must inter a valid Sql Query !";
        }
        if ($csvSeparator == "") {
            $aError[] = "You must choose CSV Separator !";
        }
        if ($csv_file_name == "") {
            $aError[] = "You must output File name!";
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

    public function checkExportCustomXLS()
    {
        $custom_query = Tools::post('custom_query');
        $csv_file_name = Tools::post('xls_file_name');

        $aError = array();
        if ($custom_query == "") {
            $aError[] = "You must inter a valid Sql Query !";
        }
        if ($csv_file_name == "") {
            $aError[] = "You must output File name!";
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

    public function checkExportCustomPDF()
    {
        $custom_query = Tools::post('custom_query');
        $pdf_file_name = Tools::post('pdf_file_name');

        $aError = array();
        if ($custom_query == "") {
            $aError[] = "You must inter a valid Sql Query !";
        }
        if ($pdf_file_name == "") {
            $aError[] = "You must output File name!";
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

    public function exportCustomCSV()
    {
        if (Tools::isPost('submitExportCustomCSV')) {
            if ($this->checkExportCustomCSV()) {
                $this->model->exportCustomCSV();
            }
        }
        $this->view->render('export/custom/csv/index');
    }

    public function exportCustomPDF()
    {
        if (Tools::isPost('submitExportCustomPDF')) {
            if ($this->checkExportCustomPDF()) {
                $this->model->exportCustomPDF();
            }
        }
        $this->view->render('export/custom/pdf/index');
    }

    public function exportCustomExcel()
    {
        if (Tools::isPost('submitExportCustomXLS')) {
            if ($this->checkExportCustomXLS()) {
                $this->model->exportCustomXLS();
            }
        }
        $this->view->render('export/custom/excel/index');
    }

    /*
    * Export PDF
    * */
    public function pdf()
    {
        if (Tools::isPost('submitExportPDF')) {
            if ($this->checkExportPDFForm()) {
                $this->model->exportPDFTable();
            }
        }

        if (Session::get('dbConfigured')) {
            $this->view->tableList = $this->model->getTablesList();
            $this->view->render('export/pdf/index');
        } else {
            FlashSession::setFlash('error', 'You must configure your Database before Exporting tables');
            Tools::redirect('dbconfig/index/export/pdf');
        }
    }

    public function pdf_fields()
    {
        $tableName = Tools::post('tableName');
        $this->view->tableName = $tableName;
        $this->view->fieldsList = $this->model->getFieldsList($tableName);
        $this->view->render('export/pdf/fields/index', true);
    }

    public function checkExportPDFForm()
    {
        $tableName = Tools::post('exported_table_pdf');
        $fieldsList = Tools::post('exported_fields');
        $pdf_file_name = Tools::post('pdf_file_name');

        $aError = array();
        if ($tableName == "") {
            $aError[] = "You must choose Table Name !";
        }
        if (count($fieldsList) == 0) {
            $aError[] = "You must choose at least one column !";
        }
        if ($pdf_file_name == "") {
            $aError[] = "You must output File name!";
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
}