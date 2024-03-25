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

  public function login($username, $password)
  {
    $query = "SELECT * FROM tabl_user WHERE user_username = :usen";
    $param = ['usen' => $username];

    if ($this->db->runQuery($query, $param)) {
      $row = $this->db->getResults(DB_SINGLE);

      if ($row) {
        if (password_verify($password, $row->user_password)) {
          return $row;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }

  public function createUser($data)
  {
    $query = "INSERT INTO tabl_user(user_role_code, user_username, user_password, user_first_name, user_last_name, user_birthday, user_gender, user_address, user_phone, user_active, user_photo) 
               VALUES(:rolc, :usen, :pass, :fnam, :lnam, :bday, :gend, :addr, :phon, :accs, :fili)";
    // VALUES(:opt_role, :txt_username, :pas_password, :txt_fname, :txt_lname, :dte_birthday, :opt_gender, :txt_address, :tel_phone, :opt_accstat, :fil_image)";

    $param = [
      'rolc' => $data['opt_role'],
      'usen' => $data['txt_username'],
      'pass' => $data['pas_password'],
      'fnam' => $data['txt_fname'],
      'lnam' => $data['txt_lname'],
      'bday' => $data['dte_birthday'],
      'gend' => $data['opt_gender'],
      'addr' => $data['txt_address'],
      'phon' => $data['tel_phone'],
      'accs' => $data['opt_accstat'],
      'fili' => $data['fil_image']
    ];

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function findByUsername($username)
  {
    $query = "SELECT * FROM tabl_user WHERE user_username = :usen";
    $param = ['usen' => $username];

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function getUsers()
  {
    $query = "SELECT * FROM users";
  }

  public function getLastUserId()
  {
    return $this->db->lastId();
  }
}
