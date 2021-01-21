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
                <a href=<?= base_url('permission/menu'); ?>>Menu</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Add Access Menu Rules</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form add access Menu</div>
            </div>
            <form action="" method="post">
              <div class="card-body">
                <div class="row d-flex justify-content-beetwen">
                  <div class="col-md-4">
                    <h3>Role Access</h3>
                    <?php foreach ($roles as $key => $role) { ?>
                      <div class="checkbox">
                        <label>
                          <input name="role_id" type="checkbox" value="<?= $role->id; ?>" <?= $menu->roles()->first($role->id) ? "checked='true'" : ''; ?>>
                          <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                          <?= $role->name; ?>
                        </label>
                      </div>
                    <?php }; ?>
                  </div>
                  <div class="col-md-4">
                    <h3>Menu</h3>
                    <div class="form-group">
                      <label for="solidInput"><?= $menu->name; ?></label>
                      <input readonly type="text" class="form-control input-solid" id="solidInput" name="menu_id" value="<?= $menu->id; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-action">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script>
    let elMenu = document.querySelector('[name="menu_id"]');
    let elRoles = document.querySelectorAll('[name="role_id"]');
    [...elRoles].forEach(elRule => {
      elRule.addEventListener("change", () => {
        let isSelect = elRule.checked;
        swal({
          title: 'Are you sure?',
          text: `this Rules will ${isSelect? "has ":' Not'} access the menu!`,
          type: 'warning',
          buttons: {
            cancel: {
              visible: true,
              text: 'No, cancel!',
              className: 'btn btn-danger'
            },
            confirm: {
              text: 'Yes, Change it!',
              className: 'btn btn-success'
            }
          }
        }).then(async (willChange) => {
          if (willChange) {
            let ress = await changeAccess(baseUrl + `permission/menu/changeaccess/${elMenu.value}`, {
              role_id: elRule.value
            });
            if (ress.status)
              swal(`${ress.message}`, {
                buttons: {
                  confirm: {
                    className: 'btn btn-success'
                  }
                }
              });
            else
              swal(`${ress.message}`, {
                buttons: {
                  confirm: {
                    className: 'btn btn-danger'
                  }
                }
              });

          } else {

            elRule.checked = isSelect ? false : true;
            swal("the procese is canceled!", {
              buttons: {
                confirm: {
                  className: 'btn btn-success'
                }
              }
            });
          }
        });
      })
    })

    async function changeAccess(url = '', data = {}) {
      let fd = new FormData();
      for (let i in data) {
        fd.append(i, data[i])
      }
      const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        body: fd // body data type must match "Content-Type" header
      });
      return response.json(); // parses JSON response into native JavaScript objects
    }
  </script>

</body>

</html>