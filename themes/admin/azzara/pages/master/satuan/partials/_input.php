<div class="form-group form-group-default">
  <label for="kode">Nama satuan</label>
  <input readonly class="form-control" id="kode" placeholder="Input Kode satuan" name="kode" value="<?= set_value("kode", null)  ??  $satuan->kode  ?>" />
  <?= form_error('kode', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="form-group form-group-default">
  <label for="nama">Nama satuan</label>
  <input class="form-control" id="nama" placeholder="Input Nama satuan" name="nama" value="<?= set_value("nama", null)  ??  $satuan->nama  ?>" />
  <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
</div>