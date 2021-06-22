<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stokout extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Restok_model", "restok");
    $this->load->model("Barang_model", "barang");
  }


  public function index($id = null)
  {
    return $this->template->load('admin', 'transaksi/stokout/list', [
      "page_title" => "Stokout Barang",
    ]);
  }
  public function tambah()
  {
    $this->form_validation->set_rules("inputKode", "Kode barang", "required");
    $this->form_validation->set_rules("stock_awal", "Stok Awal", "required|numeric");
    $this->form_validation->set_rules("catatan", "Catatan", "required");
    $this->form_validation->set_rules("jumlah", "Jumlah Stok Out", "required|numeric|callback_stock_chek");
    if ($this->input->server('REQUEST_METHOD') === 'POST')
      $this->_barang = $this->barang->first($this->input->post("barang_id"));
    if ($this->form_validation->run()) {
      $data_restok = [
        "jenis" => "stock_out",
        "barang_id" => $this->input->post("barang_id"),
        "catatan" => $this->input->post("catatan"),
        "stock_awal" => $this->input->post("stock_awal"),
        "jumlah" => $this->input->post("jumlah"),
        "created_at" => $this->input->post("created_at"),
      ];

      $restok = $this->restok->save($data_restok);

      $barang = $restok->barang;
      $barang->update(["stok" => $restok->stock_awal - $restok->jumlah]);
      return redirect("admin/barang/stokout");
    }
    $data = [
      "restok" => new $this->restok,
      'page_title' => "Tambah Stockout",
    ];
    $this->template->load('admin', 'transaksi/stokout/tambah', $data);
  }
  public function edit($id)
  {
    $restok =  $this->restok->first($id);
    if (!$restok || !in_role([1, "Admin"]))
      return  $this->not_permition(403, "Stock Out barang Khusus Admin Atau Dapat Mengakses Stock Out Barang");

    $this->form_validation->set_rules("inputKode", "Kode barang", "required");
    $this->form_validation->set_rules("stock_awal", "Stok Awal", "required|numeric");
    $this->form_validation->set_rules("catatan", "Catatan", "required");
    $this->form_validation->set_rules("jumlah", "Jumlah Stok Out", "required|numeric|callback_stock_chek");
    $barang =  $restok->barang;
    $stok = $barang->stok = $barang->stok + $restok->jumlah;
    if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post("barang_id") != $barang->id) {
      $barang->update(["stok" => $stok]);
      $barang  = $this->barang->first($this->input->post("barang_id"));
      $stok = $barang->stok;
    }
    $this->_barang = $barang;
    if ($this->form_validation->run()) {

      $data_restok = [
        "jenis" => "stock_out",
        "barang_id" => $this->input->post("barang_id"),
        "catatan" => $this->input->post("catatan"),
        "stock_awal" => $stok,
        "jumlah" => $this->input->post("jumlah"),
      ];
      $restok->update($data_restok);
      $barang->update(["stok" => $stok - $data_restok['jumlah']]);
      $this->session->set_flashdata("success", "Stok Barang Di Kurangi.!");
      return redirect("admin/barang/stokout");
    }

    $data = [
      "restok" => $restok,
      'page_title' => "Edit Stockout Barang",
    ];

    $this->template->load('admin', 'transaksi/stokout/edit', $data);
  }
  public function stock_chek($str)
  {
    if ($str > $this->_barang->stok) {
      $this->form_validation->set_message('stock_chek', '{field} Harus Lebih rendah dari Stok barang');
      return FALSE;
    } else {
      return TRUE;
    }
  }
  public function  delete($id)
  {
    $restok = $this->restok->first($id);
    if (!$restok || !in_role([1, "Admin"]))
      return  $this->not_permition(403, "Stock Out barang Khusus Admin Atau Dapat Mengakses Stock Out Barang");

    $barang = $restok->barang;
    $barang->update(["stok" => $barang->stok + $restok->jumlah]);
    $this->session->set_flashdata("success", "Stockout barang Dihapus");
    return json_encode($restok->delete());
  }
  public function getData()
  {
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode($this->restok->getDatatable("stock_out")));
  }
}
