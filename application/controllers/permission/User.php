<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["User_model" => "user", "permission/Role_model" => "role"]);
  }
  public function index()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");


    $this->input->get("roleId") && $this->db->where("id", $this->input->get("roleId"));
    $roles = $this->role->all();
    $users = $this->user->all();
    $data = [
      'page_title' => "Managemen Users Access",
    ];
    $this->template->load('admin', 'permission/user/index', array_merge($data, compact("users", "roles")));
  }
  public function  add()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $uuser = $this->user;
    $roles = $this->role->all();
    $this->form_validation->set_rules($this->user->getRules());
    if ($this->form_validation->run())
      return  $this->_insert_user();
    $data = [
      'page_title' => "tambah User",
      "form_action_add" => base_url("permission/user/add"),
    ];
    $this->template->load('admin', 'permission/user/add', array_merge($data, compact("roles", "uuser")));
  }
  public function edit($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $roles = $this->role->all();
    $uuser = $this->user->first($id);


    if (!$id || !$uuser) {
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin");
    }

    $this->form_validation->set_rules($uuser->getRules());
    if ($this->form_validation->run())
      $this->_edit_user($id);
    else {
      $data = [
        'page_title' => "Edit User Users",
        "form_action_edit" => base_url("permission/user/edit/" . $id),
      ];
      $this->template->load('admin', 'permission/user/edit', array_merge($data, compact("uuser", "roles")));
    }
  }
  public function delete($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $user = $this->user->first($id);
    if (!$id || !$user || $this->input->method() != 'post') {
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin");
    }
    $user->roles()->detach();
    $user->delete();

    if ($this->db->affected_rows() > 0) {
      $this->session->set_flashdata("success", 'User success deleted');
      return $this->output->set_content_type("application/json")->set_output(json_encode([
        "status" => true,
        "message" => "User DI Hapus"
      ]));
    } else {
      $this->session->set_flashdata("danger", 'User cannot deleted');
      return $this->output->set_content_type("application/json")->set_output(json_encode([
        "status" => false,
        "message" => "User Gagal di Hapus"
      ]));
    }
  }
  private function _insert_user()
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $this->user->password = password_hash($this->input->post("password") ?? "password", PASSWORD_DEFAULT);
    $user = $this->user->save();

    $user->roles()->attach($this->input->post("role_id"), ["model_type" => get_class($user)]);
    if ($this->db->affected_rows() > 0) {
      $this->session->set_flashdata("success", 'User sucecss addet');
    } else {
      $this->session->set_flashdata("danger", 'User cannot addet');
    }
    redirect("permission/user");
  }
  private function _edit_user($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $user = $this->user->first($id);
    if (!$id || !$user || !in_role("Super Admin")) {
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin");
    }
    $user->password =  password_hash($this->input->post("password") ?? "password", PASSWORD_DEFAULT);
    $user->update();

    $user->roles()->async($this->input->post("role_id"), ["model_type" => get_class($user)]);


    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'User success updated');
    else
      $this->session->set_flashdata("danger", 'User cannot updated');
    redirect("permission/user");
  }

  public function changeAccess($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Permission"))
      return  $this->not_permition(403, "Menu Ini Khusus Super Admin Atau Dapat Akses Permission Menu");

    $user = $this->user->first($id);
    !$user && $this->not_permition();
    $message = "Access Ditambahkan";
    try {
      $roleId = $this->input->post("role_id");
      $role = $user->roles()->first($roleId);
      if (!$role) {
        $user->roles()->attach($roleId, ['model_type' => get_class($user)]);
      } else {
        $user->roles()->detach($role->id);
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
}
