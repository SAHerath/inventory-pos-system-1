<?php

class Sales extends Controller
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
    $this->userModel = $this->model('SaleM');
  }

  public function index()
  {
    $data = [
      'title' => 'sale_list'
    ];
    $this->view('sales/salelistV', $data);
  }

  public function getSalesDataset()
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
        $data['tbl_data'][$i]['sales_no'] = 'SO-' . str_pad($data['tbl_data'][$i]['sales_id'], 8, '0', STR_PAD_LEFT);
      }


      echo json_encode($data);
    }
  }
}
