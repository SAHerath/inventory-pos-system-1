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


  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {

      $query = "SELECT COUNT(*) FROM tabl_order WHERE (ordr_date LIKE :search) OR (ordr_cust_name LIKE :search) OR (ordr_status LIKE :search)";

      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      $query = "SELECT COUNT(*) FROM tabl_order";
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
      $query = "SELECT ordr_code AS sales_id, ordr_date AS sales_date, ordr_cust_name AS sales_customer, ordr_total AS sales_totalamt, ordr_paid AS sales_paidamt, ordr_balance AS sales_balance, ordr_status AS sales_state FROM tabl_order WHERE (ordr_date LIKE :search) OR (ordr_cust_name LIKE :search) OR (ordr_status LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT ordr_code AS sales_id, ordr_date AS sales_date, ordr_cust_name AS sales_customer, ordr_total AS sales_totalamt, ordr_paid AS sales_paidamt, ordr_balance AS sales_balance, ordr_status AS sales_state FROM tabl_order ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
