<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Edit extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Suplier_model" => "suplier"]);
  }

  public function index($id = null)
  {
    $suplier  = $this->suplier->first($id);
    if (!in_role("Admin") || !$suplier)
      return $this->not_permition();

    return $this->template->load('admin', 'master/suplier/edit', [
      "page_title" => "Edit Data Suplier",
      "form_action_edit" => base_url("admin/suplier/edit/update/" . $id),
      "suplier" => $suplier,
    ]);
  }
  public function update($id)
  {

    $suplier  = $this->suplier->first($id);
    if (!in_role("Admin") || !$suplier)
      return $this->not_permition();

    $this->form_validation->set_rules($suplier->getRules());
    if (!$this->form_validation->run()) {
      $this->session->set_flashdata("danger", "Validasi Gagal");
      return $this->index($id);
    }

    $suplier->update();
    $this->session->set_flashdata("success", "Suplier Telah di Update");
    return redirect(base_url("admin/suplier/data"));
  }
}
