<?php
class RoleM
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

  public function getPermissionList()
  {
    $query = "SELECT perm_code, perm_module, perm_section FROM tabl_permission";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function create($param)
  {
    // var_dump($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "INSERT INTO tabl_role (role_name, role_state) VALUES(:rolesname, :rolesstate)";

      if ($this->db->runQuery($query, $param['roles'])) {
        $rolesId = $this->db->getResults(DB_LASTID);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "INSERT INTO tabl_role_permis (ropm_perm_code, ropm_role_code) VALUES(:permiid, :rolesid)";

      foreach ($param['permi'] as $para_arr) {
        $para_arr['rolesid'] = $rolesId;

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 2 failed');
        }
      }
      $this->db->endTransaction();
      return true;
    } catch (Exception $e) {
      $this->db->cancelTransaction();
      // echo $e->getMessage();
      error_log(date('D d-M-Y H:i:s e | ') . "RoleM: create: {$e->getMessage()}" . PHP_EOL, 3, APPROOT . '/logs/error.log');
      return false;
    }
  }

  public function getRole($rowId)
  {
    $query = "SELECT * FROM tabl_role WHERE role_code = :rolesid";
    $param = ['rolesid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getRolePermissionList($rowId)
  {
    $query = "SELECT P.perm_code, P.perm_module, P.perm_section, T.ropm_role_code 
    FROM(SELECT * FROM tabl_role_permis WHERE ropm_role_code = :rolesid) AS T 
    RIGHT JOIN tabl_permission P ON T.ropm_perm_code = P.perm_code";

    $param = ['rolesid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function update($param)
  {
    // var_dump($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "UPDATE tabl_role SET role_name=:rolesname, role_state=:rolesstate WHERE role_code=:rolesid";

      if ($this->db->runQuery($query, $param['roles'])) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "DELETE FROM tabl_role_permis WHERE ropm_role_code = :rolesid";
      $para_arr = ['rolesid' => $param['roles']['rolesid']];
      if ($this->db->runQuery($query, $para_arr)) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 2 failed');
      }

      $query = "INSERT INTO tabl_role_permis (ropm_perm_code, ropm_role_code) VALUES(:permiid, :rolesid)";

      foreach ($param['permi'] as $para_arr) {
        $para_arr['rolesid'] = $param['roles']['rolesid'];

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 3 failed');
        }
      }

      $this->db->endTransaction();
      return true;
    } catch (Exception $e) {
      $this->db->cancelTransaction();
      // echo $e->getMessage();
      error_log(date('D d-M-Y H:i:s e | ') . "RoleM: update: {$e->getMessage()}" . PHP_EOL, 3, APPROOT . '/logs/error.log');
      return false;
    }
  }

  public function remove($param)
  {
    $query = "DELETE FROM tabl_role WHERE role_code=:rolesid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
    // no need to delete relavent rows of tabl_order_products because MySQL ondelete cascade function
  }

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {
      $query = "SELECT COUNT(*) FROM tabl_role WHERE role_name LIKE :search";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {

      $query = "SELECT COUNT(*) FROM tabl_role";
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
      $query = "SELECT role_code AS roles_id, role_name AS roles_name, role_state AS roles_status FROM tabl_role WHERE role_name LIKE :search ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT role_code AS roles_id, role_name AS roles_name, role_state AS roles_status FROM tabl_role ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
      ];
    }

    if ($this->db->runQuery($query, $param)) {
      $rows = $this->db->getResults(DB_MULTIPLE);
      return $rows;
    } else {
      return false;
    }
  }
}
