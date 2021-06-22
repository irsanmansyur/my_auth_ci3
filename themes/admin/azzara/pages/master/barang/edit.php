<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>

</head>

<body>
  <div class="wrapper">
    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>

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
                <a href=<?= base_url('admin/barang'); ?>>Daftar barang</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Edit barang <b><?= $barang->nama; ?></b></a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form Edit barang</div>
            </div>
            <form action="<?= $form_action_edit; ?>" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <?php $this->load->view($thema_load . "pages/master/barang/partials/_input.php"); ?>
              </div>
              <div class="card-action">
                <a class="btn btn-success btn-border" href="<?= base_url("admin/barang/data"); ?>"><i class="fas fa-undo"></i></a>
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-danger" type="reset">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>


</body>

</html>