<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Penjualan_model", "penjualan");
    $this->load->model("Barang_model", "barang");
    $this->load->model("Keranjang_model", "keranjang");
    $this->load->model("PenjualanBarang_model", "penjualanBrg");
  }
  public function index()
  {
    if (!can("Kasir")  || !in_role(["Kasir"]))
      return  $this->not_permition(403, "Anda Tidak Dapat Akses Menu Kasir");

    $data = [
      'page_title' => "Penjualan Barang",
      "penjualan" => new $this->penjualan,
    ];
    $this->template->load('admin', 'kasir/penjualan/index', $data);
  }

  public function details($id_penjualan)
  {
    return  $this->template->view('admin', 'kasir/penjualan/_details', [
      "penjualan" => $this->penjualan->first($id_penjualan)
    ]);
  }
  public function bayar()
  {
    $keranjangs = $this->keranjang->getDatatable();
    $penjualan = $this->penjualan->save([
      "kasir_id" => user()->id,
      "no_invoice" => $this->input->post("no_invoice"),
      "created_at" => $this->input->post("tgl_invoice"),
      "pelanggan_id" => $this->input->post("pelanggan_id"),
      "jumlah_bayar" => (float)    str_replace(["Rp.", ".", " "], '', $this->input->post("jumlah_bayar")),
      "uang_bayar" => (float)    str_replace(["Rp.", ".", " "], '', $this->input->post("uangBayar")),
      "kembalian" => (float)    str_replace(["Rp.", ".", " "], '', $this->input->post("kembalian")),
    ]);
    foreach ($keranjangs['data'] as $key => $keranjang) {
      $brgJual = new  $this->penjualanBrg;
      $barang = $keranjang->barang;

      $brgJual->save([
        "penjualan_id" => $penjualan->id,
        "barang_id" => $keranjang->barang_id,
        "harga" => $barang->harga,
        "jumlah" => $keranjang->jumlah_barang,
        "total_harga" => $keranjang->jumlah_barang * $barang->harga,
      ]);
      $barang->stok -= $keranjang->jumlah_barang;
      $barang->update();
      $keranjang->delete();
    }
    return redirect(base_url("kasir/invoice/penjualan/" . $penjualan->no_invoice));
  }
  public function datatable()
  {
    $params =  $this->params_datatable();

    $params["where"] = [];
    if ($this->input->get_post("jenis"))
      $params['where']["kasir_id"] = user()->id;
    if ($this->input->get_post("mulai_tanggal"))
      $params['where']["penjualans.created_at >="] = $this->input->get_post("mulai_tanggal");
    if ($this->input->get_post("sampai_tanggal"))
      $params['where']["penjualans.created_at <="] = $this->input->get_post("sampai_tanggal");
    $params['columns'] = ["users.name"];

    $penjualans = $this->penjualan->select("users.name as nama_pelanggan")->join("users", "users.id=penjualans.pelanggan_id")->get_data($params);
    $recordsFiltered = $this->penjualan->select("users.name as nama_pelanggan")->join("users", "users.id=penjualans.pelanggan_id")->search_and_order($params)->count();
    foreach ($penjualans as $i => $penjualan) {
      $penjualans[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $penjualans[$i]->text =   $penjualan->no_invoice;
      $penjualans[$i]->jumlah_bayar = rupiah($penjualan->jumlah_bayar);
      $penjualans[$i]->uang_bayar = rupiah($penjualan->uang_bayar);
      $penjualans[$i]->kembalian = rupiah($penjualan->kembalian);
      $penjualans[$i]->dibuat_pada =  _ago($penjualan->created_at);
      $penjualans[$i]->action = $this->template->view('admin', 'kasir/penjualan/partials/_action_datatable', [
        "penjualan" => $penjualan
      ], true);

      $with = $this->input->get_post("with");
      if ($with) {
        $with = is_string($with) ? [$with] : $with;
        foreach ($with as $v) {
          $penjualans[$i]->{$v};
        }
      }
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "recordsTotal" => $this->penjualan->select("users.name as nama_pelanggan")->join("users", "users.id=penjualans.pelanggan_id")->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $penjualans,
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
