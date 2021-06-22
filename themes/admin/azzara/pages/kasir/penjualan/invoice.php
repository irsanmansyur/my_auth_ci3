<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
</head>

<body>
  <div class="wrapper">

    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title"><?= $page_title; ?></h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url('admin/dashboard'); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Invoice</a>
              </li>
            </ul>
          </div>
          <div class="card" id="parentContent">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <!-- <a href="<?= base_url('admin/barang/tambah'); ?>" class="btn btn-primary tambah-barang">Tambah</a> -->
            </div>
            <div class="card-body">

              <!--Author      : @arboshiki-->
              <div id="invoice">
                <div class="toolbar hidden-print">
                  <div class="text-right">
                    <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
                    <a href="<?= base_url("kasir/penjualan"); ?>" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Kembali</a>
                  </div>
                  <hr>
                </div>
                <div class="invoice overflow-auto">
                  <div style="">
                    <header>
                      <div class="d-flex justify-content-between">
                        <div class="text-right">
                          <a target="_blank" href="<?= base_url(); ?>">
                            <h2><?= $settings->name_app; ?></h2>
                            <!-- <img src="<?= base_url("assets/img/setting/") . $settings->logo; ?>" style="width: 150px;height:150px" data-holder-rendered="true" /> -->
                          </a>
                        </div>
                        <div class="company-details text-right">
                          <h2 class="name">
                            <a target="_blank" href="https://lobianijs.com">
                              Arboshiki
                            </a>
                          </h2>
                          <div>455 Foggy Heights, AZ 85004, US</div>
                          <div>(123) 456-789</div>
                          <div>company@example.com</div>
                        </div>
                      </div>
                    </header>
                    <main class="">
                      <div class="d-flex justify-content-between border-bottom mb-3 pb-3">
                        <div class="invoice-to">
                          <div class="text-gray-light">Nama Admin:</div>
                          <h2 class="to"><?= $user->name; ?></h2>
                          <div class="address">Sebagai : <?= implode("|", array_column($user->roles, 'name')); ?></div>
                          <div class="email"><a href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a></div>
                        </div>
                        <div class="invoice-details">
                          <h1 class="invoice-id"><?= $penjualan->no_invoice; ?></h1>
                          <div class="date">Tangal Invoice : <?= date("d F Y", strtotime($penjualan->created_at)); ?></div>
                          <div class="date">Tanggal Cetak : <?= date("d F Y", time()); ?></div>
                        </div>
                      </div>
                      <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                          <tr>
                            <th width=2>#</th>
                            <th class="text-left">Barang</th>
                            <th class="text-right">@HARGA</th>
                            <th class="text-right">Jumlah</th>
                            <th class="text-right">TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($penjualan->barangs as $i => $barang) : ?>
                            <tr>
                              <td class="no"><?= $i + 1; ?></td>
                              <td class="text-left">
                                <h2><span><?= $barang->barang->nama; ?></span></h2>
                              </td>
                              <td class="text-right unit"><?= rupiah($barang->harga); ?></td>
                              <td class="text-right qty"><?= $barang->jumlah; ?></td>
                              <td class="text-right total"><?= rupiah($barang->total_harga); ?></td>
                            </tr>
                          <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="border-top pt-3" colspan="5"></td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right">Jumlah bayar</td>
                            <td class="text-right"><?= rupiah($penjualan->jumlah_bayar); ?></td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right">Uang Bayar</td>
                            <td class="text-right"><?= rupiah($penjualan->uang_bayar); ?></td>
                          </tr>
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="text-right">Kembalian</td>
                            <td class="text-right"><?= rupiah($penjualan->kembalian); ?></td>
                          </tr>
                        </tfoot>
                      </table>
                      <div class="thanks">Terima Kasih!</div>
                      <div class="notices">
                        <div>CATATAN:</div>
                        <div class="notice">Harga Barang bisa berubah kapan Saja.</div>
                      </div>
                    </main>
                    <footer>
                      Invoice was created on a computer and is valid without the signature and seal.
                    </footer>
                  </div>
                  <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                  <div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>

    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

</body>

</html>