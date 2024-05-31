<?php
class SaleM
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
    if (!$this->db->isConnected()) {
      exit("Error! : Could Not Connect To Database!");
      // redirect('auth/error/' . urlencode('DBERROR Could Not Connect To Database!'));
    }
  }
}
