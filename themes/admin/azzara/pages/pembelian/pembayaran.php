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
          <div class="section-header">
            <h1><i class="fa fa-shopping-bag"></i> Pembayaran Pembelian Barang</h1>
          </div>
          <div class="card card-body mt-4">
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
                  <button class="btn btn-success btn-lg mb-3" id="btn-modal_kredit" data-toggle="modal" data-target="#modal-pembelian">
                    <i class="fa fa-search"></i> Cari Pembelian
                  </button>
                  <a href="javascript:void(0)" class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#my-modal">
                    <i class="fas fa-camera"></i> Scan Barcode
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div id="detail-pembelian">

          </div>
        </div>

        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Barang Modal" aria-hidden="true" id="modal-pembelian">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-body">
            <?php $this->load->view($thema_load . "pages/pembelian/partials/_datatable_kredit"); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
    <!-- End Custom template -->
  </div>
  <script>
    $("#btn-modal_kredit").click(function() {
      datatable_kredit.ajax.reload();
    })

    function bayar_status(res) {
      if (res.status) {
        $("#detail-pembelian").html("");
        btn_pilih(res.pembelian)
        datatable_kredit.ajax.reload();
      }
      return alert(res.message)
    }

    function btn_pilih(pembelian) {
      $.ajax({
        url: baseUrl + `admin/pembelian/data/get/${pembelian.id}`,
        success: function(html) {
          $("#detail-pembelian").html(html)
          $("#modal-pembelian").modal("hide")
        },
        'error': function(xmlhttprequest, textstatus, message) {
          if (textstatus === "timeout") {
            alert("request timeout");
          } else {
            alert("request timeout");
          }
        }
      })
    }
  </script>
</body>

</html>