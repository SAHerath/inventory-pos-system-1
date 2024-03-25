<?php
// load configurations
require_once('config/config.php');
// load helpers
require_once('helpers/constantsH.php');
require_once('helpers/urlH.php');
require_once('helpers/sessionH.php');
require_once('helpers/fileuploadH.php');

// autoload core libraries
spl_autoload_register('autoLoadHandler');

// load libraries
// require_once('libraries/Core.php');
// require_once('libraries/Controller.php');
// require_once('libraries/Database.php');


function autoLoadHandler($className)
{
  $filePath = 'libraries/' . $className . '.php';

  if (!file_exists('../app/' . $filePath)) {
    error_log(date('D d-M-Y H:i:s e | ') . $className . '.php not found!', 3, APPROOT . '/logs/error.log');
    exit($className . '.php not found!');
    // return false;
  }
  require_once($filePath);
}
