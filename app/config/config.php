<?php
// path configurations
define('APPROOT', dirname(dirname(__FILE__)));
define('URLROOT', 'http://localhost/Test/mySys05/');

// app details
define('SITENAME', 'Inventory');
define('VERSION', '1.5.0');

// database configurations
define('DB_HOST', 'localhost');
define('DB_USER', 'inventory');
define('DB_PSWD', 'Admin@1nv3nt0ry');
define('DB_NAME', 'db_inventory');   //'db_inventory' 'mytestdb'

// session configurations
define('SESS_EXPIRE', 1800);    // 30mins
define('SESS_RENEW', 1800);     // 30mins

// logging path configurations
define('APP_ERROR', APPROOT . '/logs/error.log');
define('APP_DEBUG', APPROOT . '/logs/debug.log');

// mail configurations
define("MAIL_HOST", "smtp.gmail.com");    //  hostname of the mail server
define("MAIL_PORT", 587);     //  SMTP port number
define("MAIL_ENCR", "tls");   //  encryption type to use
define("MAIL_NAME", "SAH Technologies");    // sender name
define("MAIL_USER", "supunanuradhaherath@gmail.com");   // sender username full email address
define("MAIL_PSWD", "hdwxphtdvafpudmp");      // password or appkey(gmail)

// define("MAIL_CONT", "");    // content file path
