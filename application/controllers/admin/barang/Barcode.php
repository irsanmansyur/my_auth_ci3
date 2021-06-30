<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barcode extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
    if (!in_role([1, "Kasir"]) && !can("Cetak Barcode"))
      return  $this->not_permition(403, "Anda Tidak punya akses Cetak Barcode");
  }

  public function index($id = null)
  {
    return $this->template->load('admin', 'master/barang/barcode_cetak', [
      "page_title" => "Cetak Barcode",
    ]);
  }
  public function list()
  {
    $barangs = $this->barang->select("keranjangs.jumlah_barang")->join("keranjangs", "keranjangs.barang_id=barangs.id")->where("keranjangs.jenis", "cetak barcode")->all();
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    return $this->template->view('admin', 'master/barang/partials/_list_barcode', [
      "barangs" => $barangs,
      "generator"  => $generator
    ]);
  }

  public function create_qr_code($barang)
  {

    if (is_file(FCPATH . '/assets/img/barang/qr_code/' . $barang->kode . ".png"))
      return '/assets/img/barang/qr_code/' . $barang->kode . ".png";

    $this->load->library('ciqrcode'); //pemanggilan library QR CODE

    $config['cacheable']    = true; //boolean, the default is true
    $config['cachedir']     = './assets/'; //string, the default is application/cache/
    $config['errorlog']     = './assets/'; //string, the default is application/logs/
    $config['imagedir']     = './assets/img/barang/qr_code/'; //direktori penyimpanan qr code
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = '1024'; //interger, the default is 1024
    $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
    $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
    $this->ciqrcode->initialize($config);

    $qr_code_name = $barang->kode . '.png'; //buat name dari qr code sesuai dengan kode barang

    $params['data'] = $barang->kode; //data yang akan di jadikan QR CODE
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = FCPATH . $config['imagedir'] .   $qr_code_name; //simpan image QR CODE ke folder assets/images/

    $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
  }
}
