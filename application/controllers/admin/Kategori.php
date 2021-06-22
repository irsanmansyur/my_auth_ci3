<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Kategori extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Kategori_model", "kategori");
  }
  public function index()
  {


    if (!in_role(["Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Kategori Ini Khusus Admin Atau Dapat Akses Kategori Master");
    $data = [
      'page_title' => "Master Kategori",
    ];
    $this->template->load('admin', 'master/kategori/index', $data);
  }

  public function  tambah()
  {
    if (!in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Kategori Ini Khusus Admin Atau Dapat Akses Kategori Master");

    $kategori = $this->kategori;

    $this->form_validation->set_rules($kategori->getRules());
    if ($this->form_validation->run()) {
      $kategori->save();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Kategori success addet');
      else
        $this->session->set_flashdata("danger", 'Kategori cannot addet');
      redirect("admin/kategori");
    }
    $data = [
      'page_title' => "Tambah Kategori",
      "form_action_add" => base_url("admin/kategori/tambah"),
    ];
    $this->template->load('admin', 'master/kategori/tambah', array_merge($data, compact("kategori")));
  }
  public function edit($id)
  {
    $kategori =  $this->kategori->first($id);
    if (!$id || !$kategori) {
      return  $this->not_permition(401, "Haraf Pilih Kategori yang akan di edit");
    }
    if (!in_role([1, "Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Kategori Ini Khusus Super Admin Atau Dapat Akses Menu Master");

    $this->form_validation->set_rules($kategori->getRules());
    if ($this->form_validation->run()) {
      $kategori->update();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Kategori success updated');
      else
        $this->session->set_flashdata("danger", 'Kategori cannot updated');
      redirect("admin/kategori");
    } else {
      $data = [
        'page_title' => "Edit Kategori Users",
        "form_action_edit" => base_url("admin/kategori/edit/" . $id),
      ];
      $this->template->load('admin', 'master/kategori/edit', array_merge($data, compact("kategori")));
    }
  }
  public function delete($id)
  {
    if (!in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Kategori Ini Khusus  Admin Atau Dapat Akses  Kategori Master");

    $kategori = $this->kategori->first($id);
    if (!$kategori) {
      return  $this->not_permition(401, "Haraf Pilih Kategori yang akan di Hapus");
    }
    return json_encode($kategori->delete());
  }
  public function access($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Kategori Ini Khusus Super Admin Atau Dapat Akses Menu Kategori");

    $kategori = $this->kategori->first($id);
    if (!$kategori)
      return  $this->not_permition(401, "Haraf Pilih Kategori yang akan di Hapus");

    $this->load->model("pemission/Role_model", "role");
    $roles = $this->role->all();

    $data = [
      'page_title' => "Tambah Kategori Users",
      "form_action_add" => base_url("admin/kategori/tambah"),
    ];
    return  $this->template->load('admin', 'admin/kategori/access', array_merge($data, compact("kategori", "roles")));
  }
  public function changeAccess($id)
  {
    if (!in_role([1, "Super Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Kategori Ini Khusus Super Admin Atau Dapat Akses Menu Kategori");

    $kategori = $this->kategori->first($id);
    if (!$kategori)
      return  $this->not_permition(401, "Haraf Pilih Kategori yang akan di Hapus");

    $message = "Access Ditambahkan";
    try {
      $roleId = $this->input->post("role_id");
      $role = $kategori->roles()->first($roleId);
      if (!$role) {
        $kategori->roles()->attach($roleId, ['model_type' => get_class($kategori)]);
      } else {
        $kategori->roles()->detach($role->id);
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

  public function subkategori($id)
  {
    $kategori = $this->kategori->first($id);
    if (!$kategori) return  $this->not_permition();
    return $kategori;
  }

  public function getData()
  {
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode($this->kategori->getDatatable()));
  }
}
