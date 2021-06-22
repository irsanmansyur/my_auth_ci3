<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends MY_Controller
{

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   * 		http://example.com/index.php/welcome
   *	- or -
   * 		http://example.com/index.php/welcome/index
   *	- or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model(["Barang_model" => "barang", "Kategori_model" => "kategori", "Suplier_model" => "suplier", "Satuan_model" => "satuan"]);
  }
  public function index()
  {
    foreach ($this->data_suplier() as $key => $value) {
      if (!empty($value['nama']))
        $this->suplier->save([
          "kode" => $this->suplier->getLastId("kode", "SPL-" . date("Ymd") . "-"),
          "nama" => $value['nama'],
        ]);
    }
    // $this->load->view("test");
  }
  public function data_satuan()
  {
    return [
      ["nama" => "BOX"],
      ["nama" => "BUNGKUS"],
      ["nama" => "CANs"],
      ["nama" => "GONI"],
      ["nama" => "KALENG"],
      ["nama" => "KARDUS"],
      ["nama" => "KARTON"],
      ["nama" => "LUSIN"],
      ["nama" => "PACKs"],
      ["nama" => "PAPAN"],
      ["nama" => "PCs"],
      ["nama" => "SLOF"],
      ["nama" => "STRIP"],
      ["nama" => "TABLET"],
      ["nama" => "TUBE"]
    ];
  }
  public function upload()
  {
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $reader->setReadDataOnly(true);

    // lokasi file excel dari file yang di upload
    $spreadsheet = $reader->load($_FILES['fileexcel']['tmp_name']);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    // hapus baris pertama
    unset($rows[0]);

    $tz = 'Asia/Jakarta';
    $dt = new DateTime("now", new DateTimeZone($tz));
    $timestamp = $dt->format('Y-m-d G:i:s');

    $hitungSukses = 0;
    $hitungGagal = 0;
    foreach ($rows as $key => $value) {
      $kategori = $this->kategori->where("nama", $value[5])->first();
      $suplier = $this->suplier->where("nama", $value[7])->first();
      $satuan = $this->satuan->where("nama", $value[11])->first();
      $data_barang = [
        'kode' => $value[1],
        "nama" => $value[4],
        "kategori_id" =>  $kategori->id ?? null,
        "suplier_id" =>  $suplier->id ?? null,
        "satuan_id" =>  $satuan->id ?? null,
        "stok" =>  $value[9] ?? 1,
        "harga_jual" => $value[16] ?? 0,
        "harga_jual" => $value[17] ?? 0
      ];
      $this->barang->save($data_barang);
    }
  }
  private function data_kategori()
  {
    return   $kategories = [
      ["nama" => "KACANG TANAH"],
      ["nama" => "ALAT BANGUNAN"],
      ["nama" => "ALAT LISTRIK"],
      ["nama" => "ALAT RUMAH TANGGA"],
      ["nama" => "BEER"],
      ["nama" => "BERAS"],
      ["nama" => "BISKUIT"],
      ["nama" => "BUMBU"],
      ["nama" => "COKELAT"],
      ["nama" => "DETERGEN"],
      ["nama" => "DIET FOOD"],
      ["nama" => "ELEKTRONIK"],
      ["nama" => "ES"],
      ["nama" => "GULAPUTIH"],
      ["nama" => "JAS HUJAN"],
      ["nama" => "KAPAS"],
      ["nama" => "KECAP & SAUCE"],
      ["nama" => "KONSINYASI"],
      ["nama" => "KOSMETIK"],
      ["nama" => "LAIN-LAIN"],
      ["nama" => "MAKANAN"],
      ["nama" => "MAKANAN BAYI"],
      ["nama" => "MAKANAN HEWAN"],
      ["nama" => "MAKANAN KALENG"],
      ["nama" => "MAKANAN PAGI"],
      ["nama" => "MANISAN"],
      ["nama" => "MENTEGA"],
      ["nama" => "MIE"],
      ["nama" => "MINUMAN"],
      ["nama" => "MINYAK GORENG"],
      ["nama" => "MINYAK RAMBUT"],
      ["nama" => "OBATAN"],
      ["nama" => "PAKAIAN"],
      ["nama" => "PAMPERS"],
      ["nama" => "PARFUM"],
      ["nama" => "PASTA & S-GIGI"],
      ["nama" => "PECAH BELAH"],
      ["nama" => "PEMBALUT WANITA"],
      ["nama" => "PEMBERSIH"],
      ["nama" => "PERMEN"],
      ["nama" => "PRODUCT BAYI"],
      ["nama" => "ROKOK"],
      ["nama" => "SABUN & SAMPHOO"],
      ["nama" => "SEMIR SEPATU"],
      ["nama" => "SLAI/JAM"],
      ["nama" => "SNACK"],
      ["nama" => "STATIONERY"],
      ["nama" => "SUSU"],
      ["nama" => "SYRUP"],
      ["nama" => "TANDAS"],
      ["nama" => "TEH & KOPI"],
      ["nama" => "TEPUNG"],
      ["nama" => "TISSUE"]
    ];
  }
  public function data_suplier()
  {
    return [
      ["nama" => "ABAD DUA SATU M"],
      ["nama" => "ABDI BATAM, UD"],
      ["nama" => "ABM"],
      ["nama" => "AGS"],
      ["nama" => "AKP[ANUGRAH KAR"],
      ["nama" => "ALAM JAYA WIRAS"],
      ["nama" => "ANGUANG"],
      ["nama" => "ANTARIKSA NIAGA"],
      ["nama" => "ANTARMITRA SEMB"],
      ["nama" => "ANUGERAH PERKAS"],
      ["nama" => "ANUGERAH PHARMI"],
      ["nama" => "ANUGERAH PUTRA"],
      ["nama" => "ARTA BOGA CEMER"],
      ["nama" => "ARTA SAWANG KUN"],
      ["nama" => "ASIA MAKMUR PER"],
      ["nama" => "BATAM PAPER CV"],
      ["nama" => "BATAM PEPER CV"],
      ["nama" => "BENTORO ADISAND"],
      ["nama" => "BERKAT STATIONE"],
      ["nama" => "BINTAN SUKSES M"],
      ["nama" => "BINTANG BARU, P"],
      ["nama" => "BINTANG LIMA, P"],
      ["nama" => "CAHAYA SENTOSA"],
      ["nama" => "CIPTA MANDIRI"],
      ["nama" => "CITRA JATIM MAN"],
      ["nama" => "CITRA JAYA, CV"],
      ["nama" => "CITRA UTAMA DIS"],
      ["nama" => "COCA COLA DISTR"],
      ["nama" => "COLAMAS INDAH S"],
      ["nama" => "CV MEGA MANDIRI"],
      ["nama" => "CV REZEKI MANDI"],
      ["nama" => "CV. KIAT SEJAHT"],
      ["nama" => "CV.FELIX SNACK"],
      ["nama" => "CV.JAYA RAYA"],
      ["nama" => "CV.TK.USAHA BER"],
      ["nama" => "CV.WAHANA TIRTA"],
      ["nama" => "DJEMBATAN DUA"],
      ["nama" => "DOS NI ROHA, PT"],
      ["nama" => "DOSNI KONSINYAS"],
      ["nama" => "ENSEVAL PUTERA"],
      ["nama" => "ERA"],
      ["nama" => "ESHAM INDRAYA S"],
      ["nama" => "GAJAH MADA"],
      ["nama" => "GARUDA EMAS SNA"],
      ["nama" => "GEMBIRA"],
      ["nama" => "GOLDEN MITRA AN"],
      ["nama" => "GOLDEN STAR"],
      ["nama" => "HANSEL DNP, PT"],
      ["nama" => "HARAPAN JAYA RE"],
      ["nama" => "HERO MULIA"],
      ["nama" => "INDOGABEN SUKSE"],
      ["nama" => "INDOMARCO"],
      ["nama" => "INDOMEDIKA MULI"],
      ["nama" => "INDOSINMA JAYA,"],
      ["nama" => "JAYA PUTRA SAWA"],
      ["nama" => "JOHN & CO"],
      ["nama" => "KAPAL TANKER"],
      ["nama" => "KIMIA FARMA"],
      ["nama" => "LAM COSMETIC, U"],
      ["nama" => "LESTARI MANDIRI"],
      ["nama" => "LIM SIANG HUAT"],
      ["nama" => "MAHA NAGA, TK"],
      ["nama" => "MAKP, PT"],
      ["nama" => "MEGA MALL BTM C"],
      ["nama" => "MENSA BINASUKSE"],
      ["nama" => "MERAPI UTAMA PH"],
      ["nama" => "MESTIKA BATAM S"],
      ["nama" => "MIRTA SITTA FAL"],
      ["nama" => "MITRA MANDIRI T"],
      ["nama" => "MITRA PELITA SU"],
      ["nama" => "MMP"],
      ["nama" => "MULTI GLOBAL TR"],
      ["nama" => "NAGOYA HILL"],
      ["nama" => "NATURAL ALTOVIR"],
      ["nama" => "NATURAL NUTRIND"],
      ["nama" => "NKC RUPAT KARYA"],
      ["nama" => "P & C DWI LESTA"],
      ["nama" => "P.N.I"],
      ["nama" => "PANCA MITRA NIA"],
      ["nama" => "PD BINTANG BARU"],
      ["nama" => "PENTA VALENT.PT"],
      ["nama" => "PERMATA SURYA B"],
      ["nama" => "PERSADA OASIS S"],
      ["nama" => "PRIMA JAYA"],
      ["nama" => "PRIMA RINTIS SE"],
      ["nama" => "PRINTIS PRIBADI"],
      ["nama" => "PT AJINAMOTO SA"],
      ["nama" => "PT ANUGRAH PERK"],
      ["nama" => "PT CITRA UTAMA"],
      ["nama" => "PT KARYA CITRA"],
      ["nama" => "PT MARGA NUSANT"],
      ["nama" => "PT MULIATAMA"],
      ["nama" => "PT MULTIBOGA A"],
      ["nama" => "PT PRIMA NIAGA"],
      ["nama" => "PT SELATINDO BA"],
      ["nama" => "PT SINAR SOSRO"],
      ["nama" => "pt tiga benua"],
      ["nama" => "PT. SUKSES JAYA"],
      ["nama" => "PT.ARTHA JAYA S"],
      ["nama" => "PT.ATRI DISTRIB"],
      ["nama" => "PT.BATAM JAYA M"],
      ["nama" => "PT.BDP"],
      ["nama" => "PT.CERIA INDONE"],
      ["nama" => "PT.CONLONG INDO"],
      ["nama" => "PT.MEGA PRIMA P"],
      ["nama" => "PT.MEKAR MITRA"],
      ["nama" => "PT.MUJUR INDO P"],
      ["nama" => "PT.MULTIBOGA AR"],
      ["nama" => "PT.S-TRA PLASTI"],
      ["nama" => "PT.SINBAT"],
      ["nama" => "PT.SUKSES DINAM"],
      ["nama" => "PT.SUKSES JAYA"],
      ["nama" => "PT.SUMBER SARI"],
      ["nama" => "PT.SURON NIAGA"],
      ["nama" => "PT.TIGARAKSA SA"],
      ["nama" => "PT.YAFINDO MIT"],
      ["nama" => "PT.YAKULT INDON"],
      ["nama" => "PT.YOFA NIAGA P"],
      ["nama" => "RADIANT SENTRAL"],
      ["nama" => "RUPAT KARYA SE"],
      ["nama" => "SAN JAYA"],
      ["nama" => "SANDI JAYA"],
      ["nama" => "SANTRI JAYA.CV"],
      ["nama" => "SELAMAT JAYA, C"],
      ["nama" => "SELAMAT PAGI"],
      ["nama" => "SELATANINDO SAR"],
      ["nama" => "SERAYA MAKMUR P"],
      ["nama" => "SINARINDO"],
      ["nama" => "SKS"],
      ["nama" => "SNS.PT"],
      ["nama" => "SRIJAYA RAYA PE"],
      ["nama" => "STAR MARA"],
      ["nama" => "STARTMARA PRATA"],
      ["nama" => "SUKSES JAYA IND"],
      ["nama" => "SUKSES MAKMUR C"],
      ["nama" => "SUMBER CIPTA AG"],
      ["nama" => "SUMBER REZEKI A"],
      ["nama" => "SUMBER SARI,CV"],
      ["nama" => "SURYA JAYA BHAK"],
      ["nama" => "SURYA LESTARI G"],
      ["nama" => "TANESIA, PT"],
      ["nama" => "tbs"],
      ["nama" => "TEMPO, PT"],
      ["nama" => "TIGA BENUA"],
      ["nama" => "TITIAN SINAR MU"],
      ["nama" => "TOKO GUNUNG KAW"],
      ["nama" => "TRIMAJU JAYA P"],
      ["nama" => "UD.MITRA PELITA"],
      ["nama" => "UNITED DICO CIT"],
      ["nama" => "vincent"],
      ["nama" => "VS PERSADA"],
      ["nama" => "WELLYSON ARTA"],
      ["nama" => "WIGO DISTRIBUSI"],
      ["nama" => "Z"],
      ["nama" => "ZEND PERMATA SU"],
    ];
  }
}
