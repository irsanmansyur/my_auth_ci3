<?php defined('BASEPATH') or exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{
  /**
   *  data ke tampilan view
   */
  public $data;

  public $time_lock;

  /**
   * Constructor 
   */
  function __construct($config = "my_auth_ci3")
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $this->load->library("session");
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('my_helper');

    if (!function_exists('is_login')) {
      $this->load->helper('auth_helper');
    }
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
  public function not_permition()
  {
    echo "anda tidak di izinkan";
    die();
  }
}


/**
 *
 * Admin Controller
 */
class Admin_Controller extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      $this->session->set_flashdata('danger', 'Menu yang anda akses sebelumnya dilarang');
      redirect('auth/login');
    }
    $this->data['user'] = user();
  }
}
