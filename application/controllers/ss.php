<?php
/**
 * Created by PhpStorm.
 * User: Anon
 * Date: 26/2/2559
 * Time: 15:55
 */
$stock_date = iconv('utf-8', 'tis-620', $stock_date);
$this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', "{$row['ref_number']}"), 1,
    'C');
if ($oilType == "1") {
    $this->pdf->Cell(45, 8, iconv('utf-8', 'tis-620', "{$row['stock_details']}"), 1,
        'C');
} else {
    $this->pdf->Cell(45, 8, iconv('utf-8', 'tis-620', "{$row['stock_details']} {$row['car_number']}"),
        1, 'C');
}

$this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "{$row['receive_oil']}"), 1,
    'C');
$this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($row['receive_price'],
    2, '.', ',')), 1, 'C');
$this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['receive_amount'],
    2, '.', ',')), 1, 'C');
$this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', "{$row['sell_oil']}"), 1, 'C');
$this->pdf->Cell(22, 8, iconv('utf-8', 'tis-620', number_format($row['sell_price'],
    2, '.', ',')), 1, 'C');
$this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', number_format($row['sell_amount'],
    2, '.', ',')), 1, 'C');
$this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', ""), 1, 'C');
$this->pdf->Cell(25, 8, iconv('utf-8', 'tis-620', ""), 1, 'C');