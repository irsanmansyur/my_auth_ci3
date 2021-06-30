<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Barang_model", "barang");
  }



  public function index($id = null)
  {
    return $this->template->load('admin', 'master/barang/index', [
      "page_title" => "Daftar barang",
      "barangs"  => $this->barang->all(),
    ]);
  }
  public function list()
  {
    in_role([1, 2]);
    $users = $this->db->where('id!=', 1)->get("users");
    $data = [
      'page_title' => "List Users",
      'users'  => $users,
    ];

    $this->template->load('admin', 'user/index', $data);
  }

  public function delete($id)
  {
    $barang = $this->barang->first($id);

    if (!$barang || $this->input->method() != "delete" || !in_role([1, "Admin"]) && !can("Master"))
      return  $this->not_permition(403, "Anda Tidak punya akses menghapus Barang");

    if ($barang->gambar !== "default.png" && is_file(FCPATH . "assets/img/barang/" . $barang->gambar))
      unlink(FCPATH . "assets/img/barang/" . $barang->gambar);
    return json_encode($barang->delete());
  }

  public function getData($tipe = null)
  {
    // mengambil parameter datatable
    $params = $this->params_datatable();

    // Setting parameter untuk barang tersedia
    if ($tipe)   $params['ready'] = true;

    // Mengembalikan berupa json
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode($this->barang->getDatatable($params)));
  }
  public function show_barcode($barang_id)
  {
    $barang = $this->barang->first($barang_id);
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

    $qrcode =  $this->create_qr_code($barang);

    return $this->template->view('admin', 'master/barang/partials/_show_barcode', [
      "barcode_img" => "data:image/png;base64," . base64_encode($generator->getBarcode($barang->kode, $generator::TYPE_CODE_128)),
      "barang"  => $barang
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

  public function datatable()
  {
    $params =  $this->params_datatable();
    if ($this->input->get_post("stok"))
      $params['where'] = ["stok >" => "0"];

    $barangs = $this->barang->harga_khusus()->get_data($params);

    $recordsFiltered = $this->barang->search_and_order($params)->count();
    foreach ($barangs as $i => $barang) {
      $barangs[$i]->urut = isset($params['order']) &&  $params['order'][1] == "desc" ? $recordsFiltered - $params['start'] - $i : $params['start'] + $i + 1;
      $barangs[$i]->kode =   $barang->kode;
      $barangs[$i]->text =   $barang->kode . " || " . $barang->nama . " | " . $barang->stok;
      $barangs[$i]->harga_jual = rupiah(isset($barang->harga_jual_khusus) ? $barang->harga_jual_khusus : $barang->harga_jual);
      $barangs[$i]->harga_beli = rupiah($barang->harga_beli);
      $barangs[$i]->tanggal_kadaluarsa =  date("d F Y", strtotime($barang->expired_at));
      $barangs[$i]->dibuat_pada =  _ago($barang->created_at);
      $barangs[$i]->action = $this->template->view('admin', 'master/barang/partials/_action_datatable', [
        "barang" => $barang
      ], true);
      if ($this->input->post("pilih_barang"))
        $barangs[$i]->pilih = $this->template->view('admin', 'master/barang/partials/_action_pilih_barang', [
          "barang" => $barang
        ], true);


      $with = $this->input->get_post("with");
      if ($with) {
        $with = is_string($with) ? [$with] : $with;
        foreach ($with as $v) {
          $barangs[$i]->{$v};
        }
      }
    }
    return $this->output->set_content_type("application/json")
      ->set_output(json_encode([
        "recordsTotal" => $this->barang->count(),
        "recordsFiltered" => $recordsFiltered,
        "data" => $barangs,
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
