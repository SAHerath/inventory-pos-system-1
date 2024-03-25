<?php
/* Base Controller
 * Loads the relevent models and views
 */
class Controller
{
  // public function __construct()
  // {
  // }

  // load model
  public function model($model)
  {
    // load model file
    if (file_exists('../app/models/' . $model . '.php')) {
      require_once('../app/models/' . $model . '.php');
      return new $model();
    } else {
      // error_log(date('D d-M-Y H:i:s e | ') . $model . '.php not exists', 3, APPROOT . '/logs/error.log');
      exit('Error! : Model does not exists');
    }
    // require_once('../app/models/' . $model . '.php');
    // return new $model();
  }

  // load view
  public function view($view, $data = [])
  {
    if (file_exists('../app/views/' . $view . '.php')) {
      require_once('../app/views/' . $view . '.php');
    } else {
      // error_log(date('D d-M-Y H:i:s e | ') . $view . '.php not exists', 3, APPROOT . '/logs/error.log');
      exit('Error! : View does not exists');
    }
  }
}
