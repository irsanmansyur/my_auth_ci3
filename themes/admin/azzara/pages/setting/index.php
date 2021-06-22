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
            <h4 class="page-title">Mengatur aplikasi</h4>
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
                <a href="#">Setting Aplikasi</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('admin/setting/add'); ?>" class="btn btn-primary">Add Setting</a>
            </div>
            <form class="form form-horizontal" method="post" action="" enctype="multipart/form-data">
              <div class="card-body">
                <?php foreach ($settings as $key => $val) : ?>
                  <?php if ($key == "theme_public" || $key == "theme_admin") { ?>

                    <div class="form-group setting">

                      <label for="<?= $key; ?>"><?= $key; ?>
                      </label>
                      <select class="form-control" name="<?= $key; ?>" id="<?= $key; ?>">
                        <?php foreach (${$key} as $rows => $value) : ?>
                          <option <?= $val == $value ? "selected" : '' ?> value="<?= $value; ?>" class="py-2"><?= $value; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  <?php } elseif ($key == 'logo') { ?>

                    <div class="form-group  setting">
                      <label for="<?= $key; ?>">Input file Image Only</label>
                      <input type="file" class="form-control-file" name="<?= $key; ?>" id="<?= $key; ?>">
                    </div>
                  <?php } else { ?>
                    <div class="form-group  setting">
                      <label for="<?= $val; ?>" class="w-100">
                        <div class="d-flex justify-content-between align-item-center">
                          <span><?= $key; ?></span>
                          <span class="delete-setting btn badge badge-danger" endpoint="<?= base_url("admin/setting/delete/" . $key); ?>">Delete</span>
                        </div>
                      </label>
                      <input class="form-control" value="<?= $val; ?>" id="<?= $val; ?>" name="<?= $key; ?>" placeholder="Input Here">
                    </div>
                  <?php } ?>
                <?php endforeach; ?>

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
    let elSetting = document.querySelectorAll(".setting");
    elSetting.forEach(setting => {
      setting.addEventListener("click", async (e) => {
        const target = e.target;
        if (target.classList.contains("delete-setting")) {
          e.preventDefault();
          swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            buttons: {
              cancel: {
                visible: true,
                text: 'No, cancel!',
                className: 'btn btn-danger'
              },
              confirm: {
                text: 'Yes, delete it!',
                className: 'btn btn-success'
              }
            }
          }).then(async (willDelete) => {
            if (willDelete) {
              let res = await fetch(target.getAttribute('endpoint'), {
                method: "post"
              }).then(res => res.json());
              if (res.status === true) {
                setting.remove();
                swal("Success  deleted!", {
                  buttons: {
                    confirm: {
                      className: 'btn btn-success'
                    }
                  }
                });
              } else {
                return swal("Gagal menghapus!");
              }
            } else {
              swal("tidak jadi menghapus!", {
                buttons: {
                  confirm: {
                    className: 'btn btn-success'
                  }
                }
              });
            }
          });
        }
      })
    })
  </script>

</body>

</html>