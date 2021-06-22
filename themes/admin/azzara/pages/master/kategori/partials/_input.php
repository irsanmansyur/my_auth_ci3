<div class="form-group form-group-default">
  <label for="kode">Nama Kategori</label>
  <input readonly class="form-control" id="kode" placeholder="Input Kode Kategori" name="kode" value="<?= set_value("kode", null)  ??  $kategori->kode  ?>" />
  <?= form_error('kode', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="form-group form-group-default">
  <label for="nama">Nama Kategori</label>
  <input class="form-control" id="nama" placeholder="Input Nama Kategori" name="nama" value="<?= set_value("nama", null)  ??  $kategori->nama  ?>" />
  <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
</div>