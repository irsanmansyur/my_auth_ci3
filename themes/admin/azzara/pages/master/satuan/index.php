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
                <a href="#">Master satuan</a>
              </li>
            </ul>
          </div>
          <div class="card" id="parentContent">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <button endpoint="<?= base_url('admin/satuan/tambah'); ?>" data-toggle="modal" data-target=".modal.satuan" type="button" class="btn btn-primary tambah-satuan">Tambah</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="satuan-datatabe" class="table table-hover display table table-striped table-hover" endpoint="<?= base_url("admin/satuan/getData"); ?>">
                  <thead>
                    <tr>
                      <th scope="col">Kode</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>

          <div class="modal satuan" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <form class="modal-content" action="" method="post">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Satuan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="card modal-body">
                  <div class="alert-satuan">

                  </div>
                  <div class="form-group form-group-default">
                    <label for="kode">Kode satuan</label>
                    <input readonly class="form-control" id="kode" placeholder="Input Kode satuan" name="kode" value="" />
                  </div>
                  <div class="form-group form-group-default">
                    <label for="nama">Nama satuan</label>
                    <input class="form-control" id="nama" placeholder="Input Nama satuan" name="nama" value="" />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save changes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="<?= $thema_folder . "pages/master/satuan/partials/main.js?" . time(); ?>"></script>

</body>

</html>