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

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="card card-body">
            <h1>Daftar Pembelian Barang</h1>
            <div class="table-responsive border-top pt-md-3">
              <?php $this->load->view($thema_load . "pages/pembayaran/partials/_datatable_pembelian_barang"); ?>
            </div>
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