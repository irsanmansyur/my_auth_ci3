  <div class="d-print" style="display: none;">
    <div class="invoice">
      <header style="border-bottom: 1px dotted black;" class="mb-1">
        <div class="d-flex justify-content-between">
          <div class="text-right">
            <a target="_blank" href="<?= base_url(); ?>">
              <h2><?= $settings->name_app; ?></h2>
            </a>
          </div>
          <div class="company-details text-right col-8">
            <h3 class="name">
              <a target="_blank" href="https://lobianijs.com">
                <?= $settings->pemilik; ?>
              </a>
            </h3>
            <div><?= $settings->alamat; ?></div>
            <div><?= $settings->telp; ?></div>
            <div><?= $settings->email; ?></div>
          </div>
        </div>
      </header>
      <main>
        <div class="d-flex justify-content-between border-bottom mb-3 pb-3">
          <div class="invoice-to">
            <div class="text-gray-light">Nama Admin:</div>
            <h2 class="to"><?= $user->name; ?></h2>
            <div class="address">Sebagai : <?= implode("|", array_column($user->roles, 'name')); ?></div>
            <div class="email"><a href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a></div>
          </div>
          <div class="invoice-details">
            <h3 class="invoice-id"><?= $penjualan->no_invoice; ?></h3>
            <div class="date">Tangal Invoice : <?= date("d F Y", strtotime($penjualan->created_at)); ?></div>
            <div class="date">Tanggal Cetak : <?= date("d F Y", time()); ?></div>
          </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0" class="w-100">
          <thead>
            <tr>
              <th width=2>#</th>
              <th class="text-left p-1 p-md-2">Barang</th>
              <th class="text-right p-1 p-md-2">@HARGA</th>
              <th class="text-right p-1 p-md-2">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($penjualan->barangs as $i => $barang) : ?>
              <tr>
                <td class="p-1 p-md-2 no"><?= $i + 1; ?></td>
                <td class="p-1 text-left">
                  <h6><span><?= $barang->nama; ?></span></h6>
                </td>
                <td class="p-1 p-md-2 text-right unit"><?= rupiah($barang->harga); ?>*<?= $barang->jumlah; ?></td>
                <td class="p-1 p-md-2 text-right total"><?= rupiah($barang->total_harga); ?></td>
              </tr>
            <?php endforeach; ?>

          </tbody>
          <tfoot>
            <tr>
              <td class="border-top pt-2" colspan="5"></td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td class="text-right">Uang Bayar</td>
              <td colspan="2" class="text-right"><?= rupiah($penjualan->uang_bayar); ?></td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td class="text-right">Jumlah bayar</td>
              <td class="text-right" colspan="2"><?= rupiah($penjualan->jumlah_bayar); ?></td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td class="text-right">Kembalian</td>
              <td colspan="2" class="text-right"><?= rupiah($penjualan->kembalian); ?></td>
            </tr>
          </tfoot>
        </table>
        <div class="thanks text-center text-md-left">Terima Kasih!</div>
        <div class="notices">
          <div>CATATAN:</div>
          <div class="notice">Harga Barang bisa berubah kapan Saja.</div>
        </div>
      </main>
      <footer>
        Invoice was created on a computer and is valid without the signature and seal.
      </footer>
    </div>
  </div>

  <script>
    function print_struk() {
      let elem = document.querySelector(".d-print");

      var $printSection = document.getElementById("section-to-print");

      if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "section-to-print";
      }
      $printSection.innerHTML = "";
      $printSection.innerHTML = elem.innerHTML;
      document.body.appendChild($printSection);
      window.print();
    }
  </script>