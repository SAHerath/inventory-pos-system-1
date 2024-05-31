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
}
