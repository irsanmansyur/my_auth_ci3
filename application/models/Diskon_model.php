
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diskon_model extends MY_Model
{
  protected $_table = 'diskons';
  protected $_rules = [
    array(
      'field' => 'name',
      'label' => 'Nama Diskon',
      'rules' => 'required|min_length[3]'
    ),
    array(
      'field' => 'kode',
      'label' => 'kode Diskon',
      'rules' => 'required',
      "unique" => "kode|kode"
    ),
    array(
      'field' => 'tipe',
      'label' => 'Jenis Diskon',
      'rules' => 'required|in_list[percentage,amount]'
    ),
    array(
      'field' => 'value',
      'label' => 'Jumlah Diskon',
      'rules' => 'required|numeric'
    ),
    array(
      'field' => 'start_at',
      'label' => 'Berlaku Tanggal',
      'rules' => 'required|regex_match[/\d{4}\-\d{2}-\d{2}/]'
    ),
    array(
      'field' => 'end_at',
      'label' => 'Expired Tanggal',
      'rules' => 'required|regex_match[/\d{4}\-\d{2}-\d{2}/]'
    ),
  ];

  public function __construct()
  {
    parent::__construct();
  }
  public function barans()
  {
    return $this->belongsToMany("Barang_model", "diskon_id", "barang_id", "barang_diskon");
  }
  public function set_barang($barang_id)
  {
    $this->db->insert("barang_diskon", [
      "barang_id" => $barang_id,
      "diskon_id" => $this->id
    ]);
  }
  public function hapus_barang($barang_id)
  {
    $this->db->delete("barang_diskon", [
      "barang_id" => $barang_id,
      "diskon_id" => $this->id
    ]);
  }
  public function get_data($params = [])
  {
    $this->db->select($this->_table . ".*");
    $this->search_and_order($params);
    if (isset($params['length']) && isset($params['start']))
      $this->db->limit($params['length'], $params['start']);
    return $this->all();
  }
  public function search_and_order($params = [])
  {
    if (isset($params['search'])) {
      $this->db->group_start();
      $this->like($this->_table . ".name",   $params["search"]);
      $this->or_like($this->_table . ".tipe",  $params["search"]);
      $this->or_like($this->_table . ".value",  $params["search"]);
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
