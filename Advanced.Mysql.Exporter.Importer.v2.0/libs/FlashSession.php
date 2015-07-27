<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 14/11/12
 * Time: 17:51
 */
class FlashSession
{
    /**
     * @param $key
     * @return bool
     */
    static function getFlash($key)
    {
        $flash = false;
        if (isset($_SESSION[$key])) {
            $flash = $_SESSION[$key];
            unset($_SESSION[$key]);
        }
        return $flash;
    }

    /**
     * @param $key
     * @param $value
     */
    static function setFlash($key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    /**
     *
     */
    static function showErrors()
    {
        $errors = self::getFlash('error');
        if ($errors && count($errors) > 0) {
            $erHtml = "";
            $erHtml .= "<div class='alert alert-error'>";
            $erHtml .= "<button type='button' class='close' data-dismiss='alert'>x</button>";
            $erHtml .= "<ul>";
            foreach ($errors as $error) {
                $erHtml .= "<li > " . $error . "</li > ";
            }
            $erHtml .= "</ul ></div >";
            echo $erHtml;
        }
    }

    /**
     *
     */
    static function showSuccess()
    {
        $success = self::getFlash('success');
        if ($success && count($success) > 0) {
            $erHtml = "";
            $erHtml .= "<div class='alert alert-success'>";
            $erHtml .= "<button type='button' class='close' data-dismiss='alert'>x</button>";
            $erHtml .= "<ul>";
            foreach ($success as $msg) {
                $erHtml .= "<li > " . $msg . "</li > ";
            }
            $erHtml .= "</ul ></div >";
            echo $erHtml;
        }
    }

}