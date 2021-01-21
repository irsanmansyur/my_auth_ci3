<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends Admin_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }
  function index()
  {
    $user = user();
    $this->load->library('form_validation');
    $this->form_validation->set_rules($user->getRules());
    if ($this->form_validation->run() == false) {
      $data = [
        'page_title' => "Profile User",
      ];
      $this->template->load('admin', 'user/profile', $data);
    } else {
      $dt = [
        "name" => $this->input->post("name"),
        "status" => $this->input->post("status"),
      ];
      if ($this->input->post("password") != "")
        $dt['password'] =  password_hash($this->input->post("password"), PASSWORD_DEFAULT);
      $dt['profile'] = $this->upload($user->profile);
      $id = $user->id;
      $this->db->where('id', $id)->update("users", $dt);
      $this->session->set_flashdata('success', "profile Berhasil di ubah.!");
      redirect('admin/dashboard');
    }
  }



  private function upload($filename = 'default.jpg')
  {
    if ($_FILES['gambar']['name']) {
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size']      = '2048';
      $config['upload_path'] = './assets/img/profile/';
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('gambar')) {
        if (is_file(FCPATH . 'assets/img/profile/' . $filename) && $filename != 'default.jpg')
          unlink(FCPATH . 'assets/img/profile/' . $filename);

        $filename = $this->upload->data('file_name');
      } else {
        echo $this->upload->display_errors();
      }
    }
    return $filename;
  }
}
