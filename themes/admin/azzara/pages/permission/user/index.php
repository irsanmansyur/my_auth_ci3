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
                <a href=<?= base_url('dashboard'); ?>>Dashboard</a>
              </li>

              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">list User Access</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('permission/user/add'); ?>" class="btn btn-primary">Add New User</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Profile</th>
                      <th scope="col">nama User</th>
                      <th scope="col">Roles</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($users as $user) : ?>
                      <tr user_id="<?= $user->id; ?>">
                        <td><?= $no++; ?></td>
                        <td><img src="<?= $user->getProfile() ?>" alt="" style="width:100px;height:100px"> </td>
                        <td><?= $user->name; ?></td>
                        <td>
                          <?php foreach ($roles as $role) : ?>
                            <?php if ($user->id !== "1" || $role->id !== "1") : ?>
                              <div class="checkbox">
                                <label>
                                  <input name="role_id" type="checkbox" value="<?= $role->id; ?>" <?= $user->roles()->first($role->id) ? "checked='true'" : ''; ?>>
                                  <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                                  <?= $role->name; ?>
                                </label>
                              </div>
                            <?php endif; ?>

                          <?php endforeach; ?>
                        </td>
                        <td>
                          <a href="<?= base_url('permission/user/edit/' . $user->id); ?>" class="btn btn-warning btn-sm rounded">Edit</a>
                          <a href="<?= base_url('permission/user/delete/' . $user->id); ?>" class="delete btn btn-danger btn-sm rounded">Delete</a>
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
    let elRoles = document.querySelectorAll('[name="role_id"]');
    [...elRoles].forEach(elRule => {
      elRule.addEventListener("change", () => {
        let userId = elRule.closest("tr").getAttribute("user_id");
        let isSelect = elRule.checked;
        swal({
          title: 'Are you sure?',
          text: `this Rules will ${isSelect? "has ":' Not'} access the User!`,
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
            let ress = await postData(baseUrl + `permission/user/changeaccess/${userId}`, {
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
    });
    async function postData(url = '', data = {}) {
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
              let res = await postData(del.getAttribute('href'));
              swal(`${res.message}`, {
                icon: res.status ? "success" : "warning",
                buttons: {
                  confirm: {
                    className: `btn btn-${res.status ? "success":"danger"}`
                  }
                }
              });
              res.status && del.closest("tr").remove()
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
  </script>
</body>

</html>