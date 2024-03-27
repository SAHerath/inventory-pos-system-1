<?php

class Roles extends Controller
{
  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('auth/index');
    }
    if (!isEnabled('role')) {
      exit("Permission Not Granted!");
      return;
    }
    $this->userModel = $this->model('RoleM');
  }

  public function index()
  {
    $data = [
      'title' => 'role_list'
    ];
    $this->view('roles/rolelistV', $data);
  }

  public function add()
  {
    $data = [
      'title' => 'role_add'
    ];

    $temp = $this->userModel->getPermissionList();
    for ($i = 0; $i < count($temp); $i++) {
      $data['permi'][$temp[$i]['perm_module']][$i] = $temp[$i];
    }

    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';

    $this->view('roles/roleaddV', $data);
  }

  public function edit($rolesId = null)
  {
    $rolesId = trim($rolesId);
    $data = [
      'title' => 'roles_edit',
    ];
    $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

    // validate role id
    if (empty($rolesId) || !preg_match($validator2, $rolesId)) {
      exit('Error! : No valied Order Id found. ');
    } else {

      $data['roles'] = $this->userModel->getRole($rolesId);

      $temp = $this->userModel->getRolePermissionList($rolesId);
      for ($i = 0; $i < count($temp); $i++) {
        $data['rolprm'][$temp[$i]['perm_module']][$i] = $temp[$i];
      }

      // echo '<pre>';
      // var_dump($data);
      // echo '</pre>';

      $this->view('roles/roleeditV', $data);
    }
  }

  public function addRole()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'roles' => [
          'rolesname' => trim($_POST['roles_rname']),
          'rolesstate' => trim($_POST['roles_status'])
        ],
        'permi' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "roles_permi") === 0) {
          $param['permi'][$key]['permiid'] = trim($val);
        }
      }

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator1 = "/^[a-zA-Z0-9 _-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate role name
      if (empty($param['roles']['rolesname'])) {
        $data['frm_msg']['roles_rname'] = 'Role Name: Field is empty';
      } elseif (!preg_match($validator1, $param['roles']['rolesname'])) {
        $data['frm_msg']['roles_rname'] = 'Role Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['roles']['rolesstate'])) {
        $data['frm_msg']['roles_status'] = 'Status: Field not selected';
      } elseif (!($param['roles']['rolesstate'] == 'active' || $param['roles']['rolesstate'] == 'inactive')) {
        $data['frm_msg']['roles_status'] = 'Status: Invalied value';
      }

      // validate role permissions
      if (empty($param['permi'])) {
        $data['frm_msg']['add_roles_msg'] = 'Permission: Not selected';
      } else {
        foreach ($param['permi'] as $permi_data) {
          if (empty($permi_data['permiid'])) {
            $data['frm_msg']['add_roles_msg'] = "Permission: Empty field found";
          } elseif (!preg_match($validator2, $permi_data['permiid'])) {
            $data['frm_msg']['add_roles_msg'] = "Permission: Invalid format found";
          }
        }
      }


      if (empty($data['frm_msg'])) {
        if ($this->userModel->create($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['add_roles_msg'] = 'Role successfully added';
        } else {
          $data['frm_msg']['add_roles_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function editRole()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'roles' => [
          'rolesid' => trim($_POST['roles_rolid']),
          'rolesname' => trim($_POST['roles_rname']),
          'rolesstate' => trim($_POST['roles_status'])
        ],
        'permi' => []
      ];

      foreach ($_POST as $key => $val) {
        if (strpos($key, "roles_permi") === 0) {
          $param['permi'][$key]['permiid'] = trim($val);
        }
      }

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator1 = "/^[a-zA-Z0-9 _-]*$/";   // filter only lowercase/uppercase/numbers/space/underscor/dash
      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate role id
      if (empty($param['roles']['rolesid'])) {
        $data['frm_msg']['edit_roles_msg'] = 'Role Id: Field is empty';
      } elseif (!preg_match($validator2, $param['roles']['rolesid'])) {
        $data['frm_msg']['edit_roles_msg'] = 'Role Id: Invalied format';
      }

      // validate role name
      if (empty($param['roles']['rolesname'])) {
        $data['frm_msg']['roles_rname'] = 'Role Name: Field is empty';
      } elseif (!preg_match($validator1, $param['roles']['rolesname'])) {
        $data['frm_msg']['roles_rname'] = 'Role Name: Can only contain letters and numbers';
      }

      // validate status
      if (empty($param['roles']['rolesstate'])) {
        $data['frm_msg']['roles_status'] = 'Status: Field not selected';
      } elseif (!($param['roles']['rolesstate'] == 'active' || $param['roles']['rolesstate'] == 'inactive')) {
        $data['frm_msg']['roles_status'] = 'Status: Invalied value';
      }

      // validate role permissions
      if (empty($param['permi'])) {
        $data['frm_msg']['edit_roles_msg'] = 'Permission: Not selected';
      } else {
        foreach ($param['permi'] as $permi_data) {
          if (empty($permi_data['permiid'])) {
            $data['frm_msg']['edit_roles_msg'] = "Permission: Empty field found";
          } elseif (!preg_match($validator2, $permi_data['permiid'])) {
            $data['frm_msg']['edit_roles_msg'] = "Permission: Invalid format found";
          }
        }
      }


      if (empty($data['frm_msg'])) {
        if ($this->userModel->update($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['edit_roles_msg'] = 'Role successfully updated';
        } else {
          $data['frm_msg']['edit_roles_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function deleteRole()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $param = [
        'rolesid' => trim($_POST['delt_roles_id'])
      ];

      $data = [
        'state' => 'invalid',
        'frm_msg' => []
      ];

      // echo json_encode($param);
      // return;

      $validator2 = "/^[1-9][0-9]*$/";  // filter any number except 0

      // validate role id
      if (empty($param['rolesid'])) {
        $data['frm_msg']['delt_roles_msg'] = 'Role Id: Field is empty';
      } elseif (!preg_match($validator2, $param['rolesid'])) {
        $data['frm_msg']['delt_roles_msg'] = 'Role Id: Invalied format';
      }


      if (empty($data['frm_msg'])) {
        if ($this->userModel->remove($param)) {
          unset($param);
          $data['state']  = 'success';
          $data['frm_msg']['delt_roles_msg'] = 'Role successfully deleted';
        } else {
          $data['frm_msg']['delt_roles_msg'] = 'Someting went wrong';
        }
      }
      echo json_encode($data);
    }
  }

  public function getRoleDataset()
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
