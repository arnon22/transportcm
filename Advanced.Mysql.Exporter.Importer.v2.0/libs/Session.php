<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 22/11/12
 * Time: 16:24
 * To change this template use File | Settings | File Templates.
 */
class Session
{
    CONST SESSION_NAME = 'AdvancedManager';

    /**
     * @param $Setting
     * @param $Value
     */
    static function set($Setting, $Value)
    {
        $_SESSION[self::SESSION_NAME][$Setting] = unserialize(serialize($Value));

    }

    static function startSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * @param $Setting
     * @param bool $Default
     * @return bool|mixed
     */
    static function get($Setting, $Default = false)
    {
        if (isset($_SESSION[self::SESSION_NAME][$Setting]) && !empty($_SESSION[self::SESSION_NAME][$Setting])) {
            $data = $_SESSION[self::SESSION_NAME][$Setting];
            $data = unserialize(serialize($data));
            return $data;
        } else {
            return $Default;
        }
    }

    /**
     *
     */
    static function logout()
    {
        unset($_SESSION[self::SESSION_NAME]);
    }
}