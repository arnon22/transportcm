<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 26/11/12
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */
class DBAccess
{
    private $db_host = '';
    private $db_username = '';
    private $db_password = '';
    private $db_name = '';

    /**
     * @param $db_host
     */
    public function setDbHost($db_host)
    {
        $this->db_host = $db_host;
    }

    /**
     * @return string
     */
    public function getDbHost()
    {
        return $this->db_host;
    }

    /**
     * @param $db_password
     */
    public function setDbPassword($db_password)
    {
        $this->db_password = $db_password;
    }

    /**
     * @return string
     */
    public function getDbPassword()
    {
        return $this->db_password;
    }

    /**
     * @param $db_username
     */
    public function setDbUsername($db_username)
    {
        $this->db_username = $db_username;
    }

    /**
     * @return string
     */
    public function getDbUsername()
    {
        return $this->db_username;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->db_name;
    }

    /**
     * @param $db_name
     */
    public function setDbName($db_name)
    {
        $this->db_name = $db_name;
    }

}