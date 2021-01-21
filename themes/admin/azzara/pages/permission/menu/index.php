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
                <a href="<?= base_url('dashboard'); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Daftar Denda</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('permission/menu/tambah'); ?>" class="btn btn-primary">Tambah</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">nama</th>
                      <th scope="col" colspan="2">Access</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($menus as $key => $menu) : ?>
                      <tr id="<?= $menu->id; ?>" menu_id="<?= $menu->id; ?>">
                        <td><?= $key + 1; ?></td>
                        <td><?= $menu->name; ?></td>
                        <td>
                          <?php foreach ($roles as $role) : ?>
                            <?php if ($role->id !== "1" || ($menu->id !== "1" || $menu->name !== "Permission")) : ?>
                              <div class="checkbox">
                                <label>
                                  <input name="role_id" type="checkbox" value="<?= $role->id; ?>" <?= $menu->roles()->first($role->id) ? "checked='true'" : ''; ?>>
                                  <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                                  <?= $role->name; ?>
                                </label>
                              </div>

                            <?php endif; ?>
                          <?php endforeach; ?>
                        </td>
                        <td>
                          <a href="<?= base_url('permission/submenu?menu_id=' . $menu->id); ?>" class="btn btn-secondary btn-sm rounded">List Submenu</a>
                        </td>
                        <td>
                          <a href="<?= base_url('permission/menu/edit/' . $menu->id); ?>" class="btn btn-warning btn-sm rounded">Edit</a>
                          <a href="<?= base_url('permission/menu/delete/' . $menu->id); ?>" class="delete btn btn-danger btn-sm rounded">Delete</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
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
  <script>
    var baseurl = "<?= base_url() ?>";
    [...document.querySelectorAll(".delete")].forEach(del => {
      del.addEventListener('click', e => {
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
            let res = await fetch(del.getAttribute('href'), {
              method: "post"
            }).then(res => res);
            if (res) {
              del.closest("tr").remove();
              swal("Success  deleted!", {
                buttons: {
                  confirm: {
                    className: 'btn btn-success'
                  }
                }
              });
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

      })
    });

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
            let menuId = elRule.closest("tr").getAttribute("menu_id");
            let ress = await changeAccess(baseUrl + `permission/menu/changeaccess/${menuId}`, {
              role_id: elRule.value
            });
            if (ress.status) {
              swal(`${ress.message}`, {
                buttons: {
                  confirm: {
                    className: 'btn btn-success'
                  }
                }
              });
              window.location.reload()
            } else
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