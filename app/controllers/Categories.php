<?php

class Categories extends Controller
{

  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('auth/index');
    }
    $this->userModel = $this->model('CategoryM');
  }

  public function index()
  {
    $data = [
      'title' => 'category'
    ];
    $this->view('categories/categoryV', $data);
  }

  public function addCategory()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'categname' => trim($_POST['add_categ_name']),
        'categactv' => trim($_POST['add_categ_state'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate category name
      if (empty($param['categname'])) {
        $data['frm_msg']['add_categ_name'] = 'Category Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['categname'])) {
        $data['frm_msg']['add_categ_name'] = 'Category Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['categactv'])) {
        $data['frm_msg']['add_categ_state'] = 'Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['categactv'])) {
        $data['frm_msg']['add_categ_state'] = 'Status: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_categ_msg'] = 'Category successfully added';
        } else {
          $data['frm_msg']['add_categ_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editCategory()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'categid' => trim($_POST['edit_categ_id']),
        'categname' => trim($_POST['edit_categ_name']),
        'categactv' => trim($_POST['edit_categ_state'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate category id
      if (empty($param['categid'])) {
        $data['frm_msg']['edit_categ_msg'] = 'Category Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['categid'])) {
        $data['frm_msg']['edit_categ_msg'] = 'Category Id: Invalied format';
      }

      // validate category name
      if (empty($param['categname'])) {
        $data['frm_msg']['edit_categ_name'] = 'Category Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['categname'])) {
        $data['frm_msg']['edit_categ_name'] = 'Category Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['categactv'])) {
        $data['frm_msg']['edit_categ_state'] = 'Status: Field not selected';
      } elseif (!preg_match($pattern2, $param['categactv'])) {
        $data['frm_msg']['edit_categ_state'] = 'Status: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_categ_msg'] = 'Category successfully updated';
        } else {
          $data['frm_msg']['edit_categ_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteCategory()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'categid' => trim($_POST['delt_categ_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate category id
      if (empty($param['categid'])) {
        $data['frm_msg']['delt_categ_msg'] = 'Category Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['categid'])) {
        $data['frm_msg']['delt_categ_msg'] = 'Category Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_categ_msg'] = 'Category successfully deleted';
        } else {
          $data['frm_msg']['delt_categ_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getCategoryDataset()
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
    var_dump($this->userModel->getRowCount('you'));

    $param = [
      'max_rows' => 5,
      'row_offset' => 0,
      'sort_col' => 1,
      'sort_type' => 0,
      'search_val' => 'you',
    ];
    var_dump($this->userModel->getRows($param));
    // $data = $this->userModel->categGetRows(1, 0, 5, 0, 'you');
    // var_dump($data[0]['title']);
    // var_dump($data[0]['artist']);
    echo '</pre>';
  }
}
