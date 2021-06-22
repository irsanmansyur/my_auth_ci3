<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenjualanBarang_model extends MY_Model
{
  protected $_table = 'penjualan_barang';

  public function __construct($type = null)
  {
    parent::__construct();
  }
  public function barang()
  {
    return $this->belongsTo("Barang_model");
  }
}
