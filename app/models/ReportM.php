<?php
class ReportM
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
    if (!$this->db->isConnected()) {

      exit("Error! : Could Not Connect To Database!");
    }
  }

  public function getStockCount($searchVal = null)
  {
    if ($searchVal) {
      $query = "SELECT *, CASE WHEN TEMP.prodt_qty > TEMP.prodt_rord THEN 'OK' ELSE 'NOT OK' END AS prodt_stat FROM 
      (SELECT P.prod_code AS prodt_id, P.prod_name AS prodt_name, P.prod_reod_level AS prodt_rord, SUM(S.stok_quantity) AS prodt_qty, COUNT(S.stok_loca_code) AS prodt_locs FROM tabl_product P LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code WHERE P.prod_active = 1 GROUP BY P.prod_code) AS TEMP 
      WHERE (TEMP.prodt_id LIKE :search) OR (TEMP.prodt_name LIKE :search) OR (TEMP.prodt_qty LIKE :search) OR (TEMP.prodt_stat LIKE :search)";
      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      $query = "SELECT COUNT(*) FROM tabl_product";
      $param = [];
    }

    if ($this->db->runQuery($query, $param)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getStockData($data)
  {
    // var_dump($data);
    $sortType = "ASC";
    if ($data['sort_type'] == '1') {
      $sortType = "DESC";
    }

    if ($data['search_val']) {
      //  "SELECT P.prod_code, P.prod_name, P.prod_reod_level, S.stok_quantity, L.loca_name FROM tabl_stock S LEFT JOIN tabl_product P ON S.stok_prod_code = P.prod_code LEFT JOIN tabl_location L ON S.stok_loca_code = L.loca_code";
      $query = "SELECT *, CASE WHEN TEMP.prodt_qty > TEMP.prodt_rord THEN 'AVAILABLE' ELSE 'LOW' END AS prodt_stat FROM 
      (SELECT P.prod_code AS prodt_id, P.prod_name AS prodt_name, P.prod_reod_level AS prodt_rord, SUM(S.stok_quantity) AS prodt_qty, COUNT(S.stok_loca_code) AS prodt_locs FROM tabl_product P LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code WHERE P.prod_active = 1 GROUP BY P.prod_code) AS TEMP 
      WHERE (TEMP.prodt_id LIKE :search) OR (TEMP.prodt_name LIKE :search) OR (TEMP.prodt_qty LIKE :search) OR (TEMP.prodt_stat LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT *, CASE WHEN TEMP.prodt_qty > TEMP.prodt_rord THEN 'AVAILABLE' ELSE 'LOW' END AS prodt_stat FROM 
      (SELECT P.prod_code AS prodt_id, P.prod_name AS prodt_name, P.prod_reod_level AS prodt_rord, SUM(S.stok_quantity) AS prodt_qty, COUNT(S.stok_loca_code) AS prodt_locs FROM tabl_product P LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code WHERE P.prod_active = 1 GROUP BY P.prod_code) AS TEMP 
      ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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

  public function getSalesCount($searchVal = null)
  {
    if ($searchVal) {
      $query = "SELECT COUNT(*) FROM (SELECT P.prod_code AS sales_pid, C.catg_name AS sales_catg, CONCAT_WS(' | ', P.prod_name, P.prod_descrip) AS sales_desp, OP.odpd_quantity AS sales_qty, O.ordr_date AS sales_date FROM tabl_order_products OP 
      LEFT JOIN tabl_order O ON OP.odpd_ordr_code = O.ordr_code LEFT JOIN tabl_product P ON OP.odpd_prod_code = P.prod_code LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code 
      WHERE O.ordr_status = 'completed' AND O.ordr_date BETWEEN :firstdate AND :lastdate) AS TEMP";
      $param = [
        // 'search' => '%' . $searchVal . '%',
        'firstdate' => $searchVal['start'],
        'lastdate' => $searchVal['end']
      ];
    } else {
      $query = "SELECT COUNT(*) FROM tabl_order_products OP LEFT JOIN tabl_order O ON OP.odpd_ordr_code = O.ordr_code WHERE O.ordr_status = 'completed'";
      $param = [];
    }

    if ($this->db->runQuery($query, $param)) {
      $count = $this->db->getResults(DB_SINGLE);
      return $count['COUNT(*)'];
    } else {
      return false;
    }
  }

  public function getSalesData($data)
  {
    // var_dump($data);
    $sortType = "ASC";
    if ($data['sort_type'] == '1') {
      $sortType = "DESC";
    }

    if ($data['search_val']) {
      $query = "SELECT * FROM (SELECT P.prod_code AS sales_pid, C.catg_name AS sales_catg, CONCAT_WS(' | ', P.prod_name, P.prod_descrip) AS sales_desp, OP.odpd_quantity AS sales_qty, O.ordr_date AS sales_date FROM tabl_order_products OP 
      LEFT JOIN tabl_order O ON OP.odpd_ordr_code = O.ordr_code LEFT JOIN tabl_product P ON OP.odpd_prod_code = P.prod_code LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code 
      WHERE O.ordr_status = 'completed' AND O.ordr_date BETWEEN :firstdate AND :lastdate) AS TEMP ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";

      // $query = "SELECT * FROM (SELECT P.prod_code AS sales_pid, C.catg_name AS sales_catg, CONCAT_WS(' | ', P.prod_name, P.prod_descrip) AS sales_desp, OP.odpd_quantity AS sales_qty, O.ordr_date AS sales_date FROM tabl_order_products OP 
      // LEFT JOIN tabl_order O ON OP.odpd_ordr_code = O.ordr_code LEFT JOIN tabl_product P ON OP.odpd_prod_code = P.prod_code LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code WHERE O.ordr_status = 'completed') AS TEMP 
      // WHERE (TEMP.sales_pid LIKE :search) OR (TEMP.sales_catg LIKE :search) OR (TEMP.sales_desp LIKE :search) OR (TEMP.sales_qty LIKE :search)  OR (TEMP.sales_date LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";

      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        // 'search' => '%' . $data['search_val'] . '%',
        'firstdate' => $data['search_val']['start'],
        'lastdate' => $data['search_val']['end']
      ];
    } else {
      $query = "SELECT * FROM (SELECT P.prod_code AS sales_pid, C.catg_name AS sales_catg, CONCAT_WS(' | ', P.prod_name, P.prod_descrip) AS sales_desp, OP.odpd_quantity AS sales_qty, O.ordr_date AS sales_date FROM tabl_order_products OP 
      LEFT JOIN tabl_order O ON OP.odpd_ordr_code = O.ordr_code LEFT JOIN tabl_product P ON OP.odpd_prod_code = P.prod_code LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code WHERE O.ordr_status = 'completed') AS TEMP 
      ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
