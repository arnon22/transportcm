<?php
/**
 * Created by JetBrains PhpStorm.
 * User : sadoknet@gmail.com
 * Date: 14/11/12
 * Time: 16:27
 */

define('LIBS', DIR_APP.'/libs/');
define('TMP', DIR_APP.'/tmp/');
define('CONF', DIR_APP.'/config/');
/**
 * Load Parameters Files
 */
$config = Spyc::YAMLLoad(CONF.'parameters.yml');

$cSiteSettings = $config['site_settings'];
$cAdminAccess = $config['admin_access'];

define('ADMIN_SESSION_NAME', 'username_csv_manager');
define('URL', $cSiteSettings['url']);
define('EXPORT_ENCODE_FUNCTION', $cSiteSettings['export_encode_function']);
define('IMPORT_ENCODE_FUNCTION', $cSiteSettings['import_encode_function']);
define('DATABASE_DEFAULT_CHARSET', $cSiteSettings['database_default_charset']);

//Start Session
Session::startSession();