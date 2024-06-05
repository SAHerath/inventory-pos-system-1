<?php

class Purchases extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('PurchaseM');
  }

  public function index()
  {
    $data = [
      'title' => 'purchord_list'
    ];
    // var_dump($data);
    // $this->view('purchases/porderlistV', $data);
    $this->view('purchases/purchaselistV', $data);
  }

  public function add()
  {
    $data = [
      'title' => 'purchord_add',
      'date' => date('Y-m-d'),
      'currency' => ' (Rs)',
      'taxp' => '10'
    ];

    $data['vendr'] = $this->userModel->getVendorList();
    $data['locat'] = $this->userModel->getLocationList();

    $this->view('purchases/purchaseaddV', $data);
  }

  public function edit($orderId = null)
  {
    $orderId = trim($orderId);
    $data = [
      'title' => 'purchord_edit',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'vendr' => [],
      'locat' => [],
      'purch' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($orderId) || !preg_match($validator2, $orderId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['vendr'] = $this->userModel->getVendorList();
      $data['locat'] = $this->userModel->getLocationList();
      $data['purch'] = $this->userModel->getOrder($orderId);
      $data['ordprd'] = $this->userModel->getOrderProduct($orderId);
      $data['prdcon'] = count($data['ordprd']);

      for ($i = 0; $i < $data['prdcon']; $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/purchaseeditV', $data);
    }
  }

  public function show($purchId = null)
  {
    $purchId = trim($purchId);
    $data = [
      'title' => 'purchord_view',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'purch' => [],
      'ordprd' => [],
      'vendr' => [],
      'locat' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate order id
    if (empty($purchId) || !preg_match($validator2, $purchId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['purch'] = $this->userModel->getOrder($purchId);
      $data['ordprd'] = $this->userModel->getOrderProduct($purchId);
      $data['vendr'] = $this->userModel->getVendor($data['purch']['prch_vend_code']);
      $data['locat'] = $this->userModel->getLocation($data['purch']['prch_loca_code']);
      $data['users']['order'] = $this->userModel->getUser($data['purch']['prch_order_user_code']);
      $data['users']['recev'] = $this->userModel->getUser($data['purch']['prch_recev_user_code']);
      $data['users']['retrn'] = $this->userModel->getUser($data['purch']['prch_retrn_user_code']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      $data['purch']['prch_no'] = 'PO-' . str_pad($data['purch']['prch_code'], 8, '0', STR_PAD_LEFT);

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/purchaseviewV', $data);
    }
  }

  public function grn($purchId = null)
  {
    $purchId = trim($purchId);
    $data = [
      'title' => 'purchord_grn',
      'date' => date('Y-m-d'),
      'currency' => ' (Rs)',

    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate purchase order id
    if (empty($purchId) || !preg_match($validator2, $purchId)) {
      exit('Error! : No valied Order Id found.');
    } else {
      $data['purch'] = $this->userModel->getOrder($purchId);
      $data['ordprd'] = $this->userModel->getOrderProduct($purchId);
      $data['vendr'] = $this->userModel->getVendor($data['purch']['prch_vend_code']);
      // $data['locat'] = $this->userModel->getLocationList();

      $data['purch']['prch_no'] = 'PO-' . str_pad($data['purch']['prch_code'], 8, '0', STR_PAD_LEFT);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      $data['prdcon'] = count($data['ordprd']);

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/purchasegrnV', $data);
    }
  }

  public function return($purchId = null)
  {
    $purchId = trim($purchId);
    $data = [
      'title' => 'purchord_return',
      'date' => date('Y-m-d'),
      'currency' => ' (Rs)',

    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate purchase order id
    if (empty($purchId) || !preg_match($validator2, $purchId)) {
      exit('Error! : No valied Order Id found.');
    } else {
      $data['purch'] = $this->userModel->getOrder($purchId);
      $data['ordprd'] = $this->userModel->getOrderProduct($purchId);
      $data['vendr'] = $this->userModel->getVendor($data['purch']['prch_vend_code']);
      // $data['locat'] = $this->userModel->getLocationList();

      $data['purch']['prch_no'] = 'PO-' . str_pad($data['purch']['prch_code'], 8, '0', STR_PAD_LEFT);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      $data['prdcon'] = count($data['ordprd']);

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/purchasereturnV', $data);
    }
  }

  public function print($type, $purchId = null)
  {
    $purchId = trim($purchId);
    $data = [
      'title' => 'purchord_view',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'vendr' => [],
      'purch' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate order id
    if (empty($purchId) || !preg_match($validator2, $purchId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['purch'] = $this->userModel->getOrder($purchId);
      $data['ordprd'] = $this->userModel->getOrderProduct($purchId);
      $data['vendr'] = $this->userModel->getVendor($data['purch']['prch_vend_code']);
      $data['locat'] = $this->userModel->getLocation($data['purch']['prch_loca_code']);
      // $data['user']['issued'] = $this->userModel->getUser($data['purch']['prch_issue_user_code']);
      // $data['user']['received'] = $this->userModel->getUser($data['purch']['prch_recev_user_code']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
        // $data['ordprd'][$i]['pcpd_ret_amount'] = ($data['ordprd'][$i]['pcpd_qty_return'] * $data['ordprd'][$i]['pcpd_unit_price']);
      }

      $data['purch']['purch_no'] = 'PO-' . str_pad($data['purch']['prch_code'], 8, '0', STR_PAD_LEFT);

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      if ($type == 'po') {
        $this->view('purchases/porderprintpoV', $data);
      } elseif ($type == 'rn') {
        $this->view('purchases/porderprintrnV', $data);
      } elseif ($type == 'pr') {
        $this->view('purchases/porderprintprV', $data);
      } else {
      }
    }
  }


  public function addPurchase()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'purch' => [
          'purchdate' => trim($_POST['purch_date']),
          'purchvendr' => trim($_POST['purch_vendr']),
          'purchlocat' => trim($_POST['purch_locat']),
          'purchremark' => trim($_POST['purch_remarks']),
          // 'ordrpmeth' => trim($_POST['purch_paymeth']),
          'purchsubtot' => trim($_POST['purch_subtotal']),
          'purchaddcha' => trim($_POST['purch_addcharg']),
          'purchtotal' => trim($_POST['purch_totalamt']),
          // 'purchpaid' => trim($_POST['purch_paidamt']),
          // 'purchbalnc' => trim($_POST['purch_balance']),
          'purchpaid' => 0,
          'purchbalnc' => 0,
          'purchstate' => '',
          'purchuser' => (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '5')
        ],
        'tblr' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "tblr") === 0) {
          $key_part = explode('_', $key);
          $param[$key_part[0]][$key_part[1]][$key_part[2] . '_' . $key_part[3]] = trim($val);
        }
      }

      // $param['count1'] = count($param['tblr']);
      // //array_pop($param['tblr']);
      unset($param['tblr'][array_key_last($param['tblr'])]);
      // $param['count2'] = count($param['tblr']);

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator1 = "/^[a-zA-Z0-9 _.-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // sku check for 11 length zero padded positive integer with prefix of PR-
      $validator8 = "/^[0-9]*$/";  // filter any number
      $validator9 = "/^[0-9]*.[0-9]+?$/"; // check for floats which has at least one floating point
      $validator10 = "/^-?[0-9]*.[0-9]+?$/"; // check floats with optional sign (-) negative

      // validate date
      if (empty($param['purch']['purchdate'])) {
        $status['frm_msg']['purch_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['purch']['purchdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['purch_date'] = 'Date: Invalied date format';
        }
      }

      // validate vendor
      if (empty($param['purch']['purchvendr'])) {
        $data['frm_msg']['purch_vendr'] = 'Vendor Name: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchvendr'])) {
        $data['frm_msg']['purch_vendr'] = 'Vendor Name: Can only contain letters and numbers';
      }

      // validate location
      if (empty($param['purch']['purchlocat'])) {
        $data['frm_msg']['purch_locat'] = 'Location: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchlocat'])) {
        $data['frm_msg']['purch_locat'] = 'Location: Can only contain letters and numbers';
      }


      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['add_purch_msg'] = 'Order Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['purch_sku'], "PR-0");
          }

          // validate qty
          if (empty($tblrow_data['purch_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['purch_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Not a valid number";
          }

          // validate unit rate
          if (empty($tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Not a valid number";
          }

          if (!empty($data['frm_msg'])) {
            break;
          }
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // // validate payment method
      // if (empty($param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['porder_paymeth'] = 'Payment Method: Field not selected';
      // } elseif (!($param['purch']['orderpmeth'] == 'Cash' || $param['purch']['orderpmeth'] == 'Credit' || $param['purch']['orderpmeth'] == 'Cheque')) {
      //   $data['frm_msg']['porder_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // elseif (!preg_match($validator2, $param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }

      // validate remarks
      if (empty($param['purch']['purchremark'])) {
        // $data['frm_msg']['purch_remarks'] = 'Vendor Note: Field is empty';
      } elseif (!preg_match($validator1, $param['purch']['purchremark'])) {
        $data['frm_msg']['purch_remarks'] = 'Remarks: Invalied characters found';
      }

      // validate sub-total
      if (empty($param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate additinal charges
      if (empty($param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Not a valied number';
      }

      // validate total amt
      if (empty($param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Not a valied number';
      }

      // // validate paid amount
      // if (empty($param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Field is empty';
      // } elseif (!preg_match($validator9, $param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Not a valied number';
      // }

      // // validate balance
      // if (empty($param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Field is empty';
      // } elseif (!preg_match($validator10, $param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Not a valied number';
      // }

      if (empty($data['frm_msg'])) {

        if ($param['purch']['purchpaid'] >= $param['purch']['purchtotal']) {
          $param['purch']['purchstate'] = 'Paid';
        } else {
          $param['purch']['purchstate'] = 'In-progress';
        }

        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_purch_msg'] = 'Order successfully added';
        } else {
          $data['frm_msg']['add_purch_msg'] = 'Something went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function editPurchase()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'purch' => [
          'purchid' => trim($_POST['purch_id']),
          'purchdate' => trim($_POST['purch_date']),
          'purchlocat' => trim($_POST['purch_locat']),
          'purchvendr' => trim($_POST['purch_vendr']),
          'purchremark' => trim($_POST['purch_remarks']),
          // 'ordrpmeth' => trim($_POST['purch_paymeth']),
          'purchsubtot' => trim($_POST['purch_subtotal']),
          'purchaddcha' => trim($_POST['purch_addcharg']),
          'purchtotal' => trim($_POST['purch_totalamt']),
          // 'purchpaid' => trim($_POST['purch_paidamt']),
          // 'purchbalnc' => trim($_POST['purch_balance']),
          'purchpaid' => 0,
          'purchbalnc' => 0,
          'purchstate' => '',
          'purchuser' => (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '5'),
        ],
        'tblr' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "tblr") === 0) {
          $key_part = explode('_', $key);
          $param['tblr'][$key_part[1]]['purch_rec'] = 0;
          $param['tblr'][$key_part[1]]['purch_ret'] = 0;
          $param['tblr'][$key_part[1]][$key_part[2] . '_' . $key_part[3]] = trim($val);
        }
      }

      // $param['count1'] = count($param['tblr']);
      // //array_pop($param['tblr']);
      unset($param['tblr'][array_key_last($param['tblr'])]);
      // $param['count2'] = count($param['tblr']);

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator1 = "/^[a-zA-Z0-9 _.-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // sku check for 11 length zero padded positive integer with prefix of PR-
      $validator8 = "/^[0-9]*$/";  // filter any number
      $validator9 = "/^[0-9]*.[0-9]+?$/"; // check for floats which has at least one floating point
      $validator10 = "/^-?[0-9]*.[0-9]+?$/"; // check floats with optional sign (-) negative

      // validate order id
      if (empty($param['purch']['purchid'])) {
        $data['frm_msg']['edit_purch_msg'] = 'Order Id: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchid'])) {
        $data['frm_msg']['edit_purch_msg'] = 'Order Id: Invalied format';
      }

      // validate date
      if (empty($param['purch']['purchdate'])) {
        $status['frm_msg']['purch_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['purch']['purchdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['purch_date'] = 'Date: Invalied date format';
        }
      }

      // validate location
      if (empty($param['purch']['purchlocat'])) {
        $data['frm_msg']['purch_locat'] = 'Location: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchlocat'])) {
        $data['frm_msg']['purch_locat'] = 'Location: Can only contain letters and numbers';
      }

      // validate vendor
      if (empty($param['purch']['purchvendr'])) {
        $data['frm_msg']['purch_vendr'] = 'Vendor Name: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchvendr'])) {
        $data['frm_msg']['purch_vendr'] = 'Vendor Name: Can only contain letters and numbers';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['edit_purch_msg'] = 'Order Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['purch_sku'], "PR-0");
          }

          // validate qty
          if (empty($tblrow_data['purch_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['purch_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Not a valid number";
          }

          // validate unit rate
          if (empty($tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Not a valid number";
          }

          if (!empty($data['frm_msg'])) {
            break;
          }
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // // validate payment method
      // if (empty($param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['purch_paymeth'] = 'Payment Method: Field not selected';
      // } elseif (!($param['purch']['orderpmeth'] == 'Cash' || $param['purch']['purchpmeth'] == 'Credit' || $param['purch']['purchpmeth'] == 'Cheque')) {
      //   $data['frm_msg']['purch_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // elseif (!preg_match($validator2, $param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }

      // validate remarks
      if (empty($param['purch']['purchremark'])) {
        // $data['frm_msg']['purch_vendnote'] = 'Vendor Note: Field is empty';
      } elseif (!preg_match($validator1, $param['purch']['purchremark'])) {
        $data['frm_msg']['purch_vendnote'] = 'Remarks: Invalied characters found';
      }

      // validate sub-total
      if (empty($param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate other charges
      if (empty($param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Not a valied number';
      }

      // validate total amt
      if (empty($param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Not a valied number';
      }

      // // validate paid amount
      // if (empty($param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Field is empty';
      // } elseif (!preg_match($validator9, $param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Not a valied number';
      // }

      // // validate balance
      // if (empty($param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Field is empty';
      // } elseif (!preg_match($validator10, $param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Not a valied number';
      // }


      if (empty($data['frm_msg'])) {

        if ($param['purch']['purchpaid'] >= $param['purch']['purchtotal']) {
          $param['purch']['purchstate'] = 'Paid';
        } else {
          $param['purch']['purchstate'] = 'In-progress';
        }

        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_purch_msg'] = 'Order successfully updated';
        } else {
          $data['frm_msg']['edit_purch_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function deletePurchase()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'purchid' => trim($_POST['delt_purch_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate order id
      if (empty($param['purchid'])) {
        $data['frm_msg']['delt_purch_msg'] = 'Order Id: Field is empty';
      } elseif (!preg_match($validator2, $param['purchid'])) {
        $data['frm_msg']['delt_purch_msg'] = 'Order Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_purch_msg'] = 'Order successfully deleted';
        } else {
          $data['frm_msg']['delt_purch_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function receivePurchase()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'purch' => [
          'purchid' => trim($_POST['purch_id']),
          'purchlocat' => trim($_POST['purch_locat']),
          'purchrecdate' => trim($_POST['purch_recev_date']),
          'purchremark' => trim($_POST['purch_remarks']),
          'purchsubtot' => trim($_POST['purch_subtotal']),
          'purchaddcha' => trim($_POST['purch_addcharg']),
          'purchtotal' => trim($_POST['purch_totalamt']),
          // 'purchpaid' => trim($_POST['purch_paidamt']),
          // 'purchbalnc' => trim($_POST['purch_balance']),
          'purchpaid' => 0,
          'purchbalnc' => 0,
          'purchstate' => '',
          'purchrecuser' => (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '5'),
        ],
        'tblr' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "tblr") === 0) {
          $key_part = explode('_', $key);
          $param['tblr'][$key_part[1]][$key_part[2] . '_' . $key_part[3]] = trim($val);
          $param['tblr'][$key_part[1]]['purch_ret'] = 0;
        }
      }

      $partial =  false;  // true if partial received

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator1 = "/^[a-zA-Z0-9 _.-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // sku check for 11 length zero padded positive integer with prefix of PR-
      $validator8 = "/^[0-9]*$/";  // filter any number
      $validator9 = "/^[0-9]*.[0-9]+?$/"; // check for floats which has at least one floating point
      $validator10 = "/^-?[0-9]*.[0-9]+?$/"; // check floats with optional sign (-) negative

      // validate order id
      if (empty($param['purch']['purchid'])) {
        $data['frm_msg']['grn_purch_msg'] = 'Purchase Id: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchid'])) {
        $data['frm_msg']['grn_purch_msg'] = 'Purchase Id: Invalied format';
      }

      // validate location
      if (empty($param['purch']['purchlocat'])) {
        $data['frm_msg']['grn_purch_msg'] = 'Location: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchlocat'])) {
        $data['frm_msg']['grn_purch_msg'] = 'Location: Can only contain letters and numbers';
      }

      // validate date
      if (empty($param['purch']['purchdate'])) {
        $status['frm_msg']['purch_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['purch']['purchdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['purch_date'] = 'Date: Invalied date format';
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['grn_purch_msg'] = 'Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['purch_sku'], "PR-0");
          }

          // validate order qty
          if (empty($tblrow_data['purch_ord'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Ord. Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['purch_ord'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Ord. Qty: Not a valid number";
          }

          // validate receive qty
          if (empty($tblrow_data['purch_rec'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rec. Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['purch_rec'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rec. Qty: Not a valid number";
          } elseif ($tblrow_data['purch_rec'] > $tblrow_data['purch_ord']) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rec. Qty: Cannot exceed Ord. Qty";
          }

          // validate unit rate
          if (empty($tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Amount: Not a valid number";
          }

          // check whether fully received or not
          if ($tblrow_data['purch_ord'] != $tblrow_data['purch_rec']) {
            $partial = true;
          }

          if (!empty($data['frm_msg'])) {
            break;
          }
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // // validate payment method
      // if (empty($param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['purch_paymeth'] = 'Payment Method: Field not selected';
      // } elseif (!($param['purch']['orderpmeth'] == 'Cash' || $param['purch']['purchpmeth'] == 'Credit' || $param['purch']['purchpmeth'] == 'Cheque')) {
      //   $data['frm_msg']['purch_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // elseif (!preg_match($validator2, $param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }

      // validate remarks
      if (empty($param['purch']['purchremark'])) {
        // $data['frm_msg']['purch_vendnote'] = 'Vendor Note: Field is empty';
      } elseif (!preg_match($validator1, $param['purch']['purchremark'])) {
        $data['frm_msg']['purch_vendnote'] = 'Remarks: Invalied characters found';
      }

      // validate sub-total
      if (empty($param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate other charges
      if (empty($param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Not a valied number';
      }

      // validate total amt
      if (empty($param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Not a valied number';
      }

      // // validate paid amount
      // if (empty($param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Field is empty';
      // } elseif (!preg_match($validator9, $param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Not a valied number';
      // }

      // // validate balance
      // if (empty($param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Field is empty';
      // } elseif (!preg_match($validator10, $param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Not a valied number';
      // }


      if (empty($data['frm_msg'])) {

        if ($partial) {
          $param['purch']['purchstate'] = 'Received';
        } else {
          $param['purch']['purchstate'] = 'Fully-received';
        }

        if ($this->userModel->receive($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['grn_purch_msg'] = 'Grn successfully saved';
        } else {
          $data['frm_msg']['grn_purch_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function returnPurchase()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'purch' => [
          'purchid' => trim($_POST['purch_id']),
          'purchlocat' => trim($_POST['purch_locat']),
          'purchretdate' => trim($_POST['purch_retrn_date']),
          'purchremark' => trim($_POST['purch_remarks']),
          'purchsubtot' => trim($_POST['purch_subtotal']),
          'purchaddcha' => trim($_POST['purch_addcharg']),
          'purchtotal' => trim($_POST['purch_totalamt']),
          // 'purchpaid' => trim($_POST['purch_paidamt']),
          // 'purchbalnc' => trim($_POST['purch_balance']),
          'purchpaid' => 0,
          'purchbalnc' => 0,
          'purchstate' => '',
          'purchretuser' => (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '5'),
        ],
        'tblr' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "tblr") === 0) {
          $key_part = explode('_', $key);
          $param['tblr'][$key_part[1]][$key_part[2] . '_' . $key_part[3]] = trim($val);
          $param['tblr'][$key_part[1]]['purch_ret'] = 0;
        }
      }

      $partial =  false;  // true if partial received

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator1 = "/^[a-zA-Z0-9 _.-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // sku check for 11 length zero padded positive integer with prefix of PR-
      $validator8 = "/^[0-9]*$/";  // filter any number
      $validator9 = "/^[0-9]*.[0-9]+?$/"; // check for floats which has at least one floating point
      $validator10 = "/^-?[0-9]*.[0-9]+?$/"; // check floats with optional sign (-) negative

      // validate order id
      if (empty($param['purch']['purchid'])) {
        $data['frm_msg']['rtn_purch_msg'] = 'Purchase Id: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchid'])) {
        $data['frm_msg']['rtn_purch_msg'] = 'Purchase Id: Invalied format';
      }

      // validate location
      if (empty($param['purch']['purchlocat'])) {
        $data['frm_msg']['rtn_purch_msg'] = 'Location: Field is empty';
      } elseif (!preg_match($validator2, $param['purch']['purchlocat'])) {
        $data['frm_msg']['rtn_purch_msg'] = 'Location: Can only contain letters and numbers';
      }

      // validate date
      if (empty($param['purch']['purchdate'])) {
        $status['frm_msg']['purch_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['purch']['purchdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['purch_date'] = 'Date: Invalied date format';
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['rtn_purch_msg'] = 'Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['purch_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['purch_sku'], "PR-0");
          }

          // validate receive qty
          if (empty($tblrow_data['purch_rec'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rec. Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['purch_rec'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rec. Qty: Not a valid number";
          }

          // validate return qty
          if (empty($tblrow_data['purch_ret'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Ret. Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['purch_ret'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Ret. Qty: Not a valid number";
          } elseif ($tblrow_data['purch_ret'] > $tblrow_data['purch_rec']) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Ret. Qty: Cannot exceed Rec. Qty";
          }

          // validate unit rate
          if (empty($tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['purch_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Product Details: Amount: Not a valid number";
          }


          if (!empty($data['frm_msg'])) {
            break;
          }
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // // validate payment method
      // if (empty($param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['purch_paymeth'] = 'Payment Method: Field not selected';
      // } elseif (!($param['purch']['orderpmeth'] == 'Cash' || $param['purch']['purchpmeth'] == 'Credit' || $param['purch']['purchpmeth'] == 'Cheque')) {
      //   $data['frm_msg']['purch_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // elseif (!preg_match($validator2, $param['purch']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }

      // validate remarks
      if (empty($param['purch']['purchremark'])) {
        // $data['frm_msg']['purch_vendnote'] = 'Vendor Note: Field is empty';
      } elseif (!preg_match($validator1, $param['purch']['purchremark'])) {
        $data['frm_msg']['purch_vendnote'] = 'Remarks: Invalied characters found';
      }

      // validate sub-total
      if (empty($param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchsubtot'])) {
        $data['frm_msg']['purch_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate other charges
      if (empty($param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchaddcha'])) {
        $data['frm_msg']['purch_addcharg'] = 'Other Charges: Not a valied number';
      }

      // validate total amt
      if (empty($param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['purch']['purchtotal'])) {
        $data['frm_msg']['purch_totalamt'] = 'Total: Not a valied number';
      }

      // // validate paid amount
      // if (empty($param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Field is empty';
      // } elseif (!preg_match($validator9, $param['purch']['purchpaid'])) {
      //   $data['frm_msg']['purch_paidamt'] = 'Paid: Not a valied number';
      // }

      // // validate balance
      // if (empty($param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Field is empty';
      // } elseif (!preg_match($validator10, $param['purch']['purchbalnc'])) {
      //   $data['frm_msg']['purch_balance'] = 'Balance: Not a valied number';
      // }


      if (empty($data['frm_msg'])) {

        // if ($partial) {
        //   $param['purch']['purchstate'] = 'Received';
        // } else {
        $param['purch']['purchstate'] = 'Refuned';
        // }

        if ($this->userModel->return($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['rtn_purch_msg'] = 'Return successfully saved';
        } else {
          $data['frm_msg']['rtn_purch_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function getRowData()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $prodtId = trim($_POST['prodtSku']);
      $data = [
        'prodt' => ''
      ];
      // echo json_encode($prodtId);
      // return;

      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // check for 11 length zero padded positive integer with prefix of PR-

      // validate product sku
      if (empty($prodtId) || !preg_match($validator7, $prodtId)) {
        $data['prodt'] = false;
      } else {
        $prodtId = ltrim($prodtId, "PR-0");
        $data['prodt'] = $this->userModel->getProduct($prodtId);
        if ($data['prodt']) {
          $data['prodt']['prodt_sku'] = 'PR-' . str_pad($prodtId, 8, '0', STR_PAD_LEFT);
        }
      }
      echo json_encode($data);
    }
  }

  public function getPurchaseDataset()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $pageNum = trim($_POST['page_num']);
      $newSearch = trim($_POST['search_new']);

      $param = [
        'max_rows' => 10,
        'row_offset' => 0,
        'sort_col' => trim($_POST['sort_col']),
        'sort_type' => trim($_POST['sort_type']),
        'search_val' => trim($_POST['search_val']),
      ];

      $data = [
        'page_tot' => '',
        'tbl_data' => []
      ];

      $pattern1 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern2 = "/^[0|1]?$/";   // filter 0 or 1
      $pattern3 = "/^[a-z]{2,}$/";  // filter only lowercase lerters, atleast 2

      if (!preg_match($pattern1, $pageNum)) {
        $pageNum = 1;
      }

      if (!preg_match($pattern2, $newSearch)) {
        $newSearch = 1;
      }

      if (!preg_match($pattern1, $param['sort_col'])) {
        $param['sort_col'] = 1;
      } else {
        $param['sort_col'] = (int)$param['sort_col'];
      }

      if (!preg_match($pattern2, $param['sort_type'])) {
        $param['sort_type'] = 0;
      } else {
        $param['sort_type'] = (int)$param['sort_type'];
      }

      if (!preg_match($pattern3, $param['search_val'])) {
        $param['search_val'] = '';
      }

      $param['row_offset'] = ((int)$pageNum - 1) * $param['max_rows'];

      if ($newSearch) {
        $rowTot = $this->userModel->getRowCount($param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getRows($param);

      for ($i = 0; $i < count($data['tbl_data']); $i++) {
        $data['tbl_data'][$i]['purch_no'] = 'PO-' . str_pad($data['tbl_data'][$i]['purch_id'], 8, '0', STR_PAD_LEFT);
      }


      echo json_encode($data);
    }
  }
}
