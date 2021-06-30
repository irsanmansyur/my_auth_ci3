<div class="d-flex flex-column flex-lg-row">
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text" id="harga_beli">Harga Beli</span>
    </div>
    <input type="text" class="form-control rupiah text-right" name="harga_beli" aria-describedby="harga_beli" value="<?= $keranjang->harga_beli; ?>">
  </div>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text" id="harga_jual">Harga Jual</span>
    </div>
    <input type="text" class="form-control rupiah text-right" name="harga_jual" aria-describedby="harga_jual" value="<?= $keranjang->harga_jual; ?>">
  </div>
</div>