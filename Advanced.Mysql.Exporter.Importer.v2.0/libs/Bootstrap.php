<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 14/11/12
 * Time: 16:25
 */

class Bootstrap
{

    private $_url = null;
    private $_controller = null;

    private $_controllerPath = 'controllers/';
    private $_modelPath = 'models/';
    private $_errorFile = 'error.php';
    private $_defaultFile = 'home.php';

    /**
     * @return bool
     */
    public function init()
    {
        // Sets the protected $_url
        $this->_getUrl();

        if (isset($_POST['submitLoginBtn'])) {
            $this->processLogin();
        }

        if (false == Session::get(ADMIN_SESSION_NAME)) {
            require_once DIR_APP . '/controllers/login.php';
            $controller = new Login();
            $controller->index();
            return false;
        }

        // Load the default controller if no URL is set
        // eg: Visit http://localhost it loads Default Controller
        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
            return false;
        }

        $this->_loadExistingController();
        $this->_callControllerMethod();
    }

    /**
     * @param $path
     */
    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path, '/') . '/';
    }

    /**
     * @param $path
     */
    public function setModelPath($path)
    {
        $this->_modelPath = trim($path, '/') . '/';
    }

    /**
     * @param $path
     */
    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path, '/');
    }

    /**
     * @param $path
     */
    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path, '/');
    }

    /**
     *
     */
    private function _getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }

    /**
     *
     */
    private function _loadDefaultController()
    {
        require $this->_controllerPath . $this->_defaultFile;
        $this->_controller = new Home();
        $this->_controller->index();
    }

    /**
     * @return bool
     */
    private function _loadExistingController()
    {
        $file = $this->_controllerPath . $this->_url[0] . '.php';

        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0], $this->_modelPath);
        } else {
            $this->_error();
            return false;
        }
    }

    /**
     *
     */
    private function _callControllerMethod()
    {
        $length = count($this->_url);

        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }

        // Determine what to load
        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;

            case 4:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;

            case 3:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;

            case 2:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}();
                break;

            default:
                $this->_controller->index();
                break;
        }
    }

    /**
     * @return bool
     */
    private function _error()
    {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new Error();
        $this->_controller->index();
        return false;
    }

    /**
     * @return bool
     */
    function processLogin()
    {
        global $cAdminAccess;
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($username == $cAdminAccess['admin_login'] && $password == $cAdminAccess['admin_password']) {
            Session::set(ADMIN_SESSION_NAME, $username);
            return true;
        } else {
            FlashSession::setFlash('error', 'Invalid Username or Password !');
            return false;
        }
    }

}