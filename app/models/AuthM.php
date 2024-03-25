<?php
class AuthM
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
    if (!$this->db->isConnected()) {
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
        if (password_verify($password, $row['user_password'])) {
          return $row;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }
}
