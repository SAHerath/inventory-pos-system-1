<?php
// load configurations
require_once('config/config.php');
// load helpers
require_once('helpers/constants.php');
require_once('helpers/url_helper.php');
require_once('helpers/file_handler.php');

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
