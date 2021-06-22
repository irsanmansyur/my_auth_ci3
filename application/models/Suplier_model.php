<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suplier_model extends MY_Model
{
  protected $_table = 'supliers';

  protected $_rules = [
    array(
      'field' => 'nama',
      'label' => 'Nama Suplier',
      'rules' => 'required|min_length[3]'
    ),
    array(
      'field' => 'kode',
      'label' => 'Kode Suplier',
      'rules' => 'required|min_length[3]',
      "unique" => "kode"
    ),
    array(
      'field' => 'alamat',
      'label' => 'Alamat',
      'rules' => 'required',
    ),
    array(
      'field' => 'telp',
      'label' => 'Nomor Telpon',
      'rules' => 'required',
    ),
    array(
      'field' => 'status',
      'label' => 'status',
      'rules' => 'required|in_list[0,1,2]',
    )
  ];

  public function __construct()
  {
    parent::__construct();
    $this->getLastId("kode", "SPL-" . date("Ymd") . "-");
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

    if ($this->input->get_post("length") != -1)
      $this->db->limit($this->input->get_post("length"), $this->input->get_post("start"));
    $data = $this->all();
    foreach ($data as $i => $spl) {
      $data[$i]->dibuat_pada = _ago($spl->created_at);
    }

    $output = array(
      "draw" => $this->input->get_post("draw") ?? 0,
      "recordsTotal" => $totalCount,
      "recordsFiltered" => $countFilter,
      "data" => $data,
      "dataTable" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
    );
    return $output;
  }
  private function searchAndOrder()
  {
    if (in_array("supliers.created_at", $this->getTable("fields")))
      $this->select("MONTH(supliers.created_at) as byMonth,YEAR(supliers.created_at) as byYear,DAY(supliers.created_at) as byDay");

    if ($this->input->get_post("search") && isset($this->input->get_post("search")['value'])) {
      $this->like("supliers.nama", $this->input->get_post("search")['value']);
      $this->or_like("supliers.kode", $this->input->get_post("search")['value']);
      $this->or_like("supliers.alamat", $this->input->get_post("search")['value']);
      isset($this->getTable("fields")['created_at']) &&  $this->or_like("byDay", $this->input->get_post("search")['value']);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byMonth", $this->input->get_post("search")['value']);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byYear", $this->input->get_post("search")['value']);
    }
    if ($this->input->get_post("order")) {
      $orderBy = $this->input->get_post("columns")[$this->input->get_post("order")['0']['column']]['name'];
      $this->db->order_by($orderBy, $this->input->get_post("order")['0']['dir']);
    }
  }

  public function get_data($params = [])
  {
    $select = $params['select'] ?? $this->_table . ".*";
    $this->db->select($select);
    $this->search_and_order($params);
    if (isset($params['length']) && isset($params['start']))
      $this->db->limit($params['length'], $params['start']);
    return $this->all();
  }
  public function search_and_order($params = [])
  {
    if (isset($params['search'])) {
      $this->db->group_start();
      $this->like($this->_table . ".nama",   $params["search"]);
      $this->or_like($this->_table . ".alamat",  $params["search"]);
      $this->or_like($this->_table . ".telp",  $params["search"]);
      $this->or_like($this->_table . ".kode",  $params["search"]);
      $this->or_like("DAY($this->_table.created_at)",   $params["search"]);
      $this->or_like("MONTH($this->_table.created_at)",   $params["search"]);
      $this->db->group_end();
    }
    if (isset($params['order'])) {
      $this->db->order_by($params['order'][0], $params['order'][1]);
    }
    return $this;
  }
}
