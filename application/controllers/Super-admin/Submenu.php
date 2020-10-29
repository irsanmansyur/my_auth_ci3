<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!in_role(1))
      $this->not_permition();
    $this->load->model(["super-admin/submenu_model", "super-admin/menu_model"]);
  }
  public function index($id = null)
  {
    $menu_id = $this->input->get("menu_id") ?? 0;
    $menu = $this->db->get_where("menus", ["id" => $menu_id])->row();

    if ($menu)
      $this->db->where("menu_id", $menu_id);
    $submenus = $this->db->get("submenus")->result();
    $data = [
      'page_title' => "Managemen submenu Access",
    ];
    $this->template->load('admin', 'super-admin/submenu/index', array_merge($data, compact(["submenus", "menu"])));
  }
  public function  tambah($menu_id = 878)
  {
    $submenu = $this->submenu_model;
    $menu = $this->menu_model->first($menu_id);
    $menus = $this->menu_model->all();

    $this->load->library("form_validation");
    $this->form_validation->set_rules($this->submenu_model->getRules());
    if ($this->form_validation->run()) {
      $submenu->save();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'successfully added submenu');
      else
        $this->session->set_flashdata("danger", 'failed to add submenu');
      redirect("super-admin/submenu" . ($menu ? "?menu_id=" . $menu->id : ''));
    }
    $data = [
      'page_title' => "Add a submenu",
      "form_action_add" => base_url("super-admin/submenu/tambah" . ($this->input->get("menu_id") ? "?menu_id={$this->input->get("menu_id")}" : '')),
    ];
    $this->template->load('admin', 'super-admin/submenu/tambah', array_merge($data, compact(["menus", "submenu", 'menu'])));
  }
  public function edit($id)
  {

    $menu =  $this->menu_model->first($this->input->get("menu_id"));

    $submenu = $this->submenu_model->first($id);
    $menus = $this->menu_model->all();
    if (!$submenu) {
      $this->not_permition();
    }

    $this->load->library("form_validation");
    $this->form_validation->set_rules($this->submenu_model->getRules());
    if ($this->form_validation->run()) {

      $submenu->update();


      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Successfully edited the submenu');
      else
        $this->session->set_flashdata("danger", 'failed to edit submenu');
      redirect("super-admin/submenu" . ($menu ? "?menu_id=" . $menu->id : ''));
    }

    $data = [
      'page_title' => "Eddit submenu",
      "form_action_edit" => base_url("super-admin/submenu/edit/" . $id . ($this->input->get("menu_id") ? "?menu_id={$this->input->get("menu_id")}" : '')),
    ];
    $this->template->load('admin', 'super-admin/submenu/edit', array_merge($data, compact(["submenu", 'menus'])));
  }
  public function delete($id)
  {
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
