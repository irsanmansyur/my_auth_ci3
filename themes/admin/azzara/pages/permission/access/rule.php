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
                <a href=<?= base_url('permission/rules'); ?>>Rules</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Access Rule <b><?= $rule->name; ?></b></a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form add access Rule</div>
            </div>
            <form action="" method="post">
              <div class="card-body">
                <div class="row d-flex justify-content-beetwen">
                  <div class="col-md-4">
                    <h3>Rule</h3>
                    <div class="form-group">
                      <label for="solidInput"><?= $rule->name; ?></label>
                      <input readonly type="text" class="form-control input-solid" id="solidInput" name="rule_id" value="<?= $rule->id; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <?php if (count($users) > 0) : ?>
                      <h3>Users Access</h3>
                      <?php foreach ($users as $key => $usr) { ?>
                        <div class="checkbox">
                          <label>
                            <input api="<?= base_url("api/access/rule/user"); ?>" name="access" type="checkbox" value="<?= $usr->id; ?>" <?= $usr->selected ? "checked='true'" : ''; ?>>
                            <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                            <?= $usr->name; ?>
                          </label>
                        </div>
                      <?php };
                    elseif (count($menus) > 0) : ?>
                      <h3>Menus Access</h3>
                      <?php foreach ($menus as $key => $menu) { ?>
                        <div class="checkbox">
                          <label>
                            <input api="<?= base_url("api/access/rule/menu"); ?>" name="access" type="checkbox" value="<?= $menu->id; ?>" <?= $menu->selected ? "checked='true'" : ''; ?>>
                            <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                            <?= $menu->name; ?>
                          </label>
                        </div>
                    <?php }
                    endif; ?>
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
    let elRule = document.querySelector('[name="rule_id"]');

    let elAccess = document.querySelectorAll('[name="access"]');
    [...elAccess].forEach(isAccess => {
      isAccess.addEventListener("change", () => {
        let isSelect = isAccess.checked;
        swal({
          title: 'Are you sure?',
          text: `this Rules will ${isSelect? "has ":' Not'} access the rule!`,
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
            let ress;
            if (!isSelect)
              ress = await deleteData(isAccess.getAttribute('api') + `/${isAccess.value}/${elRule.value}`);
            else ress = await postData(isAccess.getAttribute('api'), {
              access_id: isAccess.value,
              rule_id: elRule.value
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
            isAccess.checked = isSelect ? false : true;
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
    async function deleteData(url = '', data = {}) {
      let fd = new FormData();
      for (let i in data) {
        fd.append(i, data[i])
      }
      const response = await fetch(url, {
        method: 'DELETE', // *GET, POST, PUT, DELETE, etc.
        // body: fd // body data type must match "Content-Type" header
      });
      return response.json(); // parses JSON response into native JavaScript objects
    }
  </script>

</body>

</html>