<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Access extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!in_role(1))
      return $this->not_permition();
  }
  public function index()
  {
    $menus = $this->db->get("menus")->result();
    $data = [
      'page_title' => "Managemen Menu User Access",
    ];
    $this->template->load('admin', 'permission/menu/index', array_merge($data, compact("menus")));
  }
  public function type($id, $type, $type2 = null)
  {
    $this->load->library("form_validation");
    if ($type == 'menu') {
      $menu = $this->db->get_where("menus", ['id' => $id])->row();
      if (!$menu) {
        return $this->not_permition();
      }
      $this->data['menu'] = $menu;
      return $this->change_menu_access();
    } elseif ($type == "user") {
      $user = $this->db->get_where("users", ['id' => $id])->row();
      if (!$user) {
        return  $this->not_permition();
      }
      $this->data['isUser'] = $user;
      return $this->change_user_access_role();
    } elseif ($type == "submenu") {
      $submenu = $this->db->get_where("submenus", ['id' => $id])->row();
      if (!$submenu) {
        return     $this->not_permition();
      }
      $this->data['submenu'] = $submenu;
      return $this->change_submenu_access();
    } elseif ($type == "role") {
      $role = $this->db->get_where("roles", ['id' => $id])->row();
      if (!$role) {
        return      $this->not_permition();
      }
      $this->data['role'] = $role;
      return $this->change_role_access($type2);
    }
    $this->form_validation->set_rules("role_id", "Role", "required");
    if ($this->form_validation->run()) {
      return  $this->_insert_access();
    } else {
      $roles = $this->db->get_where("roles", ['id!=' => 1])->result();
      $submenus = $this->db->get_where("submenus", ['is_access!=' => 'public'])->result();
      $menus = $this->db->get("menus")->result();
      $data = [
        'page_title' => "Form add user access",
        "form_action_add" => base_url("permission/access/add"),
      ];
      $this->template->load('admin', 'permission/access/index', array_merge($data, compact(["menus", "roles", 'submenus'])));
    }
  }
  public function change_menu_access()
  {
    $menu = (object) $this->data['menu'];
    $roles = $this->db->get("roles")->result();
    foreach ($roles as $key => $role) {
      $menuPrivateAccess = $this->db->get_where("access_menu_role", ['role_id' => $role->id, "menu_id" => $menu->id])->row();
      $role->selected = false;
      if ($menuPrivateAccess)
        $role->selected = true;
      $roles[$key] = $role;
    }
    $data = [
      'page_title' => "Form add Role to Submenu access",
    ];
    $this->template->load('admin', 'permission/access/menu', array_merge($data, compact(['roles'])));
  }
  function change_submenu_access()
  {
    $submenu = (object) $this->data['submenu'];
    $this->db->select("roles.*")->from('roles')->join("access_menu_role", "access_menu_role.role_id=roles.id")
      ->group_by("roles.id")
      ->where("access_menu_role.menu_id", $submenu->menu_id);
    $roles = $this->db->get()->result();

    foreach ($roles as $key => $role) {
      $submenuPrivateAccess = $this->db->get_where("access_submenu_role", ['role_id' => $role->id, "submenu_id" => $submenu->id])->row();
      $role->selected = false;
      if ($submenuPrivateAccess)
        $role->selected = true;
      $roles[$key] = $role;
    }

    $data = [
      'page_title' => "Form add Role to Submenu access",
    ];
    $this->template->load('admin', 'permission/access/submenu', array_merge($data, compact(['roles'])));
  }
  function change_user_access_role()
  {
    $isUser = (object) $this->data['isUser'];
    $this->db->select("roles.*")->from('roles')->join("access_role_user", "access_role_user.role_id=roles.id")
      ->group_by("roles.id");
    $roles = $this->db->get()->result();

    foreach ($roles as $key => $role) {
      $userAccess = $this->db->get_where("access_role_user", ['role_id' => $role->id, "user_id" => $isUser->id])->row();
      $role->selected = false;
      if ($userAccess)
        $role->selected = true;
      $roles[$key] = $role;
      $data = [
        'page_title' => "Form add User to Roles access",
      ];
      $this->template->load('admin', 'permission/access/user', array_merge($data, compact(['roles'])));
    }
  }

  function change_role_access($type)
  {
    $role = (object) $this->data['role'];

    $users = $menus = [];
    if ($type == "users") {
      $users =  $this->db->get_where("users", ['id !=' => 1])->result();
      foreach ($users as $key => $user) {
        $userAccess = $this->db->get_where("access_role_user", ['role_id' => $role->id, "user_id" => $user->id])->row();
        $user->selected = false;
        if ($userAccess)
          $user->selected = true;
        $users[$key] = $user;
      }
    } elseif ($type == "menus") {
      $menus =  $this->db->get_where("menus", ['id !=' => 1])->result();

      foreach ($menus as $key => $menu) {
        $menuAccess = $this->db->get_where("access_menu_role", ['role_id' => $role->id, "menu_id" => $menu->id])->row();
        $menu->selected = false;
        if ($menuAccess)
          $menu->selected = true;
        $menus[$key] = $menu;
      }
    }
    $data = [
      'page_title' => "Select Role  access",
    ];
    $this->template->load('admin', 'permission/access/role', array_merge($data, compact(['users', 'menus'])));
  }


  private function _insert_access()
  {
    $submenu = $this->input->post('submenu_id');
    $role = $this->input->post('role_id');
    die(var_dump($role));

    $data = [
      'role_id' => $this->input->post('role_id'),
      'menu_id' => $this->input->post('menu_id'),
    ];
    $accessMenu = $this->db->get_where("access_menu_role", $data)->row();

    if ($accessMenu) {
      $this->session->set_flashdata("warning", 'The access menu already exists');
      return  back();
    }
    $this->db->insert("access_menu_role", $data);
    if ($this->db->affected_rows() > 0)
      $this->session->set_flashdata("success", 'Access Menu Role success addet');
    else
      $this->session->set_flashdata("danger", 'Access Menu Role  cannot addet');
    redirect("permission/access");
  }
  function change($type)
  {
    if ($type == 'submenu') {
      return json_encode($this->input->post());
    }
  }
}
