<div class="form-group form-group-default">
  <label for="kode">Kode diskon</label>
  <input class="form-control" id="kode" placeholder="Input Kode diskon" name="kode" value="<?= set_value("kode", null)  ??  $diskon->kode   ?>" />
  <?= form_error('kode', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="form-group form-group-default">
  <label for="name">Nama Diskon</label>
  <input class="form-control" id="name" placeholder="Input Nama diskon" name="name" value="<?= set_value("name", null)  ??  $diskon->name  ?>" />
  <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="tipe">Tipe</label>
      <select class="form-control" name="tipe" id="tipe">
        <option value="" selected disabled>-Pilih  Jenis Diskon-</option>
        <option value="percentage" <?= set_value("tipe") == "percentage" ? "selected" : ($diskon->tipe == 'percentage' ? 'selected' : ''); ?>>Persent</option>
        <option value="amount" <?= set_value("tipe") == "amount" ? "selected" : ($diskon->tipe == 'amount' ? 'selected' : ''); ?>>Bilangan</option>
      </select>
      <?= form_error('tipe', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="value">Jumlah</label>
      <input class="form-control" id="value" type="number" placeholder="Input Jumlah diskon" name="value" value="<?= set_value("value", null)  ??  $diskon->value  ?>" />
      <?= form_error('value', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="start_at">Jumlah</label>
      <input class="form-control" id="start_at" type="date" name="start_at" value="<?= set_value("start_at", null)  ??  date("Y-m-d", $diskon->start_at ? strtotime($diskon->start_at) : time())  ?>" />
      <?= form_error('start_at', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="end_at">Jumlah</label>
      <input class="form-control" id="end_at" type="date" name="end_at" value="<?= set_value("end_at", null)  ??  date("Y-m-d", $diskon->end_at ? strtotime($diskon->end_at) : time()) ?>" />
      <?= form_error('end_at', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>