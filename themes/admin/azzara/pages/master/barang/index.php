<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
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
                <a href="#">Master barang</a>
              </li>
            </ul>
          </div>
          <div class="card" id="parentContent">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('admin/barang/tambah'); ?>" class="btn btn-primary tambah-barang">Tambah</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="barang-datatable" class="table table-striped table-bordered table-hover" style="width:100%" endpoint="<?= base_url("admin/barang/data/datatable"); ?>">
                  <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Kode</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Harga Jual</th>
                      <th scope="col">Harga Beli</th>
                      <th scope="col">Stok</th>
                      <th scope="col">Tanggal Kadaluarsa</th>
                      <th scope="col">Dibuat Pada</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

  <!-- Modal -->
  <div class="modal fade" id="modal-show_barcode" tabindex="-1" role="dialog" aria-labelledby="modal-show-barcodeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-show-barcodeLabel">Barcode</h5>
          <input type="hidden" name="barang_id" id="barang_id">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
  </div>

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="<?= $thema_folder . "pages/master/barang/partials/main.js?" . time(); ?>"></script>
  <script>
    $("#barang-datatable").on("click", ".btn-show_barcode", function(e) {
      let data = $("#barang-datatable").DataTable().row($(this).parents('tr')).data();
      $("#barang_id").val(data.id);
      $('#modal-show_barcode').modal('show');
    })

    $('#modal-show_barcode').on('show.bs.modal', function(e) {
      $('#modal-show_barcode').find("modal-body").html(`<img src="/assets/img/loading.gif"/>`);
      $.get(baseUrl + `admin/barang/data/show_barcode/` + $("#barang_id").val(), function(data) {
        $("#modal-show_barcode").find(".modal-body").html(data);
      });
    })
  </script>
</body>

</html>