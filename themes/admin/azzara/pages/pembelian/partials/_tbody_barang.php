<div class="d-flex flex-column flex-md-row">
  <div class="col-md-7 order-md-2 pl-md-2 px-0">
    <div class="card card-body">
      <h3 class="pb-2 border-bottom text-primary">List Belanjaan</h3>
      <div class="border-top table-responsive">
        <table id="datatable-barang" class="table table-striped table-bordered " style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Barang</th>
              <th>Harga Beli</th>
              <th>Jumlah</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php

            use PhpParser\Node\Stmt\Echo_;

            foreach ($pembelian->barangs as $i => $barang) : ?>
              <tr>
                <td><?= $i + 1; ?></td>
                <td><?= $barang->nama; ?></td>
                <td><?= rupiah($barang->pivot->harga_beli); ?></td>
                <td><?= $barang->pivot->jumlah; ?></td>
                <td><?= rupiah($barang->pivot->harga_beli * $barang->pivot->jumlah); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
    $pembayarans = $pembelian->pembayaran()->where("jenis", "pengeluaran")->all();
    if (count($pembayarans) > 0) : ?>
      <div class="card card-body">
        <h3 class="pb-2 border-bottom text-primary">Riwayat Transaksi</h3>
        <div class="border-top table-responsive">
          <style>
            .mytable>tbody>tr>td,
            .mytable>tbody>tr>th,
            .mytable>tfoot>tr>td,
            .mytable>tfoot>tr>th,
            .mytable>thead>tr>td,
            .mytable>thead>tr>th {
              padding: 10px 15px 5px !important;
            }
          </style>
          <table id="datatable-barang" class="table table-striped table-bordered mytable" style="width:100%">
            <thead>
              <tr>
                <th class="align-center">#</th>
                <th class="align-center">Tanggal</th>
                <th class="align-center">Keterangan</th>
                <th class="align-center">Debit</th>
                <th class="align-center">Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pembayarans as $i => $transaksi) : ?>
                <tr>
                  <td class="align-top"><?= $i + 1; ?></td>
                  <td class="align-top" style="width: 120px;"><?= date("d, F Y", strtotime($transaksi->created_at)); ?></td>
                  <td class="align-top">
                    <?= $transaksi->debit_name; ?><br>
                    <span class="pl-2 pl-md-4"><?= $transaksi->kredit_name; ?></span>
                  </td>
                  <td class="align-top">
                    <div class="d-flex justify-content-between">
                      <span>Rp.</span>
                      <span><?= rupiah($transaksi->jumlah); ?></span>
                    </div>
                  </td>
                  <td class="align-top">
                    <br>
                    <div class="d-flex justify-content-between">
                      <span>Rp.</span>
                      <span><?= rupiah($transaksi->jumlah); ?></span>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <th class="text-center text-danger font-weight-bold" colspan="3">Total</th>
              <th class="text-danger font-weight-bold">
                <div class="d-flex justify-content-between">
                  <span>Rp.</span>
                  <span><?= rupiah(array_sum(array_column($pembayarans, "jumlah"))); ?></span>
                </div>
              </th>
              <th class="text-danger font-weight-bold">
                <div class="d-flex justify-content-between">
                  <span>Rp.</span>
                  <span><?= rupiah(array_sum(array_column($pembayarans, "jumlah"))); ?></span>
                </div>
              </th>
            </tfoot>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <div class="col-md-5 order-md-1 px-0">
    <div class="card card-body">
      <div class="row">
        <div class="col-6 col-lg-4 px-0 px-md-2">
          <div class="form-group pt-md-2 pb-0 pt-1">
            <label class="mb-0 mb-sm-2" for="penginput">Di Input Oleh</label>
            <input class="form-control p-1" readonly value="<?= $user->name; ?>" id="penginput" name="penginput">
          </div>
        </div>
        <div class="col-6 col-lg-4 px-0 px-md-2">
          <div class="form-group pt-md-2 pb-0 pt-1">
            <label class="mb-0 mb-sm-2" for="kode">Kode Pembelian</label>
            <input type="hidden" name="pembelian_id" value="<?= $pembelian->id; ?>">
            <input class="form-control p-1" readonly value="<?= $pembelian->kode; ?>" id="kode">
          </div>
        </div>
        <div class="col-6 col-lg-4 px-0 px-md-2">
          <div class="form-group pt-md-2 pb-0 pt-1">
            <label class="mb-0 mb-sm-2" for="created_at">Tanggal Beli</label>
            <input class="form-control p-1" readonly value="<?= date("F, m Y", strtotime($pembelian->created_at)); ?>" id="created_at">
          </div>
        </div>
        <div class="col-6 col-lg-4 px-0 px-md-2">
          <div class="form-group pt-md-2 pb-0 pt-1">
            <label class="mb-0 mb-sm-2" for="jatuh_tempo"><strong class="text-danger">Jatuh Tempo</strong></label>
            <input class="form-control p-1 text-danger font-weight-bold" readonly value="<?= date("m, F Y", strtotime($pembelian->jatuh_tempo)); ?>" id="jatuh_tempo">
          </div>
        </div>
        <div class="col-6 col-lg-4 px-0 px-md-2">
          <div class="form-group pt-md-2 pb-0 pt-1">
            <label class="mb-0 mb-sm-2"><strong class="text-danger">Total Transaksi</strong></label>
            <input class="form-control p-1 text-danger font-weight-bold" readonly value="<?= rupiah($pembelian->total); ?>">
          </div>
        </div>
        <div class="col-6 col-lg-4 px-0 px-md-2">
          <div class="form-group pt-md-2 pb-0 pt-1">
            <label class="mb-0 mb-sm-2"><strong class="text-danger">Sisa Pinjaman</strong></label>
            <input class="form-control p-1 text-danger font-weight-bold" readonly value="<?= rupiah($pembelian->total - $pembelian->dibayar); ?>">
          </div>
        </div>
      </div>
    </div>
    <?php if (isset($pembelian->dibayar) && $pembelian->total - $pembelian->dibayar > 0) : ?>
      <div class="border  card card-body">
        <form action="" method="post" id="form-bayar">
          <input type="hidden" name="kode_transaksi" value="<?= $pembelian->id ?>">
          <div class="d-flex justify-content-center mb-2">
            <div class="custom-control custom-radio">
              <input type="radio" id="customRadio1" value="Kas" checked="" name="kredit" class="custom-control-input">
              <label class="custom-control-label" for="customRadio1">Tunai</label>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" id="customRadio2" name="kredit" value="Atm/Bank" class="custom-control-input">
              <label class="custom-control-label" for="customRadio2">Non Tunai</label>
            </div>
          </div>
          <div class=" d-flex flex-column flex-md-row justify-content-md-end">
            <div class="col-md-7 pr-md-2 px-0">
              <input type="hidden" name="jumlah_pinjaman" value="<?= $pembelian->total - $pembelian->dibayar; ?>">
              <input type="number" name="jumlah" hidden>

              <input type="text" class="rupiah form-control form-lg text-danger font-weight-bold text-right" value="0" id="jumlah">
            </div>
            <button class="col-md-5 btn btn-primary my-2 mt-md-0"><b>BAYAR</b></button>
          </div>
          <div class="form-group p-0 mb-1 mb-md-2">
            <label for="#sisa_pinjaman">Sisa Pinjaman Sekarang</label>
            <input type="text" class="rupiah form-control form-lg text-primary font-weight-bold text-right" name="sisa_pinjaman" value="0" readonly id="sisa_pinjaman">
          </div>
          <div class="form-group p-0 mb-1 mb-md-2">
            <label for="#kembalian">Kembalian</label>
            <input type="number" name="kembalian" hidden>
            <input type="text" class="rupiah form-control form-lg text-primary text-right" value="0" readonly id="kembalian">
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>
<script src="<?= base_url(); ?>assets/js/autoNumeric.min.js"></script>
<script>
  $(document).ready(function bayar() {
    applyAutoNumeric();
    $("#jumlah").on("input", function() {
      apply_form();
    });
    $("#form-bayar").on("submit", function(e) {
      e.preventDefault();
      apply_form();
      if (AutoNumeric.getNumber("#jumlah") > 1)
        $.ajax({
          url: baseUrl + `admin/transaksi/hutang/pembelian`,
          type: "POST",
          data: $(this).serialize(),
          success: function(res) {
            bayar_status(res);
          }
        });
    });
  })

  function apply_form() {
    let jumlah = AutoNumeric.getNumber("#jumlah");
    let jumlah_pinjaman = parseInt($("[name=jumlah_pinjaman]").val());
    $("[name=kembalian]").val(jumlah - jumlah_pinjaman);
    $("[name=jumlah]").val(jumlah > jumlah_pinjaman ? jumlah_pinjaman : jumlah);
    AutoNumeric.set("#kembalian", jumlah - jumlah_pinjaman)
    AutoNumeric.set("#sisa_pinjaman", jumlah > jumlah_pinjaman ? 0 : jumlah_pinjaman - jumlah)
  }

  function applyAutoNumeric() {
    $('input.rupiah:not([type=number])').each(function(i, obj) {
      if (AutoNumeric.getAutoNumericElement(obj))
        return;
      var options = {
        currencySymbol: 'Rp ',
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        decimalPlaces: 0
      }
      new AutoNumeric(obj, options);
    });
  }
</script>