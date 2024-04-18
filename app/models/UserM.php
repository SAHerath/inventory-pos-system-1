<?php
class UserM
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
    if (!$this->db->isConnected()) {
      // $error = $this->db->getError();
      // echo $this->db->getError();
      // redirect('views/error');
      // header("location: app/views/error.php?msg={$error}");
      // header('location: http://localhost/Test/mySys03/app/views/error.php?msg=hi');
      exit("Error! : Could Not Connect To Database!");
    }
  }

  public function getRoleList()
  {
    $query = "SELECT role_code, role_name FROM tabl_role WHERE role_state = 'active'";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function getRole($roleId)
  {
    $query = "SELECT role_name FROM tabl_role WHERE role_code = :roleid";
    $param = ['roleid' => $roleId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function create($param)
  {
    $query = "INSERT INTO tabl_user(user_role_code, user_username, user_password, user_first_name, user_last_name, user_birthday, user_gender, user_address, user_phone, user_email, user_photo, user_status) 
               VALUES(:usersrole, :usersusname, :userspasswd, :usersfirname, :userslasname, :usersbirthd, :usersgender, :usersaddres, :usersphone, :usersemail, :usersimage, :usersstate)";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    } else {
      return false;
    }
  }

  public function update($param)
  {
    $query = "UPDATE tabl_user SET user_role_code=:usersrole, user_username=:usersusname, user_first_name=:usersfirname, user_last_name=:userslasname, user_birthday=:usersbirthd, user_gender=:usersgender, user_address=:usersaddres, user_phone=:usersphone, user_email=:usersemail, user_status=:usersstate";

    if (isset($param['userspasswd'])) {
      $query .= ", user_password=:userspasswd";
    }
    if (isset($param['usersimage'])) {
      $query .= ", user_photo=:usersimage";
    }
    $query .= " WHERE user_code=:usersid";

    // var_dump($query);
    // return;
    // if (isset($param['userspasswd'])) {
    //   $query = "UPDATE tabl_user 
    //   SET user_role_code=:usersrole, user_username=:usersusname, user_password=:userspasswd, user_first_name=:usersfirname, user_last_name=:userslasname, user_birthday=:usersbirthd, user_gender=:usersgender, user_address=:usersaddres, user_phone=:usersphone, user_photo=:usersimage, user_status=:usersstate 
    //   WHERE user_code=:usersid";
    // } else {
    //   $query = "UPDATE tabl_user 
    //   SET user_role_code=:usersrole, user_username=:usersusname, user_first_name=:usersfirname, user_last_name=:userslasname, user_birthday=:usersbirthd, user_gender=:usersgender, user_address=:usersaddres, user_phone=:usersphone, user_photo=:usersimage, user_status=:usersstate 
    //   WHERE user_code=:usersid";
    // }

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function remove($param)
  {
    $query = "DELETE FROM tabl_user WHERE user_code = :usersid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function findUsername($username)
  {
    $query = "SELECT COUNT(user_code) AS count, user_code FROM tabl_user WHERE user_username = :username";
    $param = ['username' => $username];

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    } else {
      return false;
    }
  }

  public function getUser($userId)
  {
    $query = "SELECT * FROM tabl_user WHERE user_code = :userid";
    $param = ['userid' => $userId];
    if ($this->db->runQuery($query, $param)) {
      $row = $this->db->getResults(DB_SINGLE);
      unset($row['user_password']);
      return $row;
    }
  }

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search)";
      $query = "SELECT COUNT(*) FROM tabl_user U LEFT JOIN tabl_role R ON U.user_role_code = R.role_code WHERE (U.user_first_name LIKE :search) OR (U.user_last_name LIKE :search) OR (U.user_username LIKE :search) OR (R.role_name LIKE :search) OR (U.user_status LIKE :search)";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      $query = "SELECT COUNT(*) FROM tabl_user";
      $param = [];
    }

    if ($this->db->runQuery($query, $param)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getRows($data)
  {
    // var_dump($data);
    $sortType = "ASC";
    if ($data['sort_type'] == '1') {
      $sortType = "DESC";
    }

    if ($data['search_val']) {
      $query = "SELECT U.user_code AS users_id, U.user_first_name AS users_fname, U.user_last_name AS users_lname, U.user_username AS users_usrname, R.role_name AS users_role, U.user_status AS users_state 
      FROM tabl_user U LEFT JOIN tabl_role R ON U.user_role_code = R.role_code WHERE (U.user_first_name LIKE :search) OR (U.user_last_name LIKE :search) OR (U.user_username LIKE :search) OR (R.role_name LIKE :search) OR (U.user_status LIKE :search) 
      ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";

      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT U.user_code AS users_id, U.user_first_name AS users_fname, U.user_last_name AS users_lname, U.user_username AS users_usrname, R.role_name AS users_role, U.user_status AS users_state
      FROM tabl_user U LEFT JOIN tabl_role R ON U.user_role_code = R.role_code ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
      ];
    }

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }
}
