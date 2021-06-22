<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diskon extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Diskon_model" => "diskon"]);
  }

  public function index()
  {
    return $this->template->load('admin', 'diskon/index', [
      'page_title' => "Diskon",
    ]);
  }
  public function tambah()
  {
    if (!in_role([1, "Admin"]) && !can("Diskon"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk tambah Diskon");

    $diskon =  new $this->diskon;
    $diskon->getLastId($unique = "kode", $string = "DSK-" . date("Ymd-"));

    $this->form_validation->set_rules($diskon->getRules());
    if ($this->form_validation->run()) {
      $diskon->save();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Diskon Berhasil Di Tambahkan');
      else
        $this->session->set_flashdata("danger", 'Diskon Gagal Di Tambahkan');
      if ($this->input->is_ajax_request()) {
        return $this->output->set_content_type("application/json")
          ->set_output(json_encode(['status' => true,  "message" => "Diskon Telah Di Tambah!", 'data' => $diskon]));
      }
      redirect("admin/diskon");
    }
    if ($this->input->is_ajax_request()) {
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode(['status' => false, "message" => "Validations Errors", 'errors' => $this->form_validation->error_array()]));
    }
    $this->template->load('admin', 'diskon/tambah', array_merge([
      'page_title' => "Tambah Diskon",
      "form_action_add" => base_url("admin/diskon/tambah"),
    ], compact("diskon")));
  }
  public function edit($id)
  {
    $diskon =  $this->diskon->first($id);
    if (!$id || !$diskon) {
      return  $this->not_permition(401, "Haraf Pilih Diskon yang akan di edit");
    }
    if (!in_role([1, "Admin"]) && !can("Menu"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk edit Diskon");

    $this->form_validation->set_rules($diskon->getRules());
    if ($this->form_validation->run()) {
      $diskon->update();
      if ($this->db->affected_rows() > 0)
        $this->session->set_flashdata("success", 'Diskon success updated');
      else
        $this->session->set_flashdata("danger", 'Diskon cannot updated');
      if ($this->input->is_ajax_request()) {
        return $this->output->set_content_type("application/json")
          ->set_output(json_encode(['status' => true,  "message" => "Master Diskon Telah Di Ubah!", 'data' => $diskon]));
      }
      redirect("admin/diskon");
    }
    if ($this->input->is_ajax_request()) {
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode(['status' => false, "message" => "Validations Errors", 'errors' => $this->form_validation->error_array()]));
    }
    $data = [
      'page_title' => "Edit Diskon",
      "form_action_edit" => base_url("admin/diskon/edit/" . $id),
    ];
    $this->template->load('admin', 'diskon/edit', array_merge($data, compact("diskon")));
  }

  public function delete($id)
  {
    if (!in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Anda Tidak punya akses menghapus Diskon");

    $diskon = $this->diskon->first($id);
    if (!$diskon) {
      return  $this->not_permition(401, "Haraf Pilih Diskon yang akan di Hapus");
    }
    return json_encode($diskon->delete());
  }
  public function load_datatable_barang($diskon_id)
  {
    $diskon = $this->diskon->first($diskon_id);
    $this->template->view('admin', 'diskon/partials/_datatable_barang', compact("diskon"));
  }

  public function barang($diskon_id)
  {
    $this->load->model("Barang_model", "barang");
    $diskon = $this->diskon->first($diskon_id);
    $params  = $this->params_datatable();
    $barangs = $this->barang->get_data($params);

    $recordsFiltered = $this->barang->search_and_order($params)->count();

    foreach ($barangs as $i => $barang) {
      $barangs[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $barangs[$i]->diskon_id = $diskon_id;
      $barangs[$i]->harga_jual = rupiah($barang->harga_jual);
      $diskon = $this->diskon->join("barang_diskon", "barang_diskon.diskon_id=diskons.id")->where("diskons.id", $diskon_id)->where("barang_diskon.barang_id", $barang->id)->first();
      if ($diskon) {
        $barangs[$i]->action =  '<button class="btn btn-sm btn-danger btn-pilih-barang" tipe="hapus"><i class="far fa-times-circle"></i></button>';
        $barangs[$i]->status =  '<i class="fas fa-check text-success"></i>';
      } else {
        $barangs[$i]->action =  '<button class="btn btn-sm btn-success btn-pilih-barang" tipe="pilih"><i class="fas fa-check"></i></button>';
        $barangs[$i]->status = "-";
      }
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "draw" => $this->input->get_post("draw") ?? 0,
        "recordsTotal" => $this->diskon->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $barangs,
        "params" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
      ]));
  }
  public function set_barang_diskon($diskon_id, $barang_id, $tipe)
  {
    $diskon = $this->diskon->first($diskon_id);
    if ($tipe == "pilih")
      $diskon->set_barang($barang_id);
    else
      $diskon->hapus_barang($barang_id);
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode(['status' => true]));
  }
  public function datatable()
  {
    $params = $this->params_datatable();
    $diskons = $this->diskon->get_data($params);
    $recordsFiltered = $this->diskon->search_and_order()->count();
    foreach ($diskons as $i => $diskon) {
      $diskons[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $diskons[$i]->nilai_diskon = $diskon->tipe == "amount" ? rupiah($diskon->value) : $diskon->value . "%";
      $diskons[$i]->dibuat_pada =  _ago($diskon->created_at);
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "draw" => $this->input->get_post("draw") ?? 0,
        "recordsTotal" => $this->diskon->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $diskons,
        "params" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
      ]));
  }
  private function params_datatable()
  {
    $params = [
      "draw" => $this->input->get_post("draw") ?? 0,
      "length" => $this->input->get_post("length") ?? 10,
      "start" => $this->input->get_post("start") ?? 0
    ];
    $order = $this->input->get_post("order");
    if ($order) {
      $order_column = $this->input->get_post("columns")[$order['0']['column']]['name'];
      $params['order'] = [$order_column, $order['0']['dir']];
    }

    $search_val = $this->input->get_post("search");
    $search =  is_string($search_val) ? $search_val : (is_array($search_val) ? $search_val['value'] : null);
    if ($search)
      $params["search"] = $search;
    return $params;
  }
}
