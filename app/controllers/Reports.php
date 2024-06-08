<?php

class Reports extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('ReportM');
  }

  public function index()
  {
    $data = [
      'title' => 'report_list'
    ];
    $this->view('reports/reportlistV', $data);
  }

  public function show($repotId = null)
  {
    $data = [
      'title' => 'report_' . $repotId,
    ];



    switch ($repotId) {
      case "stock":
        $this->view('reports/reportstockV', $data);
        break;
      case "sales":
        $this->view('reports/reportsalesV', $data);
        break;
      case "hello":
        $this->view('reports/newrepV', $data);
        break;
      default:
        exit('Error! : Report Id not found. ');
    }
  }

  public function hello()
  {
    $data = [
      'title' => 'purchord_add',
      'date' => date('Y-m-d'),
      'currency' => ' (Rs)',
      'taxp' => '10'
    ];

    // var_dump($data);

    $this->view('reports/newrepV', $data);
  }

  public function print($repotId = null, $sortHead = null, $sortType = null, $searchVal = null)
  {
    $param = [
      'max_rows' => 500,
      'row_offset' => 0,
      'sort_col' => 1,
      'sort_type' => 0,
      'search_val' => [],
    ];

    $data = [];

    $pattern1 = "/^[1-9]\d*$/";   // filter any number except 0
    $pattern2 = "/^[0|1]?$/";   // filter 0 or 1
    $pattern3 = "/^[a-z0-9]+$/";  // filter only lowercase lerters, numbers, atleast 1

    if (preg_match($pattern1, $sortHead)) {
      $param['sort_col'] = (int)$sortHead;
    }

    if (preg_match($pattern2, $sortType)) {
      $param['sort_type'] = (int)$sortType;
    }

    if (!preg_match($pattern3, $searchVal)) {
      $searchVal = '';
    }

    switch ($repotId) {
      case "stock":
        $param['search_val'] = $searchVal;
        $data['title'] = 'STOCK REPORT';
        $data['stock'] = $this->userModel->getStockData($param);
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        $this->view('reports/printstockV', $data);
        break;
      case "sales":
        if ($searchVal) {
          $date = DateTime::createFromFormat('d-n', '01-' . $searchVal);
          $param['search_val']['start'] = $date->format('Y-m-d');
          $param['search_val']['end'] = $date->format('Y-m-t');
        }
        $data['title'] = 'SALES REPORT';
        $data['sales'] = $this->userModel->getSalesData($param);
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        $this->view('reports/printsalesV', $data);
        break;
      case "new":
        $param['search_val'] = $searchVal;
        $data['title'] = 'STOCK REPORT NEW';
        $data['stock'] = $this->userModel->getStockData2($param);
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        $this->view('reports/printstockV', $data);
        break;
      default:
        exit('Error! : Report Id not found. ');
    }
  }

  public function getReportStockData()
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
        $rowTot = $this->userModel->getStockCount($param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getStockData($param);

      for ($i = 0; $i < count($data['tbl_data']); $i++) {
        $data['tbl_data'][$i]['prodt_sku'] = 'PR-' . str_pad($data['tbl_data'][$i]['prodt_id'], 8, '0', STR_PAD_LEFT);
      }

      echo json_encode($data);
    }
  }

  public function getSalesMonthData()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $pageNum = trim($_POST['page_num']);
      $newSearch = trim($_POST['search_new']);
      $searchVal = trim($_POST['search_val']);

      $param = [
        'max_rows' => 10,
        'row_offset' => 0,
        'sort_col' => trim($_POST['sort_col']),
        'sort_type' => trim($_POST['sort_type']),
        'search_val' => [],
      ];

      $data = [
        'page_tot' => '',
        'tbl_data' => []
      ];

      $pattern1 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern2 = "/^[0|1]?$/";   // filter 0 or 1
      // $pattern3 = "/^[a-z]{2,}$/";  // filter only lowercase lerters, atleast 2

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

      if (!preg_match($pattern1, $searchVal)) {
        $param['search_val'] = '';
      } else {
        $date = DateTime::createFromFormat('d-n', '01-' . $searchVal);
        $param['search_val']['start'] = $date->format('Y-m-d');
        $param['search_val']['end'] = $date->format('Y-m-t');
      }
      // echo json_encode($param);
      // return;

      $param['row_offset'] = ((int)$pageNum - 1) * $param['max_rows'];

      if ($newSearch) {
        $rowTot = $this->userModel->getSalesCount($param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getSalesData($param);

      for ($i = 0; $i < count($data['tbl_data']); $i++) {
        $data['tbl_data'][$i]['sales_psku'] = 'PR-' . str_pad($data['tbl_data'][$i]['sales_pid'], 8, '0', STR_PAD_LEFT);
      }

      echo json_encode($data);
    }
  }

  public function getDetails()
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
        $rowTot = $this->userModel->getStockCount2($param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getStockData2($param);

      for ($i = 0; $i < count($data['tbl_data']); $i++) {
        $data['tbl_data'][$i]['prodt_sku'] = 'PR-' . str_pad($data['tbl_data'][$i]['prodt_id'], 8, '0', STR_PAD_LEFT);
      }

      echo json_encode($data);
    }
  }
}
