<div class="d-flex justify-content-between">
  <button class="btn btn-danger btn-border btn-sm btn-hapus"><i class="fas fa-trash-alt"></i></button>
  <div style='min-width:90px' class="ml-1">
    <input type='button' name='ubahJumlah' jenis='kurang' value='-' class='btn btn-warning ubahJumlah p-1' />
    <input type='number' style='font-size: 13px;opacity: 1;border-radius:3px;width:40px' value='<?= $keranjang->jumlah_barang ?>' class='p-1 jumlah_barang' />
    <input type='button' name='ubahJumlah' jenis='tambah' value='+' class='btn btn-primary ubahJumlah p-1' />
  </div>
</div>