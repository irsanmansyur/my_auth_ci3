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
          <div class="card card-body">
            <?php $this->load->view($thema_load . "pages/transaksi/partials/_datatable_jurnal.php"); ?>
          </div>
        </div>

        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Barang Modal" aria-hidden="true" id="modal-penjualan-kredit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-body">
            <?php $this->load->view($thema_load . "pages/penjualan/partials/_datatable_kredit"); ?>
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
        $("#detail-penjualan").html("");
        btn_pilih(res.penjualan)
        datatable_kredit.ajax.reload();
      }
      return alert(res.message)
    }

    function btn_pilih(penjualan) {
      $.ajax({
        url: baseUrl + `admin/penjualan/data/get/${penjualan.id}`,
        success: function(html) {
          $("#detail-penjualan").html(html)
          $("#modal-penjualan-kredit").modal("hide")
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