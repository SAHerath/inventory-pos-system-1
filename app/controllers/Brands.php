<?php

class Brands extends Controller
{

  public function __construct()
  {
    if (!isEnabled('brnd')) {
      exit("Permission Not Granted!");
      return;
    }
    $this->userModel = $this->model('BrandM');
  }

  public function index()
  {
    $data = [
      'title' => 'brand'
    ];
    $this->view('brands/brandV', $data);
  }

  public function addBrand()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'brandname' => trim($_POST['add_brand_name']),
        'brandactv' => trim($_POST['add_brand_state'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate brand name
      if (empty($param['brandname'])) {
        $data['frm_msg']['add_brand_name'] = 'Brand Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['brandname'])) {
        $data['frm_msg']['add_brand_name'] = 'Brand Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['brandactv'])) {
        $data['frm_msg']['add_brand_state'] = 'Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['brandactv'])) {
        $data['frm_msg']['add_brand_state'] = 'Status: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_brand_msg'] = 'Brand successfully added';
        } else {
          $data['frm_msg']['add_brand_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editBrand()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'brandid' => trim($_POST['edit_brand_id']),
        'brandname' => trim($_POST['edit_brand_name']),
        'brandactv' => trim($_POST['edit_brand_state'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate brand id
      if (empty($param['brandid'])) {
        $data['frm_msg']['edit_brand_msg'] = 'Brand Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['brandid'])) {
        $data['frm_msg']['edit_brand_msg'] = 'Brand Id: Invalied format';
      }

      // validate brand name
      if (empty($param['brandname'])) {
        $data['frm_msg']['edit_brand_name'] = 'Brand Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['brandname'])) {
        $data['frm_msg']['edit_brand_name'] = 'Brand Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['brandactv'])) {
        $data['frm_msg']['edit_brand_state'] = 'Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['brandactv'])) {
        $data['frm_msg']['edit_brand_state'] = 'Status: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_brand_msg'] = 'Brand successfully updated';
        } else {
          $data['frm_msg']['edit_brand_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteBrand()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'brandid' => trim($_POST['delt_brand_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate category id
      if (empty($param['brandid'])) {
        $data['frm_msg']['delt_brand_msg'] = 'Brand Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['brandid'])) {
        $data['frm_msg']['delt_brand_msg'] = 'Brand Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_brand_msg'] = 'Brand successfully deleted';
        } else {
          $data['frm_msg']['delt_brand_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getDataset()
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

  public function testdb()
  {
    echo '<pre>';

    echo '</pre>';
  }
}
