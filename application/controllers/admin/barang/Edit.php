<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Edit extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Barang_model" => "barang", "Kategori_model" => "kategori", "Satuan_model" => "satuan"]);
  }

  public function index($id = null)
  {
    $barang  = $this->barang->first($id);
    if (!in_role("Admin") || !$barang)
      return $this->not_permition();

    return $this->template->load('admin', 'master/barang/edit', [
      "page_title" => "Edit Data Barang",
      "form_action_edit" => base_url("admin/barang/edit/update/" . $id),
      "satuans" => $this->satuan->all(),
      "kategoris" => $this->kategori->all(),
      "barang" => $barang,
    ]);
  }
  public function update($id)
  {
    $barang  = $this->barang->first($id);
    if (!in_role("Admin") || !$barang)
      return $this->not_permition();

    $this->form_validation->set_rules($barang->getRules());
    $imagename = $this->upload($barang->gambar);
    if (!$this->form_validation->run() || $imagename === null) {
      $this->session->set_flashdata("danger", "Validasi Gagal");
      return $this->index($id);
    }
    $barang->gambar =  $imagename;
    $barang->update();
    $this->session->set_flashdata("success", "Barang Telah di Update");
    return redirect(base_url("admin/barang/data"));
  }

  private function upload($filename = 'default.png')
  {
    if ($_FILES['gambar']['name']) {
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size']      = '2048';
      $config['upload_path'] = './assets/img/barang/';
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('gambar')) {
        if (is_file(FCPATH . 'assets/img/barang/' . $filename) && $filename != 'default.jpg')
          unlink(FCPATH . 'assets/img/barang/' . $filename);
        $filename = $this->upload->data('file_name');
      } else {
        $this->session->set_flashdata("img_error", $this->upload->display_errors());
        return null;
      }
    }
    return $filename;
  }
}
