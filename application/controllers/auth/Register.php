<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  public function index()
  {
    if (is_login()) {
      $this->session->set_flashdata("warning", "anda sudah login");
      return redirect(base_url('admin/dashboard'));
    }
    $this->load->model("User_model", "user");
    $this->load->library("form_validation");
    $this->form_validation->set_rules($this->user->getRules());
    $this->form_validation->set_rules("confirmpassword", "Konfirmasi Password", "matches[password]");

    if ($this->form_validation->run() == false) {
      $data = [
        'form' => [
          "action_register" => base_url('auth/register'),
        ],
      ];
      $this->template->load('admin', 'auth/register', $data);
    } else {
      // validasinya success
      $this->_register();
    }
  }
  private function _register()
  {
    $email = $this->input->post('email');
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $name = $this->input->post('name');
    $status = "0";

    $user =    $this->user->save(compact("email", 'username', 'password', 'name', 'status'));
    if (!$user) {
      $this->session->set_flashdata("danger", "User Gagal di registrasi");
      return back();
    }
    $this->session->set_flashdata("success", "User berhasil di registrasi");
    return redirect(base_url("auth/login"));
  }
}
