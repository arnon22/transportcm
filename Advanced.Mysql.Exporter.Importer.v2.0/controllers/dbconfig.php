<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 26/11/12
 * Time: 10:19
 * To change this template use File | Settings | File Templates.
 */

class Dbconfig extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $url
     * @param string $url2
     */
    public function index($url = "", $url2 = "")
    {
        if (Tools::isPost('submitDBConfigBtn')) {
            $db_provider = 'mysql';
            $db_host = Tools::post('db_host');
            $db_username = Tools::post('db_username');
            $db_password = Tools::post('db_password');
            $db_name = Tools::post('db_name');

            $dbError = false;
            $DB = NewADOConnection($db_provider);
            try {
                $DB->Connect($db_host, $db_username, $db_password, $db_name);
            } catch (ErrorException $e) {
                $dbError = true;
            }
            $result = $DB->Execute("Show tables;");
            $errorMsg = $DB->ErrorMsg();
            if ($result === false || $dbError === true || $errorMsg != "") {
                FlashSession::setFlash('error', $errorMsg);
            } else {
                $DB->Close();
                $dbAccess = new DBAccess();
                $dbAccess->setDbUsername($db_username);
                $dbAccess->setDbPassword($db_password);
                $dbAccess->setDbHost($db_host);
                $dbAccess->setDbName($db_name);

                Session::set('dbAccess', $dbAccess);
                Session::set('dbConfigured', true);
                if ($url != "") {
                    $url = $url2 == "" ? $url2 : $url . "/" . $url2;
                    Tools::redirect($url);
                } else {
                    Tools::redirect('home');
                }

            }
        }
        $this->view->render('dbconfig/index');
    }


}