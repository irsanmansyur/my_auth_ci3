<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Access extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
      if (!in_role(1))
         $this->not_permition();
   }
   public function index()
   {
      $menus = $this->db->get("menus")->result();
      $data = [
         'page_title' => "Managemen Menu User Access",
      ];
      $this->template->load('admin', 'super-admin/menu/index', array_merge($data, compact("menus")));
   }
   public function type($id, $type)
   {
      $this->load->library("form_validation");
      if ($type == 'menu') {
         $menu = $this->db->get_where("menus", ['id' => $id])->row();
         if (!$menu) {
            $this->not_permition();
         }
         $this->data['menu'] = $menu;
         return $this->change_menu_access();
      } elseif ($type == "user") {
         $user = $this->db->get_where("users", ['id' => $id])->row();
         if (!$user) {
            $this->not_permition();
         }
         $this->data['user'] = $user;
      } elseif ($type == "submenu") {
         $submenu = $this->db->get_where("submenus", ['id' => $id])->row();
         if (!$submenu) {
            $this->not_permition();
         }
         $this->data['submenu'] = $submenu;
         return $this->change_submenu_access();
      }
      $this->form_validation->set_rules("role_id", "Role", "required");
      if ($this->form_validation->run()) {
         return  $this->_insert_access();
      } else {
         $rules = $this->db->get_where("rules", ['id!=' => 1])->result();
         $submenus = $this->db->get_where("submenus", ['is_access!=' => 'public'])->result();
         $menus = $this->db->get("menus")->result();
         $data = [
            'page_title' => "Form add user access",
            "form_action_add" => base_url("super-admin/access/add"),
         ];
         $this->template->load('admin', 'super-admin/access/index', array_merge($data, compact(["menus", "rules", 'submenus'])));
      }
   }
   public function change_menu_access()
   {
      $menu = (object) $this->data['menu'];
      $rules = $this->db->get("rules")->result();
      foreach ($rules as $key => $rule) {
         $menuPrivateAccess = $this->db->get_where("access_menu_role", ['role_id' => $rule->id, "menu_id" => $menu->id])->row();
         $rule->selected = false;
         if ($menuPrivateAccess)
            $rule->selected = true;
         $rules[$key] = $rule;
      }
      $data = [
         'page_title' => "Form add Role to Submenu access",
      ];
      $this->template->load('admin', 'super-admin/access/menu', array_merge($data, compact(['rules'])));
   }
   function change_submenu_access()
   {
      $submenu = (object) $this->data['submenu'];
      $this->db->select("rules.*")->from('rules')->join("access_menu_role", "access_menu_role.role_id=rules.id")
         ->group_by("rules.id")
         ->where("access_menu_role.menu_id", $submenu->menu_id);
      $rules = $this->db->get()->result();

      foreach ($rules as $key => $rule) {
         $submenuPrivateAccess = $this->db->get_where("access_submenu_role", ['role_id' => $rule->id, "submenu_id" => $submenu->id])->row();
         $rule->selected = false;
         if ($submenuPrivateAccess)
            $rule->selected = true;
         $rules[$key] = $rule;
      }

      $data = [
         'page_title' => "Form add Role to Submenu access",
      ];
      $this->template->load('admin', 'super-admin/access/submenu', array_merge($data, compact(['rules'])));
   }

   function add()
   {
   }


   private function _insert_access()
   {
      $submenu = $this->input->post('submenu_id');
      $rule = $this->input->post('role_id');
      die(var_dump($rule));

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
      redirect("super-admin/access");
   }
   function change($type)
   {
      if ($type == 'submenu') {
         return json_encode($this->input->post());
      }
   }
}
