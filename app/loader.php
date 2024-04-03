<?php
// load configurations
require_once('config/config.php');
// load helpers
require_once('helpers/urlH.php');
require_once('helpers/logH.php');
require_once('helpers/sessionH.php');
require_once('helpers/fileuploadH.php');
require_once('helpers/autoloadH.php');

// autoload core libraries
spl_autoload_register('autoLoadHandler');

// load libraries
// require_once('libraries/Core.php');
// require_once('libraries/Controller.php');
// require_once('libraries/Database.php');
