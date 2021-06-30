<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bayar extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Pembelian_model" => "pembelian", "Keranjang_pembelian_model" => "keranjang"]);
    if (!in_role([1, "Admin"]) && !can("Pembelian"))
      return  $this->not_permition(403, "Anda tidak punya akses untuk Transaksi Pembelian Barang");
  }

  public function index()
  {
    $created_at = date($this->input->post("created_at") . "  H:i:s");
    $pembelian = $this->pembelian->save(
      [
        "kode" => $this->input->post("kode"),
        "total" => $this->input->post("total"),
        "jumlah_bayar" => $this->input->post("jumlah_bayar"),
        "suplier_id" => $this->input->post("suplier_id"),
        "status_order" => $this->input->post("status_order"),
        "created_at" => $created_at,
        "keterangan" => $this->input->post("keterangan"),
        "user_input_id" => $this->input->post("user_input_id"),
        "status_bayar" => $this->input->post("status_bayar"),
        "jatuh_tempo" => $this->input->post("jatuh_tempo"),
        "kembalian" => $this->input->post("kembalian"),
      ]
    );
    $this->transaksi($pembelian);
    $this->apply_keranjang($pembelian);
    return redirect("admin/pembelian/data");
  }
  public function get($id)
  {
    $pembelian = $this->pembelian->first($id);
    $this->apply_keranjang($pembelian);
  }


  public function hapus($id)
  {
    $pembelian = $this->pembelian->first($id);
    $pembelian->barangs()->detach();
    $pembelian->delete();
  }


  public function apply_keranjang($pembelian)
  {
    $keranjangs = $this->keranjang->all();
    $data_attach = [];
    foreach ($keranjangs as $i => $keranjang) {
      $data_attach[$keranjang->barang_id] = [
        "harga_beli" => $keranjang->harga_beli,
        "harga_jual" => $keranjang->harga_jual,
        "jumlah" => $keranjang->jumlah,
      ];
      $barang =  $keranjang->barang;
      $barang->update([
        'stok' => $barang->stok + $keranjang->jumlah
      ]);
      $keranjang->delete();
    }
    $pembelian->barangs()->attach($data_attach);
  }

  public function transaksi($pembelian)
  {
    $data = [
      "kode_transaksi" => (int) $pembelian->id,
      "kembalian" => $pembelian->kembalian,
      "debit_name" => "Pembelian Barang",
      "kredit_name" =>  "Kas"
    ];
    if ($pembelian->status_bayar == "lunas") {
      $data["jenis"] = "pengeluaran";
      $data["jumlah"] = $pembelian->total;
      $data["kembalian"] = $pembelian->kembalian;
      return  $this->db->insert("transaksi", $data);
    } else {
      if ($pembelian->jumlah_bayar > 0) {
        $data["jenis"] = "pengeluaran";
        $data["jumlah"] = $pembelian->jumlah_bayar;
        $this->db->insert("transaksi", $data);
      }
      $data["kredit_name"] = "Utang Pembelian";
      $data["jenis"] = "pemasukan";
      $data["jumlah"] = $pembelian->total - $pembelian->jumlah_bayar;
      $this->db->insert("transaksi", $data);
    }
  }
}
