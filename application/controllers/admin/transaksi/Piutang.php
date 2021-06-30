<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Penjualan_model" => "penjualan", "Transaksi_model" => "transaksi"]);
    if (!in_role([1, "Admin"]) && !can("Transaksi Keuangan"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Keuangan");
  }

  public function index()
  {
  }
  public function penjualan()
  {
    $penjualan = $this->penjualan->where("no_invoice", $this->input->post("no_invoice"))->first();
    if (!$penjualan)
      return $this->output->set_content_type("application/json")->set_output(json_encode([
        'status' => false,
        "message" => "Gagal Melakukan Transaksi",
      ]));
    $data = [
      "kode_transaksi" => $penjualan->no_invoice,
      "debit_name" => "Piutang Penjualan",
      "kredit_name" => $this->input->post("kredit"),
      "jenis" => "pemasukan",
      "jumlah" => $this->input->post("jumlah"),
      "kembalian" => $this->input->post("kembalian"),
    ];
    $transaksi = $this->transaksi->save($data);
    return $this->output->set_content_type("application/json")->set_output(json_encode([
      'status' => true,
      "message" => "Transaksi Berhasil",
      "penjualan" => $penjualan
    ]));
  }
}
