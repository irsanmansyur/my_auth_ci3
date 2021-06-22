<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
    $this->load->model("Keranjang_model", "keranjang");
    $this->load->model("Penjualan_model", "penjualan");
    $this->load->model("PenjualanBarang_model", "penjualanBrg");
  }
  public function index()
  {
    if (!can("Laporan")  && !in_role(["Admin"]))
      return  $this->not_permition(403, "Kategori Ini Khusus Admin Atau Dapat Akses Menu Laporan");

    $data = [
      'page_title' => "Laporan Penjualan",
    ];
    $this->template->load('admin', 'laporan/penjualan', $data);
  }
  public function getData()
  {


    $year = date("Y");
    $month = date("m");
    $day = date("d");
    if ($month == 01) {
      $month = 12;
      $year -= 1;
    } else $month -= 1;
    if ($month < 10)
      $month = "0" . $month;
    if ($day < 10)
      $day = "0" . $day;

    $nowHour = date("H:i:s");
    $mulaiDari = $this->input->get_post("mulaiDari") ?? $year . "-" . $month . "-" . date("d");
    $sampaiTanggal =  $this->input->get_post("sampaiTanggal") ?? date("Y-m-d");






    $page = $this->input->get_post("page") ?? 1;
    $length = $this->input->get_post("length") ?? 100;
    $start = $this->input->get_post("start") ?? ($page * $length - $length);

    // $penjualans = $this->db->where("created_at between '$mulaiDari' and '$sampaiTanggal $nowHour'")->limit($length, $start)->get("penjualans")->result();
    // die(var_dump($this->db->last_query()));

    $penjualans = $this->penjualan->where("created_at between '$mulaiDari' and '$sampaiTanggal $nowHour'")->limit($length, $start)->all();
    $penjualans = $this->penjualan->setData($penjualans);

    $countFilter = count($penjualans);
    $total_halaman = ceil($countFilter / $length);
    $output = array(
      "draw" => $this->input->get_post("draw") ?? 0,
      "page" => $page,
      "recordsTotal" => $countFilter,
      "pagesTotal" => $total_halaman,
      "recordsFiltered" => $countFilter,
      "data" => $penjualans,
      "query" => $this->last_query,
      "dataTable" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
    );
    return $this->output->set_content_type("application/json")
      ->set_output(
        json_encode(array_merge($this->data, $output))
      );
  }
}
