<?php

class Locations extends Controller
{

  public function __construct()
  {
    if (!isEnabled('loca')) {
      exit("Permission Not Granted!");
      return;
    }
    $this->userModel = $this->model('LocationM');
  }

  public function index()
  {
    $data = [
      'title' => 'location'
    ];
    $this->view('locations/locationV', $data);
  }

  public function addLocation()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'locatname' => trim($_POST['add_locat_name']),
        'locataddr' => trim($_POST['add_locat_address'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address

      // validate Location name
      if (empty($param['locatname'])) {
        $data['frm_msg']['add_locat_name'] = 'Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['locatname'])) {
        $data['frm_msg']['add_locat_name'] = 'Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['locataddr'])) {
        $data['frm_msg']['add_locat_address'] = 'Address: Field not selected';
      } elseif (!preg_match($pattern5, $param['locataddr'])) {
        $data['frm_msg']['add_locat_address'] = 'Address: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_locat_msg'] = 'Location successfully added';
        } else {
          $data['frm_msg']['add_locat_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function editLocation()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'locatid' => trim($_POST['edit_locat_id']),
        'locatname' => trim($_POST['edit_locat_name']),
        'locataddr' => trim($_POST['edit_locat_address'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern1 = "/^[a-zA-Z0-9 _]*$/";   // filter only lowercase/uppercase/numbers/space/underscor
      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0
      $pattern5 = "/^[a-zA-Z0-9 _,.-\/\r\n]*$/"; // filter address

      // validate Location id
      if (empty($param['locatid'])) {
        $data['frm_msg']['edit_locat_msg'] = 'Location Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['locatid'])) {
        $data['frm_msg']['edit_locat_msg'] = 'Location Id: Invalied format';
      }

      // validate Location name
      if (empty($param['locatname'])) {
        $data['frm_msg']['edit_locat_name'] = 'Name: Field is empty';
      } elseif (!preg_match($pattern1, $param['locatname'])) {
        $data['frm_msg']['edit_locat_name'] = 'Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['locataddr'])) {
        $data['frm_msg']['edit_locat_address'] = 'Address: Field not selected';
      } elseif (!preg_match($pattern5, $param['locataddr'])) {
        $data['frm_msg']['edit_locat_address'] = 'Address: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_locat_msg'] = 'Location successfully updated';
        } else {
          $data['frm_msg']['edit_locat_msg'] = 'Something went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function deleteLocation()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'locatid' => trim($_POST['delt_locat_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      $pattern2 = "/^[1-9]\d*$/";   // filter any number except 0

      // validate Location id
      if (empty($param['locatid'])) {
        $data['frm_msg']['delt_locat_msg'] = 'Location Id: Field is empty';
      } elseif (!preg_match($pattern2, $param['locatid'])) {
        $data['frm_msg']['delt_locat_msg'] = 'Location Id: Invalied format';
      }

      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_locat_msg'] = 'Location successfully deleted';
        } else {
          $data['frm_msg']['delt_locat_msg'] = 'Someting went wrong';
        }
      }

      echo json_encode($data);
    }
  }

  public function getLocationDataset()
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
    $param = [
      'locatid' => 1,
      'locatname' => "Main Warehouse",
      'locataddr' => "23/BS,Park Road,Negombo."
    ];
    var_dump($this->userModel->update($param));
    echo '</pre>';
  }
}
