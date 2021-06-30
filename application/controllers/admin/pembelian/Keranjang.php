<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Keranjang extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
    $this->load->model("Keranjang_pembelian_model", "keranjang");
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

    $keranjang = $this->keranjang->where("barang_id", $barang->id)->first();


    if ($keranjang) {
      $keranjang->update([
        "jumlah" => $keranjang->jumlah += ($this->input->get_post("jumlah") ?  $this->input->get_post("jumlah") : 1)
      ]);
    } else
      $keranjang = $this->keranjang->save([
        "harga_jual" => $barang->harga_jual,
        "harga_beli" => $barang->harga_beli,
        'barang_id' => $barang->id,
        "jumlah" => $this->input->get_post("jumlah") ?  $this->input->get_post("jumlah") : 1,
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

  public function ubah($id)
  {
    $keranjang = $this->keranjang->first($id);

    $jumlah = $this->input->post("jumlah");


    $keranjang->harga_beli = $this->input->post("harga_beli");
    $keranjang->harga_jual = $this->input->post("harga_jual");
    $keranjang->jumlah = $jumlah;
    $keranjang->update();
    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => true, "message" => "Berhasil merubah Keranjang Pembelian", "data" => ["keranjang" => $keranjang]]));
  }
  public function delete($id_keranjang = null)
  {
    if (!$id_keranjang || $id_keranjang == "null")
      $del = $this->keranjang->delete();
    else
      $del =  $this->keranjang->delete($id_keranjang);

    return $this->output->set_content_type("application/json")->set_output(json_encode(['status' => $del, "message" => "Berhasil Menghapus barang pada keranjang"]));
  }

  public function datatable()
  {
    $params =  $this->params_datatable();

    $params['columns'] = ["barangs.nama", "barangs.kode", "(keranjang_pembelian.harga_beli*jumlah)"];

    $select = "barangs.kode as kode_barang,barangs.nama as nama_barang,barangs.harga_jual as harga_jual_barang,barangs.harga_beli as harga_beli_barang";

    $keranjangs = $this->keranjang->select($select)->join("barangs", "barangs.id=keranjang_pembelian.barang_id")->get_data($params);

    $recordsFiltered = $this->keranjang->select($select)->join("barangs", "barangs.id=keranjang_pembelian.barang_id")->search_and_order($params)->count();

    foreach ($keranjangs as $i => $keranjang) {
      $keranjangs[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $keranjangs[$i]->text =   $keranjang->nama_barang . "||" . $keranjang->kode_barang;
      $keranjangs[$i]->total_harga = rupiah($keranjang->jumlah * $keranjang->harga_beli);

      $keranjangs[$i]->action = $this->template->view("admin", "pembelian/partials/_action_beli", ["keranjang" => $keranjang], true);

      $keranjangs[$i]->dibuat_pada =  _ago($keranjang->created_at);
      $keranjangs[$i]->jumlahset = "<div style='min-width:70px'><input type='button' name='ubahJumlah' jenis='kurang' value='-' class='btn btn-warning ubahJumlah p-1'/> 
      <input type='number' style='font-size: 13px;opacity: 1;border-radius:3px;width:39px'  value='$keranjang->jumlah' class='p-1 jumlah_val' name='jumlah'/> 
      <input type='button' name='ubahJumlah'  jenis='tambah' value='+' class='btn btn-primary ubahJumlah p-1' /></div>";
      $keranjangs[$i]->delete_update = '<button class="btn btn-danger ubahJumlah" jenis="delete" style="padding:7px 5px"><i class="fas fa-trash"></i></button><button data-toggle="tooltip" title="update harga utama" class="btn btn-primary btn-update ml-1" style="padding:7px 5px"><i class="fas fa-check"></i></button>';
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
        "recordsTotal" => $this->keranjang->select($select)->join("barangs", "barangs.id=keranjang_pembelian.barang_id")->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $keranjangs,
        "total_belanja" => $this->db->select_sum("(harga_beli*jumlah)", "total_belanja")->get("keranjang_pembelian")->row()->total_belanja,
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
