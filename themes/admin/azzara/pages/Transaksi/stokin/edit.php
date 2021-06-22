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
    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title"><?= $page_title; ?></h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url(); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href=<?= base_url('admin/barang/stokin'); ?>>List Stock IN</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Stock In</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form Stock IN barang</div>
            </div>
            <form action="<?= base_url("admin/barang/stokin/edit/" . $restok->id) ?>" method="post">
              <div class="card-body">
                <?php $this->load->view($thema_load . "pages/transaksi/stokin/partials/_input.php"); ?>
              </div>
              <div class="card-action">
                <button class="btn btn-success" type="submit">Submit</button>
                <button class="btn btn-danger" type="reset">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
  </div>
  <script src="<?= base_url("assets/vendor/select2/js/select2.min.js"); ?>"></script>
  <script src="<?= base_url("assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"); ?>"></script>

</body>

</html>