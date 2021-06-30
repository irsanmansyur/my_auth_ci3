<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
  <link rel="stylesheet" href="<?= base_url("assets/vendor/select2/css/select2.min.css"); ?>">
</head>

<body>
  <div class="wrapper">
    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>

    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
    <script src="<?= base_url(); ?>assets/js/autoNumeric.min.js"></script>
    <script src="<?= base_url("assets/vendor/select2/js/select2.min.js"); ?>"></script>
    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-4 col-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button class="btn btn-info" type="button">
                      <i class="fas fa-barcode"></i> Barcode
                    </button>
                  </div>
                  <input type="text" class="form-control" autofocus="autofocus" id="barcode_change" placeholder="" aria-label="" aria-describedby="basic-addon1">
                </div>
              </div>
              <div class="col-md-8 col-12">
                <div class="d-flex justify-content-between">
                  <button class="btn btn-success btn-lg mb-3" data-toggle="modal" data-target="#modal-barang">
                    <i class="fa fa-search"></i></i> Cari Produk
                  </button>
                  <a href="javascript:void(0)" class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#my-modal">
                    <i class="fas fa-camera"></i> Scan Barcode
                  </a>
                </div>
              </div>
            </div>
            <div class="table-responsive border-top pt-2">
              <?php $this->load->view($thema_load . "pages/pembelian/partials/_datatable_keranjang"); ?>

            </div>
          </div>
          <div class="card card-body text-right">
            <div class="input-group my-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><b>TOTAL</b></span>
              </div>
              <input type="text" class="form-control form-lg rupiah" id="total" readonly="" style="font-size:20px;font-weight:700;background:rgb(240, 243, 62)">
            </div>
            <button class="btn btn-primary btn-lg d-inline" data-toggle="modal" data-target="#modal-bayar">Bayar</button>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Barang Modal" aria-hidden="true" id="modal-barang">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-body">
            <?php $this->load->view($thema_load . "pages/pembelian/partials/_datatable_pilih_barang"); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" role="dialog" aria-labelledby="Modal Bayar" aria-hidden="true" id="modal-bayar">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-check"></i> Pembayaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <?php $this->load->view($thema_load . "pages/pembelian/partials/_form_bayar"); ?>
        </div>
      </div>
    </div>
    <!-- Custom template | don't include it in your project! -->
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
    <!-- End Custom template -->
  </div>

  <script src="<?= $thema_folder; ?>assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

  <script>
    $('#modal-bayar').on('shown.bs.modal', function(e) {
      $("#jumlah_bayar").focus();
    })
    $("#barcode_change").on("change", function(e) {
      e.preventDefault();
      tambah_keranjang($(this));
    })

    function tambah_keranjang(elChange) {
      const obj = document.createElement("audio");
      obj.src = `${baseUrl}assets/audio/beep.mp3`;
      let kode_barang = elChange.val();
      $.ajax({
        url: baseUrl + `admin/pembelian/keranjang/tambah`,
        type: "POST",
        data: {
          "kode_barang": kode_barang,
          "_token": "RCBpEL5TVTyGLO1HH4noARt3iPt3yp9IigB2bHLD",
        },
        beforeSend: function() {
          obj.play();
        },
        complete: function() {
          $("#barcode_change").val("");
        },
        success: function(res) {
          if (res.status) {
            return datatable_keranjang.ajax.reload();
          }
          alert(res.message)
        },
        'error': function(xmlhttprequest, textstatus, message) {
          if (textstatus === "timeout") {
            alert("request timeout");
          } else {
            alert("request timeout");
          }
        }
      });
    }
  </script>
</body>

</html>