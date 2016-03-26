<?php
/**
 * Created by PhpStorm.
 * User: Anon
 * Date: 26/2/2559
 * Time: 15:55
 */
// Create PDf Report
$this->pdf->SetAutoPageBreak(false);
$this->pdf->AliasNbPages();
$p = $this->pdf->totalpage();

//**** กำหนดขนาด Space ของ Footer
$height_of_cell = 30; // mm
$page_height = 210; // A4 = 210 x 297mm (portrait letter)
$bottom_margin = 0; // mm


/** In Loop */
/*กำหนดค่า Space ด้าน ด้านซ้าย*/
$space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page


if ($height_of_cell > $space_left) {}


//Header Report
$this->pdf->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
$this->pdf->SetFont('THNiramitAS-Bold', '', 16);

$this->pdf->AddFont('THNiramitAS', '', 'THNiramit.php');
$this->pdf->SetFont('THNiramitAS', '', 16);


$order_date = date('Y-m-d', strtotime($row['order_date']));
$order_time = date('H:i', strtotime($row['order_date']));

$startdate = $this->session->userdata('startdate');
$s_start = $this->conv_date->eng2engDatedot($startdate);
$enddate = $this->session->userdata('enddate');
$e_date = $this->conv_date->eng2engDatedot($enddate);

/* Title */
$this->pdf->SetWidths(array(
    34,
    20,
    18,
    45,
    20,
    15,
    22,
    27));

$this->pdf->SetAligns(array(
    "L",
    "L",
    "L",
    "L",
    "L",
    "L",
    "L",
    "L",
    "L"));
$this->pdf->mRows(array(
    "$dateTime",
    "$refNum",
    "$carNumber",
    "$details",
    "$oilValue",
    "$priceList",
    "$priceAmount",
    "$remark"));

$this->pdf->SetWidths(array(
    22,
    20,
    65,
    20,
    15,
    24,
    20,
    15,
    24,
    27,
    27));

$this->pdf->SetAligns(array(
    "L",
    "L",
    "L",
    "L",
    "R",
    "R",
    "L",
    "R",
    "R",
    "L",
    "R"));
$this->pdf->mRows(array(
    "$stock_date",
    "$ref_no",
    "$stock_detail",
    "$recive_oil",
    "$recive_price",
    "$receive_amount",
    "$sell_oil",
    "$sell_price",
    "$sell_amount",
    "",
    ""));
