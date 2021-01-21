<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["permission/Submenu_model" => "submenu", "permission/Menu_model" => "menu"]);
  }
  public function index($id = null)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $submenus = $this->submenu->all();

    $menu = $this->menu->first($this->input->get("menu_id"));
    if ($menu)
      $submenus = $menu->submenus;

    $data = [
      'page_title' => "Managemen submenu Access",
    ];

    $this->template->load('admin', 'permission/submenu/index', array_merge($data, compact(["submenus", "menu"])));
  }
  public function  tambah($id = null)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $submenu = $this->submenu;
    $menu = $this->input->get("menu_id") ? $this->menu->first($this->input->get("menu_id")) : false;
    $menus = $this->menu->all();


    $this->form_validation->set_rules($this->submenu->getRules());
    if ($this->form_validation->run()) {
      $submenu->save();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'successfully added submenu');
      else
        $this->session->set_flashdata("danger", 'failed to add submenu');
      redirect("permission/submenu" . ($menu ? "?menu_id=" . $menu->id : ''));
    }
    $data = [
      'page_title' => "Add a submenu",
      "form_action_add" => base_url("permission/submenu/tambah" . ($menu ? "?menu_id=" . $menu->id : '')),
    ];
    $this->template->load('admin', 'permission/submenu/tambah', array_merge($data, compact(["menus", "submenu", 'menu'])));
  }
  public function edit($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");


    $menu = $this->input->get("menu_id") ? $this->menu->first($this->input->get("menu_id")) : false;

    $submenu = $this->submenu->first($id);
    $menus = $this->menu->all();
    if (!$submenu) {
      return   $this->not_permition();
    }

    $this->load->library("form_validation");
    $this->form_validation->set_rules($this->submenu->getRules());
    if ($this->form_validation->run()) {
      $submenu->update();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Successfully edited the submenu');
      else
        $this->session->set_flashdata("danger", 'failed to edit submenu');
      redirect("permission/submenu" . ($menu ? "?menu_id=" . $menu->id : ''));
    }

    $data = [
      'page_title' => "Edit submenu",
      "form_action_edit" => base_url("permission/submenu/edit/" . $id . ($this->input->get("menu_id") ? "?menu_id={$this->input->get("menu_id")}" : '')),
    ];
    $this->template->load('admin', 'permission/submenu/edit', array_merge($data, compact(["submenu", 'menus', "menu"])));
  }
  public function delete($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $submenu = $this->db->get_where("submenus", ['id' => $id])->row();
    if (!$id || !$submenu || $this->input->method() != 'post') {
      return $this->not_permition();
    }
    $this->db->delete("submenus", ['id' => $id]);
    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'The Submenu has been deleted');
    else
      $this->session->set_flashdata("danger", 'Failed to delete the submenu');
    return json_encode(true);
  }
}
