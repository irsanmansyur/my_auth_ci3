<div class="row">
  <?php if (count($barangs) < 1) : ?>
    <div class="col-12">
      <div class="alert alert-danger" role="alert">Pilih Barang Terlebih dahulu</div>
    </div>
  <?php else : ?>
    <?php foreach ($barangs as $i => $barang) : ?>
      <?php for ($i = 1; $i <= $barang->jumlah_barang; $i++) : ?>
        <div class="col mt-2">
          <img src="data:image/png;base64,<?= base64_encode($generator->getBarcode($barang->kode, $generator::TYPE_CODE_128)); ?>" height="30" width="150">
          <br><?= $i . "_" .  $barang->kode; ?>
          <br><small style="font-size: 10px;"><?= $barang->nama; ?></small>
          <br><?= rupiah($barang->harga_jual); ?>
        </div>
      <?php endfor; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</div>