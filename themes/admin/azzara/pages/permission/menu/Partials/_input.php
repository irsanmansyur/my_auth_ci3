<div class="form-group form-group-default">
  <label for="nama">Nama Menu</label>
  <input class="form-control" id="nama" placeholder="Enter name" name="name" value="<?= set_value("name")  ? set_value("name") : $menu->name ?>" />
  <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
</div>