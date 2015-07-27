<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 14/11/12
 * Time: 16:25
 */

define('DIR_APP', dirname(__FILE__));

require_once DIR_APP . '/config/app.php';
require_once LIBS . 'adodb/adodb.inc.php';
require_once LIBS . 'PDF/mPDF5.4/mpdf.php';
require_once LIBS . 'DBAccess.php';


if (!defined('PHPEXCEL_ROOT')) {
    define('PHPEXCEL_ROOT', LIBS);
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

function __autoload($class_name)
{
    $fileToInclude = sprintf(LIBS . '/%s.php', $class_name);
    if (file_exists($fileToInclude)) {
        require_once $fileToInclude;
    }

}
function handleFalseError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    return false;
}

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('handleError');

$bootstrap = new Bootstrap();
$bootstrap->init();