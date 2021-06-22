<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang_model extends MY_Model
{
  protected $_table = 'keranjangs';

  public function __construct()
  {
    parent::__construct();
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
    $lastQuery = $this->db->last_query();
    foreach ($data as $i => $brg) {
      $data[$i]->dibuat_pada = _ago($brg->created_at);
      $data[$i]->harga = rupiah($brg->harga_jual);
      $data[$i]->total_harga = rupiah($brg->harga_jual * $brg->jumlah_barang);
    }

    $output = array(
      "draw" => $this->input->get_post("draw") ?? 0,
      "recordsTotal" => $totalCount,
      "recordsFiltered" => $countFilter,
      "data" => $data,
      "last_query" => $lastQuery,
      "dataTable" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
    );
    return $output;
  }
  private function searchAndOrder()
  {
    $this->select("barangs.nama,barangs.kode,barangs.harga_jual");
    $this->join("barangs", "barangs.id=keranjangs.barang_id");
    $this->where("keranjangs.kasir_id", user()->id);
    if (in_array("created_at", $this->getTable("fields")))
      $this->select("MONTH(keranjangs.created_at) as byMonth,YEAR(keranjangs.created_at) as byYear,DAY(keranjangs.created_at) as byDay");

    $search_val = $this->input->get_post("search");
    $search =  is_string($search_val) ? $search_val : (is_array($search_val) ? $search_val['value'] : '');
    if ($search) {
      $this->like("barangs.nama", $search);
      $this->or_like("barangs.kode", $search);

      isset($this->getTable("fields")['created_at']) &&  $this->or_like("byDay", $search);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byMonth", $search);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byYear", $search);
    }
    if ($this->input->get_post("order")) {
      $orderBy = $this->input->get_post("columns")[$this->input->get_post("order")['0']['column']]['name'];
      $this->db->order_by($orderBy, $this->input->get_post("order")['0']['dir']);
    }
  }
  public function barang()
  {
    return $this->belongsTo("Barang_model", "barang_id");
  }



  public function get_data($params = [])
  {
    $this->search_and_order($params);
    if (isset($params['length']))
      $this->db->limit($params['length'], $params['start']);
    return $this->all();
  }
  public function search_and_order($params = [])
  {
    $columns = $this->getTable("fields");
    foreach ($columns as $i => $column) {
      $columns[$i] = $this->getTable("name") . "." . $column;
    }
    if (isset($params['columns']))
      $columns = array_merge($columns, $params['columns']);

    if (isset($params['search'])) {
      $this->db->group_start();
      foreach ($columns as $i => $column) {
        if ($i === 0)
          $this->like($column,   $params["search"]);
        else
          $this->or_like($column,  $params["search"]);
      }
      $this->or_like("DAY($this->_table.created_at)",   $params["search"]);
      $this->or_like("MONTH($this->_table.created_at)",   $params["search"]);
      $this->db->group_end();
    }
    if (isset($params['order'])) {
      $order_column = preg_quote($params['order'][0], '~'); // don't forget to quote input string!
      if (count(preg_grep('~' . $order_column . '~', $columns)) > 0)
        $this->db->order_by($params['order'][0], $params['order'][1]);
    }
    if (isset($params['where']))
      $this->where($params['where']);
    return $this;
  }
}
