<?php

namespace auth;

// defined('BASEPATH') or exit('No direct script access allowed');


class MY_Auth extends \CI_Controller
{
  function __construct($config = "my_auth_ci3")
  {
    parent::__construct();
    if (!isset($this->session))
      $this->load->library("session");

    $sql = "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
    $this->db->query($sql);
    date_default_timezone_set('Asia/Kuala_Lumpur');


    if (!isset($this->user))
      $this->load->model('User_model', "user");
    if (!function_exists('is_login')) {
      $this->load->helper('auth_helper');
    }
    if (!function_exists("set_value"))
      $this->load->helper('form');
    if (!function_exists("base_url"))
      $this->load->helper('url');

    $this->data =  $this->_apply_setting();
    $this->load->library("template");
  }


  private function _apply_setting()
  {
    $Controller = $this->router->fetch_class();
    $Method = $this->router->fetch_method();
    $Directory = $this->router->directory;
    $data = [
      'route' => compact(['Controller', 'Method', 'Directory']),
      'title' => "Selamat datang",
      'page_description' => "Ini adalah Description Default, Selamat datang.!",
      "page_title" => "Selamat datang di super admin ci 3, anda berada di Controller $Controller dan method $Method"
    ];
    return $data;
  }

  public function not_permition(int $pageCode = 404, string $message = "Menu yang anda akses di larang", ...$arg)
  {
    $data = [
      'page_title' => $message,
      "page_code" => $pageCode,
    ];
    if ($this->input->is_ajax_request()) {
      return $this->output->set_content_type("application/json")
        ->set_output(
          json_encode($data)
        );
    };


    return $this->template->load("admin", "404", $data);
  }
}
