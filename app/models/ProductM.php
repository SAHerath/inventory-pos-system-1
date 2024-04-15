<?php
class ProductM
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

  public function getCategory($categId)
  {
    // set query
    $query = "SELECT catg_name AS categ_name FROM tabl_category WHERE catg_code = :categid";
    // set parameters in associative array
    $param = ['categid' => $categId];
    // call database class to run query
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE); // get query result as single row
    }
  }

  public function getCategoryList()
  {
    $query = "SELECT catg_code, catg_name FROM tabl_category WHERE catg_active = 1";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function getBrand($brandId)
  {
    $query = "SELECT brnd_name AS brand_name FROM tabl_brand WHERE brnd_code = :brandid";
    $param = ['brandid' => $brandId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getBrandList()
  {
    $query = "SELECT brnd_code, brnd_name FROM tabl_brand WHERE brnd_active = 1";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function getVendor($vendrId)
  {
    $query = "SELECT vend_name AS vendr_name FROM tabl_vendor WHERE vend_code = :vendrid";
    $param = ['vendrid' => $vendrId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
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

  public function getLocationList()
  {
    $query = "SELECT loca_code, loca_name FROM tabl_location";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function getAttrbAtval($atvalId)
  {
    $query = "SELECT tabl_attribute_type.attp_name AS attrb_name, tabl_attribute_value.atvl_value AS atval_name 
    FROM tabl_attribute_value 
    INNER JOIN tabl_attribute_type ON tabl_attribute_value.atvl_attp_code = tabl_attribute_type.attp_code 
    WHERE tabl_attribute_value.atvl_code = :atvalid";

    $param = ['atvalid' => $atvalId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getAttributeList()
  {
    $query = "SELECT attp_code, attp_name FROM tabl_attribute_type";
    if ($this->db->runQuery($query)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  // public function getAttributeList2()
  // {
  //   // $query = "SELECT attp_code AS attrb_id, attp_name AS attrb_name, CASE WHEN AP.atpr_code IS NOT NULL THEN true ELSE false END AS selected FROM tabl_attribute_product AP LEFT JOIN tabl_attribute_value AV ON AP.atpr_atvl_code = AV.atvl_code RIGHT JOIN tabl_attribute_type AT ON AV.atvl_attp_code = AT.attp_code GROUP BY AT.attp_code";

  //   $query = "SELECT attp_code AS attrb_id, attp_name AS attrb_name, (AP.atpr_code IS NOT NULL) AS selected FROM tabl_attribute_product AP 
  //   LEFT JOIN tabl_attribute_value AV ON AP.atpr_atvl_code = AV.atvl_code 
  //   RIGHT JOIN tabl_attribute_type AT ON AV.atvl_attp_code = AT.attp_code GROUP BY AT.attp_code";

  //   if ($this->db->runQuery($query)) {
  //     return $this->db->getResults(DB_MULTIPLE);
  //   } else {
  //     return false;
  //   }
  // }

  public function getAttrbValues($parentId)
  {
    $query = "SELECT atvl_code AS atval_id, atvl_value AS atval_name FROM tabl_attribute_value WHERE atvl_attp_code=:parent";
    $param = ['parent' => $parentId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    } else {
      return false;
    }
  }

  public function create($param)
  {
    // var_dump($param);
    // echo json_encode($param);
    // return;
    try {
      $this->db->beginTransaction();

      $query = "INSERT INTO tabl_product (prod_catg_code, prod_brnd_code, prod_vend_code, prod_name, prod_descrip, prod_retl_price, prod_whsa_price, prod_reod_level, prod_reod_quant, prod_vend_price, prod_vend_prtno, prod_active) 
                VALUES(:prodtcategry, :prodtbrand, :prodtvendor, :prodtname, :prodtdescrip, :prodtrtlprce, :prodtwslprce, :prodtreodlvl, :prodtreodqty, :prodtvndprce, :prodtvndptno, :prodtstatus)";

      if ($this->db->runQuery($query, $param['prodt'])) {
        $productId = $this->db->getResults(DB_LASTID);
      } else {
        throw new Exception('Query 1 failed');
      }

      /*  $query = "INSERT INTO tabl_vendor_product (vnpr_vend_code, vnpr_prod_code, vnpr_price, vnpr_vendor_partno) 
                VALUES(:prodtvendor, :prodtid, :prodtvndprce, :prodtvndptno)";

        $param['vendr']['prodtid'] = $productId;
        if ($this->db->runQuery($query, $param['vendr'])) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 2 failed');
        } 
      */

      $query = "INSERT INTO tabl_stock (stok_loca_code, stok_prod_code, stok_quantity) 
                VALUES(:locat, :prodtid, :stock)";

      foreach ($param['stock'] as $para_arr) {
        $para_arr['prodtid'] = $productId;

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 2 failed');
        }
      }

      $query = "INSERT INTO tabl_attribute_product (atpr_prod_code, atpr_atvl_code) 
                VALUES(:prodtid, :atval)";

      foreach ($param['attrb'] as $para_arr) {
        $para_arr['prodtid'] = $productId;

        if ($this->db->runQuery($query, $para_arr)) {
          // $this->db->getResults(DB_COUNT);
        } else {
          throw new Exception('Query 3 failed');
        }
      }

      $query = "INSERT INTO tabl_image_product (impr_prod_code, impr_img_name) 
                VALUES(:prodtid, :prodtimage)";

      foreach ($param['image'] as $para_arr) {
        $para_arr['prodtid'] = $productId;

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
      error_log(date('D d-M-Y H:i:s e | ') . "ProductM: create: {$e->getMessage()}" . PHP_EOL, 3, APPROOT . '/logs/error.log');
      return false;
    }
  }

  public function getProduct($rowId)
  {
    $query = "SELECT * FROM tabl_product WHERE prod_code=:prodtid";
    $param = ['prodtid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_SINGLE);
    }
  }

  public function getProdtImage($rowId)
  {
    $query = "SELECT impr_img_name FROM tabl_image_product WHERE impr_prod_code=:prodtid";
    $param = ['prodtid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function getProdtStock($rowId)
  {
    $query = "SELECT tabl_stock.stok_loca_code, tabl_location.loca_name, tabl_stock.stok_quantity FROM tabl_stock 
              INNER JOIN tabl_location ON tabl_stock.stok_loca_code = tabl_location.loca_code 
              WHERE tabl_stock.stok_prod_code = :prodtid";
    $param = ['prodtid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function getProdtAtval($rowId)
  {
    $query = "SELECT tabl_attribute_value.atvl_code, tabl_attribute_value.atvl_value, tabl_attribute_type.attp_code, tabl_attribute_type.attp_name FROM tabl_attribute_product 
              INNER JOIN tabl_attribute_value ON tabl_attribute_product.atpr_atvl_code = tabl_attribute_value.atvl_code 
              INNER JOIN tabl_attribute_type ON tabl_attribute_value.atvl_attp_code = tabl_attribute_type.attp_code 
              WHERE tabl_attribute_product.atpr_prod_code = :prodtid";
    $param = ['prodtid' => $rowId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  public function getProdtAtvalAll($attrbId)
  {
    $query = "SELECT atvl_code, atvl_value FROM tabl_attribute_value WHERE atvl_attp_code = :attrbid";
    $param = ['attrbid' => $attrbId];
    if ($this->db->runQuery($query, $param)) {
      return $this->db->getResults(DB_MULTIPLE);
    }
  }

  /*
    public function getProdtAttrb($prodtId)
    {
      $query = "SELECT tabl_attribute_type.attp_code, tabl_attribute_type.attp_name, tabl_attribute_product.atpr_prod_code 
      FROM tabl_attribute_type 
      LEFT JOIN tabl_attribute_value ON tabl_attribute_type.attp_code = tabl_attribute_value.atvl_attp_code 
      LEFT JOIN tabl_attribute_product ON tabl_attribute_value.atvl_code = tabl_attribute_product.atpr_atvl_code 
      WHERE (tabl_attribute_product.atpr_prod_code = :prodtid) OR (tabl_attribute_product.atpr_prod_code IS NULL) 
      GROUP BY tabl_attribute_type.attp_name";

      $param = ['prodtid' => $prodtId];
      if ($this->db->runQuery($query, $param)) {
        return $this->db->getResults(DB_MULTIPLE);
      }
    }
  */

  public function getRowCount($searchVal = null)
  {
    if ($searchVal) {

      $query = "SELECT COUNT(*) FROM (SELECT P.prod_code AS pid, P.prod_name AS pname, P.prod_descrip AS pdesc, P.prod_active AS pstat, C.catg_name AS pcatg, B.brnd_name AS pbrnd
      FROM tabl_product P LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code LEFT JOIN tabl_brand B ON P.prod_brnd_code = B.brnd_code LEFT JOIN tabl_image_product I ON P.prod_code = I.impr_prod_code LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code 
      GROUP BY P.prod_code) AS Temp WHERE (Temp.pname LIKE :search) OR (Temp.pdesc LIKE :search) OR (Temp.pcatg LIKE :search) OR (Temp.pbrnd LIKE :search)";

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

  public function getRows($data)
  {
    // var_dump($data);
    $sortType = "ASC";
    if ($data['sort_type'] == '1') {
      $sortType = "DESC";
    }

    if ($data['search_val']) {
      $query = "SELECT * FROM (SELECT P.prod_code AS pid, P.prod_name AS pname, P.prod_descrip AS pdesc, P.prod_active AS pstat, C.catg_name AS pcatg, B.brnd_name AS pbrnd, I.impr_img_name AS pimg, SUM(S.stok_quantity) AS pqty, COUNT(S.stok_loca_code) AS plocs 
      FROM tabl_product P LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code LEFT JOIN tabl_brand B ON P.prod_brnd_code = B.brnd_code LEFT JOIN tabl_image_product I ON P.prod_code = I.impr_prod_code LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code 
      GROUP BY P.prod_code) AS Temp WHERE (Temp.pname LIKE :search) OR (Temp.pdesc LIKE :search) OR (Temp.pcatg LIKE :search) OR (Temp.pbrnd LIKE :search) ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
      $param = [
        'ordcol' => $data['sort_col'],
        'rowcon' => $data['max_rows'],
        'offset' => $data['row_offset'],
        'search' => '%' . $data['search_val'] . '%'
      ];
    } else {
      $query = "SELECT * FROM (SELECT P.prod_code AS pid, P.prod_name AS pname, P.prod_descrip AS pdesc, P.prod_active AS pstat, C.catg_name AS pcatg, B.brnd_name AS pbrnd, I.impr_img_name AS pimg, SUM(S.stok_quantity) AS pqty, COUNT(S.stok_loca_code) AS plocs 
      FROM tabl_product P LEFT JOIN tabl_category C ON P.prod_catg_code = C.catg_code LEFT JOIN tabl_brand B ON P.prod_brnd_code = B.brnd_code LEFT JOIN tabl_image_product I ON P.prod_code = I.impr_prod_code LEFT JOIN tabl_stock S ON P.prod_code = S.stok_prod_code 
      GROUP BY P.prod_code) AS Temp ORDER BY :ordcol $sortType LIMIT :offset, :rowcon";
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
