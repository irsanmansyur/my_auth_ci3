<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Barang_model" => "barang", "Keranjang_model" => "keranjang"]);
  }

  public function tambah()
  {
    $barang = $this->barang->harga_khusus()->first($this->input->post("barang_id"));
    if (!$barang)
      return $this->not_permition(404, "Barang Tidak Di Temukan");
    $keranjang = $this->keranjang->where("jenis", "cetak barcode")->where("barang_id", $barang->id)->first();
    if (!$keranjang)
      $this->keranjang->save([
        "barang_id" => $barang->id,
        "jenis" => "cetak barcode",
        "jumlah_barang" => 1,
        "harga_jual" => isset($barang->harga_jual_khusus) ? $barang->harga_jual_khusus : $barang->harga_jual,
        "harga_beli" => isset($barang->harga_beli_khusus) ? $barang->harga_beli_khusus : $barang->harga_beli
      ]);
    else
      $keranjang->update([
        "jumlah_barang" => $keranjang->jumlah_barang + 1
      ]);
    return $this->output->set_content_type("applicatiob/json")->set_output(json_encode(['status' => true, "message" => "Barang Ditambahakan ke Keranjang"]));
  }

  public function hapus($id_keranjang)
  {
    $id_keranjang = $this->input->input_stream("keranjang_id");
    if ($id_keranjang == "semua") {
      $this->keranjang->delete();
      return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Keranjang Di hapus"]));
    }
    $keranjang = $this->keranjang->where("jenis", $this->input->input_stream("jenis"))->first($id_keranjang);
    if (!$keranjang)
      return $this->not_permition(200, "Anda Tidak Memiliki akses");
    $keranjang->delete();
    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Keranjang Di hapus"]));
  }

  public function ubah()
  {
    $id_keranjang = $this->input->input_stream("id_keranjang");
    $jumlah = $this->input->input_stream("jumlah");

    $keranjang = $this->keranjang->select("barangs.stok")->join("barangs", "barangs.id=keranjangs.barang_id")->where("jenis", $this->input->input_stream("jenis"))->first($id_keranjang);
    if (!$keranjang) {
      return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => false, "message" => "Anda Tidak Punya Akses", "jumlah" => $keranjang->jumlah_barang]));
    } else if ($keranjang->stok < $jumlah)
      return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => false, "message" => "Stok Barang Maksimal $keranjang->stok", "jumlah" => $keranjang->jumlah_barang]));
    $keranjang->update(['jumlah_barang' => $jumlah]);
    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Berhasil Merubah", "jumlah" => $keranjang->jumlah_barang]));
  }
  public function datatable()
  {
    $params =  $this->params_datatable();
    if ($this->input->get_post("jenis"))
      $params['where'] = ["jenis" => $this->input->get_post("jenis")];

    $select = "barangs.nama,barangs.kode";
    $keranjangs = $this->keranjang->select($select)->join("barangs", "barangs.id=keranjangs.barang_id")->get_data($params);
    $recordsFiltered = $this->keranjang->select($select)->join("barangs", "barangs.id=keranjangs.barang_id")->search_and_order($params)->count();

    foreach ($keranjangs as $i => $keranjang) {
      $keranjangs[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $keranjangs[$i]->kode =   $keranjang->kode;
      $keranjangs[$i]->text =   $keranjang->kode . " || " . $keranjang->nama . " | " . $keranjang->jumlah_barang;
      $keranjangs[$i]->harga_jual_rp = rupiah($keranjang->harga_jual);
      $keranjangs[$i]->harga_beli_rp = rupiah($keranjang->harga_beli);
      $keranjangs[$i]->dibuat_pada =  _ago($keranjang->created_at);
      $keranjangs[$i]->hapus = $this->template->view('admin', 'master/keranjang/partials/_btn_hapus', [], true);
      $keranjangs[$i]->ubah_jumlah = $this->template->view('admin', 'master/keranjang/partials/_btn_ubah_jumlah', [
        "keranjang" => $keranjang
      ], true);
      $keranjangs[$i]->action = $this->template->view('admin', 'master/keranjang/partials/_btn_action', [
        "keranjang" => $keranjang
      ], true);



      $with = $this->input->get_post("with");
      if ($with) {
        $with = is_string($with) ? [$with] : $with;
        foreach ($with as $v) {
          $keranjangs[$i]->{$v};
        }
      }
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "recordsTotal" => $this->keranjang->select($select)->join("barangs", "barangs.id=keranjangs.barang_id")->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $keranjangs,
      ]));
  }
  private function params_datatable()
  {
    $page = $this->input->get_post("page") ?? 1;
    $length = $this->input->get_post("length") ?? 10;
    $params = [
      "length" => $length,
      "start" =>  $this->input->get_post("start") ?? $page * $length - $length
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
