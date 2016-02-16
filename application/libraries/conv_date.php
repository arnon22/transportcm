<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Conv_date
{


    public function thaiDate($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2] - 543;

        $dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;

        return $dateThai;

    }
    
     public function yearMonth($monthYear)
    {

        $dt = explode('/', $monthYear);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
       
        $month = $dt[0];
        $year = $dt[1];

        //$dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;
        $yearmonth = array('Year'=>$year,'Month'=>$month);

        return $yearmonth;

    }

    public function thaiDate2($date)
    {
        
        $dt = explode('-', date($date));
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $year = $dt[0];
        $mouht = $dt[1];
        $date = $dt[2];

        $dateThai = $date . "-" . $mouht . "-" . $year; //$year . "-" . $mouht . "-" . $date;

        return $dateThai;

    }
    
    public function name_report($text="",$startdate=null,$end_date=null){
        $st_date = str_ireplace("-","",$startdate);
        $ed_date = str_ireplace("-","",$end_date);
        $name = "$text".$st_date."-".$ed_date.".pdf";
        $filename = iconv("utf-8","tis-620",$name);
        
        return $filename;
        
    }

    public function thai2engDate($date)
    {

        $dt = explode('/', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2] - 543;

        $dateEng = $year . "-" . $mouht . "-" . $date;

        return $dateEng;

    }

    public function eng2engDate($date)
    {

        $dt = explode('-', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2];

        $dateEng = $year . "." . $mouht . "." . $date;

        return $dateEng;

    }

    public function eng2engDatedot($date)
    {

        $dt = explode('.', $date);
        //$today =array('date'=>$dt[0],'mo'=>$dt[1],'Year'=>$dt['2']);
        $date = $dt[0];
        $mouht = $dt[1];
        $year = $dt[2];

        $dateEng = $year . "-" . $mouht . "-" . $date;

        return $dateEng;

    }

    function DateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array(
            "",
            "ม.ค.",
            "ก.พ.",
            "มี.ค.",
            "เม.ย.",
            "พ.ค.",
            "มิ.ย.",
            "ก.ค.",
            "ส.ค.",
            "ก.ย.",
            "ต.ค.",
            "พ.ย.",
            "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        $strYearCut = substr($strYear, 2, 2); //เอา2ตัวท้ายของปี .พ.ศ.
        return "$strDay $strMonthThai $strYearCut";
    } //end function DateThai

    function DateThai2($strDate)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array(
            "",
            "ม.ค.",
            "ก.พ.",
            "มี.ค.",
            "เม.ย.",
            "พ.ค.",
            "มิ.ย.",
            "ก.ค.",
            "ส.ค.",
            "ก.ย.",
            "ต.ค.",
            "พ.ย.",
            "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        $strYearCut = $strYear; //substr($strYear,4,4); //เอา2ตัวท้ายของปี .พ.ศ.
        return "$strDay $strMonthThai $strYearCut";
    } //end function DateThai
    
    function DateThai3($strDate)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array(
            "",
            "ม.ค.",
            "ก.พ.",
            "มี.ค.",
            "เม.ย.",
            "พ.ค.",
            "มิ.ย.",
            "ก.ค.",
            "ส.ค.",
            "ก.ย.",
            "ต.ค.",
            "พ.ย.",
            "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        $strYearCut = $strYear; //substr($strYear,4,4); //เอา2ตัวท้ายของปี .พ.ศ.
        return "$strDay $strMonthThai $strYearCut";
    } //end function DateThai
    
    function monthYearThai($strDate,$digit=null)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array(
            "",
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤษจิกายน",
            "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        $strYearCut = $strYear; //substr($strYear,4,4); //เอา2ตัวท้ายของปี .พ.ศ.
        return "$strMonthThai $strYearCut";
    } //end function DateThai
    
    
   public function _push_file($path, $name)
{
  // make sure it's a file before doing anything!
  if(is_file($path))
  {
    // required for IE
    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

    // get the file mime type using the file extension
    $this->load->helper('file');

    /**
     * This uses a pre-built list of mime types compiled by Codeigniter found at
     * /system/application/config/mimes.php 
     * Codeigniter says this is prone to errors and should not be dependant upon
     * However it has worked for me so far. 
     * You can also add more mime types as needed.
     */
    $mime = get_mime_by_extension($path);

    // Build the headers to push out the file properly.
    header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
    header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($path)); // provide file size
    header('Connection: close');
    readfile($path); // push it out
    exit();
}


}
function compareDate($date1,$date2) {
		$arrDate1 = explode("-",$date1);
		$arrDate2 = explode("-",$date2);
		//$timStmp1 = mktime(0,0,0,int($arrDate1[1]),int($arrDate1[2]),int($arrDate1[0]));
		//$timStmp2 = mktime(0,0,0,int($arrDate2[1]),int($arrDate2[2]),int($arrDate2[0]));
        $timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
        $timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

		if ($timStmp1 == $timStmp2) {
			return "E";
		} else if ($timStmp1 > $timStmp2) {
			return "M";
		} else if ($timStmp1 < $timStmp2) {
			return "L";
		}
	}
    
    
    function truncateStr($str, $maxChars=40, $holder="...."){

    // ตรวจสอบความยาวของประโยค
    if (strlen($str) > $maxChars ){
        return trim(substr($str, 0, $maxChars)) . $holder;
    }   else {
        return $str;
    }
   

} // ปิดฟังก์ชัน truncateStr


}// End Class

?>