<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Transaksi_model" => "transaksi"]);
    if (!in_role([1, "Admin"]) && !can("Transaksi"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Jurnal");
  }

  public function index()
  {
    return $this->template->load('admin', 'transaksi/jurnal', [
      'page_title' => "Jurnal Transaksi",
    ]);
  }

  public function datatable($params = [])
  {
    $params = array_merge($this->params_datatable(), $params);

    $transaksis = $this->transaksi->get_data($params);

    $recordsFiltered = $this->transaksi->search_and_order($params)->count();

    foreach ($transaksis as $i => $transaksi) {
      $transaksis[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ?  $params['start'] + $i + 1 : $recordsFiltered - $params['start'] - $i;
      $transaksis[$i]->tanggal =  date("d, F Y H:i", strtotime($transaksi->created_at));
      $transaksis[$i]->dibuat_pada =  _ago($transaksi->created_at);
      $transaksis[$i]->jumlah_rp = rupiah($transaksi->jumlah);
      $transaksis[$i]->keterangan_tp = $transaksi->debit_name . "<br>" .
        '<span class="pl-2 pl-md-4">' . $transaksi->kredit_name . '</span>';
      $transaksis[$i]->debit_tp =
        "<div class='d-flex justify-content-between'><span>Rp.</span>" .
        '<span>' . rupiah($transaksi->jumlah) . '</span></div>';
      $transaksis[$i]->kredit_tp = "<br/>" .
        "<div class='d-flex justify-content-between'><span>Rp.</span>" .
        '<span>' . rupiah($transaksi->jumlah) . '</span></div>';
    }

    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "draw" => $this->input->get_post("draw") ?? 0,
        "recordsTotal" => $this->transaksi->where($params['where'] ?? [])->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $transaksis,
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
