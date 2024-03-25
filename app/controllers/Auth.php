<?php

class Auth extends Controller
{
  public function __construct()
  {
    if (isLoggedIn()) {  // if already logged redirect to dashboard
      redirect('home');
    }
    $this->userModel = $this->model('AuthM');
  }

  public function index()  // loging
  {
    if (session_status() === PHP_SESSION_ACTIVE) {
      session_destroy();
    }

    $data = [
      'title' => 'user_login',
      'frm_state' => '',
      'frm_msg' => []
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);
      $param = [
        'txt_username' => trim($_POST['txt_username']),
        'pas_password' => trim($_POST['pas_password'])
      ];


      if (empty($param['txt_username'])) {
        $data['frm_msg']['txt_username'] = 'Please enter Username';
      }

      if (empty($param['pas_password'])) {
        $data['frm_msg']['pas_password'] = 'Please enter Password';
      }

      if (empty($data['frm_msg'])) {
        $userDetails = $this->userModel->login($param['txt_username'], $param['pas_password']);
        if ($userDetails) {
          createSession($userDetails);
          redirect('home');
        } else {
          $data['frm_state'] = 'invalid';
          $data['frm_msg']['status'] = 'Incorrect Username or Password. Please try again!';
        }
      } else {
        $data['frm_state'] = 'invalid';
      }
    }
    $this->view('authentication/login', $data);
  }

  public function logout()
  {
    deleteSession();
    redirect('auth/index');
  }

  public function error()
  {
    $this->view('authentication/error');
  }

  /*
    public function logout()
    {
      unset($_SESSION['userid']);
      unset($_SESSION['userfname']);
      unset($_SESSION['userrole']);
      unset($_SESSION['userphoto']);
      session_destroy();
      redirect('auth/index');
    }
  */
  /*
    public function createSession($user)
    {
      session_start();
      $_SESSION['userid'] = $user['user_code'];
      $_SESSION['userfname'] = $user['user_first_name'];
      $_SESSION['userrole'] = $user['user_role_code'];

      if (empty($user['user_photo'])) {
        if ($user['user_gender'] == 'male') {
          $_SESSION['userphoto'] = 'avatar_f.png';
        } else {
          $_SESSION['userphoto'] = 'avatar_m.png';
        }
      } else {
        $_SESSION['userphoto'] = $user['user_photo'];
      }

      redirect('pages/index');
    }
 */
}
