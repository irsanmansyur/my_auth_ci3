<div class="form-group form-group-default">
  <label for="kode">Kode suplier</label>
  <input class="form-control" id="kode" placeholder="Input Kode suplier" name="kode" value="<?= set_value("kode", null)  ??  $suplier->kode   ?>" />
  <?= form_error('kode', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="form-group form-group-default">
  <label for="nama">Nama suplier</label>
  <input class="form-control" id="nama" placeholder="Input Nama suplier" name="nama" value="<?= set_value("nama", null)  ??  $suplier->nama  ?>" />
  <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="alamat">Alamat suplier</label>
      <input class="form-control" id="alamat" placeholder="Input Nama suplier" name="alamat" value="<?= set_value("alamat", null)  ??  $suplier->alamat  ?>" />
      <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="telp">No Telpon</label>
      <input class="form-control" id="telp" placeholder="Input Nama suplier" name="telp" value="<?= set_value("telp", null)  ??  $suplier->telp  ?>" />
      <?= form_error('telp', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="form-group form-group-default">
  <label for="status">Status</label>
  <div class="custom-control custom-radio">
    <input type="radio" id="status_aktif" name="status" value="1" <?= set_value("status") == "1" ? "checked" : ($suplier->status == "1" ? "checked" : ''); ?> class="custom-control-input">
    <label class="custom-control-label" for="status_aktif">Aktif</label>
  </div>
  <div class="custom-control custom-radio">
    <input type="radio" id="status_tdk_aktif" name="status" value="0" <?= set_value("status") == "0" ? "checked" : ($suplier->status == "0" ? "checked" : ''); ?> class="custom-control-input">
    <label class="custom-control-label" for="status_tdk_aktif">Tidak Aktif</label>
  </div>
  <?= form_error('status', '<small class="text-danger">', '</small>'); ?>
</div>