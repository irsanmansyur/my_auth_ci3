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
            <h1><i class="fa fa-shopping-bag"></i> <?= $page_title; ?></h1>
          </div>
          <div class="card card-body mt-4 p-2 p-md-3">
            <div class="row">
              <div class="col-md-4 col-12">
                <div class="input-group mb-3 mb-md-0">
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
                  <button class="btn btn-lg btn-success col-12 col-md-auto" id="btn-modal_kredit" data-toggle="modal" data-target="#modal-penjualan-kredit">
                    <i class="fa fa-search"></i> Cari Penjualan Kredit
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div id="detail-penjualan">

          </div>
        </div>

        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Barang Modal" aria-hidden="true" id="modal-penjualan-kredit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="title-modal-daftar-barang">Daftar Pinjaman Pelanggan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card card-body p-1 p-md-2">
              <?php $this->load->view($thema_load . "pages/penjualan/partials/_datatable_kredit"); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
    <!-- End Custom template -->
  </div>
  <script>
    $(document).ready(() => {
      $("#btn-modal_kredit").click(function() {
        datatable_kredit.ajax.reload();
      })
    })

    function bayar_status(res) {
      if (res.status) {
        $("#detail-penjualan").html("");
        btn_pilih(res.penjualan)
        datatable_kredit.ajax.reload();
      }
      return alert(res.message)
    }

    function btn_pilih(penjualan) {
      set_skeleton_detail();
      $("#modal-penjualan-kredit").modal("hide")
      $.ajax({
        url: baseUrl + `admin/penjualan/data/get/${penjualan.id}`,
        success: function(html) {
          $("#detail-penjualan").html(html)
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

    function set_skeleton_detail() {
      let html = /* html */ `
        <div class="d-flex flex-column flex-md-row">
          <div class="col-md-7 order-md-2 pl-md-2 px-0">
            <div class="ph-items">
              <div class="ph-row">
                  <div class="ph-col-6 big"></div>
              </div>
              <div class="mt-2 ph-item ph-picture"></div>
            </div>
            <div class="ph-items">
              <div class="ph-row">
                  <div class="ph-col-6 big"></div>
              </div>
              <div class="mt-2 ph-item ph-picture"></div>
            </div>
          </div>
          <div class="col-md-5 order-md-1 px-0">
              <div class="ph-items w-100 mb-1 mb-md-4">
                  <div class="ph-row">
                    <div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div>
                  </div>
                  <div class="ph-row">
                    <div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div>
                  </div>
              </div>
              <div class="ph-items w-100 mt-2 mb-md-3">
                <div class="ph-row">
                    <div class="ph-col-6 big"></div>
                </div>
                <div class="mt-2 ph-item ph-picture"></div>
              </div>
          </div>
        </div>`;
      $("#detail-penjualan").html(html)
    }
  </script>
</body>

</html>