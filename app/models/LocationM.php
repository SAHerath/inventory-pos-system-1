<?php
class LocationM
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
    $query = "INSERT INTO tabl_location(loca_name, loca_address) VALUES(:locatname, :locataddr)";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function update($param)
  {
    $query = "UPDATE tabl_location SET loca_name = :locatname, loca_address = :locataddr WHERE loca_code = :locatid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function remove($param)
  {
    $query = "DELETE FROM tabl_location WHERE loca_code = :locatid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search)";
      $query = "SELECT COUNT(*) FROM tabl_location WHERE (loca_name LIKE :search) OR (loca_address LIKE :search)";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift";
      $query = "SELECT COUNT(*) FROM tabl_location";
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
      // $query = "SELECT id, title, album, artist, released_at FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $query = "SELECT loca_code AS locat_id, loca_name AS locat_name, loca_address AS locat_address FROM tabl_location WHERE (loca_name LIKE :search) OR (loca_address LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      // $query = "SELECT id, title, album, artist, released_at FROM songs_taylorswift ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $query = "SELECT loca_code AS locat_id, loca_name AS locat_name, loca_address AS locat_address FROM tabl_location ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
