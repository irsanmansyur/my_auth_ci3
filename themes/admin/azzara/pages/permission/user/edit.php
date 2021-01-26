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
                <a href=<?= base_url('admin/user/list'); ?>>User List</a>
              </li>

              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">edit User</a>
              </li>
              <?php echo validation_errors(); ?>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="card card-with-nav">
                <div class="card-header">
                  <h3 class="mt-4">Identitas user</h3>
                </div>
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <?php $this->load->view($thema_load . "pages/permission/user/partials/_input.php"); ?>
                    <div class="text-right mt-3 mb-3">
                      <button class="btn btn-success" type="submit">Save</button>
                      <button class="btn btn-danger" type="resets">Reset</button>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <?php $this->load->view($thema_load . "partials/_card-profile.php"); ?>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

    <!-- End Custom template -->
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
  <script src="<?= base_url("assets/vendor/select2/js/select2.min.js"); ?>"></script>
  <script>
    // scrip ganti gambar
    $("#changePhoto").click(function() {
      $('input#imagechange').click();
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#changePhoto').find('.img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $('input#imagechange').change(function() {
      readURL(this);
    });

    $("select.select2").select2();
  </script>
</body>

</html>