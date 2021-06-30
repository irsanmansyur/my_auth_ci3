<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_pembelian_model extends MY_Model
{
  protected $_table = 'barang_pembelian';

  public function __construct()
  {
    parent::__construct();
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
