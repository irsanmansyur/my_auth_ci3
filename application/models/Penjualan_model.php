<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends MY_Model
{
  protected $_table = 'penjualans';

  public function __construct()
  {
    parent::__construct();
  }
  public function barangs()
  {
    return $this->belongsToMany("Barang_model", "penjualan_id", "barang_id", "penjualan_barang")->select("penjualan_barang.harga,penjualan_barang.jumlah,penjualan_barang.total_harga")->withPivod("jumlah", "harga");
  }
  public function transaksi()
  {
    return $this->hasMany("Transaksi_model", "kode_transaksi", "no_invoice");
  }

  public function kasir()
  {
    return $this->belongsTo("User_model", "kasir_id", "id");
  }
  public function pelanggan()
  {
    return $this->belongsTo("User_model", "pelanggan_id", "id");
  }

  public function pendapatan_harian($bulan = null, $tahun = null, $kasir = null)
  {
    $this->db->select("SUM(jumlah_bayar) as count,DAY(created_at) as day")->group_by("DAY(created_at)")->where("deleted_at", null)->where("MONTH(created_at)", $bulan ?? date("m"))->where("YEAR(created_at)", $year ?? date("Y"));
    if ($kasir)
      $this->where("kasir_id", $kasir->id);
    return $this->all();
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

    $input = preg_quote('gr', '~'); // don't forget to quote input string!
    $data = array('orange', 'blue', 'green', 'red', 'pink', 'brown', 'black');

    $result = preg_grep('~' . $input . '~', $data);
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
