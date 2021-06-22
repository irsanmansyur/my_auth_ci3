<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Setting extends Admin_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Setting_model', "setting");
  }
  function index()
  {
    if (!in_role("Super Admin"))
      return  $this->not_permition(403, "Menu Ini Khusus SUper Admin");
    $settings = (object) $this->data['settings'];
    foreach ($settings as $key => $val) {
      if ($key != 'logo' and $key != 'theme_public') {
        $this->form_validation->set_rules($key, $key, 'required');
      }
    }
    if ($this->form_validation->run()) {
      foreach ($this->input->post() as $row => $value) {
        $where = ['name' => $row];
        $data = ['value' => $value];
        $this->db->update("settings", $data, $where);
      }

      if ($_FILES['logo']['name']) {
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = '2048';
        $config['upload_path'] = './assets/img/setting/';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('logo')) {
          if (is_file(FCPATH . 'assets/img/setting/' . $settings->logo) && $settings->logo !== 'default.jpg')
            unlink(FCPATH . 'assets/img/setting/' . $settings->logo);
          $settings->logo = $this->upload->data('file_name');
          $where = ['name' => "logo"];
          $data = ['value' =>  $settings->logo];
          $this->db->update("settings", $data, $where);
        } else {
          die($this->upload->display_errors());
        }
      }
      $this->session->set_flashdata('success', "Setting Have Updated .!");
      return back();
    } else {

      $data = [
        'page_title' => "Settings Aplikasi",
        'theme_admin' => $this->template->bacaThemes('admin'),
        'theme_public' => $this->template->bacaThemes('public'),
      ];
      $this->template->load('admin', 'setting/index', $data);
    }
  }
  function getAllUser()
  {
    $list = $this->user_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $log) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $log->nip;
      $row[] = $log->name;
      $row[] = $log->email;
      $row[] = $log->alamat;
      // $row[] = $log->image;
      $row[] = date("d M, Y,  H:i:s A", $log->date);
      $row[] = '<a href="' . base_url('admin/admin/delete/') . $log->nip . '"  class="badge badge-pill badge-primary">Delete</a>';
      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->user_model->count_all(),
      "recordsFiltered" => $this->user_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }




  // CM_delete
  function delete($name)
  {
    $setting =  $this->setting->where("name", $name)->first();
    if (!$setting || !$setting->delete())
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('status' => false, "message" => "Gagal Menghapus")));
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('status' => true, "message" => "Berhasil Menghapus")));
  }


  // CM_delete
  function delete_setting($id)
  {
    $where = ['id_setting' => $id];
    $this->setting_m->delete_setting($where);
    hasilCUD("Sukses Menghapus pengaturan .!");
    redirect(base_url("admin/admin/setting"));
  }

  // CM_insert page
  function add()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('value', 'Value', 'trim|required');
    if ($this->form_validation->run()) {
      $name = str_replace(" ", "_", $this->input->post('name'));
      $data = [
        'name   ' => $name,
        'value' => $this->input->post('value'),
        'status' => $this->input->post('status') ? 1 : 0
      ];
      $this->db->insert("settings", $data);
      $this->session->set_flashdata('success', "Managed to add new settings.!");
      return  redirect('admin/setting');
    }
    $data = [
      'page_title' => "Add Settings",
      "form_action_add" => base_url('admin/setting/add')
    ];
    $this->template->load('admin', 'setting/add', $data);
  }

  private function upload($filename = 'default.jpg')
  {
    if ($_FILES['logo']['name']) {
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size']      = '2048';
      $config['upload_path'] = './assets/img/setting/';
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('logo')) {
        if (is_file(FCPATH . 'assets/img/setting/' . $filename) && $filename != 'default.jpg')
          unlink(FCPATH . 'assets/img/setting/' . $filename);

        $filename = $this->upload->data('file_name');
      } else {
        echo $this->upload->display_errors();
      }
    }
    return $filename;
  }
}
