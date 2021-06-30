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
            <h4 class="page-title">Setting Aplikasi TOKO</h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url(); ?>">
                  <i class="flaticon-home">Home</i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="#">TOKO</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
            </div>
            <form class="form form-horizontal" method="post" action="" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="info-text">Sesuaikan dengan informasi Toko Anda.</h4>
                  </div>
                  <div class="col-12">
                    <div class="form-group w-50 my-2 mx-auto text-center">
                      <label>Gambar Toko :</label>
                      <div class="input-file input-file-image" id="changePhoto">
                        <img class="img thumbnail rounded-circle" id="" style="width: 100px;height:100px;" src="<?= base_url('assets/img/setting/' . ($setting_toko->logo ? $setting_toko->logo : 'default.png')); ?>"><br><br>
                        <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" required="">
                        <label for="uploadImg" class=" label-input-file btn btn-primary">Upload a Image</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama Toko :</label>
                      <input name="name_app" type="text" class="form-control" required="" value="<?= set_value("alamat", null)  ??  $setting_toko->name_app  ?>">
                      <?= form_error('name_app', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                      <label>Alamat Toko :</label>
                      <input name="alamat" type="text" class="form-control" required="" value="<?= set_value("alamat", null)  ??  $setting_toko->alamat  ?>">
                      <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Telp :</label>
                      <input name="telp" type="text" class="form-control" required="" value="<?= set_value("telp", null)  ??  $setting_toko->telp  ?>">
                      <?= form_error('telp', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                      <label>Email :</label>
                      <input name="email" type="text" class="form-control" required="" value="<?= set_value("email", null)  ??  $setting_toko->email  ?>">
                      <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button class="btn btn-success" type="submit">Submit</button>
                <button class="btn btn-danger" type="reset">Reset</button>
              </div>
            </form>
          </div>

        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#changePhoto').find('.img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $('input#uploadImg').change(function() {
      readURL(this);
    });
  </script>
</body>

</html>