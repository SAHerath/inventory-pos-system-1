<?php

class Users extends Controller
{
  public function __construct()
  {
    if (!isEnabled('user')) {
      exit("Permission Not Granted!");
      return;
    }
    $this->userModel = $this->model('UserM');
  }

  public function index()
  {
    $data = [
      'title' => 'user_list'
    ];
    $this->view('users/userlistV', $data);
  }

  public function add()
  {
    $data = [
      'title' => 'user_add'
    ];

    $data['roles'] = $this->userModel->getRoleList();

    $this->view('users/useraddV', $data);
  }

  public function edit($userId)
  {
    $userId = trim($userId);
    $data = [
      'title' => 'user_edit'
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($userId) || !preg_match($validator2, $userId)) {
      exit('Error! : No valied Order Id found. ');
    } else {
      $data['roles'] = $this->userModel->getRoleList();
      $data['users'] = $this->userModel->getUser($userId);

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('users/usereditV', $data);
    }
  }

  public function addUser()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);
      $param = [
        'usersfirname' => trim($_POST['users_fname']),
        'userslasname' => trim($_POST['users_lname']),
        'usersbirthd' => trim($_POST['users_birthday']),
        'usersgender' => trim($_POST['users_gender']),
        'usersaddres' => trim($_POST['users_address']),
        'usersphone' => trim($_POST['users_phone']),
        'usersrole' => trim($_POST['users_role']),
        'usersusname' => trim($_POST['users_username']),
        'userspasswd' => trim($_POST['users_password']),
        'userscnpass' => trim($_POST['users_confpass']),
        'usersstate' => trim($_POST['users_acstatus']),
        'usersimage' => ''
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator0 = ['jpeg', 'png', 'gif'];  // filter image types
      $validator1 = "/^[a-zA-Z0-9 _-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";    // filter local telephone no.
      $validator4 = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,20}$/";  // must include atleast one upercase, lowercase, number. lenght 8 to 20
      $validator5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address

      // validate image
      $fileData = validateFiles('users_image', 1, $validator0);
      if (empty($fileData['error'])) {
        $data['frm_msg']['users_image'] = 'Image: File not found';
      } elseif ($fileData['error'] != 'NoError') {
        $data['frm_msg']['users_image'] = 'Image: ' . $fileData['error'];
      }

      // validate first name
      if (empty($param['usersfirname'])) {
        $data['frm_msg']['users_fname'] = 'First Name: Field is empty';
      } elseif (!preg_match($validator1, $param['usersfirname'])) {
        $data['frm_msg']['users_fname'] = 'First Name: Can only contain letters and numbers';
      }

      // validate last name
      if (!preg_match($validator1, $param['userslasname'])) {
        $data['frm_msg']['users_lname'] = 'Last Name: Can only contain letters and numbers';
      }

      // validate birthday
      if (empty($param['usersbirthd'])) {
        $data['frm_msg']['users_birthday'] = 'Date of Birth: Field is empty';
      } else {
        $dtObj1 = new DateTime("now");
        $dtObj2 = DateTime::createFromFormat('Y-m-d', $param['usersbirthd']);
        //echo $dtObj->format('Y-m-d');
        // $dtErObj = DateTime::getLastErrors();
        // if ($dtErObj['warning_count'] > 0 || $dtErObj['error_count'] > 0)
        if (array_sum(DateTime::getLastErrors())) {
          $data['frm_msg']['users_birthday'] = 'Date of Birth: Invalied date format';
        } elseif ($dtObj2->diff($dtObj1)->format('%y') < 16) {
          $data['frm_msg']['users_birthday'] = 'Date of Birth: Under age restricted';
        }
      }

      // validate gender
      if (empty($param['usersgender'])) {
        $data['frm_msg']['users_gender'] = 'Gender: Field not selected';
      } elseif (!($param['usersgender'] == 'male' || $param['usersgender'] == 'female')) {
        $data['frm_msg']['users_gender'] = 'Gender: Invalied value';
      }

      // validate address
      if (empty($param['usersaddres'])) {
        $data['frm_msg']['users_address'] = 'Address: Field is empty';
      }

      // validate telphone number
      if (empty($param['usersphone'])) {
        $data['frm_msg']['users_phone'] = 'Phone: Field is empty';
      } elseif (!preg_match($validator3, $param['usersphone'])) {
        $data['frm_msg']['users_phone'] = 'Phone: Invalied phone number format';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate role id
      if (empty($param['usersrole'])) {
        $data['frm_msg']['users_role'] = 'Role: Field not selected';
      } elseif (!preg_match($validator2, $param['usersrole'])) {
        $data['frm_msg']['users_role'] = 'Role: Invalied format';
      }

      // validate username
      if (empty($param['usersusname'])) {
        $data['frm_msg']['users_username'] = 'Username: Field is empty';
      } elseif (!filter_var($param['usersusname'], FILTER_VALIDATE_EMAIL)) {
        $data['frm_msg']['users_username'] = 'Username: Insert valid email address';
      } else {
        $user = $this->userModel->findUsername($param['usersusname']);
        if (!$user) {
          $data['frm_msg']['edit_users_msg'] = 'Someting went wrong';
        } elseif ($user['count'] > 0) {
          $data['frm_msg']['users_username'] = 'Username: Already taken';
        }
      }

      // validate password
      if (empty($param['userspasswd'])) {
        $data['frm_msg']['users_password'] = 'Password: Field is empty';
      } elseif (!preg_match($validator4, $param['userspasswd'])) {
        $data['frm_msg']['users_password'] = 'Password: Must have 8 to 20 characters including atleast one uppercase, one lowercase and one number';
      }

      // validate confirm password
      if (empty($param['userscnpass'])) {
        $data['frm_msg']['users_confpass'] = 'Confirm Password: Field is empty';
      } elseif ($param['userscnpass'] !== $param['userspasswd']) {
        $data['frm_msg']['users_confpass'] = 'Confirm Password: Do not match';
      }

      // validate account status
      if (empty($param['usersstate'])) {
        $data['frm_msg']['users_acstatus'] = 'Account Status: Field not selected';
      } elseif (!($param['usersstate'] == 'active' || $param['usersstate'] == 'blocked')) {
        $data['frm_msg']['users_acstatus'] = 'Account Status: Invalied value';
      }


      if (empty($data['frm_msg'])) {

        $param['userspasswd'] = password_hash($param['userspasswd'], PASSWORD_DEFAULT);
        unset($param['userscnpass']);

        if (move_uploaded_file($fileData['path'][0], 'img/uploads/user/' . $fileData['users_image'][0])) {
          $param['usersimage'] = $fileData['users_image'][0];
        } else {
          $data['frm_msg']['add_users_msg'] = 'Image: File not saved';
        }

        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_users_msg'] = 'User successfully added';
        } else {
          $data['frm_msg']['add_users_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editUser()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);
      $param = [
        'usersid' => trim($_POST['users_id']),
        'usersfirname' => trim($_POST['users_fname']),
        'userslasname' => trim($_POST['users_lname']),
        'usersbirthd' => trim($_POST['users_birthday']),
        'usersgender' => trim($_POST['users_gender']),
        'usersaddres' => trim($_POST['users_address']),
        'usersphone' => trim($_POST['users_phone']),
        'usersrole' => trim($_POST['users_role']),
        'usersusname' => trim($_POST['users_username']),
        'userspasswd' => trim($_POST['users_password']),
        'userscnpass' => trim($_POST['users_confpass']),
        'usersstate' => trim($_POST['users_acstatus']),
        'usersimage' => ''
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator0 = ['jpeg', 'png', 'gif'];  // filter image types
      $validator1 = "/^[a-zA-Z0-9 _-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";    // filter local telephone no.
      $validator4 = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,20}$/";  // must include atleast one upercase, lowercase, number. lenght 8 to 20
      $validator5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address

      // validate user id
      if (empty($param['usersid'])) {
        $data['frm_msg']['edit_users_msg'] = 'User Id: Field is empty';
      } elseif (!preg_match($validator2, $param['usersid'])) {
        $data['frm_msg']['edit_users_msg'] = 'User Id: Invalied format';
      }

      // validate image
      $fileData = validateFiles('users_image', 1, $validator0);
      if (empty($fileData['error'])) {
        // $data['frm_msg']['users_image'] = 'Image: File not found';
      } elseif ($fileData['error'] != 'NoError') {
        $data['frm_msg']['users_image'] = 'Image: ' . $fileData['error'];
      }

      // validate first name
      if (empty($param['usersfirname'])) {
        $data['frm_msg']['users_fname'] = 'First Name: Field is empty';
      } elseif (!preg_match($validator1, $param['usersfirname'])) {
        $data['frm_msg']['users_fname'] = 'First Name: Can only contain letters and numbers';
      }

      // validate last name
      if (!preg_match($validator1, $param['userslasname'])) {
        $data['frm_msg']['users_lname'] = 'Last Name: Can only contain letters and numbers';
      }

      // validate birthday
      if (empty($param['usersbirthd'])) {
        $data['frm_msg']['users_birthday'] = 'Date of Birth: Field is empty';
      } else {
        $dtObj1 = new DateTime("now");
        $dtObj2 = DateTime::createFromFormat('Y-m-d', $param['usersbirthd']);
        //echo $dtObj->format('Y-m-d');
        // $dtErObj = DateTime::getLastErrors();
        // if ($dtErObj['warning_count'] > 0 || $dtErObj['error_count'] > 0)
        if (array_sum(DateTime::getLastErrors())) {
          $data['frm_msg']['users_birthday'] = 'Date of Birth: Invalied date format';
        } elseif ($dtObj2->diff($dtObj1)->format('%y') < 16) {
          $data['frm_msg']['users_birthday'] = 'Date of Birth: Under age restricted';
        }
      }

      // validate gender
      if (empty($param['usersgender'])) {
        $data['frm_msg']['users_gender'] = 'Gender: Field not selected';
      } elseif (!($param['usersgender'] == 'male' || $param['usersgender'] == 'female')) {
        $data['frm_msg']['users_gender'] = 'Gender: Invalied value';
      }

      // validate address
      if (empty($param['usersaddres'])) {
        $data['frm_msg']['users_address'] = 'Address: Field is empty';
      }

      // validate telphone number
      if (empty($param['usersphone'])) {
        $data['frm_msg']['users_phone'] = 'Phone: Field is empty';
      } elseif (!preg_match($validator3, $param['usersphone'])) {
        $data['frm_msg']['users_phone'] = 'Phone: Invalied phone number format';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate role id
      if (empty($param['usersrole'])) {
        $data['frm_msg']['users_role'] = 'Role: Field not selected';
      } elseif (!preg_match($validator2, $param['usersrole'])) {
        $data['frm_msg']['users_role'] = 'Role: Invalied format';
      }

      // validate username
      if (empty($param['usersusname'])) {
        $data['frm_msg']['users_username'] = 'Username: Field is empty';
      } elseif (!filter_var($param['usersusname'], FILTER_VALIDATE_EMAIL)) {
        $data['frm_msg']['users_username'] = 'Username: Insert valid email address';
      } else {
        $user = $this->userModel->findUsername($param['usersusname']);
        if (!$user) {
          $data['frm_msg']['edit_users_msg'] = 'Someting went wrong';
        } elseif ($user['count'] > 0 && $user['user_code'] != $param['usersid']) {
          $data['frm_msg']['users_username'] = 'Username: Already taken';
        }
      }

      // validate password
      if (empty($param['userspasswd'])) {
        // $data['frm_msg']['users_password'] = 'Password: Field is empty';
      } elseif (!preg_match($validator4, $param['userspasswd'])) {
        $data['frm_msg']['users_password'] = 'Password: Must have 8 to 20 characters including atleast one uppercase, one lowercase and one number';
      }

      // validate confirm password
      if ((!empty($param['userspasswd'])) && empty($param['userscnpass'])) {
        $data['frm_msg']['users_confpass'] = 'Confirm Password: Field is empty';
      } elseif ($param['userscnpass'] !== $param['userspasswd']) {
        $data['frm_msg']['users_confpass'] = 'Confirm Password: Do not match';
      }

      // validate account status
      if (empty($param['usersstate'])) {
        $data['frm_msg']['users_acstatus'] = 'Account Status: Field not selected';
      } elseif (!($param['usersstate'] == 'active' || $param['usersstate'] == 'blocked')) {
        $data['frm_msg']['users_acstatus'] = 'Account Status: Invalied value';
      }


      if (empty($data['frm_msg'])) {

        if (!empty($param['userspasswd'])) {
          $param['userspasswd'] = password_hash($param['userspasswd'], PASSWORD_DEFAULT);
        } else {
          unset($param['userspasswd']);
        }
        unset($param['userscnpass']);

        if (!empty($fileData['users_image'][0])) {
          if (move_uploaded_file($fileData['path'][0], 'img/uploads/user/' . $fileData['users_image'][0])) {
            $param['usersimage'] = $fileData['users_image'][0];
          } else {
            $data['frm_msg']['edit_users_msg'] = 'Image: File not saved';
          }
        }

        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_users_msg'] = 'User successfully updated';
        } else {
          $data['frm_msg']['edit_users_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteUser()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'usersid' => trim($_POST['delt_users_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate user id
      if (empty($param['usersid'])) {
        $data['frm_msg']['delt_users_msg'] = 'User Id: Field is empty';
      } elseif (!preg_match($validator2, $param['usersid'])) {
        $data['frm_msg']['delt_users_msg'] = 'User Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {

        if ($this->userModel->getRowCount() == 1) {
          $data['frm_msg']['delt_users_msg'] = 'Last user can not delete';
        } elseif ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_users_msg'] = 'User successfully deleted';
        } else {
          $data['frm_msg']['delt_users_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getUserDataset()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $pageNum = trim($_POST['page_num']);
      $newSearch = trim($_POST['search_new']);

      $param = [
        'max_rows' => 10,
        'row_offset' => 0,
        'sort_col' => trim($_POST['sort_col']),
        'sort_type' => trim($_POST['sort_type']),
        'search_val' => trim($_POST['search_val']),
      ];

      $data = [
        'page_tot' => '',
        'tbl_data' => []
      ];

      $pattern1 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern2 = "/^[0|1]?$/";   // filter 0 or 1
      $pattern3 = "/^[a-z]{2,}$/";  // filter only lowercase lerters, atleast 2

      if (!preg_match($pattern1, $pageNum)) {
        $pageNum = 1;
      }

      if (!preg_match($pattern2, $newSearch)) {
        $newSearch = 1;
      }

      if (!preg_match($pattern1, $param['sort_col'])) {
        $param['sort_col'] = 1;
      } else {
        $param['sort_col'] = (int)$param['sort_col'];
      }

      if (!preg_match($pattern2, $param['sort_type'])) {
        $param['sort_type'] = 0;
      } else {
        $param['sort_type'] = (int)$param['sort_type'];
      }

      if (!preg_match($pattern3, $param['search_val'])) {
        $param['search_val'] = '';
      }

      $param['row_offset'] = ((int)$pageNum - 1) * $param['max_rows'];

      if ($newSearch) {
        $rowTot = $this->userModel->getRowCount($param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getRows($param);

      echo json_encode($data);
    }
  }


  // public function isLoggedIn()
  // {
  //   if (isset($_SESSION['userid'])) {
  //     return true;
  //   } else {
  //     return false;
  //   }
  // }

  public function testdb()
  {
    echo '<pre>';
    // $k = true;
    // if ($k > 0) {
    //   echo 'valid';
    // } else {
    //   echo 'not';
    // }
    var_dump($this->userModel->findUsername('davdfid.smith@hot.mail'));
    // var_dump($this->userModel->login('david.smith@hot.mail', 'Hello123'));

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
}
