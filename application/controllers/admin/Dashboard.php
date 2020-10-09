<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   function index()
   {
      $menu = $this->is_user->menus;
      foreach ($menu as $row)
         foreach ($row->submenu as $rsow) {
            // print_r($rsow);
         }

      // die();
      if (in_role(1, true))
         $this->super_admin();
      elseif (in_role(["pemilik"], true))
         $this->_pemilik();
      elseif (in_role(2, true))
         $this->_pegawai();
      elseif (in_role("customer", true)) {
         $this->_customer();
      } elseif (in_role("admin", true)) {
         $this->admin();
      }
   }

   private function super_admin()
   {
      $countUser = $this->_countUser();
      $data = [
         'page_title' => "Dashboard Super Admin",
      ];
      $this->template->load('admin', 'dashboard/super-admin', array_merge($data, compact("countUser")));
   }
   private function _customer()
   {
      redirect("admin/profile");
   }
   function admin()
   {

      $this->db->where('id !=', 1);
      $this->db->from('tbl_users');
      $count_users = $this->db->count_all_results();

      $this->db->from('jenis_mobil');
      $count_jenis_mobil = $this->db->count_all_results();


      $this->db->from('mobils');
      $this->db->where('status', 'tersedia');
      $count_mobil_tersedia = $this->db->count_all_results();

      $this->db->from('mobils');
      $this->db->where('status', 'dipinjam');
      $count_mobil_dipinjam = $this->db->count_all_results();

      $this->db->from('drivers');
      $this->db->where('status', '0');
      $count_driver_keluar = $this->db->count_all_results();

      $this->db->from('drivers');
      $this->db->where('status', '1');
      $count_driver_tersedia = $this->db->count_all_results();

      $data = [
         'page_title' => 'Selamat datang admin',
      ];

      $this->template->load('admin', 'dashboard/index', array_merge($data, compact(['count_users', 'count_jenis_mobil', 'count_mobil_tersedia', 'count_mobil_dipinjam', 'count_driver_keluar', 'count_driver_tersedia'])));
   }

   private function _pemilik()
   {
      $count_users = $this->_countUser();
      $mobil = $this->_countMobil();
      $driver = $this->_countDriver();
      $pendapatan = $this->_pendapatanSetahun();
      $denda = $this->_denda();

      $jumlah_pendapatan = $this->db->select("sum(jumlah_bayar) as jumlah")->get("tbl_pesanan")->row();

      $bulan = array(01 => "Jannuari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", 'Oktober', 'November', "Desember");
      $iniBulan = $bulan[date('n', time())];


      $chart = [];
      $totalPendapatan = 0;
      foreach ($pendapatan as $row => $val) {
         $totalPendapatan += $val->pendapatan;
         for ($a = 01; $a <= 12; $a++) {
            $chart[] = [
               "bulan_n" => $a,
               "nama_bulan" =>  $bulan[$a],
               'pendapatan' => $val->bulan == $a ? $val->pendapatan : 0
            ];
         }
      }
      $data = [
         'page_title' => 'Dashboard Pegawai',
      ];
      $this->template->load('admin', 'dashboard/pemilik', array_merge($data, compact(['count_users', 'mobil', 'driver', 'chart', 'totalPendapatan', 'iniBulan', 'jumlah_pendapatan', 'denda'])));
   }
   private function _pegawai()
   {
      $data = [
         'page_title' => 'Dashboard Pegawai',
      ];


      $date_now = date('Y-m-d', time());

      $pendapatan = $this->db->select("SUM(jumlah_bayar) as hari_ini")->where("tgl_bayar", $date_now)->get("tbl_pesanan")->row();

      $mobil = $this->db->select("sum(terpakai) as terpakai,sum(stok-terpakai) as tersedia")->get("mobils")->row();

      $driver = (object) [];
      $driver->tersedia = $this->db->select("count(*) as jumlah")->where("status", 0)->get("drivers")->row();
      $driver->keluar = $this->db->select("count(*) as jumlah")->where("status", 1)->get("drivers")->row();

      $pesanan = $this->db->select("count(*) as tidak_divalidasi")->where("status", 0)->get("tbl_pesanan")->row();

      $pendapatan_seminggu = $this->db->select("tgl_bayar,DAY(tgl_bayar) as day,sum(jumlah_bayar) as pendapatan")->where("tgl_bayar >=", "DATE(NOW()) - INTERVAL 7 DAY")->order_by("tgl_bayar", "desc")->group_by("day(tgl_bayar)")->get("tbl_pesanan")->result();


      $hari = array(1 => "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
      $hari_ini = $hari[date('N', time())];


      $chart = [];
      for ($a = 6; $a >= 0; $a--) {
         if ($a == 0) {
            $time = time();
         } else $time = strtotime("-$a days");
         $chart[] = [
            "tgl" => date("d", $time),
            "day" =>  $hari[date("N", $time)],
            'pendapatan' => 0
         ];
      }


      foreach ($pendapatan_seminggu as $row => $val) {
         foreach ($chart as  $r => $c) {
            if ($val->day == $c['tgl'])
               $chart[$r]['pendapatan'] = $val->pendapatan;
         }
      }
      $this->template->load('admin', 'dashboard/Pegawai', array_merge($data, compact(['pendapatan', 'mobil', 'driver', 'pesanan', 'pendapatan_seminggu', 'chart'])));
   }

   function _countUser()
   {
      $this->db->where('id !=', 1)->from('users');
      return  $count_users = $this->db->count_all_results();
   }

   private function _countMobil($where = null)
   {
      return $mobil = $this->db->select("count(*) as jumlah,sum(terpakai) as terpakai,sum(stok-terpakai) as tersedia")->get("mobils")->row();
   }
   private function _countDriver()
   {
      $driver = (object) [];
      $driver->tersedia = $this->db->select("count(*) as jumlah")->where("status", 0)->get("drivers")->row();
      $driver->keluar = $this->db->select("count(*) as jumlah")->where("status", 1)->get("drivers")->row();
      return $driver;
   }
   private function _pendapatanSetahun()
   {
      $year = date("Y", time());
      return  $pendapatan_seminggu = $this->db->select("tgl_bayar,MONTH(tgl_bayar) as bulan,sum(jumlah_bayar) as pendapatan")->where("YEAR(tgl_bayar)", $year)->order_by("MONTH(tgl_bayar)", "asc")->group_by("MONTH(tgl_bayar)")->get("tbl_pesanan")->result();
   }

   private function _denda()
   {
      return $dendas = $this->db->select("SUM(total_denda) as total")->get("tbl_pesanan")->row();
   }
}
