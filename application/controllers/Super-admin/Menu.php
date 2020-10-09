<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends Admin_Controller
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
   public function  tambah()
   {
      $this->load->library("form_validation");
      $this->form_validation->set_rules("name", "nama Menu", "required|min_length[3]");
      if ($this->form_validation->run())
         return  $this->_insert_menu();

      $data = [
         'page_title' => "tambah Menu Users",
         "form_action_add" => base_url("super-admin/menu/tambah"),
      ];
      $this->template->load('admin', 'super-admin/menu/tambah', array_merge($data, []));
   }
   public function edit($id)
   {
      $menu = $this->db->get_where("menus", ['id' => $id])->row();
      if (!$id || !$menu) {
         $this->not_permition();
      }

      $this->load->library("form_validation");
      $this->form_validation->set_rules("name", "nama Menu", "required|min_length[3]");
      if ($this->form_validation->run())
         $this->_edit_menu($id);
      else {
         $data = [
            'page_title' => "Edit Menu Users",
            "form_action_edit" => base_url("super-admin/menu/edit/" . $id),
         ];
         $this->template->load('admin', 'super-admin/menu/edit', array_merge($data, compact("menu")));
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
   private function _insert_menu()
   {
      $data = [
         'name' => $this->input->post('name'),
      ];
      $this->db->insert("menus", $data);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'Menu success addet');
      else
         $this->session->set_flashdata("danger", 'Menu cannot addet');
      redirect("super-admin/menu");
   }
   private function _edit_menu($id)
   {
      $data = [
         'name' => $this->input->post('name'),
      ];
      $this->db->update("menus", $data, ['id' => $id]);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'Menu success updated');
      else
         $this->session->set_flashdata("danger", 'Menu cannot updated');
      redirect("super-admin/menu");
   }
}
