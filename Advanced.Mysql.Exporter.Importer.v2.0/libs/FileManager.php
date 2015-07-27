<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 27/11/12
 * Time: 14:02
 * To change this template use File | Settings | File Templates.
 */
Class FileManager
{
    /**
     * @param $handle
     * @param $fields
     * @param string $delimiter
     * @param string $enclosure
     * @param bool $useArrayKey
     * @param string $escape
     */
    static public function putCSV($handle, $fields, $delimiter = ',', $enclosure = '"', $useArrayKey = false, $escape = '\\')
    {
        $first = 1;
        foreach ($fields as $key => $field) {
            if ($first == 0)
                fwrite($handle, $delimiter);
            if ($useArrayKey) {
                $f = str_replace($enclosure, $enclosure . $enclosure, $key);
            } else {
                $field = EXPORT_ENCODE_FUNCTION != "none" && function_exists(EXPORT_ENCODE_FUNCTION) ? call_user_func(EXPORT_ENCODE_FUNCTION, $field) : $field;
                $f = str_replace($enclosure, $enclosure . $enclosure, $field);
            }

            if ($enclosure != $escape) {
                $f = str_replace($escape . $enclosure, $escape, $f);
            }
            if (strpbrk($f, " \t\n\r" . $delimiter . $enclosure . $escape) || strchr($f, "\000")) {
                fwrite($handle, $enclosure . $f . $enclosure);
            } else {
                fwrite($handle, $f);
            }
            $first = 0;
        }
        fwrite($handle, "\n");
    }

    /**
     * @param $file
     */
    static public function downloadCSVFile($file)
    {
        ob_start();
        ob_clean();
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-type: application/octet-stream");
        header("Content-Length: " . filesize($file));
        header("Content-Disposition: attachment; filename=" . str_replace(" ", "_", basename($file)));
        ob_end_clean();
        flush();
        readfile($file);
        unlink($file);
        exit();
    }

    /**
     * @param $result
     * @param $headerRow
     * @param $excelVersion
     * @param $xlsFileName
     * @param bool $fieldsList
     */
    static public function downloadExcelFile($result, $headerRow, $excelVersion, $xlsFileName, $fieldsList = false)
    {
        $objPHPExcel = self::buildExcelFile($result, $headerRow, $fieldsList);


        $objPHPExcel->setActiveSheetIndex(0);
        if ($excelVersion == "xls") {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $xlsFileName . '.xls"');
            $ExcelVersion = 'Excel5';
        } else {
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $xlsFileName . '.xlsx"');
            $ExcelVersion = 'Excel2007';
        }

        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $ExcelVersion);
        $objWriter->save('php://output');
        exit;
    }

    /**
     * @param $result
     * @param $headerRow
     * @param $excelVersion
     * @param $xlsFileName
     * @param bool $fieldsList
     */
    static public function generateExcelFile($result, $headerRow, $excelVersion, $xlsFileName, $fieldsList = false, $bar = null, &$cpBar)
    {
        $objPHPExcel = self::buildExcelFile($result, $headerRow, $fieldsList, $bar, $cpBar);
        $objPHPExcel->setActiveSheetIndex(0);
        if ($excelVersion == "xls") {
            $ExcelVersion = 'Excel5';
        } else {
            $ExcelVersion = 'Excel2007';
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $ExcelVersion);
        $objWriter->save($xlsFileName . "." . $excelVersion);
    }

    /**
     * @param $result
     * @param $headerRow
     * @param $pdfFileName
     * @param bool $fieldsList
     */
    static public function downloadPDFFile($result, $headerRow, $pdfFileName, $fieldsList = false)
    {
        set_error_handler('handleFalseError');

        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mPDF5.4';
        $rendererLibraryPath = LIBS . '/PDF/' . $rendererLibrary;

        $objPHPExcel = self::buildExcelFile($result, $headerRow, $fieldsList);

        if (!PHPExcel_Settings::setPdfRenderer(
            $rendererName,
            $rendererLibraryPath
        )
        ) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                    '<br />' .
                    'at the top of this script as appropriate for your directory structure'
            );
        }

        // Redirect output to a client’s web browser (PDF)
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $pdfFileName . '.pdf"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
        $objWriter->save('php://output');
        exit;
    }


    /**
     * @param $result
     * @param $headerRow
     * @param $pdfFileName
     * @param bool $fieldsList
     */
    static public function generatePDFFile($result, $headerRow, $pdfFileName, $fieldsList = false, $bar = null, &$cpBar)
    {
        set_error_handler('handleFalseError');

        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mPDF5.4';
        $rendererLibraryPath = LIBS . '/PDF/' . $rendererLibrary;

        $objPHPExcel = self::buildExcelFile($result, $headerRow, $fieldsList, $bar, $cpBar) ;

        if (!PHPExcel_Settings::setPdfRenderer(
            $rendererName,
            $rendererLibraryPath
        )
        ) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                    '<br />' .
                    'at the top of this script as appropriate for your directory structure'
            );
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
        $objWriter->save($pdfFileName.".pdf");
    }

    /**
     * @param $result
     * @param $headerRow
     * @param bool $fieldsList
     * @return PHPExcel
     */
    static function buildExcelFile($result, $headerRow, $fieldsList = false, $bar = null, &$cpBar = 0)
    {
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Advanced MySql Exporter Importer");
        $objPHPExcel->getProperties()->setTitle("Advanced MySql Exporter Importer");
        $objPHPExcel->getProperties()->setSubject("Advanced MySql Exporter Importer");

        $objPHPExcel->getActiveSheet()->setTitle('Exported Data');

        /*
         * Alphabetically Array
         * */
        $alphas = array();

        $cp = 0;
        $numRow = 1;
        /**
         * $fieldsList is Array
         */
        if ($fieldsList != false) {
            for ($i = 'A', $j = 0; $j < count($fieldsList) && $i < 'ZZZ'; $i++, $j++) {
                $alphas[] = $i;
            }
            if ($headerRow) {
                foreach ((array)$fieldsList as $field) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($alphas[$cp] . $numRow, $field);
                    $cp++;
                }
                $numRow++;
            }


            if ($result !== false) {
                while (!$result->EOF) {
                    $aRecords = $result->fields;
                    for ($ck = 0; $ck < count($fieldsList); $ck++) {
                        $valueCell = EXPORT_ENCODE_FUNCTION != "none" && function_exists(EXPORT_ENCODE_FUNCTION) ? call_user_func(EXPORT_ENCODE_FUNCTION, $aRecords[$ck]) : $aRecords[$ck];
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($alphas[$ck] . $numRow, $valueCell);
                    }

                    $result->MoveNext();
                    $numRow++;
                    if ($bar != null) {
                        $cpBar++;
                        $bar->update($cpBar);
                    }
                }
            }
        } else {
            for ($i = 'A'; $i < 'ZZZ'; $i++) {
                $alphas[] = $i;
            }
            if ($result !== false) {
                while (!$result->EOF) {
                    $aRecords = $result->fields;
                    if ($headerRow && $numRow == 1) {
                        foreach ($aRecords as $key => $field) {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue($alphas[$cp] . $numRow, $key);
                            $cp++;
                        }
                        $numRow++;
                    }
                    $cp = 0;
                    foreach ($aRecords as $key => $field) {
                        $valueCell = EXPORT_ENCODE_FUNCTION != "none" && function_exists(EXPORT_ENCODE_FUNCTION) ? call_user_func(EXPORT_ENCODE_FUNCTION, $field) : $field;
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($alphas[$cp] . $numRow, $valueCell);
                        $cp++;
                    }

                    $result->MoveNext();
                    $numRow++;
                    if ($bar != null) {
                        $cpBar++;
                        $bar->update($cpBar);
                    }
                }
            }
        }
        return $objPHPExcel;
    }
}
