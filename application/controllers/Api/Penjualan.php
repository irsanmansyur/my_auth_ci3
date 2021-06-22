<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
// require APPPATH . '/libraries/REST_Controller.php';

use chriskacerguis\RestServer\RestController;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Penjualan extends RestController
{
  function __construct()
  {
    // Construct the parent class
    parent::__construct();

    // Configure limits on our controller methods
    // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
    $this->methods['index_get']['limit'] = 10; // 500 requests per hour per user/key
    $this->methods['index_post']['limit'] = 100; // 100 requests per hour per user/key
    $this->methods['index_delete']['limit'] = 50; // 50 requests per hour per user/key
    $this->load->helper("my_helper");
    $this->load->model("Penjualan_model", "penjualan");
  }

  function index_get($id = null)
  {
    // Users from a data store e.g. database

    $users = $this->User->getDatatable();

    $this->response([
      "status" => false,
      "message" => "user tidak Di temukan",
      "data" => $users
    ], 200);
  }
  public function detail_get($no_invoice)
  {
    $penjualan = $this->penjualan->where("no_invoice", $no_invoice)->first();
    foreach ($penjualan->barangs as $i  => $brg) {
      $brg->barang;
      $penjualan->barangs[$i] = $brg;
    }
    $penjualan->dibuat_pada = _ago($penjualan->created_at);
    $penjualan->cetak_pada = date("d F Y", time());
    return  $this->response([
      "status" => true,
      "message" => "Data Penjualan Barang pada invoice " . $no_invoice,
      "data" => $penjualan
    ], 200);
  }
  public function softDelete_delete($no_invoice)
  {
    $penjualan = $this->penjualan->where("no_invoice", $no_invoice)->first();
    $params =  $this->delete();
    $now = new DateTime();
    $penjualan->deleted_at = $now->format('c');
    $penjualan->update();
    return  $this->response([
      "status" => true,
      "message" => "Data Penjualan Telah Di hapus dengan invocie " . $no_invoice,
      "data" => $penjualan
    ], 200);
  }
}
