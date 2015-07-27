<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class cmdf
{
    function cmdf()
    {
        $CI = &get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
    function load($param = null)
    {
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        if ($params == null)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';
        }
        return new mPDF($param);
    }
}
