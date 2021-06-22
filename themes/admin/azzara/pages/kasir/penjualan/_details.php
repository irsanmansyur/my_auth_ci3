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
        <li class="list-group-item p-0">
          <div class="row w-100">
            <div class="col-md-8 col-12">
              <!-- Custom content-->
              <div class="d-flex align-items-center justify-content-md-between flex-column flex-md-row">
                <div class="media-body order-2 order-md-1 text-left py-1">
                  <h5 class="mt-0 font-weight-bold mb-2"><?= $barang->nama; ?></h5>
                  <p class="font-italic text-muted mb-0 small"><?= $barang->kode; ?> | <?= $barang->stok; ?> | <?= $barang->satuan->nama; ?></p>
                  <div class="d-flex align-items-center justify-content-between mt-1">
                    <h6 class="font-weight-bold my-2"><?= rupiah($barang->harga); ?> X <?= $barang->jumlah; ?></h6>

                    <!-- rating bintang -->
                    <!-- <ul class="list-inline small">
                                <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star-o text-gray"></i></li>
                              </ul> -->

                  </div>
                </div>
                <img src="<?= base_url("assets/img/barang/" . ($barang->gambar ? $barang->gambar : "default.png")); ?>" alt="<?= $barang->nama; ?>" class="order-1 order-md-2 my-2 avatar-img rounded" style="width: 120px;padding-left:30px">
              </div>
              <!-- End -->
            </div>
            <div class="col-md-4">
              <div class="harga-barang"></div>
              <h4 class="text-bold text-md-left">Jumlah Harga</h4>
              <h4 class="font-weight-bold text-danger mt-2 text-md-left"><?= rupiah($barang->total_harga); ?></h4>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
      <!-- End -->
    </ul>
  </div>
</div>