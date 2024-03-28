<?php

class Attributes extends Controller
{

  public function __construct()
  {
    if (!isEnabled('atrb')) {
      exit("Permission Not Granted!");
      return;
    }
    $this->userModel = $this->model('AttributeM');
    // session_start();
  }

  public function index()
  {
    $data = [
      'title' => 'attribute'
    ];
    $this->view('attributes/attributeV', $data);
  }

  public function addAttribute()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'attrbname' => trim($_POST['add_attrb_name'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor

      // validate attribute name
      if (empty($param['attrbname'])) {
        $data['frm_msg']['add_attrb_name'] = 'Attribute Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['attrbname'])) {
        $data['frm_msg']['add_attrb_name'] = 'Attribute Name: Can only contain letters and numbers';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->createAttrbType($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_attrb_msg'] = 'Attribute successfully added';
        } else {
          $data['frm_msg']['add_attrb_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editAttribute()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'attrbid' => trim($_POST['edit_attrb_id']),
        'attrbname' => trim($_POST['edit_attrb_name'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate Attribute id
      if (empty($param['attrbid'])) {
        $data['frm_msg']['edit_attrb_msg'] = 'Attribute Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['attrbid'])) {
        $data['frm_msg']['edit_attrb_msg'] = 'Attribute Id: Invalied format';
      }

      // validate Attribute name
      if (empty($param['attrbname'])) {
        $data['frm_msg']['edit_attrb_name'] = 'Attribute Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['attrbname'])) {
        $data['frm_msg']['edit_attrb_name'] = 'Attribute Name: Can only contain letters and numbers';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->updateAttrbType($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_attrb_msg'] = 'Attribute successfully updated';
        } else {
          $data['frm_msg']['edit_attrb_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteAttribute()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'attrbid' => trim($_POST['delt_attrb_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate Attribute id
      if (empty($param['attrbid'])) {
        $data['frm_msg']['delt_attrb_msg'] = 'Attribute Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['attrbid'])) {
        $data['frm_msg']['delt_attrb_msg'] = 'Attribute Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->removeAttrbType($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_attrb_msg'] = 'Attribute successfully deleted';
        } else {
          $data['frm_msg']['delt_attrb_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getAttributeDataset()
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
        'search_val' => trim($_POST['search_val'])
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
        $rowTot = $this->userModel->getRowCountAttrbType($param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getRowsAttrbType($param);

      echo json_encode($data);
    }
  }

  ///////////////////////////////////////////////////////////

  public function attribValues($attrib_id = null)
  {
    $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0
    $attrib_id = trim($attrib_id);
    // validate attribute id
    if (empty($attrib_id) || !preg_match($pattern2, $attrib_id)) {
      exit('Error! : No valied Attribute Id found.');
    } else {
      $_SESSION['attrib_id'] = (int)$attrib_id;

      $data = [
        'title' => 'attribute_value_name',
        'display' => ''
      ];

      $data['display'] = ucwords($this->userModel->getAttribName($attrib_id));
      // var_dump($attrib_id, $data);

      $this->view('attributes/attribvaluesV', $data);
    }
  }

  public function addAttribval()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'attrbid' => $_SESSION['attrib_id'],
        'atvalname' => trim($_POST['add_atval_name'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor

      // validate attribute name
      if (empty($param['atvalname'])) {
        $data['frm_msg']['add_atval_name'] = 'Attribute Value Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['atvalname'])) {
        $data['frm_msg']['add_atval_name'] = 'Attribute Value Name: Can only contain letters and numbers';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->createAttrbValue($param)) {
          $data['state']  = 'success';
          $data['frm_msg']['add_atval_msg'] = 'Attribute Value successfully added';
        } else {
          $data['frm_msg']['add_atval_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editAttribval()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'atvalid' => trim($_POST['edit_atval_id']),
        'atvalname' => trim($_POST['edit_atval_name'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate Attribute id
      if (empty($param['atvalid'])) {
        $data['frm_msg']['edit_atval_msg'] = 'Attribute Value Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['atvalid'])) {
        $data['frm_msg']['edit_atval_msg'] = 'Attribute Value Id: Invalied format';
      }

      // validate Attribute name
      if (empty($param['atvalname'])) {
        $data['frm_msg']['edit_atval_name'] = 'Attribute Value Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['atvalname'])) {
        $data['frm_msg']['edit_atval_name'] = 'Attribute Value Name: Can only contain letters and numbers';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->updateAttrbValue($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_atval_msg'] = 'Attribute Value successfully updated';
        } else {
          $data['frm_msg']['edit_atval_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteAttribval()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'atvalid' => trim($_POST['delt_atval_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate Attribute id
      if (empty($param['atvalid'])) {
        $data['frm_msg']['delt_atval_msg'] = 'Attribute Value Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['atvalid'])) {
        $data['frm_msg']['delt_atval_msg'] = 'Attribute Value Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->removeAttrbValue($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_atval_msg'] = 'Attribute Value successfully deleted';
        } else {
          $data['frm_msg']['delt_atval_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getAttribvalDataset()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);

      $pageNum = trim($_POST['page_num']);
      $newSearch = trim($_POST['search_new']);

      $param = [
        'max_rows' => 10,
        'row_offset' => 0,
        'sort_col' => trim($_POST['sort_col']),
        'sort_type' => trim($_POST['sort_type']),
        'search_val' => trim($_POST['search_val']),
        'parent_id' => $_SESSION['attrib_id']
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

      // var_dump($param);

      if ($newSearch) {
        $rowTot = $this->userModel->getRowCountAttrbValue($param['parent_id'], $param['search_val']);
        $data['page_tot'] =  ceil($rowTot / $param['max_rows']);
      }

      $data['tbl_data'] = $this->userModel->getRowsAttrbValue($param);

      echo json_encode($data);
    }
  }

  public function testdb()
  {
    echo '<pre>';

    $param = [
      'max_rows' => 5,
      'row_offset' => 0,
      'sort_col' => 1,
      'sort_type' => 0,
      'search_val' => '',
      'parent_id' => 1
    ];
    var_dump($param);
    var_dump($this->userModel->getRowCountAttrbValue($param['parent_id'], $param['search_val']));
    var_dump($this->userModel->getRowsAttrbValue($param));

    echo '</pre>';
  }
}
