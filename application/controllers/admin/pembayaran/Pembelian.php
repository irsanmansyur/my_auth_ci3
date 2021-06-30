<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Pembelian_model" => "pembelian", "Keranjang_pembelian_model" => "keranjang"]);
    if (!in_role([1, "Admin"]) && !can("Pembayaran Pembelian"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Pembayaran Pembelian");
  }

  public function index()
  {
    return $this->template->load('admin', 'pembelian/pembayaran', [
      'page_title' => "Pembayaran Pembelian ke Suplier",
    ]);
  }

  public function bayar_piutang()
  {
    $data = [
      "kode_transaksi" => $this->input->post("kode_transaksi"),
      "kredit_name" => $this->input->post("kode_transaksi"),
    ];
  }
}
