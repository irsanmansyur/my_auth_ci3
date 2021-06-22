<?php

use auth\MY_Auth;

require(APPPATH . 'core/MY_Auth.php');


class Redirect extends MY_Auth
{
  public function __construct()
  {
    parent::__construct();
  }
  public function index()
  {
    if (is_login())
      return redirect(base_url('admin/dashboard'));

    $this->load->library("form_validation");
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    if ($this->form_validation->run() == false) {
      $data = [
        'page_title' => "Login Page",
        'form' => [
          "action_login" => base_url('auth/login'),
        ],
      ];
      $this->template->load('admin', 'auth/login', $data);
    } else {
      // validasinya success
      $this->_login();
    }
  }
  private function _login()
  {
    if(in_role("Kasir"))
    redire
  }
}
