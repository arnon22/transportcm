<?php

class View
{

    function __construct()
    {
        //echo 'this is the view';
    }

    public function render($name, $noInclude = false)
    {
        if ($noInclude == true) {
            require_once DIR_APP . '/views/' . $name . '.php';
        } else {
            require_once DIR_APP . '/views/header.php';
            if (Session::get(ADMIN_SESSION_NAME)) {
                require_once DIR_APP . '/views/main_menu.php';
            }
            require_once DIR_APP . '/views/' . $name . '.php';
            require_once DIR_APP . '/views/footer.php';
        }
    }

}