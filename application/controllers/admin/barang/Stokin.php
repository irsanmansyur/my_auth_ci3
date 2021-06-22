<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stokin extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Restok_model", "restok");
    $this->load->model("Suplier_model", "suplier");
  }


  public function index($id = null)
  {
    return $this->template->load('admin', 'transaksi/stokin/list', [
      "page_title" => "Stokin Barang",
    ]);
  }
  public function tambah()
  {
    $this->form_validation->set_rules("pilih_barang", "Pilih Barang", "required");
    $this->form_validation->set_rules("stock_awal", "Stok Awal", "required|numeric");
    $this->form_validation->set_rules("suplier_id", "Suplier", "required|numeric");
    $this->form_validation->set_rules("jumlah", "Jumlah Stok In", "required|numeric");
    if ($this->form_validation->run()) {
      $data_restok = [
        "jenis" => "stock_in",
        "barang_id" => $this->input->post("barang_id"),
        "catatan" => $this->input->post("catatan"),
        "suplier_id" => $this->input->post("suplier_id"),
        "stock_awal" => $this->input->post("stock_awal"),
        "jumlah" => $this->input->post("jumlah"),
      ];

      $restok = $this->restok->save($data_restok);

      $barang = $restok->barang;
      $barang->update(["stok" => $restok->stock_awal + $restok->jumlah]);
      return redirect("admin/barang/stokin");
    }
    $data = [
      "restok" => new $this->restok,
      'page_title' => "Tambah Stockin",
    ];
    $this->template->load('admin', 'transaksi/stokin/tambah', $data);
  }

  public function edit($id)
  {
    $restok = $this->restok->first($id);
    $this->form_validation->set_rules("pilih_barang", "Pilih Barang", "required");
    $this->form_validation->set_rules("stock_awal", "Stok Awal", "required|numeric");
    $this->form_validation->set_rules("suplier_id", "Suplier", "required|numeric");
    $this->form_validation->set_rules("jumlah", "Jumlah Stok In", "required|numeric");
    if ($this->form_validation->run()) {
      $barang = $restok->barang;
      $stok = $barang->stok -  $restok->jumlah;

      $data_restok = [
        "jenis" => "stock_in",
        "barang_id" => $this->input->post("barang_id"),
        "catatan" => $this->input->post("catatan"),
        "suplier_id" => $this->input->post("suplier_id"),
        "stock_awal" => $stok,
        "jumlah" => $this->input->post("jumlah"),
      ];


      $restok->update($data_restok);
      $barang->update(["stok" => $stok + $data_restok['jumlah']]);
      $this->session->set_flashdata("success", "Stokin Update");
      return redirect("admin/barang/stokin");
    }

    $data = [
      "restok" => $restok,
      'page_title' => "Edit Stockin",
    ];

    $this->template->load('admin', 'transaksi/stokin/edit', $data);
  }

  public function  delete($id)
  {
    $restok = $this->restok->first($id);
    if (!$restok || !in_role([1, "Admin"]))
      return  $this->not_permition(403, "Satuan Ini Khusus  Admin Atau Dapat Akses  Satuan Master");
    $barang = $restok->barang;
    $barang->update(["stok" => $barang->stok - $restok->jumlah]);
    $this->session->set_flashdata("success", "Satuan Dihapus");
    return json_encode($restok->delete());
  }

  public function datatable()
  {
    $params =  $this->params_datatable();
    $params['select'] = "barangs.nama as nama_barang";
    if ($this->input->get_post("jenis"))
      $params['where'] = ["jenis" => $this->input->get_post("jenis")];


    $restoks = $this->restok->get_data($params);

    $recordsFiltered = $this->restok->search_and_order($params)->count();
    foreach ($restoks as $i => $restok) {
      $restoks[$i]->urut = isset($params['order']) &&  $params['order'][1] == "asc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $restoks[$i]->dibuat_pada =  _ago($restok->created_at);

      $with = $this->input->get_post("with");
      if ($with) {
        $with = is_string($with) ? [$with] : $with;
        foreach ($with as $v) {
          $restoks[$i]->{$v};
        }
      }
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "recordsTotal" => $this->restok->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $restoks,
      ]));
  }
  private function params_datatable()
  {
    $page = $this->input->get_post("page") ?? 1;
    $length = $this->input->get_post("length") ?? 10;
    $params = [
      "length" => $length,
      "start" =>  $this->input->get_post("start") ?? $page * $length - $length
    ];
    $order = $this->input->get_post("order");
    if ($order) {
      $order_column = $this->input->get_post("columns")[$order['0']['column']]['name'];
      $params['order'] = [$order_column, $order['0']['dir']];
    }

    $search_val = $this->input->get_post("search");
    $search =  is_string($search_val) ? $search_val : (is_array($search_val) ? $search_val['value'] : null);
    if ($search)
      $params["search"] = $search;
    return $params;
  }
}
