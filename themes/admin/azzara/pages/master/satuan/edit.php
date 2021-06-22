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
                <a href="<?= base_url(); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href=<?= base_url('admin/satuan'); ?>>Daftar satuan</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Edit satuan <b><?= $satuan->nama; ?></b></a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form Edit satuan</div>
            </div>
            <form action="<?= $form_action_edit; ?>" method="post">
              <div class="card-body">
                <?php $this->load->view($thema_load . "pages/master/satuan/partials/_input.php"); ?>

              </div>
              <div class="card-action">
                <button class="btn btn-success" type="submit">Submit</button>
                <button class="btn btn-danger">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

</body>

</html>