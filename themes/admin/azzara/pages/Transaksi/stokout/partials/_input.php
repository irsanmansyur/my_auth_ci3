<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="created_at">Tanggal Keluar</label>
      <input class="form-control" value="<?= $restok->created_at ? date("Y-m-d", strtotime($restok->created_at)) : date("Y-m-d"); ?>" type="date" name="created_at" id="created_at" />
      <?= form_error('created_at', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="inputKode">Input Kode / Cari Nama Barang</label>
      <input type="text" class="form-control custom-select custom-select-sm" endpoint="" required id="inputKode" value="<?= $restok->barang_id ? $restok->barang->kode : '' ?>" name="inputKode" placeholder="Barcode atau Kode Barang/Nama Barang">
    </div>
  </div>
</div>
<div class="form-group form-group-default">
  <label for="nama">Nama barang</label>
  <input class="form-control" id="barang_id" hidden name="barang_id" readonly value="<?= $restok->barang_id ?>" />
  <input class="form-control" id="nama" readonly value="<?= $restok->barang_id ? $restok->barang->nama : ''; ?>" />
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="satuan">Satuan</label>
      <input class="form-control" id="satuan" readonly value="<?= $restok->barang_id ? $restok->barang->satuan->nama : ''; ?>" />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="stock_awal">Stok Barang</label>
      <input class="form-control" name="stock_awal" id="stock_awal" readonly value="<?= $restok->barang_id ? $restok->barang->stok : ''; ?>" />
      <?= form_error('stock_awal', '<small class="text-danger">', '</small>'); ?>

    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="catatan" class="mb-2">Keterangan</label>
      <input class="form-control" value="<?= set_value("catatan", null) ?? $restok->catatan; ?>" name="catatan" id="catatan" placeholder="Rusak/Hilang/Kadaluarsa/etc..." />
      <?= form_error('catatan', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="jumlah">Stok Keluar</label>
      <input class="form-control" value="<?= set_value("jumlah", null) ?? $restok->jumlah; ?>" type="number" name="jumlah" id="jumlah" />
      <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>