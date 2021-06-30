<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view($thema_load . "partials/_head.php"); ?>

  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
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
          </div>
          <div class="card card-body">
            <form action="<?= base_url("kasir/keranjang/tambah"); ?>" method="POST" id="submitBarang">
              <div class="row">
                <div class="col-md-4 col-12">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <button class="btn btn-info" type="button">
                        <i class="fas fa-barcode"></i> Barcode
                      </button>
                    </div>
                    <input type="text" class="form-control" autofocus="autofocus" id="barcode_change" placeholder="" name="kode_barang" aria-label="" aria-describedby="basic-addon1">
                  </div>
                </div>
                <div class="col-md-8 col-12">
                  <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-success btn-lg mb-3" data-toggle="modal" data-target="#modal-barang">
                      <i class="fa fa-search"></i></i> Cari Barang
                    </button>
                    <a href="javascript:void(0)" class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#my-modal">
                      <i class="fas fa-camera"></i> Scan Barcode
                    </a>
                  </div>
                </div>
              </div>
            </form>
            <hr>
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
            </div>
          </div>
          <div class="card card-body text-right">
            <div class="my-1">
              <input type="text" disabled id="jumlah_bayar_text" class="form-control text-danger font-weight-bold form-control-lg text-right" value="Rp. 0">
            </div>
            <button class="btn btn-primary" id="btnBayar">Selesai & Bayar</button>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalBayar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" action="<?= base_url("kasir/penjualan/bayar"); ?>" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group py-0 ">
                  <label class="mb-0 mb-sm-2" for="kasir">Kasir</label>
                  <input class="form-control  p-1" value="<?= $user->name ?>" disabled id="kasir" name="kasir">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group p-0">
                  <div class="d-flex justify-content-between">
                    <label class="mb-0 mb-sm-2" for="selectPelanggan">Nama Pelanggan</label>
                  </div>
                  <select endpoint="<?= base_url("api/user"); ?>" class="js-data-example-ajax form-control p-1" style="width:100%" id="selectPelanggan" name="pelanggan_id">
                    <option value="" selected="selected">Pelanggan Umum</option>
                  </select>
                </div>
              </div>
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
            <div class="d-flex justify-content-between mt-2 pb-2">
              <div class="col-md-6 pl-0">
                <h5 class="sub">Metode Pembayaran</h5>
                <div class="form-check form-check-inline pb-0">
                  <div class="custom-control custom-radio">
                    <input type="radio" id="metode_bayar1" name="metode_bayar" class="custom-control-input" value="tunai" checked="">
                    <label class="custom-control-label" for="metode_bayar1">Tunai</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="metode_bayar2" name="metode_bayar" class="custom-control-input" value="non tunai">
                    <label class="custom-control-label" for="metode_bayar2">Non Tunai</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 pr-0">
                <h5 class="sub">Status Pembayaran</h5>
                <div class="form-check form-check-inline pb-0">
                  <div class="custom-control custom-radio">
                    <input type="radio" id="status1" name="status_bayar" class="custom-control-input" value="lunas" checked="">
                    <label class="custom-control-label" for="status1">Lunas</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="status_bayar_kredit" name="status_bayar" value="kredit" class="custom-control-input">
                    <label class="custom-control-label" for="status_bayar_kredit">Kredit</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-2 d-none" id="jatuh_tempo">
              <div class="col-12">
                <h5 class="sub">Jatuh Tempo</h5>
                <input type="date" name="jatuh_tempo" class="form-control" value="<?= date("Y-m-d", strtotime("+7 day", strtotime(date("M d, Y")))); ?>">
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

    <!-- modal barang -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Barang Modal" aria-hidden="true" id="modal-barang">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-body">
            <?php $this->load->view($thema_load . "pages/kasir/penjualan/partials/_datatable_jual_barang"); ?>
          </div>
        </div>
      </div>
    </div>

    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url("assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"); ?>"></script>
  <script src="<?= base_url("assets/vendor/select2/js/select2.min.js"); ?>"></script>

  <script src="<?= $thema_folder . "pages/kasir/penjualan/partials/main.js?" . time(); ?>"></script>

  <script>
    $("#selectPelanggan").select2({
      data: {
        id: 1,
        selected: true,
        text: 'Barn owl'
      },
      ajax: {
        url: $("#selectPelanggan").attr('endpoint'),
        processResults: function(data, params) {
          params.page = params.page || 1;
          return {
            results: data.data.data.map(User => {
              if (User.name === "UMUM")
                User.selected = true;
              User.text = User.name;
              return User;
            }),
            pagination: {
              more: (params.page * 10) < data.data.recordsFiltered
            }
          };
        },
        data: function(params) {
          let query = {
            search: params.term,
            role: "Pelanggan",
            page: params.page || 1
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
    $('#selectPelanggan').on('select2:select', function(e) {
      let data = e.params.data;
      $("[name=pelanggan_id]").val(data.id);
    });

    $("[name=uangBayar]").on("input", function(e) {
      let uang_bayar = toDecimal($(this).val());
      let total_bayar = toDecimal($("[name=jumlah_bayar]").val());
      if (uang_bayar > total_bayar) {
        $("[name=bayar]").attr("disabled", false);
        $("#status1").prop('checked', true);
      }
    })

    $("[name=status_bayar]").change(function(e) {
      setPembayaran();
    })
  </script>
</body>

</html>