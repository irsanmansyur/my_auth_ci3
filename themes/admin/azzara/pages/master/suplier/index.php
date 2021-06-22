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
                <a href="#">Master suplier</a>
              </li>
            </ul>
          </div>
          <div class="card" id="parentContent">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('admin/suplier/tambah'); ?>" class="btn btn-primary tambah-suplier">Tambah</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="suplier-datatable" class="table table-hover display table table-striped table-hover" endpoint="<?= base_url("admin/suplier/data/getData"); ?>">
                  <thead>
                    <tr>
                      <th scope="col">Kode</th>
                      <th scope="col">Nama</th>
                      <th scope="col">alamat</th>
                      <th scope="col">telp</th>
                      <th scope="col">status</th>
                      <th scope="col">Dibuat Pada</th>
                      <th scope="col">Action</th>
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

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="<?= $thema_folder . "pages/master/suplier/partials/main.js?" . time(); ?>"></script>

</body>

</html>