<?php

class Orders extends Controller
{
  public function __construct()
  {
    // if (!isLoggedIn()) {
    //   redirect('auth/index');
    // }
    // if (!isEnabled('ordr')) {
    //   exit("Permission Not Granted!");
    //   return;
    // }
    $this->userModel = $this->model('OrderM');
  }

  public function index()
  {
    $data = [
      'title' => 'order_list'
    ];
    $this->view('orders/orderlistV', $data);
  }

  public function add()
  {
    $data = [
      'title' => 'order_add',
      'date' => date('Y-m-d'),
      'currency' => ' (Rs)',
      'taxp' => '10'
    ];

    $this->view('orders/orderaddV', $data);
  }

  public function edit($orderId = null)
  {
    $orderId = trim($orderId);
    $data = [
      'title' => 'order_edit',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'order' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($orderId) || !preg_match($validator2, $orderId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['order'] = $this->userModel->getOrder($orderId);
      $data['ordprd'] = $this->userModel->getOrderProduct($orderId);
      $data['prdcon'] = count($data['ordprd']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('orders/ordereditV', $data);
    }
  }

  public function show($orderId = null)
  {
    $orderId = trim($orderId);
    $data = [
      'title' => 'order_view',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'order' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($orderId) || !preg_match($validator2, $orderId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['order'] = $this->userModel->getOrder($orderId);
      $data['ordprd'] = $this->userModel->getOrderProduct($orderId);
      // $data['prdcon'] = count($data['ordprd']);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      $data['order']['order_num'] = 'SO-' . str_pad($data['order']['ordr_code'], 8, '0', STR_PAD_LEFT);
      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('orders/orderviewV', $data);
    }
  }

  public function print($type, $orderId = null)
  {
    $orderId = trim($orderId);
    $data = [
      'title' => 'order_print',
      'currency' => ' (Rs)',
      'taxp' => '10',
      'order' => [],
      'ordprd' => []
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($orderId) || !preg_match($validator2, $orderId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['order'] = $this->userModel->getOrder($orderId);
      $data['ordprd'] = $this->userModel->getOrderProduct($orderId);
      $data['user'] = $this->userModel->getOrderUser($orderId);

      for ($i = 0; $i < count($data['ordprd']); $i++) {
        $data['ordprd'][$i]['prodt_sku'] = 'PR-' . str_pad($data['ordprd'][$i]['prod_code'], 8, '0', STR_PAD_LEFT);
      }

      $data['order']['order_incno'] = 'SO-' . str_pad($data['order']['ordr_code'], 8, '0', STR_PAD_LEFT);
      $data['order']['ordr_total_spell'] = $this->spellCurrency($data['order']['ordr_total']);

      // $fmt = new NumberFormatter('en_LK', NumberFormatter::CURRENCY);
      // $data['a1'] = $fmt->format($data['order']['ordr_total']);
      // $data['a2'] = $fmt->formatCurrency($data['order']['ordr_total'], "LKR");

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      if ($type == 'in') {
        $this->view('orders/orderprintinV', $data);
      } elseif ($type == 'rc') {
        $this->view('orders/orderprintrcV', $data);
      } else {
      }
    }
  }

  public function addOrder()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'order' => [
          'orderdate' => trim($_POST['order_date']),
          'ordercname' => trim($_POST['order_cusname']),
          'ordercphon' => trim($_POST['order_cusphone']),
          'ordercaddr' => trim($_POST['order_cusaddress']),
          'orderpmeth' => trim($_POST['order_paymeth']),
          'ordertaxrt' => trim($_POST['order_taxrate']),
          'ordersubtot' => trim($_POST['order_subtotal']),
          'ordertaxes' => trim($_POST['order_taxesall']),
          'ordertotal' => trim($_POST['order_totalamt']),
          'orderpaid' => trim($_POST['order_paidamt']),
          'orderbalnc' => trim($_POST['order_balance']),
          'orderstate' => '',
          'ordersaler' => '2'   // $_SESSION['user_id']
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
      // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator1 = "/^[a-zA-Z0-9 _.-]*$/";
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      // filter local telephone no.
      $validator3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";
      $validator5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address
      // sku check for 11 length zero padded positive integer with prefix of PR-
      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/";
      $validator8 = "/^[0-9]*$/";  // filter any number
      // check for floats which has at least one floating point
      $validator9 = "/^[0-9]*.[0-9]+?$/";
      // check floats which has at least one floating point with optional sign (-) negative
      $validator10 = "/^-?[0-9]*.[0-9]+?$/";

      // validate date
      if (empty($param['order']['orderdate'])) {
        $status['frm_msg']['order_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['order']['orderdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['order_date'] = 'Date: Invalied date format';
        }
      }

      // validate customer name
      if (empty($param['order']['ordercname'])) {
        $data['frm_msg']['order_cusname'] = 'Customer Name: Field is empty';
      } elseif (!preg_match($validator1, $param['order']['ordercname'])) {
        $data['frm_msg']['order_cusname'] = 'Customer Name: Can only contain letters and numbers';
      }

      // validate customer phone
      if (empty($param['order']['ordercphon'])) {
        $data['frm_msg']['order_cusphone'] = 'Phone: Field is empty';
      } elseif (!preg_match($validator3, $param['order']['ordercphon'])) {
        $data['frm_msg']['order_cusphone'] = 'Phone: Can only contain letters and numbers';
      }

      // validate customer address
      if (empty($param['order']['ordercaddr'])) {
        $data['frm_msg']['order_cusaddress'] = 'Billing Address: Field is empty';
      } elseif (!preg_match($validator5, $param['order']['ordercaddr'])) {
        $data['frm_msg']['order_cusaddress'] = 'Billing Address: Invalied characters found';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['add_order_msg'] = 'Order Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['order_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['order_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['order_sku'], "PR-0");
          }

          // validate qty
          if (empty($tblrow_data['order_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['order_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Not a valid number";
          }

          // validate qty
          if (empty($tblrow_data['order_dis'])) {
            // $data['frm_msg']['tblr_'.$tblrow_id] = "Order Product Details: Disc: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['order_dis'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Disc: Not a valid number";
          }

          // validate unit rate
          if (empty($tblrow_data['order_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['order_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['order_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['order_amt'])) {
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

      // validate payment method
      if (empty($param['order']['orderpmeth'])) {
        $data['frm_msg']['order_paymeth'] = 'Payment Method: Field not selected';
      } elseif (!($param['order']['orderpmeth'] == 'Cash' || $param['order']['orderpmeth'] == 'Credit' || $param['order']['orderpmeth'] == 'Cheque')) {
        $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      }
      // elseif (!preg_match($validator2, $param['order']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // validate tax rate
      // if (empty($param['order']['ordertaxrt'])) {
      //   $data['frm_msg']['order_taxrate'] = 'Tax: Field is empty';
      // } 
      if (!preg_match($validator8, $param['order']['ordertaxrt'])) {
        $data['frm_msg']['order_taxrate'] = 'Tax: Not a valied number';
      }

      // validate sub-total
      if (empty($param['order']['ordersubtot'])) {
        $data['frm_msg']['order_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['ordersubtot'])) {
        $data['frm_msg']['order_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate total taxes
      if (empty($param['order']['ordertaxes'])) {
        $data['frm_msg']['order_taxesall'] = 'Total Tax: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['ordertaxes'])) {
        $data['frm_msg']['order_taxesall'] = 'Total Tax: Not a valied number';
      }

      // validate total amt
      if (empty($param['order']['ordertotal'])) {
        $data['frm_msg']['order_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['ordertotal'])) {
        $data['frm_msg']['order_totalamt'] = 'Total: Not a valied number';
      }

      // validate paid amount
      if (empty($param['order']['orderpaid'])) {
        $data['frm_msg']['order_paidamt'] = 'Paid: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['orderpaid'])) {
        $data['frm_msg']['order_paidamt'] = 'Paid: Not a valied number';
      }

      // validate balance
      if (empty($param['order']['orderbalnc'])) {
        $data['frm_msg']['order_balance'] = 'Balance: Field is empty';
      } elseif (!preg_match($validator10, $param['order']['orderbalnc'])) {
        $data['frm_msg']['order_balance'] = 'Balance: Not a valied number';
      }

      if (empty($data['frm_msg'])) {

        if ($param['order']['orderpaid'] >= $param['order']['ordertotal']) {
          $param['order']['orderstate'] = 'completed';
        } else {
          $param['order']['orderstate'] = 'pending';
        }

        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_order_msg'] = 'Order successfully added';
        } else {
          $data['frm_msg']['add_order_msg'] = 'Someting went wrong';
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
        'order' => [
          'orderid' => trim($_POST['order_id']),
          'orderdate' => trim($_POST['order_date']),
          'ordercname' => trim($_POST['order_cusname']),
          'ordercphon' => trim($_POST['order_cusphone']),
          'ordercaddr' => trim($_POST['order_cusaddress']),
          'orderpmeth' => trim($_POST['order_paymeth']),
          'ordertaxrt' => trim($_POST['order_taxrate']),
          'ordersubtot' => trim($_POST['order_subtotal']),
          'ordertaxes' => trim($_POST['order_taxesall']),
          'ordertotal' => trim($_POST['order_totalamt']),
          'orderpaid' => trim($_POST['order_paidamt']),
          'orderbalnc' => trim($_POST['order_balance']),
          'orderstate' => '',
          'ordersaler' => '2'   // $_SESSION['user_id']
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
      $validator3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";    // filter local telephone no.
      $validator5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address
      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // sku check for 12 length zero padded positive integer with prefix of PRD-
      $validator8 = "/^[0-9]*$/";  // filter any number
      $validator9 = "/^[0-9]*.[0-9]+?$/"; // check for floats which has at least one floating point
      $validator10 = "/^-?[0-9]*.[0-9]+?$/"; // check floats with optional sign (-) negative

      // validate order id
      if (empty($param['order']['orderid'])) {
        $data['frm_msg']['edit_order_msg'] = 'Order Id: Field is empty';
      } elseif (!preg_match($validator2, $param['order']['orderid'])) {
        $data['frm_msg']['edit_order_msg'] = 'Order Id: Invalied format';
      }
      // validate date
      if (empty($param['order']['orderdate'])) {
        $status['frm_msg']['order_date'] = 'Date: Field is empty';
      } else {
        DateTime::createFromFormat('Y-m-d', $param['order']['orderdate']);
        if (array_sum(DateTime::getLastErrors())) {
          $status['frm_msg']['order_date'] = 'Date: Invalied date format';
        }
      }

      // validate customer name
      if (empty($param['order']['ordercname'])) {
        $data['frm_msg']['order_cusname'] = 'Customer Name: Field is empty';
      } elseif (!preg_match($validator1, $param['order']['ordercname'])) {
        $data['frm_msg']['order_cusname'] = 'Customer Name: Can only contain letters and numbers';
      }

      // validate customer phone
      if (empty($param['order']['ordercphon'])) {
        // $data['frm_msg']['order_cusphone'] = 'Phone: Field is empty';
      } elseif (!preg_match($validator3, $param['order']['ordercphon'])) {
        $data['frm_msg']['order_cusphone'] = 'Phone: Can only contain letters and numbers';
      }

      // validate customer address
      if (empty($param['order']['ordercaddr'])) {
        $data['frm_msg']['order_cusaddress'] = 'Billing Address: Field is empty';
      } elseif (!preg_match($validator5, $param['order']['ordercaddr'])) {
        $data['frm_msg']['order_cusaddress'] = 'Billing Address: Invalied characters found';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate order product details
      if (empty($param['tblr'])) {
        $data['frm_msg']['add_order_msg'] = 'Order Product Details: No valid fields found';
      } else {
        foreach ($param['tblr'] as $tblrow_id => $tblrow_data) {

          // validate sku
          if (empty($tblrow_data['order_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Field is empty";
          } elseif (!preg_match($validator7, $tblrow_data['order_sku'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: SKU: Invalid format";
          } else {
            $param['tblr'][$tblrow_id]['prodtid'] = ltrim($tblrow_data['order_sku'], "PR-0");
          }

          // validate qty
          if (empty($tblrow_data['order_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['order_qty'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Qty: Not a valid number";
          }

          // validate qty
          if (empty($tblrow_data['order_dis'])) {
            // $data['frm_msg']['tblr_'.$tblrow_id] = "Order Product Details: Disc: Field is empty";
          } elseif (!preg_match($validator2, $tblrow_data['order_dis'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Disc: Not a valid number";
          }

          // validate unit rate
          if (empty($tblrow_data['order_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['order_rat'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Rate: Not a valid number";
          }

          // validate amount
          if (empty($tblrow_data['order_amt'])) {
            $data['frm_msg']['tblr_' . $tblrow_id] = "Order Product Details: Amount: Field is empty";
          } elseif (!preg_match($validator9, $tblrow_data['order_amt'])) {
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

      // validate payment method
      if (empty($param['order']['orderpmeth'])) {
        $data['frm_msg']['order_paymeth'] = 'Payment Method: Field not selected';
      } elseif (!($param['order']['orderpmeth'] == 'Cash' || $param['order']['orderpmeth'] == 'Credit' || $param['order']['orderpmeth'] == 'Cheque')) {
        $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      }
      // elseif (!preg_match($validator2, $param['order']['orderpmeth'])) {
      //   $data['frm_msg']['order_paymeth'] = 'Payment Method: Not a valied method';
      // }
      // validate tax rate

      if (!preg_match($validator8, $param['order']['ordertaxrt'])) {
        $data['frm_msg']['order_taxrate'] = 'Tax: Not a valied number';
      }

      // validate sub-total
      if (empty($param['order']['ordersubtot'])) {
        $data['frm_msg']['order_subtotal'] = 'Sub Total: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['ordersubtot'])) {
        $data['frm_msg']['order_subtotal'] = 'Sub Total: Not a valied number';
      }

      // validate total taxes
      if (empty($param['order']['ordertaxes'])) {
        $data['frm_msg']['order_taxesall'] = 'Total Tax: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['ordertaxes'])) {
        $data['frm_msg']['order_taxesall'] = 'Total Tax: Not a valied number';
      }

      // validate total amt
      if (empty($param['order']['ordertotal'])) {
        $data['frm_msg']['order_totalamt'] = 'Total: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['ordertotal'])) {
        $data['frm_msg']['order_totalamt'] = 'Total: Not a valied number';
      }

      // validate paid amount
      if (empty($param['order']['orderpaid'])) {
        $data['frm_msg']['order_paidamt'] = 'Paid: Field is empty';
      } elseif (!preg_match($validator9, $param['order']['orderpaid'])) {
        $data['frm_msg']['order_paidamt'] = 'Paid: Not a valied number';
      }

      // validate balance
      if (empty($param['order']['orderbalnc'])) {
        $data['frm_msg']['order_balance'] = 'Balance: Field is empty';
      } elseif (!preg_match($validator10, $param['order']['orderbalnc'])) {
        $data['frm_msg']['order_balance'] = 'Balance: Not a valied number';
      }

      if (empty($data['frm_msg'])) {

        if ($param['order']['orderpaid'] >= $param['order']['ordertotal']) {
          $param['order']['orderstate'] = 'completed';
        } else {
          $param['order']['orderstate'] = 'pending';
        }

        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_order_msg'] = 'Order successfully added';
        } else {
          $data['frm_msg']['edit_order_msg'] = 'Someting went wrong';
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
        'orderid' => trim($_POST['delt_order_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate order id
      if (empty($param['orderid'])) {
        $data['frm_msg']['delt_order_msg'] = 'Order Id: Field is empty';
      } elseif (!preg_match($validator2, $param['orderid'])) {
        $data['frm_msg']['delt_order_msg'] = 'Order Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_order_msg'] = 'Order successfully deleted';
        } else {
          $data['frm_msg']['delt_order_msg'] = 'Someting went wrong';
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

      $validator7 = "/^(?=PR-[0-9]*[1-9][0-9]*).{11}$/"; // check for 12 length zero padded positive integer with prefix of PRD-

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

  public function getOrderDataset()
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
        $data['tbl_data'][$i]['order_no'] = 'SO-' . str_pad($data['tbl_data'][$i]['order_id'], 8, '0', STR_PAD_LEFT);
      }


      echo json_encode($data);
    }
  }

  public function spellCurrency($number)
  {
    $num = explode('.', $number);
    // NumberFormatter class require to enable "intl" extention of php.ini
    $numFormat = new NumberFormatter("en_LK", NumberFormatter::SPELLOUT);
    return "{$numFormat->format($num[0])} rupees and {$numFormat->format($num[1])} cents";
  }

  public function testdb()
  {
    echo '<pre>';

    // var_dump($this->userModel->getRowCount(''));

    // $param = [
    //   'max_rows' => 5,
    //   'row_offset' => 0,
    //   'sort_col' => 1,
    //   'sort_type' => 0,
    //   'search_val' => '',
    // ];

    // var_dump($this->userModel->getRows($param));

    echo '</pre>';
  }
}
