<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rules extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
      if (!in_role(1))
         $this->not_permition();
   }
   public function index()
   {
      $rules = $this->db->get_where("rules", ['id !=' => 1])->result();
      $data = [
         'page_title' => "Managemen Rules Access",
      ];
      $this->template->load('admin', 'super-admin/rules/index', array_merge($data, compact("rules")));
   }
   public function  add()
   {
      $this->load->library("form_validation");
      $this->form_validation->set_rules("name", "Name Rule", "required|min_length[3]");
      if ($this->form_validation->run())
         return  $this->_insert_rule();
      $data = [
         'page_title' => "tambah Rule Users",
         "form_action_add" => base_url("super-admin/rules/add"),
      ];
      $this->template->load('admin', 'super-admin/rules/add', array_merge($data, []));
   }
   public function edit($id)
   {
      $rule = $this->db->get_where("rules", ['id' => $id])->row();
      if (!$id || !$rule) {
         $this->not_permition();
      }

      $this->load->library("form_validation");
      $this->form_validation->set_rules("name", "nama Rule", "required|min_length[3]");
      if ($this->form_validation->run())
         $this->_edit_rule($id);
      else {
         $data = [
            'page_title' => "Edit Rule Users",
            "form_action_edit" => base_url("super-admin/rules/edit/" . $id),
         ];
         $this->template->load('admin', 'super-admin/rules/edit', array_merge($data, compact("rule")));
      }
   }
   public function delete($id)
   {
      $rules = $this->db->get_where("rules", ['id' => $id])->row();
      if (!$id || !$rules || $this->input->method() != 'post') {
         return $this->not_permition();
      }
      $this->db->delete("rules", ['id' => $id]);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'Rule success deleted');
      else
         $this->session->set_flashdata("danger", 'Rule cannot deleted');
      return json_encode(true);
   }
   private function _insert_rule()
   {
      $data = [
         'name' => $this->input->post('name'),
      ];
      $this->db->insert("rules", $data);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'Rule success addet');
      else
         $this->session->set_flashdata("danger", 'Rule cannot addet');
      redirect("super-admin/rules");
   }
   private function _edit_rule($id)
   {
      $data = [
         'name' => $this->input->post('name'),
      ];
      $this->db->update("rules", $data, ['id' => $id]);
      if ($this->db->affected_rows() > 0)
         $this->session->set_flashdata("success", 'Rule success updated');
      else
         $this->session->set_flashdata("danger", 'Rule cannot updated');
      redirect("super-admin/rules");
   }
}
