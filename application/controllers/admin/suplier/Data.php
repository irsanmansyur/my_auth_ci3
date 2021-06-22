<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Suplier_model", "suplier");
  }

  public function index($id = null)
  {
    return $this->template->load('admin', 'master/suplier/index', [
      "page_title" => "Daftar suplier",
      "supliers"  => $this->suplier->all(),
    ]);
  }
  public function getData()
  {
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode($this->suplier->getDatatable()));
  }
  public function delete($id)
  {
    $suplier = $this->suplier->first($id);
    if (!$suplier || !in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Satuan Ini Khusus  Admin Atau Dapat Akses  Satuan Master");
    $this->session->set_flashdata("success", "Satuan Dihapus");
    return json_encode($suplier->delete());
  }

  public function datatable()
  {
    $params = $this->params_datatable();
    $supliers = $this->suplier->get_data($params);
    $recordsFiltered = $this->suplier->search_and_order($params)->count();
    foreach ($supliers as $i => $suplier) {
      $supliers[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $supliers[$i]->text =  $suplier->nama;
      $supliers[$i]->dibuat_pada =  _ago($suplier->created_at);
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "recordsTotal" => $this->suplier->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $supliers,
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
