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
            </div>
            <form action="<?= $form_action_add; ?>" method="post">
              <div class="card-body">
                <?php if (!isset($submenu)) : ?>
                  <div class="form-group">
                    <label for="menuSelecct">Menu Select <?= $menu->name ?? ""; ?></label>

                    <?php if (isset($menu)) : ?>
                      <input type="text" name="menu_id" readonly class="form-control input-pill" id="menuSelecct" value="<?= $menu->id; ?>">
                    <?php else :; ?>
                      <select class="form-control input-pill" name="menu_id" id="menuSelecct">
                        <?php foreach ($menus as $key => $sm) : ?>

                          <option value="<?= $sm->id; ?>" <?= set_value("menu_id") == $sm->id ? "selected" : ''; ?>><?= $sm->name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <div class="form-group">
                  <label for="roleSelecct">Rules Select <?= $rule->name ?? ""; ?></label>
                  <?php if (isset($rule)) : ?>
                    <input type="text" name="role_id" readonly class="form-control input-pill" id="roleSelecct" value="<?= $rule->id; ?>">
                  <?php else :; ?>
                    <select class="form-control input-pill" name="role_id" id="roleSelecct">
                      <?php foreach ($rules as $key => $rl) : ?>
                        <option value="<?= $rl->id; ?>" <?= set_value("role_id") == $rl->id ? "selected" : ''; ?>><?= $rl->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  <?php endif; ?>
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