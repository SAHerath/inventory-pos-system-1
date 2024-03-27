<?php
if (session_status() === PHP_SESSION_NONE) {
  ini_set('session.use_strict_mode', 1);  // session strict mode is enabled
  session_start();
}

function isLoggedIn()
{
  if (isset($_SESSION['usercode']) && is_int($_SESSION['usercode'])) {
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

function isEnabled($module)   // checks whether module enabled
{
  return array_key_exists($module, $_SESSION['userpermi']);
}

function isAllowed($module, $section)   // checks whether module's section enabled
{
  return in_array($section, $_SESSION['userpermi'][$module]);
}

function createSession($user, $permis)
{
  session_start();

  $_SESSION['usercode'] = (int)$user['user_code'];
  $_SESSION['userfname'] = $user['user_first_name'];
  $_SESSION['username'] = $user['user_username'];
  $_SESSION['activated'] = time();

  for ($i = 0; $i < count($permis); $i++) {
    $_SESSION['userpermi'][$permis[$i]['perm_module']][] = $permis[$i]['perm_section'];
  }

  if (empty($user['user_photo'])) {
    if ($user['user_gender'] == 'male') {
      $_SESSION['userphoto'] = 'avatar_f.png';
    } else {
      $_SESSION['userphoto'] = 'avatar_m.png';
    }
  } else {
    $_SESSION['userphoto'] = $user['user_photo'];
  }

  error_log(date('D d-M-Y H:i:s e | ') . "User {$_SESSION['usercode']} logged in" . PHP_EOL, 3, APPROOT . '/logs/debug.log');
}

function deleteSession()
{
  error_log(date('D d-M-Y H:i:s e | ') . "User {$_SESSION['usercode']} logged out" . PHP_EOL, 3, APPROOT . '/logs/debug.log');

  unset($_SESSION['usercode']);
  unset($_SESSION['userfname']);
  unset($_SESSION['username']);
  unset($_SESSION['userpermi']);
  unset($_SESSION['userphoto']);
  unset($_SESSION['activated']);
  session_destroy();
}
