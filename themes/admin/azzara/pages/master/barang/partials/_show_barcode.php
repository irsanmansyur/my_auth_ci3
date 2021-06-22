<div class="card">
  <div class="card-header">
    <h5 class="card-title">Barcode</h5>
  </div>
  <div class="card-body">
    <img src="<?= $barcode_img; ?>" alt="barcode Generator"><br>
    <span><?= $barang->nama; ?></span>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <h5 class="card-title">QR Code</h5>
  </div>
  <div class="card-body">
    <span class="text-center">
      <img src="<?= base_url('assets/img/barang/qr_code/' . $barang->kode . ".png") ?>" alt="qr code"><br>
      <?= $barang->nama; ?>
    </span>
  </div>
</div>