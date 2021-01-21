<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("permission/Role_model", "role");
  }
  public function index()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $roles = $this->role->all();
    $data = [
      'page_title' => "Managemen Roles Access",
    ];
    $this->template->load('admin', 'permission/role/index', array_merge($data, compact("roles")));
  }
  public function  add()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $this->form_validation->set_rules("name", "Name Role", "required|min_length[3]");
    if ($this->form_validation->run())
      return  $this->_insert_role();
    $data = [
      'page_title' => "tambah Role Users",
      "form_action_add" => base_url("permission/role/add"),
    ];
    $this->template->load('admin', 'permission/role/add', array_merge($data, []));
  }
  public function edit($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $role = $this->role->first($id);
    if (!$id || !$role) {
      return $this->not_permition();
    }

    $this->load->library("form_validation");
    $this->form_validation->set_rules("name", "nama Role", "required|min_length[3]");
    if ($this->form_validation->run())
      $this->_edit_role($id);
    else {
      $data = [
        'page_title' => "Edit Role Users",
        "form_action_edit" => base_url("permission/role/edit/" . $id),
      ];
      $this->template->load('admin', 'permission/role/edit', array_merge($data, compact("role")));
    }
  }
  public function delete($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $roles = $this->db->get_where("roles", ['id' => $id])->row();
    if (!$id || !$roles || $this->input->method() != 'post') {
      return $this->not_permition();
    }

    $this->db->delete("roles", ['id' => $id]);
    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'Role success deleted');
    else
      $this->session->set_flashdata("danger", 'Role cannot deleted');
    return json_encode(true);
  }
  private function _insert_role()
  {
    $data = [
      'name' => $this->input->post('name'),
    ];
    $this->db->insert("roles", $data);
    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'Role success addet');
    else
      $this->session->set_flashdata("danger", 'Role cannot addet');
    redirect("permission/role");
  }
  private function _edit_role($id)
  {
    $data = [
      'name' => $this->input->post('name'),
    ];
    $this->db->update("roles", $data, ['id' => $id]);
    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'Role success updated');
    else
      $this->session->set_flashdata("danger", 'Role cannot updated');
    redirect("permission/role");
  }
}
