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

  public function getPermission($rowId)
  {
    $query = "SELECT P.perm_module, P.perm_section FROM tabl_role_permis RP LEFT JOIN tabl_permission P ON RP.ropm_perm_code = P.perm_code WHERE RP.ropm_role_code = :rolesid";
    $param = ['rolesid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }
}
