<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();

    if (!can("Kasir")  || !in_role(["Kasir"]))
      return  $this->not_permition(403, "Anda Tidak Dapat Akses Riwayat Kasir");
  }
  public function index()
  {
  }
  public function penjualan()
  {
    $data = [
      'page_title' => "Riwayat Penjualan Oleh Kasir",
    ];
    $this->template->load('admin', 'kasir/penjualan/riwayat', $data);
  }
}
