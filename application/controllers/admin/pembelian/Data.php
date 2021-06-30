<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Pembelian_model" => "pembelian"]);
    if (!in_role([1, "Admin"]) && !can("Pembelian"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Pembelian Barang");
  }
  public function hapus($id)
  {
    $pembelian = $this->pembelian->first($id);
    $pembelian->barangs()->detach();
    $pembelian->delete();
  }

  public function index()
  {
    return $this->template->load('admin', 'pembelian/list', [
      'page_title' => "Riwayat Pembelian Barang",
    ]);
  }
  public function get($id_pembelian)
  {
    $pembelian = $this->pembelian->select("IFNULL((SELECT SUM(jumlah) FROM transaksi WHERE transaksi.kode_transaksi=pembelians.id AND transaksi.jenis='pengeluaran' LIMIT 1) ,0 ) as dibayar")->first($id_pembelian);
    return $this->template->view("admin", "pembelian/partials/_tbody_barang", ['pembelian' => $pembelian]);
  }
  public function details($id_pembelian, $jenis = null)
  {
    $pembelian = $this->pembelian->first($id_pembelian);
    if ($jenis)
      return $this->template->view("admin", "pembelian/partials/_tbody_barang", ['pembelian' => $pembelian]);
    return $this->template->view("admin", "pembelian/partials/_details_pembelian", ['pembelian' => $pembelian]);
  }
  public function datatable()
  {
    $params = $this->params_datatable();
    if ($this->input->post("status_bayar") == "kredit") {
      $this->pembelian->select("IFNULL((SELECT SUM(jumlah) FROM transaksi WHERE transaksi.kode_transaksi=pembelians.id AND transaksi.jenis='pengeluaran' LIMIT 1) ,0 ) as dibayar")
        ->having("dibayar < total");
      $this->pembelian->where("status_bayar", "kredit");
    }

    $pembelians = $this->pembelian->get_data($params);

    $recordsFiltered = $this->pembelian->search_and_order($params)->count();

    foreach ($pembelians as $i => $pembelian) {
      $pembelians[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ?  $params['start'] + $i + 1 : $recordsFiltered - $params['start'] - $i;
      $pembelians[$i]->total_rp = rupiah($pembelian->total);
      if (property_exists($pembelian, 'dibayar'))
        $pembelians[$i]->dibayar_rp = rupiah($pembelian->dibayar);
      $pembelians[$i]->jumlah_bayar_rp = rupiah($pembelian->jumlah_bayar);
      $pembelians[$i]->kembalian_rp = rupiah($pembelian->kembalian);
      $pembelians[$i]->dibuat_pada =  _ago($pembelian->created_at);
      $pembelians[$i]->pilih =  $this->template->view("admin", "pembelian/partials/_btn_pilih", ["pembelian" => $pembelian], true);
      $pembelians[$i]->action =  $this->template->view("admin", "pembelian/partials/_btn_detail_pembelian", ["pembelian" => $pembelian], true);
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "draw" => $this->input->get_post("draw") ?? 0,
        "recordsTotal" => $this->pembelian->where($params['where'] ?? [])->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $pembelians,
      ]));
  }
  private function params_datatable()
  {
    $params = [
      "draw" => $this->input->get_post("draw") ?? 0,
      "length" => $this->input->get_post("length") ?? 10,
      "start" => $this->input->get_post("start") ?? 0
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
