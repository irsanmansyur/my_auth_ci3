<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan_model extends MY_Model
{
  protected $_table = 'satuans';

  protected $_rules = [
    array(
      'field' => 'nama',
      'label' => 'Nama Kategori',
      'rules' => 'required|min_length[3]'
    ),
    array(
      'field' => 'kode',
      'label' => 'Kode Kategori',
      'rules' => 'min_length[3]',
      "unique" => "kode"
    ),
  ];

  public function __construct()
  {
    parent::__construct();
    $this->getLastId("kode", "SAT-" . date("Ymd") . "-");
  }



  /**
   * Datatable
   * 
   */
  public function getDatatable()
  {

    $this->searchAndOrder();
    $totalCount = $this->db->count_all_results($this->getTable("name"));

    $this->searchAndOrder();
    if (in_array("created_at", $this->getTable("fields"))) {
      if ($this->input->get_post("byMonth")) {
        $this->where("MONTH(created_at)", $this->input->get_post("byMonth"));
      }
      if ($this->input->get_post("byYear")) {
        $this->where("YEAR(created_at)", $this->input->get_post("byYear"));
      }
      if ($this->input->get_post("byDay")) {
        $this->where("DAY(created_at)", $this->input->get_post("byDay"));
      }
    }
    $countFilter = $this->db->count_all_results($this->getTable("name"));

    $this->searchAndOrder();
    if (in_array("created_at", $this->getTable("fields"))) {
      if ($this->input->get_post("byMonth")) {
        $this->where("MONTH(created_at)", $this->input->get_post("byMonth"));
      }
      if ($this->input->get_post("byYear")) {
        $this->where("YEAR(created_at)", $this->input->get_post("byYear"));
      }
      if ($this->input->get_post("byDay")) {
        $this->where("DAY(created_at)", $this->input->get_post("byDay"));
      }
    }





    $this->db->limit(intval($this->input->get_post("length") ?? 10), intval($this->input->get_post("start") ?? 0));

    $data = $this->all();

    $output = array(
      "draw" => intval($this->input->get_post("draw") ?? 0),
      "recordsTotal" => $totalCount,
      "recordsFiltered" => $countFilter,
      "data" => $data,
      "dataTable" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
    );
    return $output;
  }
  private function searchAndOrder()
  {
    if (in_array("created_at", $this->getTable("fields")))
      $this->kategori->select("MONTH(created_at) as byMonth,YEAR(created_at) as byYear,DAY(created_at) as byDay");
    if ($this->input->get_post("search") && isset($this->input->get_post("search")['value'])) {
      $this->like("nama", $this->input->get_post("search")['value']);
      $this->or_like("kode", $this->input->get_post("search")['value']);
      isset($this->getTable("fields")['created_at']) &&  $this->or_like("byDay", $this->input->get_post("search")['value']);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byMonth", $this->input->get_post("search")['value']);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byYear", $this->input->get_post("search")['value']);
    }
    if ($this->input->get_post("order")) {
      $orderBy = $this->input->get_post("columns")[$this->input->get_post("order")['0']['column']]['name'];
      $this->db->order_by($orderBy, $this->input->get_post("order")['0']['dir']);
    }
  }
}
