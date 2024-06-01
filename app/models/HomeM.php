<?php
class HomeM
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
    if (!$this->db->isConnected()) {
      exit("Error! : Could Not Connect To Database!");
    }
  }

  public function getProductCount()
  {
    $query = "SELECT COUNT(*) FROM tabl_product WHERE prod_active = 1";
    if ($this->db->runQuery($query)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getOrderCount()
  {
    $query = "SELECT COUNT(*) FROM tabl_order WHERE ordr_status = 'completed'";
    if ($this->db->runQuery($query)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getUserCount()
  {
    $query = "SELECT COUNT(*) FROM tabl_user WHERE user_status = 'active'";
    if ($this->db->runQuery($query)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getLocationCount()
  {
    $query = "SELECT COUNT(*) FROM tabl_location";
    if ($this->db->runQuery($query)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getLowProductCount()
  {
    $query = "SELECT SUM(CASE WHEN TEMP.prodt_qty < TEMP.prod_reod_level THEN 1 ELSE 0 END) AS low_count FROM (SELECT P.prod_reod_level, SUM(S.stok_quantity) AS prodt_qty FROM tabl_product P LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code WHERE P.prod_active = 1 GROUP BY P.prod_code) AS TEMP";
    if ($this->db->runQuery($query)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['low_count'];
    } else {
      return false;
    }
  }
}
