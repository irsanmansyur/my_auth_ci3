<div class="d-flex flex-row-reverse mb-2">
  <button class="btn btn-primary btn-border" onclick="print_struk()" type="button">Print Struck</button>
</div>
<div class="card card-pricing">
  <div class="card-body">
    <ul class="specification-list">
      <li>
        <span class="name-specification">Nomor Invoice</span>
        <span class="status-specification"><?= $penjualan->no_invoice; ?></span>
      </li>
      <li>
        <span class="name-specification">Tanggal</span>
        <span class="status-specification"><?= date("F m Y", strtotime($penjualan->created_at)); ?></span>
      </li>
      <li>
        <span class="name-specification">Kasir</span>
        <span class="status-specification"><?= $penjualan->kasir->name; ?></span>
      </li>
      <button class="btn btn-primary btn-block"><b><?= rupiah($penjualan->jumlah_bayar); ?></b></button>
    </ul>
    <ul class="list-group shadow">
      <!-- list group item-->
      <?php foreach ($penjualan->barangs as $barang) : ?>
        <div class="d-flex flex-column flex-md-row w-100">
          <!-- Custom content-->
          <div class="p-0 col-md-7 d-flex flex-md-row justify-content-md-between">
            <div class="media-body col-md-6 order-2 order-md-1 p-md-0 pl-2 py-1 text-left">
              <h5 class="mt-0 font-weight-bold mb-2"><?= $barang->nama; ?></h5>
              <p class="font-italic text-muted mb-0 small"><?= $barang->kode; ?> | <?= $barang->stok; ?> | <?= $barang->satuan->nama; ?></p>
              <h6 class="font-weight-bold my-2"><?= rupiah($barang->harga); ?> X <?= $barang->jumlah; ?></h6>
            </div>
            <img src="<?= base_url("assets/img/barang/" . ($barang->gambar ? $barang->gambar : "default.png")); ?>" alt="<?= $barang->nama; ?>" alt="26-PROMIL GOLD 400G" class="my-2 order-1 order-md-2 rounded" style="width: 120px;">
          </div>
          <!-- End -->
          <div class="align-items-md-start d-flex flex-md-column harga-barang justify-content-between pl-md-4">
            <h4 class="text-bold">Jumlah Harga</h4>
            <span class="font-weight-bold mb-md-auto text-danger"><?= rupiah($barang->total_harga); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
      <!-- End -->
    </ul>
  </div>
</div>
<?php $this->load->view($thema_load . "pages/kasir/penjualan/partials/_struck_penjualan"); ?>