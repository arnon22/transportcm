<?php

class Import_Model extends Model
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

    public function importSingleTable()
    {
        $tableName = Tools::post('imported_table');
        $fieldsList = Tools::post('imported_fields');
        $csvSeparator = Tools::post('csv_separator');
        $headerRow = Tools::post('with_header_row');
        $updateQuery = Tools::post('update_query');

        $handle = fopen($_FILES['csv_file']['tmp_name'], "r");
        if ($headerRow) {
            $lineData = fgetcsv($handle, 1000, $csvSeparator);
        }

        $aSql = array();

        $cRows = 0;
        $totalQuery = 0;
        while (($lineData = fgetcsv($handle, 1000, $csvSeparator)) !== FALSE) {
            $aLine = array();
            $aUpdateQuery = array();
            $cTmp = 0;
            foreach ($lineData as $data) {
                $valueCell = IMPORT_ENCODE_FUNCTION != "none" && function_exists(IMPORT_ENCODE_FUNCTION) ? call_user_func(IMPORT_ENCODE_FUNCTION, $data) : $data;
                $valueCell = mysql_real_escape_string($valueCell);
                $aLine[] = $valueCell;
                if (isset($fieldsList[$cTmp])) {
                    $aUpdateQuery[] = $fieldsList[$cTmp] . " = '$valueCell' ";
                }
                $cTmp++;
            }

            if ($updateQuery == "1") {
                $sql = "UPDATE $tableName ";
                $sql .= "SET " . implode(',', $aUpdateQuery);
                $sql .= "WHERE " . $fieldsList[0] . "='" . $aLine[0] . "' ; ";
                $this->DB->Execute($sql);
                $totalQuery++;
            } else {
                $aSql[] = "('" . implode("','", $aLine) . "')";
            }
            $cRows++;
        }
        if ($updateQuery == "0" && count($aSql) > 0) {
            $sql = "INSERT INTO $tableName (" . implode(",", $fieldsList)
                . ") VALUES ";
            $sql .= implode(',', $aSql);
            $this->DB->Execute($sql);
            $totalQuery = count($aSql);
            $queryMessage = ' rows imported.';
        } else {
            $queryMessage = ' rows updated.';
        }

        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            FlashSession::setFlash('error', $errorMsg);
        } else {
            FlashSession::setFlash('success', 'Import has been successfully finished : ' . $totalQuery . $queryMessage);
        }

    }

    public function importExcelTable()
    {
        $tableName = Tools::post('imported_table_xls');
        $fieldsList = Tools::post('imported_fields');
        $headerRow = Tools::post('with_header_row');
        $updateQuery = Tools::post('update_query');

        $objPHPExcel = PHPExcel_IOFactory::load($_FILES['xls_file']['tmp_name']);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $cp = 1;

        $aSql = array();

        $totalQuery = 0;
        foreach ($objWorksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
            if ($headerRow && $cp++ == 1) {
                continue;
            }
            $aLine = array();
            $aUpdateQuery = array();
            $cTmp = 0;
            foreach ($cellIterator as $cell) {
                $valueCell = IMPORT_ENCODE_FUNCTION != "none" && function_exists(IMPORT_ENCODE_FUNCTION) ? call_user_func(IMPORT_ENCODE_FUNCTION, $cell->getValue()) : $cell->getValue();
                $valueCell = mysql_real_escape_string($valueCell);
                $aLine[] = $valueCell;
                if (isset($fieldsList[$cTmp])) {
                    $aUpdateQuery[] = $fieldsList[$cTmp] . " = '$valueCell' ";
                }
                $cTmp++;
            }
            if ($updateQuery == "1") {
                $sql = "UPDATE $tableName ";
                $sql .= "SET " . implode(',', $aUpdateQuery);
                $sql .= "WHERE " . $fieldsList[0] . "='" . $aLine[0] . "' ; ";
                $this->DB->Execute($sql);
                $totalQuery++;
            } else {
                $aSql[] = "('" . implode("','", $aLine) . "')";
            }
        }
        if ($updateQuery == "0" && count($aSql) > 0) {
            $sql = "INSERT INTO $tableName (" . implode(",", $fieldsList)
                . ") VALUES ";
            $sql .= implode(',', $aSql);
            $this->DB->Execute($sql);
            $totalQuery = count($aSql);
            $queryMessage = ' rows imported.';
        } else {
            $queryMessage = ' rows updated.';
        }

        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            FlashSession::setFlash('error', $errorMsg);
        } else {
            FlashSession::setFlash('success', 'Import has been successfully finished : ' . $totalQuery . $queryMessage);
        }

    }
}