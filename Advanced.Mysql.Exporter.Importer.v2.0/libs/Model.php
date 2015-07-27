<?php

class Model
{
    /**
     * @var $DB
     */
    public $DB;

    /**
     *
     */
    public function __construct()
    {
        if (Session::get('dbConfigured') && Session::get('dbAccess')) {
            /** @DBAccess $dbAccess */
            $dbAccess = Session::get('dbAccess');
            $this->DB = NewADOConnection('mysql');
            $this->DB->Connect($dbAccess->getDbHost(), $dbAccess->getDbUsername(), $dbAccess->getDbPassword(), $dbAccess->getDbName());
            $this->DB->setFetchMode(ADODB_FETCH_NUM);
            if(DATABASE_DEFAULT_CHARSET != 'none'){
                $this->DB->SetCharSet(DATABASE_DEFAULT_CHARSET);
            }
        }
    }

}