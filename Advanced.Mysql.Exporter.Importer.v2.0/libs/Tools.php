<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 23/11/12
 * Time: 11:27
 * To change this template use File | Settings | File Templates.
 */
class Tools
{
    /**
     * @param $view
     */
    static function url($view)
    {
        echo URL . "/" . $view;
    }

    /**
     * @param $cssFile
     */
    static function css($cssFile)
    {
        echo URL . "/public/css/" . $cssFile;
    }

    /**
     * @param $jsFile
     */
    static function js($jsFile)
    {
        echo URL . "/public/js/" . $jsFile;
    }

    /**
     * @param $imgFile
     */
    static function img($imgFile)
    {
        echo URL . "/public/img/" . $imgFile;
    }

    /**
     * @param $url
     */
    static public function redirect($url)
    {
        header('location:' . URL . '/' . $url);
        exit;
    }

    /**
     * @param $variable
     * @param bool $default
     * @return bool
     */
    static public function isPost($variable, $default = false)
    {
        if (isset($_POST[$variable])) {
            return true;
        }
        return $default;
    }

    /**
     * @param $variable
     * @param null $default
     * @return null
     */
    static public function post($variable, $default = null)
    {
        if (isset($_POST[$variable])) {
            return $_POST[$variable];
        }
        return $default;
    }

    /**
     * @param $variable
     * @param null $default
     * @return null
     */
    static public function get($variable, $default = null)
    {
        if (isset($_GET[$variable])) {
            return $_GET[$variable];
        }
        return $default;
    }
}