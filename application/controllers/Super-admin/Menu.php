<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!in_role(1))
      $this->not_permition();
    $this->load->model("permission/menu_model");
  }
  public function index()
  {
    $menus = $this->menu_model->all();
    $data = [
      'page_title' => "Managemen Menu User Access",
    ];
    $this->template->load('admin', 'permission/menu/index', array_merge($data, compact("menus")));
  }

  public function  tambah()
  {
    $menu = $this->menu_model;

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
      'page_title' => "tambah Menu Users",
      "form_action_add" => base_url("permission/menu/tambah"),
    ];
    $this->template->load('admin', 'permission/menu/tambah', array_merge($data, compact("menu")));
  }
  public function edit($id)
  {
    $menu =  $this->menu_model->first($id);
    if (!$id || !$menu) {
      $this->not_permition();
    }

    $this->load->library("form_validation");
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
    $menu = $this->db->get_where("menus", ['id' => $id])->row();
    if (!$id || !$menu || $this->input->method() != 'post') {
      return $this->not_permition();
    }
    $this->db->delete("menus", ['id' => $id]);
    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'Menu success deleted');
    else
      $this->session->set_flashdata("danger", 'Menu cannot deleted');
    return json_encode(true);
  }
}
