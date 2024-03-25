<?php

class Vendors extends Controller
{

  public function __construct()
  {
    $this->userModel = $this->model('VendorM');
  }

  public function index()
  {
    $data = [
      'title' => 'vendor_list'
    ];
    $this->view('vendors/vendorlistV', $data);
  }

  public function add()
  {
    $data = [
      'title' => 'vendor_add',
      'param' => [
        'vend_name' => '',
        'vend_phone' => '',
        'vend_email' => '',
        'vend_website' => '',
        'vend_address' => '',
        'vend_city' => '',
        'vend_country' => '',
        'vend_zip' => '',
        'vend_notes' => '',
        'vend_active' => ''
      ]
    ];
    $this->view('vendors/vendoraddeditV', $data);
  }

  public function edit($vendrId = null)
  {
    $vendrId = trim($vendrId);

    $data = [
      'title' => 'vendor_edit',
      'param' => []
    ];

    $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

    // validate vendor id
    if (empty($vendrId) || !preg_match($pattern2, $vendrId)) {
      exit('Error! : No valied Vendor Id found. ');
    } else {
      $data['param'] = $this->userModel->getRow($vendrId);
      $this->view('vendors/vendoraddeditV', $data);
    }
  }

  public function addVendor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'vendrname' => trim($_POST['vendr_name']),
        'vendrphone' => trim($_POST['vendr_phone']),
        'vendremail' => trim($_POST['vendr_email']),
        'vendrweb' => trim($_POST['vendr_website']),
        'vendraddr' => trim($_POST['vendr_address']),
        'vendrcity' => trim($_POST['vendr_city']),
        'vendrcont' => trim($_POST['vendr_country']),
        'vendrzip' => trim($_POST['vendr_postal']),
        'vendrnote' => trim($_POST['vendr_remarks']),
        'vendractv' => trim($_POST['vendr_state'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";    // filter local telephone no.
      $pattern5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address
      $pattern6 = "^[0-9]{5}(?:-[0-9]{4})?$"; // US Postal Codes ex 98102 or 98102-1234

      // validate vendor name
      if (empty($param['vendrname'])) {
        $data['frm_msg']['vendr_name'] = 'Vendor Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['vendrname'])) {
        $data['frm_msg']['vendr_name'] = 'Vendor Name: Can only contain letters and numbers';
      }

      // validate telphone number
      if (empty($param['vendrphone'])) {
        $data['frm_msg']['vendr_phone'] = 'Phone: Field is empty';
      } elseif (!preg_match($pattern3, $param['vendrphone'])) {
        $data['frm_msg']['vendr_phone'] = 'Phone: Invalied phone number format';
      }

      // validate email
      if (empty($param['vendremail'])) {
        $data['frm_msg']['vendr_email'] = 'Email: Field is empty';
      } elseif (!filter_var($param['vendremail'], FILTER_VALIDATE_EMAIL)) {
        $data['frm_msg']['vendr_email'] = 'Email: Invalied email format';
      }

      // validate website
      if (empty($param['vendrweb'])) {
        // $data['frm_msg']['vendr_website'] = 'Website: Field is empty';
      } elseif (!filter_var('http://' . $param['vendrweb'], FILTER_VALIDATE_URL)) {
        $data['frm_msg']['vendr_website'] = 'Website: Invalied url format';
      }

      // validate address
      if (empty($param['vendraddr'])) {
        $data['frm_msg']['vendr_address'] = 'Address: Field is empty';
      } elseif (!preg_match($pattern5, $param['vendraddr'])) {
        $data['frm_msg']['vendr_address'] = 'Address: Invalied characters found';
      }

      // validate city
      if (empty($param['vendrcity'])) {
        $data['frm_msg']['vendr_city'] = 'City: Field is empty';
      } elseif (!preg_match($pattern1, $param['vendrcity'])) {
        $data['frm_msg']['vendr_city'] = 'City: Can only contain letters and numbers';
      }

      // validate country
      if (empty($param['vendrcont'])) {
        $data['frm_msg']['vendr_country'] = 'Country: Field is empty';
      } elseif (!preg_match($pattern1, $param['vendrcont'])) {
        $data['frm_msg']['vendr_country'] = 'Country: Can only contain letters and numbers';
      }

      // validate zip
      if (empty($param['vendrzip'])) {
        // $data['frm_msg']['vendr_postal'] = 'Country: Field is empty';
      } elseif (!preg_match($pattern2, $param['vendrzip'])) {
        $data['frm_msg']['vendr_postal'] = 'ZIP/Postal Code: Invalied format';
      }

      // validate notes
      // if (!preg_match($pattern5, $param['vendrnote'])) {
      //   $data['frm_msg']['vendr_remarks'] = 'Remarks: Invalied characters found';
      // }

      // validate status
      if (empty($param['vendractv'])) {
        $data['frm_msg']['vendr_state'] = 'Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['vendractv'])) {
        $data['frm_msg']['vendr_state'] = 'Status: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['vendr_msg'] = 'Vendor successfully added';
        } else {
          $data['frm_msg']['vendr_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editVendor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'vendrid' => trim($_POST['vendr_id']),
        'vendrname' => trim($_POST['vendr_name']),
        'vendrphone' => trim($_POST['vendr_phone']),
        'vendremail' => trim($_POST['vendr_email']),
        'vendrweb' => trim($_POST['vendr_website']),
        'vendraddr' => trim($_POST['vendr_address']),
        'vendrcity' => trim($_POST['vendr_city']),
        'vendrcont' => trim($_POST['vendr_country']),
        'vendrzip' => trim($_POST['vendr_postal']),
        'vendrnote' => trim($_POST['vendr_remarks']),
        'vendractv' => trim($_POST['vendr_state'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern3 = "/^([0-9]{3}|\+94[1-9]{2})[0-9]{7}$/";    // filter local telephone no.
      $pattern5 = "/^[a-zA-Z0-9 _,-.\/]*$/"; // filter address

      // validate category id
      if (empty($param['vendrid'])) {
        $data['frm_msg']['vendr_msg'] = 'Vendor Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['vendrid'])) {
        $data['frm_msg']['vendr_msg'] = 'Vendor Id: Invalied format';
      }

      // validate vendor name
      if (empty($param['vendrname'])) {
        $data['frm_msg']['vendr_name'] = 'Vendor Name: Field is empty';
      } elseif (!preg_match($pattern5, $param['vendrname'])) {
        $data['frm_msg']['vendr_name'] = 'Vendor Name: Can only contain letters and numbers';
      }

      // validate telphone number
      if (empty($param['vendrphone'])) {
        $data['frm_msg']['vendr_phone'] = 'Phone: Field is empty';
      } elseif (!preg_match($pattern3, $param['vendrphone'])) {
        $data['frm_msg']['vendr_phone'] = 'Phone: Invalied phone number format';
      }

      // validate email
      if (empty($param['vendremail'])) {
        $data['frm_msg']['vendr_email'] = 'Email: Field is empty';
      } elseif (!filter_var($param['vendremail'], FILTER_VALIDATE_EMAIL)) {
        $data['frm_msg']['vendr_email'] = 'Email: Invalied email format';
      }

      // validate website
      if (empty($param['vendrweb'])) {
        // $data['frm_msg']['vendr_website'] = 'Website: Field is empty';
      } elseif (!filter_var('http://' . $param['vendrweb'], FILTER_VALIDATE_URL)) {
        $data['frm_msg']['vendr_website'] = 'Website: Invalied url format';
      }

      // validate address
      if (empty($param['vendraddr'])) {
        $data['frm_msg']['vendr_address'] = 'Address: Field is empty';
      } elseif (!preg_match($pattern5, $param['vendraddr'])) {
        $data['frm_msg']['vendr_address'] = 'Address: Invalied characters found';
      }

      // validate city
      if (empty($param['vendrcity'])) {
        $data['frm_msg']['vendr_city'] = 'City: Field is empty';
      } elseif (!preg_match($pattern1, $param['vendrcity'])) {
        $data['frm_msg']['vendr_city'] = 'City: Can only contain letters and numbers';
      }

      // validate country
      if (empty($param['vendrcont'])) {
        $data['frm_msg']['vendr_country'] = 'Country: Field is empty';
      } elseif (!preg_match($pattern1, $param['vendrcont'])) {
        $data['frm_msg']['vendr_country'] = 'Country: Can only contain letters and numbers';
      }

      // validate zip
      if (empty($param['vendrzip'])) {
        // $data['frm_msg']['vendr_postal'] = 'Country: Field is empty';
      } elseif (!preg_match($pattern2, $param['vendrzip'])) {
        $data['frm_msg']['vendr_postal'] = 'ZIP/Postal Code: Invalied format';
      }

      // validate notes
      // if (!preg_match($pattern5, $param['vendrnote'])) {
      //   $data['frm_msg']['vendr_remarks'] = 'Remarks: Invalied characters found';
      // }

      // validate status
      if (empty($param['vendractv'])) {
        $data['frm_msg']['vendr_state'] = 'Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['vendractv'])) {
        $data['frm_msg']['vendr_state'] = 'Status: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['vendr_msg'] = 'Vendor successfully added';
        } else {
          $data['frm_msg']['vendr_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteVendor()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'vendrid' => trim($_POST['delt_vendr_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate category id
      if (empty($param['vendrid'])) {
        $data['frm_msg']['delt_vendr_msg'] = 'Vendor Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['vendrid'])) {
        $data['frm_msg']['delt_vendr_msg'] = 'Vendor Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_vendr_msg'] = 'Vendor successfully deleted';
        } else {
          $data['frm_msg']['delt_vendr_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getVendorDataset()
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

      echo json_encode($data);
    }
  }

  public function getVendorData()
  {
  }
}
