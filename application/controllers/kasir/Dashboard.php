<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Dashboard extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!in_role("kasir", true))
      return $this->not_permition();

    $this->load->model(["Barang_model" => "barang", "Suplier_model" => "suplier",  "Kategori_model" => "kategori", "Penjualan_model" => "penjualan"]);
  }

  function index()
  {
    $chartUserVisit = $this->countUserVisit();
    $jumlah_jenis_barang = $this->barang->jumlah_barang();
    $jumlah_suplier = $this->suplier->count();
    $jumlah_kategori = $this->kategori->count();
    $jumlah_pelanggan = $this->user->jumlah_pelanggan();
    $chart_pendapatan_harian = $this->pendapatan_harian();

    $data = [
      'page_title' => "Selamat datang " . user()->name,
    ];
    $this->template->load('admin', 'kasir/dashboard', array_merge($data, compact("jumlah_jenis_barang", "jumlah_pelanggan", "jumlah_kategori", "jumlah_suplier", "chartUserVisit", "chart_pendapatan_harian")));
  }
  private function countUserVisit()
  {
    $this->load->model("View_model", "view");

    $countDay = date("t");
    $yourVisit = user()->views()->select("count(model_id) as count,DAY(created_at) as day")->group_by("DAY(created_at)")->where("MONTH(created_at)", date("m"))->where("YEAR(created_at)", date("Y"))->all();

    $allUserVisit = $this->view->select("count(model_id) as count,DAY(created_at) as day")->group_by("DAY(created_at)")->where("model_type", "User_model")->where("MONTH(created_at)", date("m"))->where("YEAR(created_at)", date("Y"))->where("model_id !=", user()->id)->all();

    $chartUserVisit = [];
    for ($i = 01; $i <= $countDay; $i++) {
      $this->i = (string) $i;
      $viewIsUser = array_column(array_filter($yourVisit, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");

      $viewAllUser = array_column(array_filter($allUserVisit, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");
      $chartUserVisit[] = [
        "day" =>  $this->i,
        "countIsUser" => isset($viewIsUser[0]) ? $viewIsUser[0] : 0,
        "countAllUser" => isset($viewAllUser[0]) ? $viewAllUser[0] : 0,
      ];
    }

    return $chartUserVisit;
  }
  private function pendapatan_harian()
  {
    $kasir = user();
    $countDay = date("t");
    $bulan = date("m");
    $bulan_kemarin = $bulan < 2 ? 12 : $bulan - 1;

    $pend_bulan_ini = $this->penjualan->pendapatan_harian($bulan);
    $pend_bulan_ini_kasir = $this->penjualan->pendapatan_harian($bulan, date("Y"), $kasir);

    $pend_bulan_kemarin = $this->penjualan->pendapatan_harian($bulan_kemarin, $bulan < 2 ? date("Y") - 1 : date("Y"));
    $pend_bulan_kemarin_kasir = $this->penjualan->pendapatan_harian($bulan_kemarin, $bulan < 2 ? date("Y") - 1 : date("Y"), $kasir);


    $chart_pendapatan_harian = [];
    for ($i = 01; $i <= $countDay; $i++) {
      $this->i = (string) $i;
      $arr_bulan_ini = array_column(array_filter($pend_bulan_ini, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");
      $arr_bulan_ini_kasir = array_column(array_filter($pend_bulan_ini_kasir, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");

      $arr_bulan_kemarin = array_column(array_filter($pend_bulan_kemarin, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");
      $arr_bulan_kemarin_kasir = array_column(array_filter($pend_bulan_kemarin_kasir, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");
      $chart_pendapatan_harian[] = [
        "day" =>  $this->i,
        "day_name" => indonesia_day(date("Y-m-" . $this->i)),
        "bulan_ini_kasir" => isset($arr_bulan_ini_kasir[0]) ? $arr_bulan_ini_kasir[0] : 0,
        "bulan_ini" => isset($arr_bulan_ini[0]) ? $arr_bulan_ini[0] : 0,
        "bulan_kemarin" => isset($arr_bulan_kemarin[0]) ? $arr_bulan_kemarin[0] : 0,
        "bulan_kemarin_kasir" => isset($arr_bulan_kemarin_kasir[0]) ? $arr_bulan_kemarin_kasir[0] : 0,
      ];
    }

    return $chart_pendapatan_harian;
  }
}
