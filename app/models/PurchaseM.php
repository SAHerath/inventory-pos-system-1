<?php
class PurchaseM
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
    if (!$this->db->isConnected()) {
      exit("Error! : Could Not Connect To Database!");
    }
  }

  public function getVendorList()
  {
    $query = "SELECT vend_code, vend_name FROM tabl_vendor WHERE vend_active = 1";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function getVendor($rowId)
  {
    $query = "SELECT vend_name, vend_address, vend_city, vend_country, vend_phone, vend_email FROM tabl_vendor WHERE vend_code = :vendrid";
    $param = ['vendrid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    } else {
      return false;
    }
  }

  public function getLocationList()
  {
    $query = "SELECT loca_code, loca_name FROM tabl_location";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function getLocation($rowId)
  {
    $query = "SELECT loca_name, loca_address FROM tabl_location WHERE loca_code = :locatid";
    $param = ['locatid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    } else {
      return false;
    }
  }

  public function getUser($rowId)
  {
    $query = "SELECT user_username FROM tabl_user WHERE user_code = :usersid";
    $param = ['usersid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    } else {
      return false;
    }
  }

  public function getProduct($rowId)
  {
    $query = "SELECT prod_code AS prodt_id, prod_name AS prodt_name, prod_vend_price AS prodt_venprice, prod_vend_prtno AS prodt_venpart, prod_reod_quant AS prodt_reqty FROM tabl_product WHERE prod_code = :prodtid";
    $param = ['prodtid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    } else {
      return false;
    }
  }

  public function getOrder($rowId)
  {
    $query = "SELECT * FROM tabl_purchase WHERE prch_code = :purchid";
    $param = ['purchid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getOrderProduct($rowId)
  {
    $query = "SELECT PP.pcpd_code, PP.pcpd_unit_price, PP.pcpd_order_qty, PP.pcpd_recev_qty, PP.pcpd_retrn_qty, P.prod_code, P.prod_vend_prtno 
    FROM tabl_purchase_products PP LEFT JOIN tabl_product P ON PP.pcpd_prod_code = P.prod_code WHERE PP.pcpd_prch_code = :purchid";
    $param = ['purchid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function create($param)
  {
    // var_dump($param);
    // return false;
    try {
      $this->db->beginTransaction();

      $query = "INSERT INTO tabl_purchase (prch_vend_code, prch_loca_code, prch_order_user_code, prch_order_date, prch_remark, prch_sub_total, prch_charges, prch_total, prch_status) 
                VALUES(:purchvendr, :purchlocat, :purchuser, :purchdate, :purchremark, :purchsubtot, :purchaddcha, :purchtotal, :purchstate)";

      if ($this->db->runQuery($query, $param['purch'])) {
        $purchId = $this->db->getResults(DB_LASTID);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "INSERT INTO tabl_purchase_products (pcpd_prch_code, pcpd_prod_code, pcpd_unit_price, pcpd_order_qty) 
      VALUES(:purchid, :prodtid, :purch_rat, :purch_qty)";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['purchid'] = $purchId;

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
      logger("PurchaseM: create: {$e->getMessage()}", APP_ERROR);
      return false;
    }
  }

  public function update($param)
  {
    // var_dump($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "UPDATE tabl_purchase SET prch_vend_code=:purchvendr, prch_loca_code=:purchlocat, prch_order_date=:purchdate, prch_remark=:purchremark, prch_sub_total=:purchsubtot, prch_charges=:purchaddcha, prch_total=:purchtotal, prch_paid=:purchpaid, prch_balance=:purchbalnc, prch_status=:purchstate WHERE prch_code = :purchid";

      if ($this->db->runQuery($query, $param['purch'])) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "DELETE FROM tabl_purchase_products WHERE pcpd_prch_code = :purchid";
      $para_arr = ['purchid' => $param['purch']['purchid']];
      if ($this->db->runQuery($query, $para_arr)) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 2 failed');
      }

      $query = "INSERT INTO tabl_purchase_products (pcpd_prch_code, pcpd_prod_code, pcpd_unit_price, pcpd_order_qty, pcpd_recev_qty, pcpd_retrn_qty) 
      VALUES(:purchid, :prodtid, :purch_rat, :purch_qty, :purch_rec, :purch_ret)";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['purchid'] = $param['purch']['purchid'];

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
      logger("PurchaseM: update: {$e->getMessage()}", APP_ERROR);
      return false;
    }
  }

  public function remove($param)
  {
    $query = "DELETE FROM tabl_purchase WHERE prch_code = :purchid";

    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_COUNT);
    }
    // no need to delete relavent rows of tabl_order_products because MySQL ondelete cascade function
  }

  public function receive($param)
  {
    // var_dump($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "UPDATE tabl_purchase SET prch_recev_user_code=:purchrecuser, prch_recev_date=:purchrecdate, prch_remark=:purchremark, prch_sub_total=:purchsubtot, prch_charges=:purchaddcha, prch_total=:purchtotal, prch_status=:purchstate WHERE prch_code = :purchid";

      if ($this->db->runQuery($query, $param['purch'])) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "DELETE FROM tabl_purchase_products WHERE pcpd_prch_code = :purchid";
      $para_arr = ['purchid' => $param['purch']['purchid']];
      if ($this->db->runQuery($query, $para_arr)) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 2 failed');
      }

      $query = "INSERT INTO tabl_purchase_products (pcpd_prch_code, pcpd_prod_code, pcpd_unit_price, pcpd_order_qty, pcpd_recev_qty, pcpd_retrn_qty) 
      VALUES(:purchid, :prodtid, :purch_rat, :purch_ord, :purch_rec, :purch_ret)";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['purchid'] = $param['purch']['purchid'];

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 3 failed');
        }
      }

      // update stock
      $query = "UPDATE tabl_stock SET stok_quantity = (stok_quantity + :purch_rec) WHERE stok_prod_code = :prodtid AND stok_loca_code = :purchlocat";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['purchlocat'] = $param['purch']['purchlocat'];

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 4 failed');
        }
      }

      $this->db->endTransaction();
      return true;
    } catch (Exception $e) {
      $this->db->cancelTransaction();
      // echo $e->getMessage();
      logger("PurchaseM: receive: {$e->getMessage()}", APP_ERROR);
      return false;
    }
  }

  public function return($param)
  {
    var_dump($param);
    return;
    try {
      $this->db->beginTransaction();

      $query = "UPDATE tabl_purchase SET prch_retrn_user_code=:purchretuser, prch_retrn_date=:purchretdate, prch_remark=:purchremark, prch_refund=:purchtotal, prch_status=:purchstate WHERE prch_code = :purchid";

      if ($this->db->runQuery($query, $param['purch'])) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 1 failed');
      }

      $query = "DELETE FROM tabl_purchase_products WHERE pcpd_prch_code = :purchid";
      $para_arr = ['purchid' => $param['purch']['purchid']];
      if ($this->db->runQuery($query, $para_arr)) {
        // $this->db->getResults(DB_COUNT);
      } else {
        throw new Exception('Query 2 failed');
      }

      $query = "INSERT INTO tabl_purchase_products (pcpd_prch_code, pcpd_prod_code, pcpd_unit_price, pcpd_order_qty, pcpd_recev_qty, pcpd_retrn_qty) 
      VALUES(:purchid, :prodtid, :purch_rat, :purch_ord, :purch_rec, :purch_ret)";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['purchid'] = $param['purch']['purchid'];

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 3 failed');
        }
      }

      // update stock
      $query = "UPDATE tabl_stock SET stok_quantity = (stok_quantity - :purch_rec) WHERE stok_prod_code = :prodtid AND stok_loca_code = :purchlocat";

      foreach ($param['tblr'] as $para_arr) {
        $para_arr['purchlocat'] = $param['purch']['purchlocat'];

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 4 failed');
        }
      }

      $this->db->endTransaction();
      return true;
    } catch (Exception $e) {
      $this->db->cancelTransaction();
      // echo $e->getMessage();
      logger("PurchaseM: receive: {$e->getMessage()}", APP_ERROR);
      return false;
    }
  }

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {

      $query = "SELECT COUNT(*) FROM tabl_purchase P LEFT JOIN tabl_vendor V ON P.prch_vend_code = V.vend_code WHERE (P.prch_order_date LIKE :search) OR (P.prch_status LIKE :search) OR (V.vend_name LIKE :search)";

      $param = ['search' => '%' . $searchVal . '%'];
    } else {
      $query = "SELECT COUNT(*) FROM tabl_purchase";
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
      $query = "SELECT P.prch_code AS purch_id, P.prch_order_date AS purch_date, P.prch_status AS purch_state, P.prch_total AS purch_totalamt, P.prch_paid AS purch_paidamt, P.prch_balance AS purch_balance, V.vend_name AS vendr_name FROM tabl_purchase P LEFT JOIN tabl_vendor V ON P.prch_vend_code = V.vend_code WHERE (P.prch_order_date LIKE :search) OR (P.prch_status LIKE :search) OR (V.vend_name LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT P.prch_code AS purch_id, P.prch_order_date AS purch_date, P.prch_status AS purch_state, P.prch_total AS purch_totalamt, P.prch_paid AS purch_paidamt, P.prch_balance AS purch_balance, V.vend_name AS vendr_name FROM tabl_purchase P LEFT JOIN tabl_vendor V ON P.prch_vend_code = V.vend_code ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
