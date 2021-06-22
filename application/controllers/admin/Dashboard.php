<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Barang_model" => "barang", "Suplier_model" => "suplier", "Restok_model" => "restok", "Kategori_model" => "kategori", "Penjualan_model" => "penjualan"]);
  }

  function index()
  {
    if (in_role([1, "Super Admin", "admin"]))
      return  $this->admin();
    elseif (in_role("admin", true))
      $this->admin();
    elseif (in_role("kasir", true))
      return redirect("kasir/dashboard");
    elseif (count(user()->roles) < 1)
      $this->userNotRole();
  }

  private function admin()
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
    $this->template->load('admin', 'dashboard/admin', array_merge($data, compact("jumlah_jenis_barang", "jumlah_pelanggan", "jumlah_kategori", "jumlah_suplier", "chartUserVisit", "chart_pendapatan_harian")));
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
    $countDay = date("t");
    $bulan = date("m");
    $bulan_ini = $this->penjualan->pendapatan_harian($bulan);
    $bulan_kemarin = $this->penjualan->pendapatan_harian($bulan < 2 ? 12 : $bulan - 1, $bulan < 2 ? date("Y") - 1 : null);

    $chart_pendapatan_harian = [];
    for ($i = 01; $i <= $countDay; $i++) {
      $this->i = (string) $i;
      $pendapatan_bulan_ini = array_column(array_filter($bulan_ini, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");

      $pendapatan_bulan_kemarin = array_column(array_filter($bulan_kemarin, function ($view) {
        if ($this->i == $view->day) {
          return $view;
        }
      }), "count");
      $chart_pendapatan_harian[] = [
        "day" =>  $this->i,
        "day_name" => indonesia_day(date("Y-m-" . $this->i)),
        "bulan_ini" => isset($pendapatan_bulan_ini[0]) ? $pendapatan_bulan_ini[0] : 0,
        "bulan_kemarin" => isset($pendapatan_bulan_kemarin[0]) ? $pendapatan_bulan_kemarin[0] : 0,
      ];
    }

    return $chart_pendapatan_harian;
  }
  private function userNotRole()
  {
    $chartUserVisit = $this->countUserVisit();

    $data = [
      'page_title' => "Selamat datang " . user()->name,
    ];
    $this->template->load('admin', 'dashboard/no-role', array_merge($data, compact("chartUserVisit")));
  }
}
