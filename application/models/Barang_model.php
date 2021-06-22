<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends MY_Model
{
  protected $_table = 'barangs';

  protected $_rules = [
    array(
      'field' => 'nama',
      'label' => 'Nama Barang',
      'rules' => 'required|min_length[3]'
    ),
    array(
      'field' => 'kode',
      'label' => 'Kode Barang',
      'rules' => 'required|min_length[3]',
      "unique" => "kode|kode"
    ),
    array(
      'field' => 'satuan_id',
      'label' => 'Satuan Barang',
      'rules' => 'required',
    ),
    array(
      'field' => 'kategori_id',
      'label' => 'Kategori Barang',
      'rules' => 'required',
    ),
    array(
      'field' => 'harga_jual',
      'label' => 'Harga Jual',
      'rules' => 'required|numeric',
    ),
    array(
      'field' => 'harga_beli',
      'label' => 'Harga Beli',
      'rules' => 'required|numeric',
    ),
    array(
      'field' => 'stok',
      'label' => 'Stok',
      'rules' => 'required|numeric',
    )
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function satuan()
  {
    return $this->belongsTo("Satuan_model", "satuan_id");
  }

  public function jumlah_barang()
  {
    return $this->db->count_all_results($this->_table);
  }

  /**
   * Datatable
   * 
   */
  public function getDatatable($params = [])
  {
    $this->searchAndOrder();
    if (isset($params["ready"]))
      $this->where("barangs.stok >", 0);
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
    if (isset($params["ready"]))
      $this->where("barangs.stok >", 0);
    $countFilter = $this->db->count_all_results($this->getTable("name"));

    $this->searchAndOrder();
    if (isset($params["ready"]))
      $this->where("barangs.stok >", 0);
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

    if (isset($params['length']))
      $this->db->limit($params['length'], $params['start']);
    $data = $this->all();
    foreach ($data as $i => $brg) {
      $data[$i]->dibuat_pada = _ago($brg->created_at);
      $data[$i]->tanggal_kadaluarsa = date("d F Y", strtotime($brg->expired_at));
      $data[$i]->harga_jual = rupiah($brg->harga_jual);
      $data[$i]->harga_beli = rupiah($brg->harga_beli);
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
    $this->select("kategoris.nama as kategori_name,satuans.nama as satuan_name");
    $this->join("satuans", "satuans.id=barangs.satuan_id");
    $this->join("kategoris", "kategoris.id=barangs.kategori_id");
    if (in_array("barangs.created_at", $this->getTable("fields")))
      $this->select("MONTH(barangs.created_at) as byMonth,YEAR(barangs.created_at) as byYear,DAY(barangs.created_at) as byDay");

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

  public function diskons()
  {
    return $this->belongsToMany("Diskon_model", "barang_id", "diskon_id", "barang_diskon");
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
    if (isset($params['search'])) {
      $this->db->group_start();
      $this->like($this->_table . ".kode",   $params["search"]);
      $this->or_like($this->_table . ".nama",  $params["search"]);
      $this->or_like($this->_table . ".harga_jual",  $params["search"]);
      $this->or_like("DAY($this->_table.created_at)",   $params["search"]);
      $this->or_like("MONTH($this->_table.created_at)",   $params["search"]);
      $this->db->group_end();
    }
    if (isset($params['order'])) {
      $this->db->order_by($params['order'][0], $params['order'][1]);
    }
    if (isset($params['where'])) {
      $this->db->WHERE($params['where']);
    }
    return $this;
  }
}
