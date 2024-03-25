<?php
class VendorM
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

  public function create($param)
  {
    $query = "INSERT INTO tabl_vendor (vend_name, vend_phone, vend_email, vend_website, vend_address, vend_city, vend_country, vend_zip, vend_notes, vend_active) 
      VALUES(:vendrname, :vendrphone, :vendremail, :vendrweb, :vendraddr, :vendrcity, :vendrcont, :vendrzip, :vendrnote, :vendractv)";
    // var_dump($param, $query);
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function update($param)
  {
    $query = "UPDATE tabl_vendor 
    SET vend_name=:vendrname, vend_phone=:vendrphone, vend_email=:vendremail, vend_website=:vendrweb, vend_address=:vendraddr, vend_city=:vendrcity, vend_country=:vendrcont, vend_zip=:vendrzip, vend_notes=:vendrnote, vend_active=:vendractv 
    WHERE vend_code=:vendrid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }


  public function remove($param)
  {
    $query = "DELETE FROM tabl_vendor WHERE vend_code=:vendrid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function getRow($rowId)
  {
    // vend_code AS vendr_id,
    // vend_name AS vendr_name,
    // vend_phone AS vendr_phone,
    // vend_email AS vendr_email,
    // vend_website AS vendr_website,
    // vend_address AS vendr_address,
    // vend_city AS vendr_city,
    // vend_country AS vendr_country,
    // vend_zip AS vendr_postal,
    // vend_notes AS vendr_remarks,
    // vend_active AS vendr_state
    $query = "SELECT * FROM tabl_vendor WHERE vend_code=:vendrid";
    $param = ['vendrid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {
      $query = "SELECT COUNT(*) FROM tabl_vendor WHERE (vend_name LIKE :search) OR (vend_email LIKE :search) OR (vend_city LIKE :search)";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      $query = "SELECT COUNT(*) FROM tabl_vendor";
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
      $query = "SELECT vend_code AS vendr_id, vend_name AS vendr_name, vend_phone AS vendr_phone, vend_email AS vendr_email, vend_active AS vendr_state FROM tabl_vendor WHERE (vend_name LIKE :search) OR (vend_email LIKE :search) OR (vend_city LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT vend_code AS vendr_id, vend_name AS vendr_name, vend_phone AS vendr_phone, vend_email AS vendr_email, vend_active AS vendr_state FROM tabl_vendor ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
