<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Restok_model extends MY_Model
{
  protected $_table = 'restok';

  protected $_rules = [
    array(
      'field' => 'barang_id',
      'label' => 'Barang',
      'rules' => 'required'
    ),
    array(
      'field' => 'jenis',
      'label' => 'Jenis',
      'rules' => 'required'
    ),
    array(
      'field' => 'catatan',
      'label' => 'Catatan',
      'rules' => 'required',
    ),
    array(
      'field' => 'harga_jual',
      'label' => 'Harga Jual',
      'rules' => 'required|numeric',
    ),
    array(
      'field' => 'jumlah',
      'label' => 'jumlah',
      'rules' => 'required|numeric',
    ),
    array(
      'field' => 'harga',
      'label' => 'Harga',
      'rules' => 'required|numeric',
    )
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function barang()
  {
    return $this->belongsTo("Barang_model");
  }
  public function suplier()
  {
    return $this->belongsTo("Suplier_model");
  }


  /**
   * Datatable
   * 
   */
  public function getDatatable($tipe = null)
  {
    $this->searchAndOrder();
    if ($tipe)
      $this->where("restok.jenis", $tipe);
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
    if ($tipe)
      $this->where("restok.jenis", $tipe);
    $countFilter = $this->db->count_all_results($this->getTable("name"));

    $this->searchAndOrder();
    if ($tipe)
      $this->where("restok.jenis", $tipe);
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

    $start = $this->input->get_post("start") ?? 0;
    if ($this->input->get_post("length") != -1)
      $this->db->limit($this->input->get_post("length"), $this->input->get_post("start"));
    $data = $this->all();

    foreach ($data as $i => $brg) {
      $data[$i]->number = $start + $i + 1;
      $data[$i]->dibuat_pada = _ago($brg->created_at);
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
    $this->select("barangs.kode,restok.catatan,restok.stock_awal,restok.jumlah,barangs.nama,kategoris.nama as nama_kategori,satuans.nama as nama_satuan,supliers.nama as suplier_nama");
    $this->join("barangs", "barangs.id=restok.barang_id");
    $this->join("supliers", "supliers.id=restok.suplier_id", "LEFT");
    $this->join("satuans", "satuans.id=barangs.satuan_id");
    $this->join("kategoris", "kategoris.id=barangs.kategori_id");
    if (in_array("restok.created_at", $this->getTable("fields")))
      $this->select("MONTH(restok.created_at) as byMonth,YEAR(restok.created_at) as byYear,DAY(restok.created_at) as byDay");

    $search_val = $this->input->get_post("search");
    $search =  is_string($search_val) ? $search_val : (is_array($search_val) ? $search_val['value'] : '');
    if ($search) {
      $this->db->group_start();
      $this->like("satuans.nama",   $search);
      $this->or_like("barangs.nama",   $search);
      $this->or_like("kategoris.nama",   $search);
      $this->or_like("barangs.kode",   $search);
      isset($this->getTable("fields")['created_at']) &&  $this->or_like("byDay",   $search);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byMonth",   $search);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byYear",   $search);
      $this->db->group_end();
    }
    if ($this->input->get_post("order")) {
      $orderBy = $this->input->get_post("columns")[$this->input->get_post("order")['0']['column']]['name'];
      $this->db->order_by($orderBy, $this->input->get_post("order")['0']['dir']);
    }
  }

  public function get_data($params = [])
  {
    $this->search_and_order($params);
    if (isset($params['length']))
      $this->db->limit($params['length'], $params['start']);

    if (isset($params['select'])) {
      $this->select($params['select']);
    }
    return $this->all();
  }
  public function search_and_order($params = [])
  {
    $this->join("barangs", "barangs.id=restok.barang_id");
    $this->join("supliers", "supliers.id=restok.suplier_id", "LEFT");
    if (isset($params['search'])) {
      $this->db->group_start();
      $this->like($this->_table . ".jenis",   $params["search"]);
      $this->or_like($this->_table . ".catatan",  $params["search"]);
      $this->or_like($this->_table . ".jumlah",  $params["search"]);
      $this->or_like("DAY($this->_table.created_at)",   $params["search"]);
      $this->or_like("MONTH($this->_table.created_at)",   $params["search"]);
      $this->or_like("barangs.nama",  $params["search"]);
      $this->or_like("supliers.nama",  $params["search"]);
      $this->db->group_end();
    }
    if (isset($params['order'])) {
      $this->db->order_by($params['order'][0], $params['order'][1]);
    }
    if (isset($params['where']))
      $this->where($params['where']);
    return $this;
  }
}
