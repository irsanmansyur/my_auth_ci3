<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Keranjang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
    $this->load->model("Keranjang_model", "keranjang");
  }
  public function index()
  {
    if (!can("Kasir")  && !in_role(["Kasir"]))
      return  $this->not_permition(403, "Kategori Ini Khusus Admin Atau Dapat Akses Menu Kasir");
    if ($this->input->is_ajax_request()) {
      return $this->getData();
    }
    $data = [
      'page_title' => "Penjualan Barang",
    ];
    $this->template->load('admin', 'penjualan/index', $data);
  }
  public function tambah()
  {
    $kodeBarang = $this->input->get_post("kode_barang");

    $barang = $this->barang->where("kode", $kodeBarang)->first();
    if (!$barang)
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode(['status' => false, "message" => "Barang Tidak Di Temukan", "request" => $this->input->post()]));
    if ($barang->stok < 1)
      return $this->output->set_content_type("application/json")
        ->set_output(json_encode(['status' => false, "message" => "Stok Barang Habis", "request" => $this->input->post()]));

    $keranjang = $this->keranjang->where("kasir_id", user()->id)->where("barang_id", $barang->id)->first();

    if ($keranjang)
      $keranjang->update([
        "jumlah_barang" => $keranjang->jumlah_barang += ($this->input->get_post("jumlahBarang") ?  $this->input->get_post("jumlahBarang") : 1)
      ]);
    else
      $keranjang = $this->keranjang->save([
        "kasir_id" => user()->id,
        'barang_id' => $barang->id,
        "jumlah_barang" => $this->input->get_post("jumlahBarang") ?  $this->input->get_post("jumlahBarang") : 1,
      ]);

    return $this->output->set_content_type("application/json")
      ->set_output(json_encode(['status' => true, "message" => "Barang Di tambahkan ke keranjang", "data" => ["keranjang" => $keranjang, "barang" => $barang]]));
  }
  public function getData()
  {
    $keranjangs = $this->keranjang->getDatatable("ready");
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode($keranjangs));
  }
  public function kurangi($id)
  {
    $keranjang = $this->keranjang->where("kasir_id", user()->id)->first($id);
    if ($keranjang->jumlah_barang  - 1 <= 0) {
      return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => false, "message" => "Tidak Boleh Kurang dari 1 (satu)", "data" => ["keranjang" => $keranjang]]));
    }
    $keranjang->jumlah_barang -= 1;
    $keranjang->update();
    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Jumlah Barang di kurangi", "data" => ["keranjang" => $keranjang]]));
  }
  public function tambahi($id)
  {
    $keranjang = $this->keranjang->where("kasir_id", user()->id)->first($id);
    $barang = $keranjang->barang;
    if ($barang->stok < $keranjang->jumlah_barang + 1) {
      return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => false, "message" => "Stock Barang Tidak Mencukupi", "data" => ["keranjang" => $keranjang]]));
    }
    $keranjang->jumlah_barang += 1;
    $keranjang->update();
    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Berhasil menambah jumlah", "data" => ["keranjang" => $keranjang]]));
  }
  public function ubah($id, $jumlah)
  {
    $keranjang = $this->keranjang->where("kasir_id", user()->id)->first($id);

    $barang = $keranjang->barang;
    if ($barang->stok  < $jumlah) {
      return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => false, "message" => "Stock Barang Tidak Mencukupi", "data" => ["keranjang" => $keranjang]]));
    }

    $keranjang->jumlah_barang = $jumlah;
    $keranjang->update();
    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Berhasil menambah jumlah", "data" => ["keranjang" => $keranjang]]));
  }
  public function delete($id = null)
  {
    if (!$id || $id == "null")
      $del = $this->keranjang->where("kasir_id", user()->id)->delete();
    else
      $del =  $this->keranjang->delete($id);

    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => $del, "message" => "Berhasil Menghapus barang pada keranjang"]));
  }

  public function datatable()
  {
    $params =  $this->params_datatable();
    if ($this->input->get_post("jenis"))
      $params['where']["kasir_id"] = user()->id;
    if ($this->input->get_post("mulai_tanggal"))
      $params['where']["penjualans.created_at >="] = $this->input->get_post("mulai_tanggal");
    if ($this->input->get_post("sampai_tanggal"))
      $params['where']["penjualans.created_at <="] = $this->input->get_post("sampai_tanggal");
    $params['columns'] = ["barangs.nama", "barangs.kode"];

    $select = "barangs.kode as kode_barang,barangs.nama as nama_barang,barangs.harga_jual";
    $keranjangs = $this->keranjang->select($select)->join("barangs", "barangs.id=keranjangs.barang_id")->get_data($params);

    $recordsFiltered = $this->keranjang->select($select)->join("barangs", "barangs.id=keranjangs.barang_id")->search_and_order($params)->count();
    foreach ($keranjangs as $i => $keranjang) {
      $keranjangs[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $keranjangs[$i]->text =   $keranjang->nama_barang . "||" . $keranjang->kode_barang;
      $keranjangs[$i]->harga = rupiah($keranjang->harga_jual);
      $keranjangs[$i]->total_harga = rupiah($keranjang->jumlah_barang * $keranjang->harga_jual);

      $keranjangs[$i]->total_detail = "<div class='text-right'> <u>{$keranjangs[$i]->harga} x $keranjang->jumlah_barang </u><br>{$keranjangs[$i]->total_harga}</div>";
      rupiah($keranjang->harga_jual);

      $keranjangs[$i]->dibuat_pada =  _ago($keranjang->created_at);
      $keranjangs[$i]->jumlahset = "<div style='min-width:70px'><input type='button' name='ubahJumlah' jenis='kurang' value='-' class='btn btn-warning ubahJumlah p-1'/> 
      <input type='number' style='font-size: 13px;opacity: 1;border-radius:3px;width:30px'  value='$keranjang->jumlah_barang' class='p-1 jumlah_val'/> 
      <input type='button' name='ubahJumlah'  jenis='tambah' value='+' class='btn btn-primary ubahJumlah p-1' /></div>";
      $keranjangs[$i]->delete = '<button class="btn btn-danger ubahJumlah" jenis="delete" style="padding:7px 5px"><i class="fas fa-trash"></i></button>';


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
      "length" => $length == "-1" ? 10 : $length,
      "start" =>  $this->input->get_post("start") ?? $page * ($length == "-1" ? 10 : $length) - ($length == "-1" ? 10 : $length)
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
