<?php

use phpDocumentor\Reflection\Types\This;

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("permission/Menu_model", "menu");
    $this->load->model("permission/Role_model", "role");
  }
  public function index()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");


    $this->input->get("roleId") && $this->db->where("id", $this->input->get("roleId"));
    $roles =   $this->role->all();

    $menus = $this->menu->all();
    $data = [
      'page_title' => "Managemen Menu User Access",
    ];
    $this->template->load('admin', 'permission/menu/index', array_merge($data, compact("menus", "roles")));
  }

  public function  tambah()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $menu = $this->menu;

    $this->load->library("form_validation");
    $this->form_validation->set_rules($menu->getRules());
    if ($this->form_validation->run()) {
      $menu->save();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Menu success addet');
      else
        $this->session->set_flashdata("danger", 'Menu cannot addet');
      redirect("permission/menu");
    }
    $data = [
      'page_title' => "Tambah Menu Users",
      "form_action_add" => base_url("permission/menu/tambah"),
    ];
    $this->template->load('admin', 'permission/menu/tambah', array_merge($data, compact("menu")));
  }
  public function edit($id)
  {
    $menu =  $this->menu->first($id);
    if (!$id || !$menu) {
      return  $this->not_permition(401, "Haraf Pilih Menu yang akan di edit");
    }
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");


    $this->form_validation->set_rules($menu->getRules());
    if ($this->form_validation->run()) {
      $menu->update();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Menu success updated');
      else
        $this->session->set_flashdata("danger", 'Menu cannot updated');
      redirect("permission/menu");
    } else {
      $data = [
        'page_title' => "Edit Menu Users",
        "form_action_edit" => base_url("permission/menu/edit/" . $id),
      ];
      $this->template->load('admin', 'permission/menu/edit', array_merge($data, compact("menu")));
    }
  }
  public function delete($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $menu = $this->menu->first($id);
    if (!$menu) {
      return  $this->not_permition(401, "Haraf Pilih Menu yang akan di Hapus");
    }
    $menu->submenus()->delete();
    $menu->roles()->detach();

    return json_encode($menu->delete());
  }
  public function access($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $menu = $this->menu->first($id);
    if (!$menu)
      return  $this->not_permition(401, "Haraf Pilih Menu yang akan di Hapus");

    $this->load->model("pemission/Role_model", "role");
    $roles = $this->role->all();

    $data = [
      'page_title' => "Tambah Menu Users",
      "form_action_add" => base_url("permission/menu/tambah"),
    ];
    return  $this->template->load('admin', 'permission/menu/access', array_merge($data, compact("menu", "roles")));
  }
  public function changeAccess($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $menu = $this->menu->first($id);
    if (!$menu)
      return  $this->not_permition(401, "Haraf Pilih Menu yang akan di Hapus");

    $message = "Access Ditambahkan";
    try {
      $roleId = $this->input->post("role_id");
      $role = $menu->roles()->first($roleId);

      if (!$role) {
        $menu->roles()->attach($roleId, ['model_type' => get_class($menu)]);
      } else {
        $menu->roles()->detach($role->id);
        $message = "Access Di Hilankan";
      }
    } catch (\Throwable $th) {
      echo json_encode([
        "status" => false,
        "message" => $th
      ]);
      return 0;
    }
    return $this->output->set_content_type("application/json")
      ->set_output(
        json_encode([
          "status" => true,
          "message" => $message
        ])
      );
  }

  public function submenu($id)
  {
    $menu = $this->menu->first($id);
    if (!$menu) return  $this->not_permition();
    return $menu;
  }
}
