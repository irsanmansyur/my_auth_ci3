<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
  <link rel="stylesheet" href="<?= base_url("assets/vendor/jquery-ui-1.12.1/jquery-ui.min.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("assets/vendor/select2/css/select2.min.css"); ?>">
</head>

<body>
  <div class="wrapper">

    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title"><?= $page_title; ?></h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url('admin/dashboard'); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Penjualan</a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="card border border-primary">
                <div class="card-header text-white bg-primary">Informasi Pelanggan</div>
                <div class="card-body p-2">
                  <form action="<?= base_url("kasir/keranjang/tambah"); ?>" method="POST">
                    <div class="form-group p-0">
                      <div class="d-flex justify-content-between">
                        <label class="mb-0 mb-sm-2" for="selectPelanggan">Nama Pelanggan</label>
                        <!-- <a id="newPelanggan" href="#">
                            <span class="text-primary link text-right"><span class="d-none d-md-inline">Tambah </span>Pelanggan ?</span>
                          </a> -->
                      </div>
                      <select endpoint="<?= base_url("api/user"); ?>" class="js-data-example-ajax form-control p-1" id="selectPelanggan" name="selectPelanggan"></select>
                    </div>
                    <div class="form-group  p-0">
                      <label class="mb-0 mb-sm-2" for="emailPelanggan">Email</label>
                      <input class="form-control  p-1" disabled id="emailPelanggan" name="emailPelanggan">
                    </div>
                    <div class="form-group  p-0">
                      <label class="mb-0 mb-sm-2" for="no_hp">No HP/Telephone</label>
                      <input class="form-control  p-1" disabled id="no_hp" name="no_hp">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-8  m-auto">
              <div class="card">
                <div class="card-body p-1">
                  <div class="search-barang">
                    <div class="w-100 col-lg-8">
                      <form action="<?= base_url("kasir/keranjang/tambah"); ?>" method="POST" id="submitBarang">
                        <div class="form-group">
                          <label for="inputKode">Input Kode / Cari Nama Barang</label>
                          <input type="hidden" name="kode_barang" hidden>
                          <select class="text-left js-data-example-ajax form-control p-1" id="inputKode" name="inputKode"></select>
                        </div>
                      </form>
                    </div>
                  </div>
                  <hr style="margin-top: 65px;">
                  <div class="table-responsive">
                    <table id="keranjang-datatable" class="table table-hover display table table-striped table-hover" endpoint="<?= base_url("kasir/keranjang/datatable"); ?>">
                      <thead>
                        <tr>
                          <th scope="col" width="20px"></th>
                          <th scope="col">#</th>
                          <th scope="col">Nama Barang</th>
                          <th scope="col" style="width: 70px!important;">Jumlah</th>
                          <th scope="col" class="text-left" style="text-align:left">Total</th>
                        </tr>
                      </thead>
                    </table>


                    <div class="card card-body text-right">
                      <div class="my-1">
                        <input type="text" disabled id="jumlah_bayar_text" class="form-control text-danger form-control-lg text-right" value="Rp. 0">
                      </div>
                      <button class="btn btn-primary" id="btnBayar">Selesai & Bayar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="modalBayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <form class="modal-content" action="<?= base_url("kasir/penjualan/bayar"); ?>" method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group py-0 ">
                <label class="mb-0 mb-sm-2" for="kasir">Kasir</label>
                <input class="form-control  p-1" value="<?= $user->name ?>" disabled id="kasir" name="kasir">
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group py-0">
                    <label class="mb-0 mb-sm-2" for="no_invoice">No Invoice/Nota</label>
                    <input type="text" class="form-control p-1" id="no_invoice" name="no_invoice" value="<?= $penjualan->getLastId("no_invoice", "INV-" . date("Ymd") . "-"); ?>" readonly>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group py-0 ">
                    <label class="mb-0 mb-sm-2" for="tgl_invoice">Tanggal</label>
                    <input type="date" class="form-control  p-1" value="<?= date("Y-m-d"); ?>" id="tgl_invoice" name="tgl_invoice">
                  </div>
                </div>
              </div>
              <hr>
              <input class="hidden" name="pelanggan_id" hidden>
              <div class="form-group">
                <label class="sr-only" for="uangBayar">0</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Rp.</div>
                  </div>
                  <input value="<?= set_value("uangBayar"); ?>" class="rupiah form-control form-control-lg text-right" name="uangBayar" min="0" placeholder="Rp. 00">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="jumlah_bayar">Jumlah Bayar</label>
                    <input type="text" class="form-control form-control-lg text-right" id="jumlah_bayar" value="" readonly name="jumlah_bayar">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="kembalian">Kembalian</label>
                    <input type="text" class="form-control form-control-lg text-right" id="kembalian" value="" readonly name="kembalian">
                  </div>
                </div>
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="bayar" class="btn btn-primary">Bayar Sekarang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url("assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"); ?>"></script>
  <script src="<?= base_url("assets/vendor/select2/js/select2.min.js"); ?>"></script>

  <script src="<?= $thema_folder . "pages/kasir/penjualan/partials/main.js?" . time(); ?>"></script>
</body>

</html>