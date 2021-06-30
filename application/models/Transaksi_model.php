<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends MY_Model
{
  protected $_table = 'transaksi';
  public function __construct()
  {
    parent::__construct();
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
    if (isset($params['search'])) {
      $this->db->group_start();
      $this->like($this->_table . ".id",   $params["search"]);
      $this->or_like("DAY($this->_table.created_at)",   $params["search"]);
      $this->or_like("MONTH($this->_table.created_at)",   $params["search"]);
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
