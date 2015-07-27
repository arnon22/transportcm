<?php

class Console
{
    public $DB;

    /**
     * @param $host
     * @param $username
     * @param $password
     * @param $dbName
     */
    public function __construct($host, $username, $password, $dbName)
    {
        $this->DB = NewADOConnection('mysql');
        $this->DB->Connect($host, $username, $password, $dbName);
        $this->DB->setFetchMode(ADODB_FETCH_NUM);
    }


    /**
     * @param $cImportSettings
     */
    public function runImport($cImportSettings)
    {
        global $blueColor;

        if ($this->DB->_connectionID == false) {
            $this->showError($this->DB->ErrorMsg());
            return;
        }
        echo $blueColor;

        $importType = $cImportSettings['import_type'];
        $updateQuery = $cImportSettings['update_query'];
        $fileName = $cImportSettings['file_name'];
        $tableName = $cImportSettings['table_name'];
        $importFieldsType = $cImportSettings['import_fields_type'];
        $fieldsList = $cImportSettings['custom_fields'];
        $csvSeparator = $cImportSettings['file_separator'];
        $ignoreFirstRow = $cImportSettings['ignore_first_row'];

        $fileName = DIR_IMPORT . $fileName;

        if (file_exists($fileName)) {
            switch ($importType) {
                case "csv":
                    $this->runCSVImport($fileName, $tableName, $updateQuery, $importFieldsType, $fieldsList, $csvSeparator, $ignoreFirstRow);
                    break;
                case "xls":
                case "xlsx":
                    $this->runXLSImport($fileName, $tableName, $updateQuery, $importFieldsType, $fieldsList, $csvSeparator, $ignoreFirstRow);
                    break;
            }

        } else {
            $this->showError("Import file do not exist : '$fileName' ");
        }
    }

    /**
     * @param $fileName
     * @param $tableName
     * @param $importFieldsType
     * @param $fieldsList
     * @param $csvSeparator
     * @param $ignoreFirstRow
     */
    private function runCSVImport($fileName, $tableName, $updateQuery, $importFieldsType, $fieldsList, $csvSeparator, $ignoreFirstRow)
    {
        $count = null;
        list($count) = preg_split("/[\s,]+/", exec('wc -l ' . escapeshellarg($fileName)));

        if (!$count) {
            $count = count(file($fileName));
        }
        //
        if ($ignoreFirstRow == false) $count++;

        $handle = fopen($fileName, "r");

        $format = $updateQuery == true ? "Updated" : "Inserted";
        $format .= " Queries : %current%/%max% [%bar%] %percent% (%elapsed%)";
        $filler = '=>';
        $empty = ' ';
        $width = 100;
        /**
         * Init Progress Bar
         */
        $bar = new Console_ProgressBar($format, $filler, $empty, $width, $count);
        $cp = 0;
        while (($lineData = fgetcsv($handle, 1000, $csvSeparator)) !== FALSE) {
            if ($cp == 0 && $ignoreFirstRow == true) {
                $cp++;
                continue;
            } elseif ($cp == 0 && $ignoreFirstRow == false) {
                $cp++;
            }
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

            if ($updateQuery == true) {
                $sql = "UPDATE $tableName ";
                $sql .= "SET " . implode(',', $aUpdateQuery);
                $sql .= "WHERE " . $fieldsList[0] . "='" . $aLine[0] . "' ";
            } else {
                if ($importFieldsType == 'all') {
                    $sql = "INSERT INTO $tableName VALUES ";
                } else {
                    $sql = "INSERT INTO $tableName (" . implode(",", $fieldsList)
                        . ") VALUES ";
                }
                $sql .= "('" . implode("','", $aLine) . "')";
            }
            $this->DB->Execute($sql);
            $bar->update($cp++);

        }

        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            $this->showError($errorMsg);
        } else {
            $this->showNotice("Import has been successfully finished : " . ($cp - 1) . " rows imported.");
        }
    }

    /**
     * @param $fileName
     * @param $tableName
     * @param $importFieldsType
     * @param $fieldsList
     * @param $csvSeparator
     */
    private function runXLSImport($fileName, $tableName, $updateQuery, $importFieldsType, $fieldsList, $csvSeparator, $ignoreFirstRow)
    {

        $objPHPExcel = PHPExcel_IOFactory::load($fileName);
        $count = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objWorksheet = $objPHPExcel->getActiveSheet();

        if ($ignoreFirstRow == true) $count--;

        $format = $updateQuery == true ? "Updated" : "Inserted";
        $format .= " Queries : %current%/%max% [%bar%] %percent% (%elapsed%)";
        $filler = '=>';
        $empty = ' ';
        $width = 100;
        /**
         * Init Progress Bar
         */
        $bar = new Console_ProgressBar($format, $filler, $empty, $width, $count);

        $cp = 1;
        $cpQuery = 0;
        foreach ($objWorksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
            if ($ignoreFirstRow && $cp++ == 1) {
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
            if ($updateQuery == true) {
                $sql = "UPDATE $tableName ";
                $sql .= "SET " . implode(',', $aUpdateQuery);
                $sql .= "WHERE " . $fieldsList[0] . "='" . $aLine[0] . "' ";
            } else {
                if ($importFieldsType == 'all') {
                    $sql = "INSERT INTO $tableName VALUES ";
                } else {
                    $sql = "INSERT INTO $tableName (" . implode(",", $fieldsList)
                        . ") VALUES ";
                }
                $sql .= "('" . implode("','", $aLine) . "')";
            }
            //echo "\n $sql\n";
            $this->DB->Execute($sql);
            $cpQuery++;
            $bar->update($cpQuery);
        }

        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            $this->showError($errorMsg);
        } else {
            $this->showNotice("Import has been successfully finished : " . $cpQuery . " rows imported.");
        }

    }

    /**
     * @param $cExportSettings
     */
    public function runExport($cExportSettings)
    {
        global $blueColor;

        if ($this->DB->_connectionID == false) {
            $this->showError($this->DB->ErrorMsg());
            return;
        }
        echo $blueColor;

        $exportType = $cExportSettings['export_type'];
        $fileName = $cExportSettings['file_name'];
        $tableName = $cExportSettings['table_name'];
        $importFieldsType = $cExportSettings['export_fields_type'];
        $fieldsList = $cExportSettings['custom_fields'];
        $csvSeparator = $cExportSettings['file_separator'];
        $exportFieldsName = $cExportSettings['export_fields_name'];

        $fileName = DIR_EXPORT . $fileName;

        switch ($exportType) {
            case "csv":
                $this->runCSVExport($fileName, $tableName, $importFieldsType, $fieldsList, $csvSeparator, $exportFieldsName);
                break;
            case "xls":
            case "xlsx":
                $this->runXlSExport($exportType, $fileName, $tableName, $importFieldsType, $fieldsList, $exportFieldsName);
                break;
            case "pdf":
                $this->runPDFExport($fileName, $tableName, $importFieldsType, $fieldsList, $csvSeparator, $exportFieldsName);
                break;
        }

    }

    /**
     * @param $fileName
     * @param $tableName
     * @param $importFieldsType
     * @param $fieldsList
     * @param $csvSeparator
     * @param $exportFieldsName
     */
    private function runCSVExport($fileName, $tableName, $importFieldsType, $fieldsList, $csvSeparator, $exportFieldsName)
    {

        $fileName = $fileName . '.csv';

        $fp = fopen($fileName, 'w');
        if ($exportFieldsName) {
            FileManager::putCSV($fp, $fieldsList, $csvSeparator, '');
        }
        if ($importFieldsType == "all") {
            $query = "SELECT *  FROM $tableName";
        } else {
            $query = "SELECT " . implode(",", $fieldsList) .
                " FROM $tableName";
        }
        $format = "Exported rows : %current%/%max% [%bar%] %percent% (%elapsed%)";
        $filler = '=>';
        $empty = ' ';
        $width = 100;

        $cp = 0;
        $result = $this->DB->Execute($query);
        if ($result !== false) {
            $count = $result->_numOfRows;
            /**
             * Init Progress Bar
             */
            $bar = new Console_ProgressBar($format, $filler, $empty, $width, $count);

            while (!$result->EOF) {
                $aRecords = $result->fields;
                FileManager::putCSV($fp, $aRecords, $csvSeparator, '');
                $result->MoveNext();
                $cp++;
                $bar->update($cp);
            }
            $this->showNotice("Export has been successfully finished : " . $cp . " rows exported.");
        }
        fclose($fp);

        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            $this->showError($errorMsg);
        }

    }

    /**
     * @param $exportType
     * @param $fileName
     * @param $tableName
     * @param $importFieldsType
     * @param $fieldsList
     * @param $exportFieldsName
     */
    private function runXlSExport($exportType, $fileName, $tableName, $importFieldsType, $fieldsList, $exportFieldsName)
    {
        $format = "Exported rows : %current%/%max% [%bar%] %percent% (%elapsed%)";
        $filler = '=>';
        $empty = ' ';
        $width = 100;

        if ($importFieldsType == "all") {
            $query = "SELECT *  FROM $tableName";
        } else {
            $query = "SELECT " . implode(",", $fieldsList) .
                " FROM $tableName";
        }
        $result = $this->DB->Execute($query);
        if ($result !== false) {
            $count = $result->_numOfRows;
            /**
             * Init Progress Bar
             */
            $bar = new Console_ProgressBar($format, $filler, $empty, $width, $count);
            $cpBar = 0;
            FileManager::generateExcelFile($result, $exportFieldsName, $exportType, $fileName, $fieldsList, $bar, $cpBar);
            $this->showNotice("Export has been successfully finished : " . $cpBar . " rows exported.");
        }
        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            $this->showError($errorMsg);
        }

    }

    /**
     * @param $fileName
     * @param $tableName
     * @param $importFieldsType
     * @param $fieldsList
     * @param $exportFieldsName
     */
    private function runPDFExport($fileName, $tableName, $importFieldsType, $fieldsList, $exportFieldsName)
    {
        $format = "Exported rows : %current%/%max% [%bar%] %percent% (%elapsed%)";
        $filler = '=>';
        $empty = ' ';
        $width = 100;

        if ($importFieldsType == "all") {
            $query = "SELECT *  FROM $tableName";
        } else {
            $query = "SELECT " . implode(",", $fieldsList) .
                " FROM $tableName";
        }
        $result = $this->DB->Execute($query);
        if ($result !== false) {
            $count = $result->_numOfRows;
            /**
             * Init Progress Bar
             */
            $bar = new Console_ProgressBar($format, $filler, $empty, $width, $count);
            $cpBar = 0;
            FileManager::generatePDFFile($result, $exportFieldsName, $fileName, $fieldsList, $bar, $cpBar);
            $this->showNotice("Export has been successfully finished : " . $cpBar . " rows exported.");
        }
        $errorMsg = $this->DB->ErrorMsg();
        if ($errorMsg != "") {
            $this->showError($errorMsg);
        }

    }

    /**
     * @param $errorMessage
     */
    static public function showError($errorMessage)
    {
        global $errorColor;
        echo $errorColor;
        echo "\nERROR : " . $errorMessage;
    }

    /**
     * @param $errorMessage
     */
    static public function showNotice($successMessage)
    {
        global $successColor;
        echo $successColor;
        echo "\nSUCCESS : " . $successMessage;
    }

    /**
     *
     */
    static public function startScript()
    {
        global $normalColor;
        echo "$normalColor";
    }

    /**
     *
     */
    static public function endScript()
    {
        global $normalColor;
        echo "\n$normalColor\n";
    }
}