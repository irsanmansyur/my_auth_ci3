<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
      if (!in_role(1))
         $this->not_permition();
   }
   public function index()
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
   public function  tambah()
   {
      $menus = $this->db->get("menus")->result();

      $this->load->library("form_validation");
      $this->form_validation->set_rules("name", "nama subMenu", "required|min_length[3]");
      $this->form_validation->set_rules("url", "url SubMenu", "required|min_length[3]");
      $this->form_validation->set_rules("status", "status SubMenu", "required");
      $this->form_validation->set_rules("menu_id", "Menu", "required");
      if ($this->form_validation->run())
         return  $this->_insert_submenu();

      $data = [
         'page_title' => "Add a submenu",
         "form_action_add" => base_url("super-admin/submenu/tambah"),
      ];
      $this->template->load('admin', 'super-admin/submenu/tambah', array_merge($data, compact("menus")));
   }
   public function edit($id)
   {
      $menus = $this->db->get("menus")->result();
      $submenu = $this->db->get_where("submenus", ['id' => $id])->row();
      if (!$id || !$submenu) {
         $this->not_permition();
      }

      $this->load->library("form_validation");
      $this->form_validation->set_rules("name", "nama subMenu", "required|min_length[3]");
      $this->form_validation->set_rules("url", "url SubMenu", "required|min_length[3]");
      $this->form_validation->set_rules("status", "status SubMenu", "required");
      $this->form_validation->set_rules("menu_id", "Menu", "required");
      if ($this->form_validation->run())
         return $this->_edit_submenu($id);

      $data = [
         'page_title' => "Eddit submenu",
         "form_action_edit" => base_url("super-admin/submenu/edit/" . $id),
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
   private function _insert_submenu()
   {
      $data = [
         'name' => $this->input->post('name'),
         'url' => $this->input->post('url'),
         'is_access' => $this->input->post('status'),
         'menu_id' => $this->input->post('menu_id'),
      ];

      $this->db->insert("submenus", $data);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'successfully added submenu');
      else
         $this->session->set_flashdata("danger", 'failed to add submenu');
      redirect("super-admin/submenu");
   }
   private function _edit_submenu($id)
   {
      $data = [
         'name' => $this->input->post('name'),
         'url' => $this->input->post('url'),
         'is_access' => $this->input->post('status'),
         'menu_id' => $this->input->post('menu_id'),
      ];
      $this->db->update("submenus", $data, ['id' => $id]);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'Successfully edited the submenu');
      else
         $this->session->set_flashdata("danger", 'failed to edit submenu');
      redirect("super-admin/submenu");
   }
}
