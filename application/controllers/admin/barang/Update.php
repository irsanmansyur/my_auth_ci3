<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    header("Access-Control-Allow-Origin: *");
    $this->load->model(["Barang_model" => "barang"]);
  }

  public function index($id = null)
  {
  }
  public function from_pembelian($id_barang)
  {
    $barang = $this->barang->first($id_barang);
    if (!$barang)
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode([
          "status" => false,
          "message" => "Gagal Update Harga"
        ]));
    $barang->update([
      "harga_jual" => $this->input->input_stream('harga_jual'),
      "harga_beli" => $this->input->input_stream('harga_beli')
    ]);
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "status" => true,
        "message" => "Harga Barang Di Update",
        "barang" => $barang
      ]));
  }
}
