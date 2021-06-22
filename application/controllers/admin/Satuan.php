<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Satuan extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Satuan_model", "satuan");
  }
  public function index()
  {
    if (!in_role(["Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Satuan Ini Khusus Admin Atau Dapat Akses Satuan Master");
    $data = [
      'page_title' => "Master Satuan",
    ];
    $this->template->load('admin', 'master/satuan/index', $data);
  }


  public function  tambah()
  {

    if (!in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Satuan Ini Khusus Admin Atau Dapat Akses Satuan Master");

    $satuan = $this->satuan;

    $this->form_validation->set_rules($satuan->getRules());
    if ($this->form_validation->run()) {
      $satuan->save();

      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Satuan success addet');
      else
        $this->session->set_flashdata("danger", 'Satuan cannot addet');
      if ($this->input->is_ajax_request()) {
        return $this->output->set_content_type("application/json")
          ->set_output(json_encode(['status' => true,  "message" => "Berhasil input master satuan!", 'data' => $satuan]));
      }
      redirect("admin/satuan");
    }

    if ($this->input->is_ajax_request()) {
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode(['status' => false, "message" => "Validations Errors", 'errors' => $this->form_validation->error_array()]));
    }
    $data = [
      'page_title' => "Tambah Satuan",
      "form_action_add" => base_url("admin/satuan/tambah"),
    ];
    $this->template->load('admin', 'master/satuan/tambah', array_merge($data, compact("satuan")));
  }
  public function edit($id, $show = null)
  {
    $satuan =  $this->satuan->first($id);
    if (!$id || !$satuan) {
      return  $this->not_permition(401, "Haraf Pilih Satuan yang akan di edit");
    }
    if (!in_role([1, "Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Satuan Ini Khusus Super Admin Atau Dapat Akses Menu Master");

    $this->form_validation->set_rules($satuan->getRules());
    if ($this->form_validation->run()) {
      $satuan->update();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Satuan success updated');
      else
        $this->session->set_flashdata("danger", 'Satuan cannot updated');
      if ($this->input->is_ajax_request()) {
        return $this->output->set_content_type("application/json")
          ->set_output(json_encode(['status' => true,  "message" => "Master Satuan Telah Di Ubah!", 'data' => $satuan]));
      }
      redirect("admin/satuan");
    }
    if ($this->input->is_ajax_request()) {
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode(['status' => false, "message" => "Validations Errors", 'errors' => $this->form_validation->error_array()]));
    }
    $data = [
      'page_title' => "Edit Satuan Users",
      "form_action_edit" => base_url("admin/satuan/edit/" . $id),
    ];
    $this->template->load('admin', 'master/satuan/edit', array_merge($data, compact("satuan")));
  }
  public function delete($id)
  {
    if (!in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Satuan Ini Khusus  Admin Atau Dapat Akses  Satuan Master");

    $satuan = $this->satuan->first($id);
    if (!$satuan) {
      return  $this->not_permition(401, "Haraf Pilih Satuan yang akan di Hapus");
    }
    return json_encode($satuan->delete());
  }
  public function access($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Satuan Ini Khusus Super Admin Atau Dapat Akses Menu Satuan");

    $satuan = $this->satuan->first($id);
    if (!$satuan)
      return  $this->not_permition(401, "Haraf Pilih Satuan yang akan di Hapus");

    $this->load->model("pemission/Role_model", "role");
    $roles = $this->role->all();

    $data = [
      'page_title' => "Tambah Satuan Users",
      "form_action_add" => base_url("admin/satuan/tambah"),
    ];
    return  $this->template->load('admin', 'admin/satuan/access', array_merge($data, compact("satuan", "roles")));
  }
  public function changeAccess($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Satuan Ini Khusus Super Admin Atau Dapat Akses Menu Satuan");

    $satuan = $this->satuan->first($id);
    if (!$satuan)
      return  $this->not_permition(401, "Haraf Pilih Satuan yang akan di Hapus");

    $message = "Access Ditambahkan";
    try {
      $roleId = $this->input->post("role_id");
      $role = $satuan->roles()->first($roleId);
      if (!$role) {
        $satuan->roles()->attach($roleId, ['model_type' => get_class($satuan)]);
      } else {
        $satuan->roles()->detach($role->id);
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

  public function subsatuan($id)
  {
    $satuan = $this->satuan->first($id);
    if (!$satuan) return  $this->not_permition();
    return $satuan;
  }

  public function getData()
  {

    return $this->output->set_content_type("application/json")
      ->set_output(json_encode($this->satuan->getDatatable()));
  }
  public function show($id = null)
  {
    $satuan = $id ? $this->satuan->first($id) : $this->satuan;

    if ($this->input->is_ajax_request()) {
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode($satuan));
    }
  }
}
