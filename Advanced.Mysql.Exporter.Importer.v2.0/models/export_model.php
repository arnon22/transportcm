<?php

class Export_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTablesList()
    {
        $result = $this->DB->Execute("Show tables;");
        $listTables = array();
        while (!$result->EOF) {
            $listTables [] = $result->fields[0];
            $result->MoveNext();
        }
        return $listTables;
    }

    public function getFieldsList($tableName)
    {
        $result = $this->DB->Execute("SHOW COLUMNS FROM $tableName");
        $aFields = array();
        if ($result !== false) {
            while (!$result->EOF) {
                $aFields[] = $result->fields[0];
                $result->MoveNext();
            }
        }
        return $aFields;
    }

    public function exportCSVTable()
    {
        $tableName = Tools::post('exported_table_csv');
        $fieldsList = Tools::post('exported_fields');
        $csvSeparator = Tools::post('csv_separator');
        $headerRow = Tools::post('with_header_row');
        $csv_file_name = Tools::post('csv_file_name');

        $fileName = TMP . $csv_file_name . '.csv';

        $fp = fopen($fileName, 'w');
        if ($headerRow) {
            FileManager::putCSV($fp, $fieldsList, $csvSeparator, '');
        }
        $query = "SELECT " . implode(",", $fieldsList) .
            " FROM $tableName";
        $result = $this->DB->Execute($query);
        if ($result !== false) {
            while (!$result->EOF) {
                $aRecords = $result->fields;
                FileManager::putCSV($fp, $aRecords, $csvSeparator, '');
                $result->MoveNext();
            }
        }
        fclose($fp);
        FileManager::downloadCSVFile($fileName);
    }

    public function exportCustomCSV()
    {
        $custom_query = Tools::post('custom_query');
        $csvSeparator = Tools::post('csv_separator');
        $headerRow = Tools::post('with_header_row');
        $csv_file_name = Tools::post('csv_file_name');

        $fileName = TMP . $csv_file_name . '.csv';

        $fp = fopen($fileName, 'w');

        $this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $this->DB->Execute($custom_query);
        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            FlashSession::setFlash('error', $errorMsg);
            return false;
        }
        $cp = 0;

        if ($result !== false) {
            while (!$result->EOF) {

                $aRecords = $result->fields;
                if ($headerRow && $cp == 0) {
                    FileManager::putCSV($fp, $aRecords, $csvSeparator, '', true);
                }

                FileManager::putCSV($fp, $aRecords, $csvSeparator, '');
                $result->MoveNext();
                $cp++;
            }
        }
        fclose($fp);
        FileManager::downloadCSVFile($fileName);
    }

    public function exportXLSTable()
    {
        $tableName = Tools::post('exported_table_xls');
        $fieldsList = Tools::post('exported_fields');
        $headerRow = Tools::post('with_header_row');
        $xls_file_name = Tools::post('xls_file_name');
        $excel_version = Tools::post('excel_version');

        $query = "SELECT " . implode(",", $fieldsList) .
            " FROM $tableName";
        $result = $this->DB->Execute($query);
        FileManager::downloadExcelFile($result, $headerRow, $excel_version, $xls_file_name, $fieldsList);

    }

    public function exportCustomXLS()
    {
        $custom_query = Tools::post('custom_query');
        $headerRow = Tools::post('with_header_row');
        $xls_file_name = Tools::post('xls_file_name');
        $excel_version = Tools::post('excel_version');

        $this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $this->DB->Execute($custom_query);
        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            FlashSession::setFlash('error', $errorMsg);
            return false;
        }
        FileManager::downloadExcelFile($result, $headerRow, $excel_version, $xls_file_name);
    }

    /*
     * PDF
     * */
    public function exportPDFTable()
    {
        $tableName = Tools::post('exported_table_pdf');
        $fieldsList = Tools::post('exported_fields');
        $headerRow = Tools::post('with_header_row');
        $pdf_file_name = Tools::post('pdf_file_name');

        $query = "SELECT " . implode(",", $fieldsList) .
            " FROM $tableName";
        $result = $this->DB->Execute($query);
        FileManager::downloadPDFFile($result, $headerRow, $pdf_file_name, $fieldsList);
    }

    public function exportCustomPDF()
    {
        $custom_query = Tools::post('custom_query');
        $headerRow = Tools::post('with_header_row');
        $pdf_file_name = Tools::post('pdf_file_name');

        $this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
        $result = $this->DB->Execute($custom_query);
        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            FlashSession::setFlash('error', $errorMsg);
            return false;
        }
        FileManager::downloadPDFFile($result, $headerRow, $pdf_file_name);
    }
}