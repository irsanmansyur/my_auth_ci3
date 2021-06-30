<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Penjualan_model" => "penjualan"]);
    if (!in_role([1, "Admin"]) && !can("Penjualan"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Penjualan Barang");
  }
  public function hapus($id)
  {
    $penjualan = $this->penjualan->first($id);
    $penjualan->barangs()->detach();
    $penjualan->delete();
  }

  public function index()
  {
    return $this->template->load('admin', 'penjualan/list', [
      'page_title' => "Riwayat Penjualan Barang",
    ]);
  }
  public function get($id_penjualan)
  {
    $penjualan = $this->penjualan->select("IFNULL((SELECT SUM(jumlah) FROM transaksi WHERE transaksi.kode_transaksi=penjualans.no_invoice AND transaksi.jenis='pemasukan' LIMIT 1) ,0 ) as dibayar")->first($id_penjualan);
    return $this->template->view("admin", "penjualan/partials/_details", ['penjualan' => $penjualan]);
  }
  public function details($id_penjualan, $jenis = null)
  {
    $penjualan = $this->penjualan->first($id_penjualan);
    if ($jenis)
      return $this->template->view("admin", "penjualan/partials/_tbody_barang", ['penjualan' => $penjualan]);
    return $this->template->view("admin", "penjualan/partials/_details_penjualan", ['penjualan' => $penjualan]);
  }
  public function datatable($params = [])
  {
    $params = array_merge($this->params_datatable(), $params);
    if ($this->input->post("status_bayar") == "kredit") {
      $this->penjualan->select("IFNULL((SELECT SUM(jumlah) FROM transaksi WHERE transaksi.kode_transaksi=penjualans.no_invoice AND transaksi.jenis='pemasukan' LIMIT 1),0) as dibayar")
        ->where("status_bayar", "kredit")
        ->having("dibayar < jumlah_bayar");
    }
    $this->penjualan->join("users", "penjualans.pelanggan_id=users.id")->select("users.name as pelanggan");

    $penjualans = $this->penjualan->get_data($params);

    $recordsFiltered = $this->penjualan->search_and_order($params)->count();

    foreach ($penjualans as $i => $penjualan) {
      $penjualans[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ?  $params['start'] + $i + 1 : $recordsFiltered - $params['start'] - $i;
      $penjualans[$i]->jumlah_bayar_rp = rupiah($penjualan->jumlah_bayar, "Rp. ");
      if (property_exists($penjualan, 'dibayar')) {
        $penjualans[$i]->dibayar_rp = rupiah($penjualan->dibayar);
        $penjualans[$i]->pinjaman_rp = rupiah($penjualan->jumlah_bayar - $penjualan->dibayar, "Rp. ");
      }

      $penjualans[$i]->kembalian_rp = rupiah($penjualan->kembalian);
      $penjualans[$i]->dibuat_pada =  _ago($penjualan->created_at);
      $penjualans[$i]->jatuh_tempo_f = date("d, F Y", strtotime($penjualan->created_at));
      $penjualans[$i]->pilih =  $this->template->view("admin", "penjualan/partials/_btn_pilih", ["penjualan" => $penjualan], true);
    }

    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "draw" => $this->input->get_post("draw") ?? 0,
        "recordsTotal" => $this->penjualan->where($params['where'] ?? [])->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $penjualans,
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
