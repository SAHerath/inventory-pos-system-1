<?php
class AttributeM
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
      exit("Error! : Could Not Connect To Database.");
    }
  }

  public function createAttrbType($param)
  {
    $query = "INSERT INTO tabl_attribute_type(attp_name) VALUES(:attrbname)";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function updateAttrbType($param)
  {
    $query = "UPDATE tabl_attribute_type SET attp_name=:attrbname WHERE attp_code=:attrbid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function removeAttrbType($param)
  {
    $query = "DELETE FROM tabl_attribute_type WHERE attp_code=:attrbid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function getRowCountAttrbType($searchVal = null)
  {
    if ($searchVal) {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search)";
      $query = "SELECT COUNT(*) FROM tabl_attribute_type WHERE attp_name LIKE :search";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift";
      $query = "SELECT COUNT(*) FROM tabl_attribute_type";
      $param = [];
    }

    if ($this->db->runQuery($query, $param)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getRowsAttrbType($data)
  {
    // var_dump($data);
    $sortType = "ASC";
    if ($data['sort_type'] == '1') {
      $sortType = "DESC";
    }

    if ($data['search_val']) {

      $query = "SELECT * FROM (SELECT tabl_attribute_type.attp_code AS attrb_id, tabl_attribute_type.attp_name AS attrb_name, COUNT(tabl_attribute_value.atvl_code) AS value_total FROM tabl_attribute_type LEFT JOIN tabl_attribute_value ON tabl_attribute_type.attp_code = tabl_attribute_value.atvl_attp_code GROUP BY tabl_attribute_type.attp_code) AS tabl_temp WHERE tabl_temp.attp_name LIKE :search ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      // $query = "SELECT attp_code AS attrb_id, attp_name AS attrb_name FROM tabl_attribute_type WHERE attp_name LIKE :search ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";

      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT * FROM (SELECT tabl_attribute_type.attp_code AS attrb_id, tabl_attribute_type.attp_name AS attrb_name, COUNT(tabl_attribute_value.atvl_code) AS value_total FROM tabl_attribute_type LEFT JOIN tabl_attribute_value ON tabl_attribute_type.attp_code = tabl_attribute_value.atvl_attp_code GROUP BY tabl_attribute_type.attp_code) AS tabl_temp ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      // $query = "SELECT attp_code AS attrb_id, attp_name AS attrb_name FROM tabl_attribute_type ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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

  ///////////////////////////////////////////////////////////////////////////

  public function getAttribName($attid)
  {
    $query = "SELECT attp_name FROM tabl_attribute_type WHERE attp_code=:attrbid";
    $param = ['attrbid' => $attid];

    if ($this->db->runQuery($query, $param)) {
      $name = $this->db->getResults(DB_SINGLE);
      return $name['attp_name'];
    }
  }

  public function createAttrbValue($param)
  {
    $query = "INSERT INTO tabl_attribute_value(atvl_attp_code, atvl_value) VALUES(:attrbid, :atvalname)";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function updateAttrbValue($param)
  {
    $query = "UPDATE tabl_attribute_value SET atvl_value=:atvalname WHERE atvl_code=:atvalid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function removeAttrbValue($param)
  {
    $query = "DELETE FROM tabl_attribute_value WHERE atvl_code=:atvalid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function getRowCountAttrbValue($parentId, $searchVal = null)
  {
    if ($searchVal) {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search)";
      $query = "SELECT COUNT(*) FROM tabl_attribute_value WHERE (atvl_attp_code=:parent) AND (atvl_value LIKE :search)";
      $param = [
        'parent' => $parentId,
        'search' => '%' . $searchVal . '%'
      ];
    } else {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift";
      $query = "SELECT COUNT(*) FROM tabl_attribute_value WHERE atvl_attp_code=:parent";
      $param = ['parent' => $parentId];
    }

    if ($this->db->runQuery($query, $param)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getRowsAttrbValue($data)
  {
    // var_dump($data);
    $sortType = "ASC";
    if ($data['sort_type'] == '1') {
      $sortType = "DESC";
    }

    if ($data['search_val']) {
      // $query = "SELECT id, title, album, artist, released_at FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $query = "SELECT atvl_code AS atval_id, atvl_value AS atval_name FROM tabl_attribute_value WHERE (atvl_attp_code=:parent) AND (atvl_value LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'parent' => $data['parent_id'],
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      // $query = "SELECT id, title, album, artist, released_at FROM songs_taylorswift ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $query = "SELECT atvl_code AS atval_id, atvl_value AS atval_name FROM tabl_attribute_value WHERE atvl_attp_code=:parent ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'parent' => $data['parent_id'],
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
      ];
    }
    // var_dump($param);
    if ($this->db->runQuery($query, $param)) {
      $rows = $this->db->getResults(DB_MULTIPLE);
      return $rows;
    } else {
      return false;
    }
  }
}
