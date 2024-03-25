<?php
class BrandM
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
    $query = "INSERT INTO tabl_brand(brnd_name, brnd_active) VALUES(:brandname, :brandactv)";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function update($param)
  {
    $query = "UPDATE tabl_brand SET brnd_name=:brandname, brnd_active=:brandactv WHERE brnd_code=:brandid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function remove($param)
  {
    $query = "DELETE FROM tabl_brand WHERE brnd_code=:brandid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
  }

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift WHERE (title LIKE :search) OR (album LIKE :search)";
      $query = "SELECT COUNT(*) FROM tabl_brand WHERE brnd_name LIKE :search";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      // $query = "SELECT COUNT(*) FROM songs_taylorswift";
      $query = "SELECT COUNT(*) FROM tabl_brand";
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
      $query = "SELECT brnd_code AS brand_id, brnd_name AS brand_name, brnd_active AS brand_state FROM tabl_brand WHERE brnd_name LIKE :search ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      // $query = "SELECT id, title, album, artist, released_at FROM songs_taylorswift ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $query = "SELECT brnd_code AS brand_id, brnd_name AS brand_name, brnd_active AS brand_state FROM tabl_brand ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
