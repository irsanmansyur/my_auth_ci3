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
                <a href=<?= base_url('admin/dashboard'); ?>>Dashboard</a>
              </li>

              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Profiles User</a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="card card-with-nav">
                <div class="card-header">
                  <h3 class="mt-4">Identitas user</h3>
                  <?php echo validation_errors(); ?>
                </div>
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <div class="form-group form-group-default">
                          <label>Name</label>
                          <input type="text" class="form-control" name="name" placeholder="Name" value="<?= $user->name ?? set_value('name'); ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group form-group-default">
                          <label>Username</label>
                          <input type="text" readonly class="form-control" name="username" placeholder="Name" value="<?= $user->username ??  set_value('username'); ?>">
                        </div>
                      </div>


                    </div>
                    <div class="row mt-3">

                      <div class="col-md-12">
                        <div class="form-group form-group-default">
                          <label>status</label>
                          <select class="form-control" id="status" name="status">
                            <option <?= $user->status == 'aktif' ? 'selected' : ''; ?> value="aktif">aktif</option>
                            <option value="non aktif" <?= $user->status == 'non aktif' ? 'selected' : ''; ?>>Non Aktif</option>
                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <div class="form-group form-group-default">
                          <label>Email</label>
                          <input type="email" readonly class="form-control" name="email" placeholder="Name email" value="<?= $user->email  ??  set_value('email'); ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group form-group-default">
                          <label>Password</label>
                          <input type="password" class="form-control" name="password">
                        </div>
                        <span class="text-danger">Kosonkan Jika tidak ingin di ubah</span>

                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-12">
                        <div class="form-group form-group-default">
                          <h3>Ganti Gambar (Klik gambar di bawah)</h3>
                          <div class="card-avatar">
                            <input type="file" name="gambar" id="imagechange" class="d-none" />
                            <a href="#pablo" id="changePhoto">
                              <img class="img thumbnail rounded-circle" style="width: 100px;height:100px;" src="<?= base_url('assets/img/profile/' . $user->profile) ?>">
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="text-right mt-3 mb-3">
                      <button class="btn btn-success" type="submit">Save</button>
                      <button class="btn btn-danger" type="resets">Reset</button>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <?php $this->load->view($thema_load . "partials/_card_profile.php"); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <div class="custom-template">
      <div class="title">Settings</div>
      <div class="custom-content">
        <div class="switcher">
          <div class="switch-block">
            <h4>Topbar</h4>
            <div class="btnSwitch">
              <button type="button" class="changeMainHeaderColor" data-color="blue"></button>
              <button type="button" class="selected changeMainHeaderColor" data-color="purple"></button>
              <button type="button" class="changeMainHeaderColor" data-color="light-blue"></button>
              <button type="button" class="changeMainHeaderColor" data-color="green"></button>
              <button type="button" class="changeMainHeaderColor" data-color="orange"></button>
              <button type="button" class="changeMainHeaderColor" data-color="red"></button>
            </div>
          </div>
          <div class="switch-block">
            <h4>Background</h4>
            <div class="btnSwitch">
              <button type="button" class="changeBackgroundColor" data-color="bg2"></button>
              <button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
              <button type="button" class="changeBackgroundColor" data-color="bg3"></button>
            </div>
          </div>
        </div>
      </div>
      <div class="custom-toggle">
        <i class="flaticon-settings"></i>
      </div>
    </div>
    <!-- End Custom template -->
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
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
  </script>
</body>

</html>