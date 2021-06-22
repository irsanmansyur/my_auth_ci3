<div class="d-image text-center pb-4">
  <h3>Gambar Barang</h3>
  <div class="card-avatar">
    <input type="file" name="gambar" id="imagechange" class="d-none">
    <a href="#pablo" id="changePhoto">
      <img class="img thumbnail rounded-circle" style="width: 100px;height:100px;" src="<?= base_url("assets/img/barang/" . ($barang->gambar ? $barang->gambar : "default.png")); ?>">
    </a>
    <?php if ($this->session->flashdata("img_error")) : ?>
      <small class="text-danger"><?= $this->session->flashdata("img_error"); ?></small>
    <?php endif; ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="kode">Kode barang</label>
      <input class="form-control" id="kode" placeholder="Input Kode barang" name="kode" value="<?= set_value("kode", null)  ??  $barang->kode   ?>" />
      <?= form_error('kode', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="nama">Nama barang</label>
      <input class="form-control" id="nama" placeholder="Input Nama barang" name="nama" value="<?= set_value("nama", null)  ??  $barang->nama  ?>" />
      <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="kategori_id" class="mb-2">Kategori</label>
      <select name="kategori_id" class="default_select form-control" id="kategori_id">
        <option value="" selected disabled>Select Kategori</option>
        <?php foreach ($kategoris as $i => $kategori) : ?>
          <option value="<?= $kategori->id; ?>" <?= set_value("kategori_id") == $kategori->id ? "selected" : ($barang->kategori_id == $kategori->id ? "selected" : '') ?>><?= $kategori->nama; ?></option>
        <?php endforeach; ?>
      </select>
      <?= form_error('kategori_id', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="satuan_id" class="mb-2">Satuan</label>
      <select name="satuan_id" class="default_select form-control" id="satuan_id">
        <option value="" selected disabled>Select Satuan</option>
        <?php foreach ($satuans as $i => $satuan) : ?>
          <option value="<?= $satuan->id; ?>" <?= set_value("satuan_id") == $satuan->id ? "selected" : ($barang->satuan_id == $satuan->id ? "selected" : '') ?>><?= $satuan->nama; ?></option>
        <?php endforeach; ?>
      </select>
      <?= form_error('satuan_id', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="harga_jual">Harga Jual</label>
      <div class="input-group mt-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Rp</span>
        </div>
        <input type="number" class="form-control input-sm pl-2" name="harga_jual" id="harga_jual" value="<?= set_value("harga_jual", null)  ??  $barang->harga_jual  ?>" required placeholder="0">
      </div>
      <?= form_error('harga_jual', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="harga_beli">Harga Beli</label>
      <div class="input-group mt-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Rp</span>
        </div>
        <input type="number" class="form-control input-sm pl-2" name="harga_beli" id="harga_beli" value="<?= set_value("harga_beli", null)  ??  $barang->harga_beli  ?>" required placeholder="0">
      </div>
      <?= form_error('harga_beli', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="expired_at">Expired At</label>
      <div class="input-group mt-2">
        <input type="date" class="form-control input-sm pl-2" name="expired_at" id="expired_at" value="<?= set_value("expired_at", null)  ??  date("Y-m-d", strtotime($barang->expired_at)) ?>" required placeholder="0">
      </div>
      <?= form_error('expired_at', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="stok">Stok</label>
      <div class="input-group mt-2">
        <div class="input-group-prepend">
          <span class="input-group-text">Jumlah</span>
        </div>
        <input type="number" class="form-control input-sm pl-2" name="stok" id="stok" value="<?= set_value("stok", null)  ??  $barang->stok  ?>" required placeholder="0">
      </div>
      <?= form_error('stok', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>
<div class="row">

  <div class="col">
    <div class="form-group form-group-default">
      <label for="status">Status</label>
      <div class="custom-control custom-radio">
        <input type="radio" id="status_aktif" name="status" value="1" checked class="custom-control-input">
        <label class="custom-control-label" for="status_aktif">Aktif</label>
      </div>
      <div class="custom-control custom-radio">
        <input type="radio" id="status_tdk_aktif" name="status" value="0" class="custom-control-input">
        <label class="custom-control-label" for="status_tdk_aktif">Tidak Aktif</label>
      </div>
      <?= form_error('status', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>

<script>
  // scrip ganti gambar
  $("#changePhoto").click(function() {
    $('input#imagechange').click();
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#changePhoto').find('.img').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('input#imagechange').change(function() {
    readURL(this);
  });
</script>