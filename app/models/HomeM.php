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
}
