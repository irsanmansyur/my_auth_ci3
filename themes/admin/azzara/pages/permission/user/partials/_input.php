<div class="row mt-3">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label>Name</label>
      <input type="text" class="form-control" name="name" placeholder="Name" value="<?= set_value("name", null) ?? $uuser->name ?? ''; ?>">
      <?= form_error('name', '<small class="text-danger">', '</small>'); ?>

    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label>Username</label>
      <input type="text" class="form-control" name="username" placeholder="Name" value="<?= set_value("username", null) ?? $uuser->username ?? ''; ?>">
    </div>
    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>

  </div>


</div>
<div class="row mt-3">

  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label>status</label>
      <select class="select2 form-control" id="status" name="status">
        <option disabled selected>Choose Status</option>
        <option value="1" <?= set_value("status", null) === "1" ? "selected" : ($uuser->status === "1"  ? 'selected' : ''); ?>>aktif</option>
        <option value="0" <?= set_value("status", null) == "0" ? "selected" : ($uuser->status === "0"  ? 'selected' : ''); ?>>Non Aktif</option>
      </select>
      <?= form_error('status', '<small class="text-danger">', '</small>'); ?>

    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label>Pilih level Admin</label>
      <select class="select2 form-control" multiple id="role_id" name="role_id[]">
        <?php foreach ($roles as $i => $role) : ?>
          <option <?= set_value("role_id[{$i}]", null) == $role->id ? "selected" : ($uuser->roles()->first($role->id)  ? 'selected' : ''); ?> value="<?= $role->id; ?>"><?= $role->name; ?></option>
        <?php endforeach; ?>
      </select>
      <?= form_error('role_id', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="row mt-3">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label>Email</label>
      <input type="email" class="form-control" name="email" placeholder="Name email" value="<?= set_value("email", null) ?? $uuser->email ?? ''; ?>">
      <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label>Password</label>
      <input type="password" class="form-control" name="password">
      <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>

</div>
<div class="row mt-3">
  <div class="col-12">
    <div class="form-group form-group-default">
      <h3>Ganti Gambar (Klik gambar di bawah)</h3>
      <div class="card-avatar">
        <input type="file" name="gambar" id="imagechange" class="d-none" />
        <a href="#pablo" id="changePhoto">
          <img class="img thumbnail rounded-circle" style="width: 100px;height:100px;" src="<?= $uuser->getProfile() ?>">
        </a>
      </div>
    </div>
  </div>
</div>