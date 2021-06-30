<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Pembelian_model" => "pembelian", "Transaksi_model" => "transaksi"]);
    if (!in_role([1, "Admin"]) && !can("Transaksi Keuangan"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Keuangan");
  }

  public function index()
  {
  }
  public function pembelian()
  {
    $pembelian = $this->pembelian->where("id", $this->input->post("kode_transaksi"))->first();
    if (!$pembelian)
      return $this->output->set_content_type("application/json")->set_output(json_encode([
        'status' => false,
        "message" => "Gagal Melakukan Transaksi",
      ]));
    $data = [
      "kode_transaksi" => $this->input->post("kode_transaksi"),
      "debit_name" => "Utang Pembelian",
      "kredit_name" => $this->input->post("kredit"),
      "jenis" => "pengeluaran",
      "jumlah" => $this->input->post("jumlah"),
      "kembalian" => $this->input->post("kembalian"),
    ];
    $transaksi = $this->transaksi->save($data);
    return $this->output->set_content_type("application/json")->set_output(json_encode([
      'status' => true,
      "message" => "Transaksi Berhasil",
      "pembelian" => $pembelian
    ]));
  }
}
