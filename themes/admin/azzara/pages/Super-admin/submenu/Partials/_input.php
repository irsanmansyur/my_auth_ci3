<div class="form-group form-group-default">
  <label for="nama">Submenu Name</label>
  <input class="form-control" id="nama" placeholder="Enter name" name="name" value="<?= set_value("name")  ? set_value("name") : $submenu->name ?>" />
  <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="form-group form-group-default">
  <label for="url">Submenu Url</label>
  <input class="form-control" id="url" placeholder="Enter name" name="url" value="<?= set_value("url")  ? set_value("url") : $submenu->url ?>" />
  <?= form_error('url', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="form-group">
  <label for="is_access">Status Select</label>

  <select class="form-control input-solid" name="is_access" id="is_access" required>
    <option value="">Select Status</option>
    <option <?= set_value('is_access') == 'public' ? "selected" : ($submenu->is_access == 'public' ? 'selected' : ''); ?> value="public">Public</option>
    <option <?= set_value('is_access') == 'private' ? "selected" : ($submenu->is_access == 'private' ? 'selected' : ''); ?> value="private">private</option>
  </select>
</div>
<div class="form-group">
  <label for="menu_id">Menu Select</label>
  <select class="form-control input-solid" name="menu_id" id="menu_id" required>
    <option value="">select Menu</option>
    <?php foreach ($menus as  $key => $menu) : ?>
      <option value="<?= $menu->id; ?>" <?= set_value('menu_id') == $menu->id ? "selected" : ($menu->id == $submenu->menu_id ? "selected" : ''); ?>><?= $menu->name; ?></option>
    <?php endforeach; ?>
  </select>
</div>