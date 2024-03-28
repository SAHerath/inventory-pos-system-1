<?php
/*
 * App Core Class
 * Create URL and loads core controller
 * URL Format :- /controller/method/params
 */

class Core
{
  protected $currentController = 'Auth';  // first value of url, default 'Auth'
  protected $currentMethod = 'index';   // second value of url, default 'index'
  protected $params = [];   // from third to end values

  public function __construct()
  {
    $url = $this->getUrl();
    // print_r($url);

    // look in 'controllers' for first value of url which is control class
    if (isset($url[0])) {
      if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        //if found request controller, set as active
        $this->currentController = ucwords($url[0]); // captitalize first letter
        unset($url[0]);

        if (!isLoggedIn() && $this->currentController != 'Auth') {
          error_log(date('D d-M-Y H:i:s e | ') . 'Invalid Access ' . $this->currentController . PHP_EOL, 3, APPROOT . '/logs/debug.log');
          // redirect('auth/index');
        }
      }
    }

    // load controller file and make instance
    require_once('../app/controllers/' . $this->currentController . '.php');
    $this->currentController = new $this->currentController;

    // look in currentController for second value of url, which is method
    if (isset($url[1])) {
      if (method_exists($this->currentController, $url[1])) {
        // if method found, set as active
        $this->currentMethod = $url[1];
        unset($url[1]);

        // restric non-permission users

      } else {
        redirect('auth/error/404');
        // exit('Error! : Requested method not found!');
      }
    }

    // get parameters if exists 
    if (isset($url[2])) {
      $this->params = array_values($url);
    } else {
      $this->params = [];
    }
    // $this->params = $url ? array_values($url) : [];

    // call active method as callback with parameters
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      error_log(date('D d-M-Y H:i:s e | ') . 'Request URL: ' . URLROOT . $url . PHP_EOL, 3, APPROOT . '/logs/debug.log');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}
