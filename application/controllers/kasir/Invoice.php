<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Invoice extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!can("Kasir")  && !in_role(["Kasir"]))
      return  $this->not_permition(403, "Anda tidak punya akses ke invoice");
    $this->load->model("Penjualan_model", "penjualan");
  }
  public function index($id = null)
  {
  }
  public function penjualan($no_invoice)
  {
    $data = [
      'page_title' => "Invoice Penjualan Barang",
      "penjualan" => $this->penjualan->where("no_invoice", $no_invoice)->first()
    ];
    return $this->template->load('admin', 'kasir/penjualan/invoice', $data);
  }
}
