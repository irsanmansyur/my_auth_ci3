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
    if (in_role([1, "Super Admin"]))
      return  $this->super_admin();
    elseif (in_role("admin", true)) {
      $this->admin();
    } elseif (count(user()->roles) < 1)
      $this->userNotRole();
  }

  private function super_admin()
  {

    $countUser = $this->db->count_all_results("users");
    $chartUserVisit = $this->countUserVisit();


    $data = [
      'page_title' => "Dashboard Super Admin",
    ];
    $this->template->load('admin', 'dashboard/super-admin', array_merge($data, compact("countUser", "chartUserVisit")));
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
  private function userNotRole()
  {
    $chartUserVisit = $this->countUserVisit();
    $data = [
      'page_title' => "Selamat datang " . user()->name,
    ];
    $this->template->load('admin', 'dashboard/no-role', array_merge($data, compact("chartUserVisit")));
  }
  private function admin()
  {
    $chartUserVisit = $this->countUserVisit();
    $data = [
      'page_title' => "Hay Admin, Selamat datang " . user()->name,
    ];
    $this->template->load('admin', 'dashboard/no-role', array_merge($data, compact("chartUserVisit")));
  }
}
