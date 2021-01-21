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
                <a href=<?= base_url('permission/access'); ?>>Access Users</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Add Access Menu</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form add access Menu</div>
              <p>
                <?= var_dump(validation_errors()); ?>
              </p>
            </div>
            <form action="" method="post">
              <div class="card-body">
                <div class="row d-flex justify-content-beetwen">
                  <div class="col-md-4">
                    <h3>Role Access</h3>
                    <?php if (isset($rule)) : ?>
                      <div class="form-group">
                        <label for="solidInput"><?= $rule->name; ?></label>
                        <input readonly type="text" class="form-control input-solid" id="solidInput" name="role_id" value="<?= $rule->id; ?>">
                      </div>
                      <?php else :
                      foreach ($rules as $key => $rule) { ?>
                        <div class="checkbox">
                          <label>
                            <input name="role_id" type="checkbox" value="<?= $rule->id; ?>">
                            <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                            <?= $rule->name; ?>
                          </label>
                        </div>
                      <?php }; ?>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-4">
                    <h3>Submenu</h3>
                    <?php if (isset($submenu)) : ?>
                      <div class="form-group">
                        <label for="solidInput"><?= $submenu->name; ?></label>
                        <input readonly type="text" class="form-control input-solid" id="solidInput" name="submenu_id" value="<?= $submenu->id; ?>">
                      </div>
                      <?php else :
                      foreach ($submenus as $key => $submenu) { ?>
                        <div class="checkbox">
                          <label>
                            <input name="submenu_id[]" type="checkbox" value="<?= $submenu->id; ?>">
                            <span class="cr"><i class="cr-icon fa fa-bullseye"></i></span>
                            <?= $submenu->name; ?>
                          </label>
                        </div>
                      <?php }; ?>
                    <?php endif; ?>
                  </div>
                </div>
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