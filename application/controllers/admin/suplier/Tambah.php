<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tambah extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Suplier_model" => "suplier"]);
  }

  public function index($id = null)
  {
    if (!in_role("Admin"))
      return $this->not_permition();

    return $this->template->load('admin', 'master/suplier/tambah', [
      "page_title" => "Tambah Data Suplier",
      "form_action_add" => base_url("admin/suplier/tambah/store"),
      "suplier" => new $this->suplier,
    ]);
  }
  public function store()
  {
    if (!in_role("Admin"))
      return $this->not_permition();
    $this->form_validation->set_rules($this->suplier->getRules());
    if (!$this->form_validation->run()) {
      $this->session->set_flashdata("danger", "Validasi Gagal");
      return $this->index();
    }
    $suplier = $this->suplier->save();
    $this->session->set_flashdata("success", "Suplier Telah di tambahkan");
    return redirect(base_url("admin/suplier/data"));
  }
}
