<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf_ extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
    $this->load->library("Pdf");
  }



  public function index($id = null)
  {

    $this->Pdf->view();
    return $this->template->load('admin', 'master/barang/index', [
      "page_title" => "Daftar barang",
      "barangs"  => $this->barang->all(),
    ]);
  }
  public function print_view($barang_id)
  {

    $barang = $this->barang->first($barang_id);

    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $qrcode =  $this->create_qr_code($barang);

    $html =  $this->template->view('admin', 'master/barang/partials/_show_barcode', [
      "barcode_img" => "data:image/png;base64," . base64_encode($generator->getBarcode($barang->kode, $generator::TYPE_CODE_128)),
      "barang"  => $barang
    ], TRUE);

    $this->pdf->view($html, $barang->nama);
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
