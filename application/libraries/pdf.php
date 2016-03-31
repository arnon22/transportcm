<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require ('fpdf.php');
require ('htmlparser.inc');

class Pdf extends FPDF
{
    // Extend FPDF using this class
    // More at fpdf.org -> Tutorials
    var $CI;
    var $widths;
    var $aligns;

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        // Call parent constructor
        parent::__construct($orientation, $unit, $size);
    }

    public function Footer()
    {
        $obj = &get_instance();
        $this->AddFont('THNiramitAS', '', 'THNiramit.php');
        $this->SetFont('THNiramitAS', '', 12);
        //$this->SetY(-10);
        $this->SetXY(10, -10);
        date_default_timezone_set('Asia/Bangkok');
        $tex_l = $obj->lang->line('print_date') . date('d') . '/' . date('m') . '/' . (date
            ('Y') + 543) . " เวลา " . date('H:i:s');
        $text_r = 'หน้า ' . $this->PageNo() . ' / {nb}';
        $txt_r = iconv('utf-8', 'tis-620', $text_r);
        $txt_L = iconv('utf-8', 'tis-620', $tex_l);
        $this->Cell(0, 10, $txt_L, 0, 0, 'L');
        $this->Cell(0, 10, $txt_r, 0, 0, 'R');
        //$this->Cell(0) ;

    }

    public function totalpage()
    {

        //$c_page = strval($this->PageNo());
        return '{nb}';
        /*
        if('{nb}'== 5){
        return true;
        }else{
        return false;
        }
        */
        //return $final;
    }

    var $javascript;
    var $n_js;

    function IncludeJS($script)
    {
        $this->javascript = $script;
    }

    function _putjavascript()
    {
        $this->_newobj();
        $this->n_js = $this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) ' . ($this->n + 1) . ' 0 R]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS ' . $this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources()
    {
        parent::_putresources();
        if (!empty($this->javascript))
        {
            $this->_putjavascript();
        }
    }

    function _putcatalog()
    {
        parent::_putcatalog();
        if (!empty($this->javascript))
        {
            $this->_out('/Names <</JavaScript ' . ($this->n_js) . ' 0 R>>');
        }
    }

    function AutoPrint($dialog = false)
    {
        //Open the print dialog or start printing immediately on the standard printer
        $param = ($dialog ? 'true' : 'false');
        $script = "print($param);";
        $script .= "window.onbeforeunload = function(e) {
  return 'Dialog text here.';
};";

        $this->IncludeJS($script);

    }

    function AutoPrintToPrinter($server, $printer, $dialog = false)
    {
        //Print on a shared printer (requires at least Acrobat 6)
        $script = "var pp = getPrintParams();";
        if ($dialog)
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
        else
            $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
        $script .= "pp.printerName = '\\\\\\\\" . $server . "\\\\" . $printer . "';";
        $script .= "print(pp);";
        $this->IncludeJS($script);
    }


    function BasicTable($header, $data)
    {
        // Header
        foreach ($header as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();
        // Data
        foreach ($data as $row)
        {
            foreach ($row as $col)
                $this->Cell(40, 6, $col, 1);
            $this->Ln();
        }
    }


    //Table Query

    var $ProcessingTable = false;
    var $aCols = array();
    var $TableX;
    var $HeaderColor;
    var $RowColors;
    var $ColorIndex;

    function Header()
    {
        //Print the table header if necessary
        if ($this->ProcessingTable)
            $this->TableHeader();
    }

    function TableHeader()
    {
        $this->AddFont('THNiramitAS', '', 'THNiramit.php');
        $this->SetFont('THNiramitAS', '', 12);
        $this->SetX($this->TableX);
        $fill = !empty($this->HeaderColor);
        if ($fill)
            $this->SetFillColor($this->HeaderColor[0], $this->HeaderColor[1], $this->
                HeaderColor[2]);
        foreach ($this->aCols as $col)
            $this->Cell($col['w'], 6, $col['c'], 1, 0, 'C', $fill);
        $this->Ln();
    }

    function Row($data)
    {
        $this->SetX($this->TableX);
        $ci = $this->ColorIndex;
        $fill = !empty($this->RowColors[$ci]);
        if ($fill)
            $this->SetFillColor($this->RowColors[$ci][0], $this->RowColors[$ci][1], $this->
                RowColors[$ci][2]);
        foreach ($this->aCols as $col)
            $this->Cell($col['w'], 5, $data[$col['f']], 1, 0, $col['a'], $fill);
        $this->Ln();
        $this->ColorIndex = 1 - $ci;
    }

    function CalcWidths($width, $align)
    {
        //Compute the widths of the columns
        $TableWidth = 0;
        foreach ($this->aCols as $i => $col)
        {
            $w = $col['w'];
            if ($w == -1)
                $w = $width / count($this->aCols);
            elseif (substr($w, -1) == '%')
                $w = $w / 100 * $width;
            $this->aCols[$i]['w'] = $w;
            $TableWidth += $w;
        }
        //Compute the abscissa of the table
        if ($align == 'C')
            $this->TableX = max(($this->w - $TableWidth) / 2, 0);
        elseif ($align == 'R')
            $this->TableX = max($this->w - $this->rMargin - $TableWidth, 0);
        else
            $this->TableX = $this->lMargin;
    }

    function AddCol($field = -1, $width = -1, $caption = '', $align = 'L')
    {
        //Add a column to the table
        if ($field == -1)
            $field = count($this->aCols);
        $this->aCols[] = array(
            'f' => $field,
            'c' => $caption,
            'w' => $width,
            'a' => $align);
    }

    function Table($query, $prop = array())
    {
        //Issue query
        $res = mysql_query($query) or die('Error: ' . mysql_error() . "<BR>Query: $query");
        //Add all columns if none was specified
        if (count($this->aCols) == 0)
        {
            $nb = mysql_num_fields($res);
            for ($i = 0; $i < $nb; $i++)
                $this->AddCol();
        }
        //Retrieve column names when not specified
        foreach ($this->aCols as $i => $col)
        {
            if ($col['c'] == '')
            {
                if (is_string($col['f']))
                    $this->aCols[$i]['c'] = ucfirst($col['f']);
                else
                    $this->aCols[$i]['c'] = ucfirst(mysql_field_name($res, $col['f']));
            }
        }
        //Handle properties
        if (!isset($prop['width']))
            $prop['width'] = 0;
        if ($prop['width'] == 0)
            $prop['width'] = $this->w - $this->lMargin - $this->rMargin;
        if (!isset($prop['align']))
            $prop['align'] = 'C';
        if (!isset($prop['padding']))
            $prop['padding'] = $this->cMargin;
        $cMargin = $this->cMargin;
        $this->cMargin = $prop['padding'];
        if (!isset($prop['HeaderColor']))
            $prop['HeaderColor'] = array();
        $this->HeaderColor = $prop['HeaderColor'];
        if (!isset($prop['color1']))
            $prop['color1'] = array();
        if (!isset($prop['color2']))
            $prop['color2'] = array();
        $this->RowColors = array($prop['color1'], $prop['color2']);
        //Compute column widths
        $this->CalcWidths($prop['width'], $prop['align']);
        //Print header
        $this->TableHeader();
        //Print rows
        $this->SetFont('Arial', '', 11);
        $this->ColorIndex = 0;
        $this->ProcessingTable = true;
        while ($row = mysql_fetch_array($res))
            $this->Row($row);
        $this->ProcessingTable = false;
        $this->cMargin = $cMargin;
        $this->aCols = array();
    }

    //HtmlTable
    var $B;
    var $I;
    var $U;
    var $HREF;

    function PDF($orientation = 'P', $unit = 'mm', $format = 'A4')
    {
        //Call parent constructor
        $this->FPDF($orientation, $unit, $format);
        //Initialization
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
        $this->HREF = '';
    }

    function WriteHTML2($html)
    {
        //HTML parser
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e)
        {
            if ($i % 2 == 0)
            {
                //Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else
            {
                //Tag
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else
                {
                    //Extract attributes
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v)
                    {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        //Opening tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
        if ($tag == 'P')
            $this->Ln(10);
    }

    function CloseTag($tag)
    {
        //Closing tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
        if ($tag == 'P')
            $this->Ln(10);
    }

    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array(
            'B',
            'I',
            'U') as $s)
            if ($this->$s > 0)
                $style .= $s;
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }

    function WriteTable($data, $w)
    {
        $this->SetLineWidth(.3);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        foreach ($data as $row)
        {
            $nb = 0;
            for ($i = 0; $i < count($row); $i++)
                $nb = max($nb, $this->NbLines($w[$i], trim($row[$i])));
            $h = 5 * $nb;
            $this->CheckPageBreak($h);
            for ($i = 0; $i < count($row); $i++)
            {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Rect($x, $y, $w[$i], $h);
                $this->MultiCell($w[$i], 5, trim($row[$i]), 0, 'C');
                //Put the position to the right of the cell
                $this->SetXY($x + $w[$i], $y);
            }
            $this->Ln($h);

        }
    }


    function ReplaceHTML($html)
    {
        $html = str_replace('<li>', "\n<br> - ", $html);
        $html = str_replace('<LI>', "\n - ", $html);
        $html = str_replace('</ul>', "\n\n", $html);
        $html = str_replace('<strong>', "<b>", $html);
        $html = str_replace('</strong>', "</b>", $html);
        $html = str_replace('&#160;', "\n", $html);
        $html = str_replace('&nbsp;', " ", $html);
        $html = str_replace('&quot;', "\"", $html);
        $html = str_replace('&#39;', "'", $html);
        return $html;
    }

    function ParseTable($Table)
    {
        $_var = '';
        $htmlText = $Table;
        $parser = new HtmlParser($htmlText);
        while ($parser->parse())
        {
            if (strtolower($parser->iNodeName) == 'table')
            {
                if ($parser->iNodeType == NODE_TYPE_ENDELEMENT)
                    $_var .= '/::';
                else
                    $_var .= '::';
            }

            if (strtolower($parser->iNodeName) == 'tr')
            {
                if ($parser->iNodeType == NODE_TYPE_ENDELEMENT)
                    $_var .= '!-:'; //opening row
                else
                    $_var .= ':-!'; //closing row
            }
            if (strtolower($parser->iNodeName) == 'td' && $parser->iNodeType ==
                NODE_TYPE_ENDELEMENT)
            {
                $_var .= '#,#';
            }
            if ($parser->iNodeName == 'Text' && isset($parser->iNodeValue))
            {
                $_var .= $parser->iNodeValue;
            }
        }
        $elems = explode(':-!', str_replace('/', '', str_replace('::', '', str_replace('!-:',
            '', $_var)))); //opening row
        foreach ($elems as $key => $value)
        {
            if (trim($value) != '')
            {
                $elems2 = explode('#,#', $value);
                array_pop($elems2);
                $data[] = $elems2;
            }
        }
        return $data;
    }

    function WriteHTML($html)
    {
        $html = $this->ReplaceHTML($html);
        //Search for a table
        $start = strpos(strtolower($html), '<table');
        $end = strpos(strtolower($html), '</table');
        if ($start !== false && $end !== false)
        {
            $this->WriteHTML2(substr($html, 0, $start) . '<BR>');

            $tableVar = substr($html, $start, $end - $start);
            $tableData = $this->ParseTable($tableVar);
            for ($i = 1; $i <= count($tableData[0]); $i++)
            {
                if ($this->CurOrientation == 'L')
                    $w[] = abs(120 / (count($tableData[0]) - 1)) + 24;
                else
                    $w[] = abs(120 / (count($tableData[0]) - 1)) + 5;
            }
            $this->WriteTable($tableData, $w);

            $this->WriteHTML2(substr($html, $end + 8, strlen($html) - 1) . '<BR>');
        } else
        {
            $this->WriteHTML2($html);
        }
    }


    function expense_pdf($data)
    {
        $this->CI = &get_instance();
        $this->CI->load->library('conv_date');

        //Load library
        $this->CI->load->library('conv_date');
        $stratDate = $this->CI->session->userdata('startDate');
        $endDate = $this->CI->session->userdata('endDate');
        $expense_Type = $this->CI->session->userdata('expenseType');

        $st_date2 = $this->CI->conv_date->eng2engDatedot($stratDate);
        $st_date = $this->CI->conv_date->DateThai2($st_date2);
        $ed_date2 = $this->CI->conv_date->eng2engDatedot($endDate);
        $ed_date = $this->CI->conv_date->DateThai2($ed_date2);




        if($expense_Type=="car"){
            $title = "รายงาน รายจ่ายเกี่ยวกับรถ";
        }else{
            $title = "รายงาน รายจ่ายทั่วไป";
        }
        $head_report = iconv('UTF-8', 'TIS-620', $title);
        $right_report = "วันที่ $st_date ถึงวันที่ $ed_date";

        $i = 0;


        $sumline_amount = 0;

        // Create PDf Report
        /*
        $this->AliasNbPages();
        $this->SetMargins(5, 5, 5);
        $this->AddPage('P', 'A4');
        $p = $this->totalpage();
        $c_page = $this->PageNo();
        */

        // Create PDf Report
        $this->SetAutoPageBreak(false);
        $this->AliasNbPages();
        $this->AddPage('P', 'A4');
        $this->SetMargins(5, 5, 5);
        $p = $this->totalpage();

        //**** กำหนดขนาด Space ของ Footer
        $height_of_cell = 45; // mm
        $page_height = 297; //210 x 297  mm (portrait letter)
        $bottom_margin = 0; // mm



        //Header Report
        $this->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
        $this->SetFont('THNiramitAS-Bold', '', 16);
        $this->Header();
        $this->SetX(75);
        $this->Cell(50, 10, $head_report, 'C');
        $this->Ln();
        $this->AddFont('THNiramitAS', '', 'THNiramit.php');
        $this->SetFont('THNiramitAS', '', 15);
        $this->SetX(-65);
        $this->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
        $this->Ln();


        if ($expense_Type == "car")
        {
            #hearder Table
            $factory_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('factory'));
            $ref_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('reference_number'));
            $Date_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('date'));
            $List_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('list'));
            $car_number_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('car_number'));
            $Amount_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('amount'));
            $Remark_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('remark'));

            $this->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->SetFont('THNiramitAS', '', 15);
            #TITLE
            $this->SetWidths(array(
                22,
                16,
                24,
                78,
                24,
                37
            ));
            $this->SetAligns(array(
                "C",
                "C",
                "C",
                "C",
                "C",
                "C"
            ));
            $this->mRows(array(
                "$Date_title",
                "$factory_title",
                "$car_number_title",
                "$List_title",
                "$Amount_title",
                "$Remark_title",
            ));

        } else
        {
            #hearder Table
            $factory_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('factory'));
            $ref_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('reference_number'));
            $Date_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('date'));
            $List_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('list'));
            $Amount_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('amount'));
            $Remark_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('remark'));
            $this->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->SetFont('THNiramitAS', '', 15);
            #TITLE
            $this->SetWidths(array(
                22,
                15,
                90,
                28,
                45));
            $this->SetAligns(array(
                "C",
                "C",
                "C",
                "C",
                "C"));
            $this->mRows(array(
                "$Date_title",
                "$factory_title",
                "$List_title",
                "$Amount_title",
                "$Remark_title"));


        }
        #footer
        $Baht = iconv('utf-8', 'tis-620', $this->CI->lang->line('baht'));
        $sub_total_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('sub_total'));
        $totals_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('totals'));


        date_default_timezone_set('Asia/Bangkok');

        foreach ($data as $row)
        {

            $expense_date = $this->CI->conv_date->eng2engDate(date('Y-m-d', strtotime("{$row['expense_date']}")));
            $ref_number = iconv('utf-8', 'tis-620', $row['ref_number']);
            $factory = iconv('utf-8', 'tis-620', $row['factory_code']);
            $car_number = iconv('utf-8', 'tis-620', $row['car_number']);
            $deatil = iconv('utf-8', 'tis-620', $row['expense_details']);
            $amount = number_format($row['total_amount'], 2, '.', ',');
            $totals = number_format($row['totals'], 2, '.', ',');
            $remark = iconv('utf-8', 'tis-620', $row['note']);

            $sumline_amount = $sumline_amount + $row['total_amount'];

            $this->AddFont('THNiramitAS', '', 'THNiramit.php');
            $this->SetFont('THNiramitAS', '', 15);

            /*กำหนดค่า Space ด้าน ด้านซ้าย*/
            $space_left = $page_height - ($this->GetY() + $bottom_margin); // space left on page

            if ($expense_Type == "car")
            {
               /*car*/
                $this->SetWidths(array(
                    22,
                    16,
                    24,
                    78,
                    24,
                    37
                ));
                $this->SetAligns(array(
                    "L",
                    "C",
                    "C",
                    "L",
                    "R",
                    "L"));

                $this->mRows(array(
                    "$expense_date",
                    "$factory",
                    "$car_number",
                    "$deatil",
                    "$amount",
                    "$remark"));


            } else
            {
                /*
                รายงานค่าใช้จ่ายทั่วไป
                */
                $this->SetWidths(array(
                    22,
                    15,
                    90,
                    28,
                    45));;
                $this->SetAligns(array(
                    "L",
                    "C",
                    "L",
                    "R",
                    "L"));
                $this->mRows(array(
                    "$expense_date",
                    "$factory",
                    "$deatil",
                    "$amount",
                    "$remark"));

            }


            $h = 1 * $i;

            #if ($this->GetY() + $h > $this->PageBreakTrigger + 15)
            if ($height_of_cell > $space_left)
            {
                $sub_total = number_format($sumline_amount, 2, '.', ',');

                if ($expense_Type == "car")
                {
                    /* Car */
                    $this->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                    $this->Cell(140, 5, $sub_total_title, 1, 0, "C", true);
                    $this->Cell(24, 5, $sub_total, 1, 0, "R", true);
                    $this->Cell(37, 5, "", 1, 0, "L", true);
                    $this->Ln();
                } else
                {
                    /*Normal*/
                    /*
                    #Date Modified 12/05/2015
                    $this->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                    $this->Cell(120, 5, $sub_total_title, 1, 0, "C", true);
                    $this->Cell(25, 5, $sub_total, 1, 0, "R", true);
                    $this->Cell(57, 5, $Baht, 1, 0, "C", true);
                    */


                    $this->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                    $this->Cell(127, 5, $sub_total_title, 1, 0, "C", true);
                    $this->Cell(28, 5, $sub_total, 1, 0, "R", true);
                    $this->Cell(45, 5, "", 1, 0, "C", true);

                }


                $sumline_amount = 0;



                if ($expense_Type == "car")
                {
                    $this->AddPage();
                    //Header Report
                    $this->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->SetFont('THNiramitAS-Bold', '', 16);
                    $this->Header();
                    $this->SetX(75);
                    $this->Cell(50, 10, $head_report, 'C');
                    $this->Ln();
                    $this->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->SetFont('THNiramitAS', '', 15);
                    $this->SetX(-65);
                    $this->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                    $this->Ln();

                    #TITLE
                    $this->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->SetFont('THNiramitAS', '', 15);
                    $this->SetWidths(array(
                        22,
                        16,
                        24,
                        78,
                        24,
                        37
                    ));
                    $this->SetAligns(array(
                        "L",
                        "L",
                        "L",
                        "L",
                        "R",
                        "L"
                    ));
                    $this->mRows(array(
                        "$Date_title",
                        "$factory_title",
                        "$car_number_title",
                        "$List_title",
                        "$Amount_title",
                        "$Remark_title",
                    ));

                    $this->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->SetFont('THNiramitAS', '', 15);


                } else
                {
                    #hearder Table Normal
                    $this->AddPage();
                    //Header Report
                    $this->AddFont('THNiramitAS-Bold', '', 'THNiramit Bold.php');
                    $this->SetFont('THNiramitAS-Bold', '', 16);
                    $this->Header();
                    $this->SetX(75);
                    $this->Cell(50, 10, $head_report, 'C');
                    $this->Ln();
                    $this->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->SetFont('THNiramitAS', '', 15);
                    $this->SetX(-65);
                    $this->Cell(10, 10, iconv('utf-8', 'tis-620', $right_report), 'C');
                    $this->Ln();

                    $factory_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('factory'));
                    $ref_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('reference_number'));
                    $Date_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('date'));
                    $List_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('list'));
                    $Amount_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('amount'));
                    $Remark_title = iconv('utf-8', 'tis-620', $this->CI->lang->line('remark'));
                    #TITLE
                    $this->AddFont('THNiramitAS', '', 'THNiramit.php');
                    $this->SetFont('THNiramitAS', '', 15);
                    $this->SetWidths(array(
                        22,
                        15,
                        90,
                        28,
                        45));
                    $this->SetAligns(array(
                        "C",
                        "C",
                        "C",
                        "C",
                        "C"));
                    $this->mRows(array(
                        "$Date_title",
                        "$factory_title",
                        "$List_title",
                        "$Amount_title",
                        "$Remark_title"));

                }


                $i = 0;
            } //End if
            $i++;


        } // end for each

        if ('{nb}' == $p)
        {

            if ($expense_Type == "car")
            {

                $sub_total = number_format($sumline_amount, 2, '.', ',');
                $this->SetFillColor(220, 220, 255); //$this->pdf->SetFillColor(200,220,255);
                $this->Cell(140, 5, $sub_total_title, 1, 0, "C", true);
                $this->Cell(24, 5, $sub_total, 1, 0, "R", true);
                $this->Cell(37, 5, "", 1, 0, "L", true);
            } else
            {
                //Subtotal หน้าสุดท้าย
                $sub_total = number_format($sumline_amount, 2, '.', ',');
                $this->SetFillColor(220, 220, 255);
                $this->Cell(127, 5, $sub_total_title, 1, 0, "C", true);
                $this->Cell(28, 5, $sub_total, 1, 0, "R", true);
                $this->Cell(45, 5, "", 1, 0, "L", true);
                /*
                $this->SetWidths(array(
                    127,
                    28,
                    45
                ));
                $this->SetAligns(array(
                    "C",
                    "R",
                    "L"
                ));
                $this->mRows(array(
                    "$sub_total_title",
                    "$sub_total",
                    "$Baht"
                ));
                */

            }
        }

        if ($expense_Type == "car")
        {
            /*
            #Modified Date 12/05/2015
            $this->SetY(270);
            $this->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
            $this->Cell(122, 5, $totals_title, 1, 0, "C", true);
            $this->Cell(25, 5, $totals, 1, 0, "R", true);
            $this->Cell(55, 5, $Baht, 1, 0, "C", true);
            */
            $this->SetY(270);
            $this->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
            $this->Cell(140, 5, $totals_title, 1, 0, "C", true);
            $this->Cell(24, 5, $totals, 1, 0, "R", true);
            $this->Cell(37, 5, "", 1, 0, "L", true);

        } else
        {
            #Normal Footer
            $this->SetY(270);
            $this->SetFillColor(200, 220, 255); //$this->pdf->SetFillColor(200,220,255);
            $this->Cell(127, 5, $totals_title, 1, 0, "C", true);
            $this->Cell(28, 5, $totals, 1, 0, "R", true);
            $this->Cell(45, 5, "", 1, 0, "L", true);
        }


        // Print Out
        //$this->AutoPrint(true);
        $this->Output();
        //$this->Output('expense_report.pdf', 'I');


    } //expense_pdf

    /* Start Table Function*/
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }
    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb)
        {
            $c = $s[$i];
            if ($c == "\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax)
            {
                if ($sep == -1)
                {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function mRows($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 7 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 7, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    /*End of Table function*/

} // End Class


?>