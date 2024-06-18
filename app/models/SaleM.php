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

  public function getProduct($rowId)
  {
    $query = "SELECT prod_code AS prodt_id, prod_name AS prodt_name, prod_retl_price AS prodt_reprice, prod_whsa_price AS prodt_whprice FROM tabl_product WHERE prod_code = :prodtid";
    $param = ['prodtid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    } else {
      return false;
    }
  }

  public function getOrder($rowId)
  {
    $query = "SELECT * FROM tabl_order WHERE ordr_code = :orderid";
    $param = ['orderid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getOrderUser($rowId)
  {
    $query = "SELECT U.user_first_name FROM tabl_order O LEFT JOIN tabl_user U ON O.ordr_user_code = U.user_code WHERE O.ordr_code = :orderid";
    $param = ['orderid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getOrderProduct($rowId)
  {
    $query = "SELECT OP.odpd_code, OP.odpd_unit_price, OP.odpd_quantity, OP.odpd_discount, OP.odpd_sub_amount, P.prod_code, P.prod_name FROM tabl_order_products OP 
    LEFT JOIN tabl_product P ON OP.odpd_prod_code = P.prod_code WHERE OP.odpd_ordr_code = :orderid";
    $param = ['orderid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function create($param)
  {
    // var_dump($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "INSERT INTO tabl_order (ordr_user_code, ordr_date, ordr_cust_name, ordr_cust_phone, ordr_cust_address, ordr_sub_total, ordr_taxes, ordr_total, ordr_paid, ordr_balance, ordr_pay_method, ordr_status) 
                VALUES(:ordersaler, :orderdate, :ordercname, :ordercphon, :ordercaddr, :ordersubtot, :ordertaxes, :ordertotal, :orderpaid, :orderbalnc, :orderpmeth, :orderstate)";

      if ($this->db->runQuery($query, $param['order'])) {
        $orderId = $this->db->getResults(DB_LASTID);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "INSERT INTO tabl_order_products (odpd_ordr_code, odpd_prod_code, odpd_unit_price, odpd_quantity, odpd_discount, odpd_sub_amount) 
      VALUES(:orderid, :prodtid, :order_rat, :order_qty, :order_dis, :order_amt)";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['orderid'] = $orderId;

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
      logger("OrderM: create: {$e->getMessage()}", APP_ERROR);
      return false;
    }
  }

  public function update($param)
  {
    // var_dump($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "UPDATE tabl_order SET ordr_date=:orderdate, ordr_cust_name=:ordercname, ordr_cust_phone=:ordercphon, ordr_cust_address=:ordercaddr, ordr_sub_total=:ordersubtot, ordr_taxes=:ordertaxes, ordr_total=:ordertotal, ordr_paid=:orderpaid, ordr_balance=:orderbalnc, ordr_pay_method=:orderpmeth, ordr_status=:orderstate WHERE ordr_code=:orderid";

      if ($this->db->runQuery($query, $param['order'])) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "DELETE FROM tabl_order_products WHERE odpd_ordr_code = :orderid";
      $para_arr = ['orderid' => $param['order']['orderid']];
      if ($this->db->runQuery($query, $para_arr)) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 2 failed');
      }

      $query = "INSERT INTO tabl_order_products (odpd_ordr_code, odpd_prod_code, odpd_unit_price, odpd_quantity, odpd_discount, odpd_sub_amount) 
      VALUES(:orderid, :prodtid, :order_rat, :order_qty, :order_dis, :order_amt)";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['orderid'] = $param['order']['orderid'];

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
      logger("OrderM: update: {$e->getMessage()}", APP_ERROR);
      return false;
    }
  }

  public function remove($param)
  {
    $query = "DELETE FROM tabl_order WHERE ordr_code = :orderid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
    // no need to delete relavent rows of tabl_order_products because MySQL ondelete cascade function
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
