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
    $this->view('purchases/porderlistV', $data);
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

    $this->view('purchases/porderaddV', $data);
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
      'pordr' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($orderId) || !preg_match($validator2, $orderId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['vendr'] = $this->userModel->getVendorList();
      $data['locat'] = $this->userModel->getLocationList();
      $data['pordr'] = $this->userModel->getOrder($orderId);
      $data['ordprd'] = $this->userModel->getOrderProduct($orderId);
      $data['prdcon'] = count($data['ordprd']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/pordereditV', $data);
    }
  }

  public function addreceive($orderId = null)
  {
    $orderId = trim($orderId);
    $data = [
      'title' => 'purchord_recev',
      'date' => date('Y-m-d'),
      'currency' => ' (Rs)',
      'taxp' => '10',
      'vendr' => [],
      'locat' => [],
      'pordr' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($orderId) || !preg_match($validator2, $orderId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['locat'] = $this->userModel->getLocationList();
      $data['pordr'] = $this->userModel->getOrder($orderId);
      $data['ordprd'] = $this->userModel->getOrderProduct($orderId);
      $data['vendr'] = $this->userModel->getVendor($data['pordr']['prch_vend_code']);
      $data['prdcon'] = count($data['ordprd']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/pordraddreceV', $data);
    }
  }

  public function show($pordrId = null)
  {
    $pordrId = trim($pordrId);
    $data = [
      'title' => 'order_view',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'pordr' => [],
      'ordprd' => [],
      'vendr' => [],
      'locat' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate order id
    if (empty($pordrId) || !preg_match($validator2, $pordrId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['pordr'] = $this->userModel->getOrder($pordrId);
      $data['ordprd'] = $this->userModel->getOrderProduct($pordrId);
      $data['vendr'] = $this->userModel->getVendor($data['pordr']['prch_vend_code']);
      $data['locat'] = $this->userModel->getLocation($data['pordr']['prch_loca_code']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      $data['pordr']['pordr_no'] = 'PO-' . str_pad($data['pordr']['prch_code'], 8, '0', STR_PAD_LEFT);

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('purchases/porderviewV', $data);
    }
  }

  public function print($type, $pordrId = null)
  {
    $pordrId = trim($pordrId);
    $data = [
      'title' => 'order_view',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'vendr' => [],
      'pordr' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate order id
    if (empty($pordrId) || !preg_match($validator2, $pordrId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['pordr'] = $this->userModel->getOrder($pordrId);
      $data['ordprd'] = $this->userModel->getOrderProduct($pordrId);
      $data['vendr'] = $this->userModel->getVendor($data['pordr']['prch_vend_code']);
      $data['locat'] = $this->userModel->getLocation($data['pordr']['prch_loca_code']);
      // $data['user']['issued'] = $this->userModel->getUser($data['pordr']['prch_issue_user_code']);
      // $data['user']['received'] = $this->userModel->getUser($data['pordr']['prch_recev_user_code']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
        $data['ordprd'][$i]['pcpd_ret_amount'] = ($data['ordprd'][$i]['pcpd_qty_return'] * $data['ordprd'][$i]['pcpd_unit_price']);
      }

      $data['pordr']['pordr_no'] = 'PO-' . str_pad($data['pordr']['prch_code'], 8, '0', STR_PAD_LEFT);

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

  public function addOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'pordr' => [
          'pordrdate' => trim($_POST['pordr_date']),
          'pordrvendr' => trim($_POST['pordr_vendr']),
          'pordrlocat' => trim($_POST['pordr_locat']),
          'pordrnote' => trim($_POST['pordr_vendnote']),
          // 'ordrpmeth' => trim($_POST['pordr_paymeth']),
          'pordrsubtot' => trim($_POST['pordr_subtotal']),
          'pordraddcha' => trim($_POST['pordr_addcharg']),
          'pordrtotal' => trim($_POST['pordr_totalamt']),
          'pordrpaid' => trim($_POST['pordr_paidamt']),
          'pordrbalnc' => trim($_POST['pordr_balance']),
          'pordrstate' => '',
          'pordruser' => (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '5')
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
      if (empty($param['pordr']['pordrdate'])) {
        $status['frm_msg']['pordr_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['pordr']['pordrdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['pordr_date'] = 'Date: Invalied date format';
        }
      }

      // validate vendor
      if (empty($param['pordr']['pordrvendr'])) {
        $data['frm_msg']['pordr_vendr'] = 'Vendor Name: Field is empty';
      } elseif (!preg_match($validator2, $param['pordr']['pordrvendr'])) {
        $data['frm_msg']['pordr_vendr'] = 'Vendor Name: Can only contain letters and numbers';
      }

      // validate location
      if (empty($param['pordr']['pordrlocat'])) {
        $data['frm_msg']['pordr_locat'] = 'Location: Field is empty';
      } elseif (!preg_match($validator2, $param['pordr']['pordrlocat'])) {
        $data['frm_msg']['pordr_locat'] = 'Location: Can only contain letters and numbers';
      }

      // validate vendor note
      if (empty($param['pordr']['pordrnote'])) {
        // $data['frm_msg']['pordr_vendnote'] = 'Vendor Note: Field is empty';
      } elseif (!preg_match($validator1, $param['pordr']['pordrnote'])) {
        $data['frm_msg']['pordr_vendnote'] = 'Vendor Note: Invalied characters found';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['add_pordr_msg'] = 'Order Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['pordr_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['pordr_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['pordr_sku'], "PR-0");
          }

          // validate qty
          if (empty($tblrow_data['pordr_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['pordr_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Not a valid number";
          }

          // validate unit rate
          if (empty($tblrow_data['pordr_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['pordr_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['pordr_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['pordr_amt'])) {
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
      // if (empty($param['pordr']['orderpmeth'])) {
      //   $data['frm_msg']['porder_paymeth'] = 'Payment Method: Field not selected';
      // } elseif (!($param['pordr']['orderpmeth'] == 'Cash' || $param['pordr']['orderpmeth'] == 'Credit' || $param['pordr']['orderpmeth'] == 'Cheque')) {
      //   $data['frm_msg']['porder_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // elseif (!preg_match($validator2, $param['pordr']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }

      // validate sub-total
      if (empty($param['pordr']['pordrsubtot'])) {
        $data['frm_msg']['pordr_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordrsubtot'])) {
        $data['frm_msg']['pordr_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate additinal charges
      if (empty($param['pordr']['pordraddcha'])) {
        $data['frm_msg']['pordr_addcharg'] = 'Other Charges: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordraddcha'])) {
        $data['frm_msg']['pordr_addcharg'] = 'Other Charges: Not a valied number';
      }

      // validate total amt
      if (empty($param['pordr']['pordrtotal'])) {
        $data['frm_msg']['pordr_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordrtotal'])) {
        $data['frm_msg']['pordr_totalamt'] = 'Total: Not a valied number';
      }

      // validate paid amount
      if (empty($param['pordr']['pordrpaid'])) {
        $data['frm_msg']['pordr_paidamt'] = 'Paid: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordrpaid'])) {
        $data['frm_msg']['pordr_paidamt'] = 'Paid: Not a valied number';
      }

      // validate balance
      if (empty($param['pordr']['pordrbalnc'])) {
        $data['frm_msg']['pordr_balance'] = 'Balance: Field is empty';
      } elseif (!preg_match($validator10, $param['pordr']['pordrbalnc'])) {
        $data['frm_msg']['pordr_balance'] = 'Balance: Not a valied number';
      }

      if (empty($data['frm_msg'])) {

        if ($param['pordr']['pordrpaid'] >= $param['pordr']['pordrtotal']) {
          $param['pordr']['pordrstate'] = 'paid';
        } else {
          $param['pordr']['pordrstate'] = 'pending';
        }

        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_pordr_msg'] = 'Order successfully added';
        } else {
          $data['frm_msg']['add_pordr_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function editOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'pordr' => [
          'pordrid' => trim($_POST['pordr_id']),
          'pordrdate' => trim($_POST['pordr_date']),
          'pordrvendr' => trim($_POST['pordr_vendr']),
          'pordrlocat' => trim($_POST['pordr_locat']),
          'pordrnote' => trim($_POST['pordr_vendnote']),
          // 'ordrpmeth' => trim($_POST['pordr_paymeth']),
          'pordrsubtot' => trim($_POST['pordr_subtotal']),
          'pordraddcha' => trim($_POST['pordr_addcharg']),
          'pordrtotal' => trim($_POST['pordr_totalamt']),
          'pordrpaid' => trim($_POST['pordr_paidamt']),
          'pordrbalnc' => trim($_POST['pordr_balance']),
          'pordrstate' => '',
          'pordruser' => (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : '5'),
        ],
        'tblr' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "tblr") === 0) {
          $key_part = explode('_', $key);
          $param['tblr'][$key_part[1]]['pordr_rec'] = 0;
          $param['tblr'][$key_part[1]]['pordr_ret'] = 0;
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
      if (empty($param['pordr']['pordrid'])) {
        $data['frm_msg']['edit_pordr_msg'] = 'Order Id: Field is empty';
      } elseif (!preg_match($validator2, $param['pordr']['pordrid'])) {
        $data['frm_msg']['edit_pordr_msg'] = 'Order Id: Invalied format';
      }

      // validate date
      if (empty($param['pordr']['pordrdate'])) {
        $status['frm_msg']['pordr_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['pordr']['pordrdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['pordr_date'] = 'Date: Invalied date format';
        }
      }

      // validate location
      if (empty($param['pordr']['pordrlocat'])) {
        $data['frm_msg']['pordr_locat'] = 'Location: Field is empty';
      } elseif (!preg_match($validator2, $param['pordr']['pordrlocat'])) {
        $data['frm_msg']['pordr_locat'] = 'Location: Can only contain letters and numbers';
      }

      // validate vendor
      if (empty($param['pordr']['pordrvendr'])) {
        $data['frm_msg']['pordr_vendr'] = 'Vendor Name: Field is empty';
      } elseif (!preg_match($validator2, $param['pordr']['pordrvendr'])) {
        $data['frm_msg']['pordr_vendr'] = 'Vendor Name: Can only contain letters and numbers';
      }

      // validate vendor note
      if (empty($param['pordr']['pordrnote'])) {
        // $data['frm_msg']['pordr_vendnote'] = 'Vendor Note: Field is empty';
      } elseif (!preg_match($validator1, $param['pordr']['pordrnote'])) {
        $data['frm_msg']['pordr_vendnote'] = 'Vendor Note: Invalied characters found';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['edit_pordr_msg'] = 'Order Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['pordr_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['pordr_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['pordr_sku'], "PR-0");
          }

          // validate qty
          if (empty($tblrow_data['pordr_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['pordr_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Not a valid number";
          }

          // validate unit rate
          if (empty($tblrow_data['pordr_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['pordr_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['pordr_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['pordr_amt'])) {
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
      // if (empty($param['pordr']['orderpmeth'])) {
      //   $data['frm_msg']['pordr_paymeth'] = 'Payment Method: Field not selected';
      // } elseif (!($param['pordr']['orderpmeth'] == 'Cash' || $param['pordr']['pordrpmeth'] == 'Credit' || $param['pordr']['pordrpmeth'] == 'Cheque')) {
      //   $data['frm_msg']['pordr_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // elseif (!preg_match($validator2, $param['pordr']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }

      // validate sub-total
      if (empty($param['pordr']['pordrsubtot'])) {
        $data['frm_msg']['pordr_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordrsubtot'])) {
        $data['frm_msg']['pordr_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate other charges
      if (empty($param['pordr']['pordraddcha'])) {
        $data['frm_msg']['pordr_addcharg'] = 'Other Charges: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordraddcha'])) {
        $data['frm_msg']['pordr_addcharg'] = 'Other Charges: Not a valied number';
      }

      // validate total amt
      if (empty($param['pordr']['pordrtotal'])) {
        $data['frm_msg']['pordr_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordrtotal'])) {
        $data['frm_msg']['pordr_totalamt'] = 'Total: Not a valied number';
      }

      // validate paid amount
      if (empty($param['pordr']['pordrpaid'])) {
        $data['frm_msg']['pordr_paidamt'] = 'Paid: Field is empty';
      } elseif (!preg_match($validator9, $param['pordr']['pordrpaid'])) {
        $data['frm_msg']['pordr_paidamt'] = 'Paid: Not a valied number';
      }

      // validate balance
      if (empty($param['pordr']['pordrbalnc'])) {
        $data['frm_msg']['pordr_balance'] = 'Balance: Field is empty';
      } elseif (!preg_match($validator10, $param['pordr']['pordrbalnc'])) {
        $data['frm_msg']['pordr_balance'] = 'Balance: Not a valied number';
      }


      if (empty($data['frm_msg'])) {

        if ($param['pordr']['pordrpaid'] >= $param['pordr']['pordrtotal']) {
          $param['pordr']['pordrstate'] = 'paid';
        } else {
          $param['pordr']['pordrstate'] = 'pending';
        }

        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_pordr_msg'] = 'Order successfully updated';
        } else {
          $data['frm_msg']['edit_pordr_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function deleteOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'porderid' => trim($_POST['delt_porder_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate order id
      if (empty($param['porderid'])) {
        $data['frm_msg']['delt_porder_msg'] = 'Order Id: Field is empty';
      } elseif (!preg_match($validator2, $param['porderid'])) {
        $data['frm_msg']['delt_porder_msg'] = 'Order Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_porder_msg'] = 'Order successfully deleted';
        } else {
          $data['frm_msg']['delt_porder_msg'] = 'Someting went wrong';
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

  public function getPorderDataset()
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
