<?php
if (session_status() === PHP_SESSION_NONE) {
  ini_set('session.use_strict_mode', 1);  // session strict mode is enabled
  session_start();
}

function isLoggedIn()
{
  if (isset($_SESSION['userid']) && is_int($_SESSION['userid'])) {
    if (time() - $_SESSION['activated'] > SESS_EXPIRE) {  // sessin will expire if user does not active for certain period
      deleteSession();
      return false;
    }
    // elseif (time() - $_SESSION['created'] > SESS_RENEW) {
    //   session_regenerate_id(true);   // see php.net
    //   $_SESSION['activated'] = time();
    // }
    else {
      $_SESSION['activated'] = time();
      return true;
    }
  } else {
    return false;
  }
}

function createSession($user)
{
  session_start();

  $_SESSION['userid'] = (int)$user['user_code'];
  $_SESSION['userfname'] = $user['user_first_name'];
  $_SESSION['username'] = $user['user_username'];
  $_SESSION['userrole'] = $user['user_role_code'];
  $_SESSION['activated'] = time();

  if (empty($user['user_photo'])) {
    if ($user['user_gender'] == 'male') {
      $_SESSION['userphoto'] = 'avatar_f.png';
    } else {
      $_SESSION['userphoto'] = 'avatar_m.png';
    }
  } else {
    $_SESSION['userphoto'] = $user['user_photo'];
  }

  error_log(date('D d-M-Y H:i:s e | ') . "User {$_SESSION['userid']} logged in" . PHP_EOL, 3, APPROOT . '/logs/debug.log');
}

function deleteSession()
{
  error_log(date('D d-M-Y H:i:s e | ') . "User {$_SESSION['userid']} logged out" . PHP_EOL, 3, APPROOT . '/logs/debug.log');

  unset($_SESSION['userid']);
  unset($_SESSION['userfname']);
  unset($_SESSION['username']);
  unset($_SESSION['userrole']);
  unset($_SESSION['userphoto']);
  unset($_SESSION['activated']);
  session_destroy();
}
