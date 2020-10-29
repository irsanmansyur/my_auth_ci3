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
                <a href=<?= base_url('super-admin/submenu'); ?>>List of Submenus</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Add a submenu</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Form add subMenu</div>
            </div>
            <form action="<?= $form_action_add; ?>" method="post">
              <div class="card-body">
                <div class="form-group form-group-default">
                  <label for="name">Submenu Name</label>
                  <input class="form-control" id="name" placeholder="Enter name" name="name" value="<?= set_value("name") ?>" />
                  <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group form-group-default">
                  <label for="url">Submenu url</label>
                  <input class="form-control" id="url" placeholder="Enter name" name="url" value="<?= set_value("url") ?>" />
                  <?= form_error('url', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                  <label for="status">Status Select</label>
                  <select class="form-control input-solid" name="status" id="status" required>
                    <option value="">Select Status</option>
                    <option <?= set_value('status') == 'public' ? "selected" : ''; ?> value="public">Public</option>
                    <option <?= set_value('status') == 'private' ? "selected" : ''; ?> value="private">private</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="menu_id">Menu Select</label>
                  <select class="form-control input-solid" name="menu_id" id="menu_id" required>
                    <option value="">select Menu</option>
                    <?php foreach ($menus as  $key => $menu) : ?>
                      <option value="<?= $menu->id; ?>" <?= $menu->id == set_value("menu_id") ? "selected" : ''; ?>><?= $menu->name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="card-action">
                <button class="btn btn-success" type="submit">Submit</button>
                <button class="btn btn-danger" type="reset">Reset</button>
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