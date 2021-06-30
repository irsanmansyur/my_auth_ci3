<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Penjualan_model" => "penjualan", "Keranjang_pembelian_model" => "keranjang"]);
    if (!in_role([1, "Admin"]) && !can("Pembayaran Pembelian"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Pembayaran Pembelian");
  }

  public function index()
  {
    return $this->template->load('admin', 'penjualan/piutang', [
      'page_title' => "Pembayaran Piutang Oleh Pelanggan",
    ]);
  }
}
