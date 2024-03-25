<?php

class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('UserM');
  }

  public function index()
  {
    exit('Error! : Invalid method');
  }

  public function userlist()
  {
  }

  public function testdb()
  {
    echo '<pre>';
    var_dump($this->userModel->login('david.smith@hot.mail', 'Hello123'));

    // var_dump($this->userModel->findByUsername('david.smith@hot.mail'));

    // $data = [
    //   'txt_fname' => 'supun',
    //   'txt_lname' => 'herath',
    //   'dte_birthday' => '1992-03-03',
    //   'opt_gender' => 1,
    //   'txt_address' => '9/26, Galison Mawatha, Negombo.',
    //   'tel_phone' => '0712118855',
    //   'opt_role' => 1,
    //   'txt_username' => 'h.supun.anuradha@gmail.com',
    //   'pas_password' => '$2y$10$n8x8A7nt6BEbVDw6caAv8eCEIiaooPFPtorZQRNANMmpYugHxWzrW',
    //   // 'pas_confpass' => trim($_POST['pas_confpass']),
    //   // 'txt_usrstat' => trim($_POST['txt_usrstat']),
    //   'opt_accstat' => 1,
    //   'fil_image' => 'avatar_m.png'
    // ];
    // var_dump($this->userModel->createUser($data));
    echo '</pre>';
  }

  public function test()
  {
    // var_dump($_SESSION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


      // $status = [
      //   'state' => 'success',
      //   'msg' => []
      // ];
      // $status['msg']['frm_status'] = 'User successfully added';
      // echo json_encode($status);

      // if (isset($_SESSION['files'])) {
      //   $targetPath = 'uploads/';
      //   $targetName = uniqid('testImg_') . '.jpeg';
      //   if (move_uploaded_file($_SESSION['files'][0], $targetPath . $targetName)) {
      //     echo $targetName;
      //   } else {
      //     echo 'not saved';
      //   }
      // }


      // var_dump($_POST);
      // var_dump($_FILES);

      // echo json_encode($_POST);
      // echo json_encode($_FILES);
      // if (isset($_FILES['fil_image'])) {
      //   if (!array_sum($_FILES['fil_image']['error'])) {
      //     $_SESSION['files'] = $_FILES['fil_image']['tmp_name'];
      //   }
      // }
    }
  }

  public function addUser()
  {
    $data = [
      'title' => 'Add User'
    ];
    $this->view('users/add_user', $data);
  }

  public function saveUser()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);
      $param = [
        'txt_fname' => trim($_POST['txt_fname']),
        'txt_lname' => trim($_POST['txt_lname']),
        'dte_birthday' => trim($_POST['dte_birthday']),
        'opt_gender' => trim($_POST['opt_gender']),
        'txt_address' => trim($_POST['txt_address']),
        'tel_phone' => trim($_POST['tel_phone']),
        'opt_role' => trim($_POST['opt_role']),
        'txt_username' => trim($_POST['txt_username']),
        'pas_password' => trim($_POST['pas_password']),
        'pas_confpass' => trim($_POST['pas_confpass']),
        // 'txt_usrstat' => trim($_POST['txt_usrstat']),
        'opt_accstat' => trim($_POST['opt_accstat']),
        'fil_image' => ''
      ];

      $status = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9]*$/";   // filter only lowercase/uppercase/numbers
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";    // filter local telephone no.
      $pattern4 = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,20}$/";  // must include atleast one upercase, lowercase, number. lenght 8 to 20
      $fileTypes = ['jpeg', 'png', 'gif'];
      // $fileSize = 1;  // 1 mega byte

      // validate first name
      if (empty($param['txt_fname'])) {
        $status['frm_msg']['txt_fname'] = 'First Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['txt_fname'])) {
        $status['frm_msg']['txt_fname'] = 'First Name: Can only contain letters and numbers';
      }

      // validate last name
      if (!preg_match($pattern1, $param['txt_lname'])) {
        $status['frm_msg']['txt_lname'] = 'Last Name: Can only contain letters and numbers';
      }

      // validate birthday
      if (empty($param['dte_birthday'])) {
        $status['frm_msg']['dte_birthday'] = 'Date of Birth: Field is empty';
      } else {
        $dtObj1 = new DateTime("now");
        $dtObj2 = DateTime::createFromFormat('Y-m-d', $param['dte_birthday']);
        //echo $dtObj->format('Y-m-d');
        // $dtErObj = DateTime::getLastErrors();
        // if ($dtErObj['warning_count'] > 0 || $dtErObj['error_count'] > 0)
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['dte_birthday'] = 'Date of Birth: Invalied date format';
        } elseif ($dtObj2->diff($dtObj1)->format('%y') < 16) {
          $status['frm_msg']['dte_birthday'] = 'Date of Birth: Under age restricted';
        }
      }

      // validate gender
      if (empty($param['opt_gender'])) {
        $status['frm_msg']['opt_gender'] = 'Gender: Field not selected';
      } elseif (!preg_match($pattern2, $param['opt_gender'])) {
        $status['frm_msg']['txt_fname'] = 'Gender: Invalied format';
      }

      // validate address
      if (empty($param['txt_address'])) {
        $status['frm_msg']['txt_address'] = 'Address: Field is empty';
      }

      // validate telphone number
      if (empty($param['tel_phone'])) {
        $status['frm_msg']['tel_phone'] = 'Phone: Field is empty';
      } elseif (!preg_match($pattern3, $param['tel_phone'])) {
        $status['frm_msg']['tel_phone'] = 'Phone: Invalied phone number format';
      }

      // validate role id
      if (empty($param['opt_role'])) {
        $status['frm_msg']['opt_role'] = 'Role: Field not selected';
      } elseif (!preg_match($pattern2, $param['opt_role'])) {
        $status['frm_msg']['opt_role'] = 'Role: Invalied format';
      }

      // validate username
      if (empty($param['txt_username'])) {
        $status['frm_msg']['txt_username'] = 'Username: Field is empty';
      } elseif ($this->userModel->findByUsername($param['txt_username'])) {
        $status['frm_msg']['txt_username'] = 'Username: Already taken';
      }

      // validate password
      if (empty($param['pas_password'])) {
        $status['frm_msg']['pas_password'] = 'Password: Field is empty';
      } elseif (!preg_match($pattern4, $param['pas_password'])) {
        $status['frm_msg']['pas_password'] = 'Password: Must have 8 to 20 characters including atleast one uppercase, one lowercase and one number';
      }

      // validate confirm password
      if (empty($param['pas_confpass'])) {
        $status['frm_msg']['pas_confpass'] = 'Confirm Password: Field is empty';
      } elseif ($param['pas_confpass'] !== $param['pas_password']) {
        $status['frm_msg']['pas_confpass'] = 'Confirm Password: Do not match';
      }

      // validate account status
      if (empty($param['opt_accstat'])) {
        $status['frm_msg']['opt_accstat'] = 'Account Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['opt_accstat'])) {
        $status['frm_msg']['opt_accstat'] = 'Account Status: Invalied format';
      }

      // validate image
      $fileData = validateFiles('fil_image', 1, $fileTypes);
      if (!empty($fileData['error'])) {
        if ($fileData['error'] != 'File not found') {
          $status['frm_msg']['fil_image'] = 'Image: ' . $fileData['error'];
        }
      }

      /* if (empty($fileData['error'])) {
        for ($index = 0; $index < count($fileData['path']); $index++) {
          if (move_uploaded_file($fileData['path'][$index], 'uploads/' . $fileData['fil_image'][$index])) {
            $data['fil_image'] = $fileData['fil_image'][$index];
          } else {
            $status['frm_msg']['fil_image'] = 'Image: File not saved';
          }
        }
      }  else {
        $status['frm_msg']['fil_image'] = 'Image: ' . $fileData['error'];
      }*/


      if (empty($status['frm_msg'])) {

        $param['pas_password'] = password_hash($param['pas_password'], PASSWORD_DEFAULT);
        // unset($data['pas_confpass']);

        if (empty($fileData['error'])) {
          if (move_uploaded_file($fileData['path'][0], 'img/uploads/user/' . $fileData['fil_image'][0])) {
            $param['fil_image'] = $fileData['fil_image'][0];
          } else {
            $status['frm_msg']['frm_status'] = 'Image: File not saved';
          }
        }

        if ($this->userModel->createUser($param)) {
          unset($param);
          $status['state']  = 'success';
          $status['frm_msg']['frm_status'] = 'User successfully added';
        } else {
          $status['frm_msg']['frm_status'] = 'Someting went wrong';
        }
      }

      echo json_encode($status);
    }
  }

  public function login()
  {
    $data = [
      'title' => 'Login',
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
          $this->createSession($userDetails);
        } else {
          $data['frm_state'] = 'invalid';
          $data['frm_msg']['status'] = 'Incorrect Username or Password. Please try again!';
        }
      } else {
        $data['frm_state'] = 'invalid';
      }
    }
    $this->view('users/login', $data);
  }

  public function logout()
  {
    unset($_SESSION['userid']);
    unset($_SESSION['userfname']);
    unset($_SESSION['userrole']);
    unset($_SESSION['userphoto']);
    session_destroy();
    redirect('users/login');
  }

  public function createSession($user)
  {
    session_start();
    $_SESSION['userid'] = $user['user_code'];
    $_SESSION['userfname'] = $user['user_first_name'];
    $_SESSION['userrole'] = $user['user_role_code'];

    if (empty($user['user_photo'])) {
      if ($user['user_gender'] == '2') {
        $_SESSION['userphoto'] = 'avatar_f.png';
      } else {
        $_SESSION['userphoto'] = 'avatar_m.png';
      }
    } else {
      $_SESSION['userphoto'] = $user['user_photo'];
    }

    redirect('pages/index');
  }

  public function isLoggedIn()
  {
    if (isset($_SESSION['userid'])) {
      return true;
    } else {
      return false;
    }
  }
}
