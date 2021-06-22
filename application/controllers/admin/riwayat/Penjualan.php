<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
    $this->load->model("Keranjang_model", "keranjang");
    $this->load->model("Penjualan_model", "penjualan");
    $this->load->model("PenjualanBarang_model", "penjualanBrg");
  }
  public function index()
  {
    if (!can("Kasir")  || !in_role(["Kasir"]))
      return  $this->not_permition(403, "Kategori Ini Khusus Admin Atau Dapat Akses Menu Kasir");


    $data = [
      'page_title' => "Riwayat Penjualan Oleh Kasir",
    ];
    $this->template->load('admin', 'penjualan/riwayat', $data);
  }
  public function dataTable()
  {
    return $this->output->set_content_type("application/json")
      ->set_output(
        json_encode(array_merge($this->data, $this->penjualan->getDatatable()))
      );
  }
}
