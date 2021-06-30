<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Pembelian_model" => "pembelian"]);
    if (!in_role([1, "Admin"]) && !can("Pembelian"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Pembelian Barang");
  }

  public function index()
  {
    return $this->template->load('admin', 'pembelian/barang', [
      'page_title' => "Pembelian Barang",
      "pembelian" => $this->pembelian
    ]);
  }
}
