<?php

class Products extends Controller
{
  public function __construct()
  {
    if (!isEnabled('prod')) {
      exit("Permission Not Granted!");
      return;
    }
    $this->userModel = $this->model('ProductM');
  }

  public function index()
  {
    $data = [
      'title' => 'product_list'
    ];
    $this->view('products/productlistV', $data);
  }

  public function add()
  {
    $data = [
      'title' => 'product_add'
    ];
    $data['categ'] = $this->userModel->getCategoryList();
    $data['brand'] = $this->userModel->getBrandList();
    $data['locat'] = $this->userModel->getLocationList();
    $data['vendr'] = $this->userModel->getVendorList();
    $data['attrb'] = $this->userModel->getAttributeList();
    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';
    $this->view('products/productaddV', $data);
  }

  public function edit($prodtId = null)
  {
    $prodtId = trim($prodtId);

    $data = [
      'title' => 'product_edit'
      // 'categ' => [],
      // 'brand' => [],
      // 'locat' => [],
      // 'vendr' => [],
      // 'attrb' => [],
      // 'prodt' => [],
      // 'prdstk' => [],
      // 'prdatv' => [],
      // 'prdimg' => []
    ];

    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($prodtId) || !preg_match($validator2, $prodtId)) {
      exit('Error! : No valied Product Id found. ');
    } else {
      $data['categ'] = $this->userModel->getCategoryList();
      $data['brand'] = $this->userModel->getBrandList();
      $data['locat'] = $this->userModel->getLocationList();
      $data['vendr'] = $this->userModel->getVendorList();
      $data['attrb'] = $this->userModel->getAttributeList();
      // $data['attrb'] = $this->userModel->getProdtAttrb($prodtId);

      $data['prodt'] = $this->userModel->getProduct($prodtId);
      $data['prdimg'] = $this->userModel->getProdtImage($prodtId);
      $data['prdstk'] = $this->userModel->getProdtStock($prodtId);
      $data['prdatv'] = $this->userModel->getProdtAtval($prodtId);

      //prepare $data['atval'] for ui easyness
      for ($i = 0; $i < count($data['prdatv']); $i++) {
        $data['prdatv'][$i]['atval_list'] = $this->userModel->getProdtAtvalAll($data['prdatv'][$i]['attp_code']);
      }

      //prepare $data['attrb'] for ui easyness
      for ($i = 0; $i < count($data['attrb']); $i++) {
        $data['attrb'][$i]['selected'] = false;
        for ($j = 0; $j < count($data['prdatv']); $j++) {
          if ($data['prdatv'][$j]['attp_code'] == $data['attrb'][$i]['attp_code']) {
            $data['attrb'][$i]['selected'] = true;
            break;
          }
        }
      }

      //prepare $data['locat'] for ui easyness
      for ($i = 0; $i < count($data['locat']); $i++) {
        $data['locat'][$i]['selected'] = false;
        for ($j = 0; $j < count($data['prdstk']); $j++) {
          if ($data['prdstk'][$j]['stok_loca_code'] == $data['locat'][$i]['loca_code']) {
            $data['locat'][$i]['selected'] = true;
            break;
          }
        }
      }
      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';
      $this->view('products/producteditV', $data);
    }
  }

  public function show($prodtId = null)
  {
    require_once(APPROOT . '/extensions/barcode/vendor/autoload.php');

    $prodtId = trim($prodtId);

    $data = [
      'title' => 'product_view'
    ];

    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate product id
    if (empty($prodtId) || !preg_match($validator2, $prodtId)) {
      exit('Error! : No valied Product Id found. ');
    } else {

      $data['prodt'] = $this->userModel->getProduct($prodtId);
      $data['prodt']['prod_sku'] = 'PR-' . str_pad($prodtId, 8, '0', STR_PAD_LEFT);

      $data['categ'] = $this->userModel->getCategory($data['prodt']['prod_catg_code']);
      $data['brand'] = $this->userModel->getBrand($data['prodt']['prod_brnd_code']);
      $data['vendr'] = $this->userModel->getVendor($data['prodt']['prod_vend_code']);
      $data['stock'] = $this->userModel->getProdtStock($prodtId);
      $data['attrb'] = $this->userModel->getProdtAtval($prodtId);
      $data['image'] = $this->userModel->getProdtImage($prodtId);


      // instantiate the barcode class
      $barcode = new \Com\Tecnick\Barcode\Barcode();
      $bobj = $barcode->getBarcodeObj(
        'C128A', //'C128A' 'QRCODE,H'// barcode type and additional comma-separated parameters
        $data['prodt']['prod_sku'],     // data string to encode
        -2,                             // bar width (use absolute or negative value as multiplication factor)
        -40,                            // bar height (use absolute or negative value as multiplication factor)
        'black',                        // foreground color
        array(0, 0, 0, 0)               // padding (use absolute or negative values as multiplication factors)
      );
      $data['bcode'] = $bobj->getSvgCode();
      // echo '<pre>';
      // var_dump($data);
      // var_dump($bobj->getSvgCode());
      // echo '</pre>';

      $this->view('products/productviewV', $data);
    }
  }

  public function getAttributVal($attrib_id = null)
  {
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
    $attrib_id = trim($attrib_id);
    // validate attribute id
    if (empty($attrib_id) || !preg_match($validator2, $attrib_id)) {
      exit('Error! : No valied Attribute Id found.');
    } else {
      $data = ['atval' => ''];
      $data['atval'] = $this->userModel->getAttrbValues($attrib_id);
      echo json_encode($data);
    }
  }

  public function addProduct()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // echo json_encode($_POST);
      // echo json_encode($_FILES);
      // return;

      $param = [
        'prodt' => [
          'prodtname' => trim($_POST['prodt_name']),
          'prodtbrand' => trim($_POST['prodt_brand']),
          'prodtcategry' => trim($_POST['prodt_category']),
          'prodtvendor' => trim($_POST['prodt_vendor']),
          'prodtreodlvl' => trim($_POST['prodt_rorderlvl']),
          'prodtreodqty' => trim($_POST['prodt_rorderqty']),
          'prodtrtlprce' => trim($_POST['prodt_rtlprice']),
          'prodtwslprce' => trim($_POST['prodt_wslprice']),
          'prodtdescrip' => trim($_POST['prodt_descrip']),
          'prodtstatus' => trim($_POST['prodt_state']),
          'prodtvndptno' => trim($_POST['prodt_vendprtno']),
          'prodtvndprce' => trim($_POST['prodt_vendprice'])
        ],
        'stock' => $this->findKeyVal($_POST, 'dynm_locat_stock'),   // find given key from POST then decode location id and stock quantity
        'attrb' => $this->findKeyVal($_POST, 'dynm_attrb_atval'),  // find given key from POST then decode attribute id and attribute value
        'image' => []
      ];

      /*    $param2 = [
        'prodtlocat' => '',
        'prodtstock' => array_map('trim', array_filter($_POST, function ($key) {
          return strpos($key, 'dynm_locat_stock_') === 0;
        }, ARRAY_FILTER_USE_KEY))
      ];

      foreach ($_POST as $key => $value) {
        if (strpos($key, 'dynm_locat_stock') === 0) {
          $param['stock']['prodtlocat'][] = substr(strrchr($key, '_'), 1);
          $param['stock']['prodtstock'][] = trim($value);
        }
      }
     */
      // echo json_encode($param);
      // return;

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $validator0 = ['jpeg', 'png', 'gif'];  // filter image types
      $validator1 = "/^[a-zA-Z0-9 _-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      // $validator2 = "/^[1-9]\d*$/";   // filter any number except 0
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address

      // validate product name
      if (empty($param['prodt']['prodtname'])) {
        $data['frm_msg']['prodt_name'] = 'Product Name: Field is empty';
      } elseif (!preg_match($validator1, $param['prodt']['prodtname'])) {
        $data['frm_msg']['prodt_name'] = 'Product Name: Can only contain letters and numbers';
      }

      // validate brand
      if (empty($param['prodt']['prodtbrand'])) {
        $data['frm_msg']['prodt_brand'] = 'Brand: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtbrand'])) {
        $data['frm_msg']['prodt_brand'] = 'Brand: Invalied format';
      }

      // validate category
      if (empty($param['prodt']['prodtcategry'])) {
        $data['frm_msg']['prodt_category'] = 'Category: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtcategry'])) {
        $data['frm_msg']['prodt_category'] = 'Category: Invalied format';
      }

      // validate image
      $fileData = validateFiles('prodt_image', 3, $validator0);
      if (empty($fileData['error'])) {
        $data['frm_msg']['prodt_image'] = 'Image: File not found';
      } elseif ($fileData['error'] != 'NoError') {
        $data['frm_msg']['prodt_image'] = 'Image: ' . $fileData['error'];
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate reorder level
      if (empty($param['prodt']['prodtreodlvl'])) {
        $data['frm_msg']['prodt_rorderlvl'] = 'Reorder Level: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtreodlvl'])) {
        $data['frm_msg']['prodt_rorderlvl'] = 'Reorder Level: Not a valied number';
      }

      // validate reorder quantity
      if (empty($param['prodt']['prodtreodqty'])) {
        $data['frm_msg']['prodt_rorderqty'] = 'Reorder Quantity: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtreodqty'])) {
        $data['frm_msg']['prodt_rorderqty'] = 'Reorder Quantity: Not a valied number';
      }

      // validate stocks
      if (empty($param['stock'])) {
        $data['frm_msg']['prodt_totstock'] = 'Total Stock: No fields';
      } else {
        foreach ($param['stock'] as $elem_id => $stock_data) {
          if (!preg_match($validator2, $stock_data['locat'])) {                       // check location id which is embeded in POST->key
            $data['frm_msg'][$elem_id] = 'Total Stock: Unknown format error';
          } elseif (empty($stock_data['stock'])) {                                    // check quantity 
            $data['frm_msg'][$elem_id] = 'Stock Quantity: Field is empty';
          } elseif (!preg_match($validator2, $stock_data['stock'])) {
            $data['frm_msg'][$elem_id] = 'Stock Quantity: Not a valied number';
          }
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate retail price
      if (empty($param['prodt']['prodtrtlprce'])) {
        $data['frm_msg']['prodt_rtlprice'] = 'Retail Price: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtrtlprce'])) {
        $data['frm_msg']['prodt_rtlprice'] = 'Retail Price: Not a valied number';
      }

      // validate wholesale price
      if (empty($param['prodt']['prodtwslprce'])) {
        $data['frm_msg']['prodt_wslprice'] = 'Wholesale Price: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtwslprce'])) {
        $data['frm_msg']['prodt_wslprice'] = 'Wholesale Price: Not a valied number';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate vendor
      if (empty($param['prodt']['prodtvendor'])) {
        $data['frm_msg']['prodt_vendor'] = 'Vendor Name: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtvendor'])) {
        $data['frm_msg']['prodt_vendor'] = 'Vendor Name: Invalied format';
      }

      // validate vendor part no
      if (empty($param['prodt']['prodtvndptno'])) {
        $data['frm_msg']['prodt_vendprtno'] = 'Vendor\'s Part No: Field is empty';
      } elseif (!preg_match($validator1, $param['prodt']['prodtvndptno'])) {
        $data['frm_msg']['prodt_vendprtno'] = 'Vendor\'s Part No: Can only contain letters and numbers';
      }

      // validate vendor price
      if (empty($param['prodt']['prodtvndprce'])) {
        $data['frm_msg']['prodt_vendprice'] = 'Vendor\'s Price: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtvndprce'])) {
        $data['frm_msg']['prodt_vendprice'] = 'Vendor\'s Price: Not a valied number';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate attributes
      if (empty($param['attrb'])) {
        // $data['frm_msg']['prodt_attributes'] = 'Attributes: No fields';
      } else {
        foreach ($param['attrb'] as $elem_id => $attrb_data) {
          if (!preg_match($validator2, $attrb_data['attrb'])) {
            $data['frm_msg'][$elem_id] = 'Attributes: Unknown format error';
          } elseif (empty($attrb_data['atval'])) {
            $data['frm_msg'][$elem_id] = 'Attribute Value: Field is empty';
          } elseif (!preg_match($validator2, $attrb_data['atval'])) {
            $data['frm_msg'][$elem_id] = 'Attribute Value: Invalied format';
          }
        }

        /*  foreach ($param['attrb']['prodtattrb'] as $val) {
          if (!preg_match($validator2, $val)) {
            $data['frm_msg']['prodt_attributes'] = 'Attributes: Unknown format error';
          }
        }
        foreach ($param['attrb']['prodtatval'] as $val) {
          if (empty($val)) {
            $data['frm_msg']['prodt_attributes'] = 'Attributes: Field is not selected';
          } elseif (!preg_match($validator2, $val)) {
            $data['frm_msg']['prodt_attributes'] = 'Attributes: Not a valied number';
          }
        }*/
      }

      // validate description
      if (empty($param['prodt']['prodtdescrip'])) {
        $data['frm_msg']['prodt_descrip'] = 'Product Description: Field is empty';
      } elseif (!preg_match($validator5, $param['prodt']['prodtdescrip'])) {
        $data['frm_msg']['prodt_descrip'] = 'Product Description: Can only contain letters, numbers and special char*';
      }

      // validate status
      if (empty($param['prodt']['prodtstatus'])) {
        $data['frm_msg']['prodt_state'] = 'Status: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtstatus'])) {
        $data['frm_msg']['prodt_state'] = 'Status: Not a valied number';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      if (empty($data['frm_msg'])) {

        for ($i = 0; $i < count($fileData['path']); $i++) {
          if (move_uploaded_file($fileData['path'][$i], 'img/uploads/product/' . $fileData['prodt_image'][$i])) {
            $param['image']['prodt_image_' . $i]['prodtimage'] = $fileData['prodt_image'][$i];
          } else {
            $data['frm_msg']['add_prodt_msg'] = 'Image: File not saved';
          }
        }

        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_prodt_msg'] = 'Product successfully added';
        } else {
          $data['frm_msg']['add_prodt_msg'] = 'Someting went wrong';
        }
        echo json_encode($data);
      }
    }
  }

  public function editProduct()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // echo json_encode($_POST);
      // echo json_encode($_FILES);
      // return;

      $param = [
        'prodt' => [
          'prodtid' => trim($_POST['prodt_id']),
          'prodtname' => trim($_POST['prodt_name']),
          'prodtbrand' => trim($_POST['prodt_brand']),
          'prodtcategry' => trim($_POST['prodt_category']),
          'prodtvendor' => trim($_POST['prodt_vendor']),
          'prodtreodlvl' => trim($_POST['prodt_rorderlvl']),
          'prodtreodqty' => trim($_POST['prodt_rorderqty']),
          'prodtrtlprce' => trim($_POST['prodt_rtlprice']),
          'prodtwslprce' => trim($_POST['prodt_wslprice']),
          'prodtdescrip' => trim($_POST['prodt_descrip']),
          'prodtstatus' => trim($_POST['prodt_state']),
          'prodtvndptno' => trim($_POST['prodt_vendprtno']),
          'prodtvndprce' => trim($_POST['prodt_vendprice'])
        ],
        'stock' => $this->findKeyVal($_POST, 'dynm_locat_stock'),   // find given key from POST then decode location id and stock quantity
        'attrb' => $this->findKeyVal($_POST, 'dynm_attrb_atval'),  // find given key from POST then decode attribute id and attribute value
        'image' => []
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator0 = ['jpeg', 'png', 'gif'];  // filter image types
      $validator1 = "/^[a-zA-Z0-9 _-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0
      $validator5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address
      $validator9 = "/^[0-9]*.[0-9]+?$/"; // check for floats which has at least one floating point

      // validate prodct id
      if (empty($param['prodt']['prodtid'])) {
        $data['frm_msg']['edit_prodt_msg'] = 'Product Id: Field is empty';
      } elseif (!preg_match($validator2, $param['prodt']['prodtid'])) {
        $data['frm_msg']['edit_prodt_msg'] = 'Product Id: Invalied format';
      }

      // validate product name
      if (empty($param['prodt']['prodtname'])) {
        $data['frm_msg']['prodt_name'] = 'Product Name: Field is empty';
      } elseif (!preg_match($validator1, $param['prodt']['prodtname'])) {
        $data['frm_msg']['prodt_name'] = 'Product Name: Can only contain letters and numbers';
      }

      // validate brand
      if (empty($param['prodt']['prodtbrand'])) {
        $data['frm_msg']['prodt_brand'] = 'Brand: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtbrand'])) {
        $data['frm_msg']['prodt_brand'] = 'Brand: Invalied format';
      }

      // validate category
      if (empty($param['prodt']['prodtcategry'])) {
        $data['frm_msg']['prodt_category'] = 'Category: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtcategry'])) {
        $data['frm_msg']['prodt_category'] = 'Category: Invalied format';
      }

      // validate image
      $fileData = validateFiles('prodt_image', 3, $validator0);
      if (empty($fileData['error'])) {
        // $data['frm_msg']['prodt_image'] = 'Image: File not found';
      } elseif ($fileData['error'] != 'NoError') {
        $data['frm_msg']['prodt_image'] = 'Image: ' . $fileData['error'];
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate reorder level
      if (empty($param['prodt']['prodtreodlvl'])) {
        $data['frm_msg']['prodt_rorderlvl'] = 'Reorder Level: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtreodlvl'])) {
        $data['frm_msg']['prodt_rorderlvl'] = 'Reorder Level: Not a valied number';
      }

      // validate reorder quantity
      if (empty($param['prodt']['prodtreodqty'])) {
        $data['frm_msg']['prodt_rorderqty'] = 'Reorder Quantity: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtreodqty'])) {
        $data['frm_msg']['prodt_rorderqty'] = 'Reorder Quantity: Not a valied number';
      }

      // validate stocks
      if (empty($param['stock'])) {
        $data['frm_msg']['prodt_totstock'] = 'Total Stock: No fields';
      } else {
        foreach ($param['stock'] as $elem_id => $stock_data) {
          if (!preg_match($validator2, $stock_data['locat'])) {                       // check location id which is embeded in POST->key
            $data['frm_msg'][$elem_id] = 'Total Stock: Unknown format error';
          } elseif (empty($stock_data['stock'])) {                                    // check quantity 
            $data['frm_msg'][$elem_id] = 'Stock Quantity: Field is empty';
          } elseif (!preg_match($validator2, $stock_data['stock'])) {
            $data['frm_msg'][$elem_id] = 'Stock Quantity: Not a valied number';
          }
        }
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate retail price
      if (empty($param['prodt']['prodtrtlprce'])) {
        $data['frm_msg']['prodt_rtlprice'] = 'Retail Price: Field not selected';
      } elseif (!preg_match($validator9, $param['prodt']['prodtrtlprce'])) {
        $data['frm_msg']['prodt_rtlprice'] = 'Retail Price: Not a valied number';
      }

      // validate wholesale price
      if (empty($param['prodt']['prodtwslprce'])) {
        $data['frm_msg']['prodt_wslprice'] = 'Wholesale Price: Field not selected';
      } elseif (!preg_match($validator9, $param['prodt']['prodtwslprce'])) {
        $data['frm_msg']['prodt_wslprice'] = 'Wholesale Price: Not a valied number';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate vendor
      if (empty($param['prodt']['prodtvendor'])) {
        $data['frm_msg']['prodt_vendor'] = 'Vendor Name: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtvendor'])) {
        $data['frm_msg']['prodt_vendor'] = 'Vendor Name: Invalied format';
      }

      // validate vendor part no
      if (empty($param['prodt']['prodtvndptno'])) {
        $data['frm_msg']['prodt_vendprtno'] = 'Vendor\'s Part No: Field is empty';
      } elseif (!preg_match($validator1, $param['prodt']['prodtvndptno'])) {
        $data['frm_msg']['prodt_vendprtno'] = 'Vendor\'s Part No: Can only contain letters and numbers';
      }

      // validate vendor price
      if (empty($param['prodt']['prodtvndprce'])) {
        $data['frm_msg']['prodt_vendprice'] = 'Vendor\'s Price: Field not selected';
      } elseif (!preg_match($validator9, $param['prodt']['prodtvndprce'])) {
        $data['frm_msg']['prodt_vendprice'] = 'Vendor\'s Price: Not a valied number';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      // validate attributes
      if (empty($param['attrb'])) {
        // $data['frm_msg']['prodt_attributes'] = 'Attributes: No fields';
      } else {
        foreach ($param['attrb'] as $elem_id => $attrb_data) {
          if (!preg_match($validator2, $attrb_data['attrb'])) {
            $data['frm_msg'][$elem_id] = 'Attributes: Unknown format error';
          } elseif (empty($attrb_data['atval'])) {
            $data['frm_msg'][$elem_id] = 'Attribute Value: Field is empty';
          } elseif (!preg_match($validator2, $attrb_data['atval'])) {
            $data['frm_msg'][$elem_id] = 'Attribute Value: Invalied format';
          }
        }
      }

      // validate description
      if (empty($param['prodt']['prodtdescrip'])) {
        $data['frm_msg']['prodt_descrip'] = 'Product Description: Field is empty';
      } elseif (!preg_match($validator5, $param['prodt']['prodtdescrip'])) {
        $data['frm_msg']['prodt_descrip'] = 'Product Description: Can only contain letters, numbers and special char*';
      }

      // validate status
      if (empty($param['prodt']['prodtstatus'])) {
        $data['frm_msg']['prodt_state'] = 'Status: Field not selected';
      } elseif (!preg_match($validator2, $param['prodt']['prodtstatus'])) {
        $data['frm_msg']['prodt_state'] = 'Status: Not a valied number';
      }

      if (!empty($data['frm_msg'])) {
        echo json_encode($data);
        return;
      }

      if (empty($data['frm_msg'])) {

        for ($i = 0; $i < count($fileData['path']); $i++) {
          if (move_uploaded_file($fileData['path'][$i], 'img/uploads/product/' . $fileData['prodt_image'][$i])) {
            $param['image']['prodt_image_' . $i]['prodtimage'] = $fileData['prodt_image'][$i];
          } else {
            $data['frm_msg']['edit_prodt_msg'] = 'Image: File not saved';
          }
        }

        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_prodt_msg'] = 'Product successfully updated';
        } else {
          $data['frm_msg']['edit_prodt_msg'] = 'Someting went wrong';
        }
        echo json_encode($data);
      }
    }
  }

  public function deleteProduct()
  {
  }

  public function getProductDataset()
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
        $data['tbl_data'][$i]['prodt_no'] = 'PR-' . str_pad($data['tbl_data'][$i]['pid'], 8, '0', STR_PAD_LEFT);
      }

      echo json_encode($data);
    }
  }

  public function test()
  {
    echo '<pre>';
    $str = 'hello-world-123';
    echo hrtime(true), PHP_EOL;
    // $val = substr($str, strrpos($str, '-') + 1);

    // $val = end(explode('-', $str));

    // $temp = explode('-', $str);
    // $val = end($temp);

    // $val = substr(strrchr($str, '-'), 1);

    // $temp = explode('-', $str);
    // echo array_pop($temp), PHP_EOL;
    // if (implode('-', $temp) == 'hello-world') {
    //   echo "found", PHP_EOL;
    // }

    echo substr(strrchr($str, '-'), 1), PHP_EOL;
    if (strpos($str, 'hello-world-') === 0) {
      echo "found", PHP_EOL;
    }

    echo hrtime(true), PHP_EOL;

    // $param = [
    //   'locatid' => 1,
    //   'locatname' => "Main Warehouse",
    //   'locataddr' => "23/BS,Park Road,Negombo."
    // ];

    echo '</pre>';
  }

  public function testdb()
  {
    echo '<pre>';

    var_dump($this->userModel->getRowCount(''));

    $param = [
      'max_rows' => 5,
      'row_offset' => 0,
      'sort_col' => 1,
      'sort_type' => 0,
      'search_val' => '',
    ];

    var_dump($this->userModel->getRows($param));

    echo '</pre>';
  }

  private function findKeyVal($arr_in, $str_find)
  {
    $arr_out = [];
    foreach ($arr_in as $key => $val) {
      if (strpos($key, $str_find) === 0) {
        // $arr_out[$key] = [substr(strrchr($key, '_'), 1), trim($val)];
        $key_part = explode('_', $key);
        $arr_out[$key][$key_part[1]] = end($key_part);
        $arr_out[$key][$key_part[2]] = trim($val);
      }
    }
    return $arr_out;
  }
}
