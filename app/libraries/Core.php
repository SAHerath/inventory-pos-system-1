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

    // look in 'controllers' folder for first value of url which is control class
    if (isset($url[0])) {
      if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        //if found request controller, set as active
        $this->currentController = ucwords($url[0]); // captitalize first letter
        unset($url[0]);
        // authenticate user
        // if (!isLoggedIn() && $this->currentController != 'Auth') {
        //   logger("Invalid Access: {$this->currentController}", APP_DEBUG);
        //   redirect('auth/index');
        // }
      }
    }

    // load controller file and make instance
    require_once('../app/controllers/' . $this->currentController . '.php');
    $this->currentController = new $this->currentController;

    // look in currentController for second value of url, which is method
    if (isset($url[1])) {
      if (method_exists($this->currentController, $url[1])) {
        // if method found, set as active method
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
    // check if Get array has 'url' key
    if (isset($_GET['url'])) {
      // remove additinal '/' at right
      $url = rtrim($_GET['url'], '/');
      logger("Request URL: {$url}", APP_DEBUG);
      // filterout invalid compnents 
      $url = filter_var($url, FILTER_SANITIZE_URL);
      // devide url by '/' and store segments in array  
      $url = explode('/', $url);
      return $url;
    }
  }
}
