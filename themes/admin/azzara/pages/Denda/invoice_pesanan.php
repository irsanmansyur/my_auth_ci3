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
                        <a href="<?= base_url(); ?>">
                           <i class="flaticon-home"></i>
                        </a>
                     </li>
                     <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                     </li>
                     <li class="nav-item">
                        <a href=<?= base_url('dashboard'); ?>>Dashboard</a>
                     </li>

                     <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                     </li>
                     <li class="nav-item active">
                        <a href="#">Daftar Pesanan</a>
                     </li>
                  </ul>
               </div>
               <div class="card">

                  <div class="card-body">
                     <div class="d-flex justify-content-center mb-5 w-100">
                        <div class="invoice mr-5">
                           <h1>INVOICE</h1>
                        </div>
                        <div class="app ml-auto">
                           <h3 class="p-0"><img src="<?= base_url('assets/setting/' . $settings->logo); ?>" alt="" class="logo"> <?= $settings->name_app; ?></h3>

                           <div class="d-flex align-items-center bg-light">
                              <span class="pr-5">alamat</span>
                              <span class="ml-auto"><?= $settings->alamat_app; ?></span>
                           </div>
                           <div class="d-flex align-items-center bg-light">
                              <span class="pr-5">No. Telp</span>
                              <span class=""><?= $settings->telp_app; ?></span>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="informasi d-flex  justify-content-between p-3">
                        <div class="date">
                           <h6>Tanggal</h6>
                           <span><?= date("d, M Y"); ?></span>
                        </div>
                        <div class="date">
                           <h6>Invoice ID</h6>
                           <span class="text-danger"><?= @$pesanan->id_invoice ?></span>
                        </div>
                        <div class="date">
                           <h6>Invoice to</h6>
                           <span><?= $user->nama_user ?></span>
                        </div>
                     </div>
                     <hr>
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Order Summary</h4>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                                 <thead>
                                    <tr>
                                       <th scope="col">#</th>
                                       <th scope="col">Nama Mobil</th>
                                       <th scope="col">Denda Ringan</th>
                                       <th scope="col">Denda Sedang</th>
                                       <th scope="col">Denda Berat</th>
                                       <th scope="col">Harga Denda</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $id = null;
                                    $ttlDenda = 0;
                                    foreach ($pesanan->list as $row => $list_pesanan) :
                                       if (count($list_pesanan->dendas) > 1) : ?>
                                          <?php foreach ($list_pesanan->dendas as $key => $dnd) :
                                             $dendanya = ($dnd->jenis_id == 1 && $dnd->id == 1) ? $dnd->biaya * $pesanan->terlambat : $dnd->biaya;

                                             $ttlDenda += $dendanya; ?>
                                             <tr>
                                                <?php
                                                if ($key == 0) { ?>
                                                   <td rowspan="<?= count($list_pesanan->dendas); ?>"> <?= $row + 1; ?></td>
                                                   <td rowspan="<?= count($list_pesanan->dendas); ?>"><?= $list_pesanan->nama_mobil; ?></td>
                                                   <td><?= $dnd->jenis_id == 1 ? $dnd->nama : "-" ?></td>
                                                   <td><?= $dnd->jenis_id == 2 ? $dnd->nama : "-" ?></td>
                                                   <td><?= $dnd->jenis_id == 3 ? $dnd->nama : "-" ?></td>
                                                   <td> <?= rupiah($dendanya); ?></td>
                                             </tr>
                                          <?php } else { ?>

                                             <td><?= $dnd->jenis_id == 1 ? $dnd->nama : "-" ?></td>
                                             <td><?= $dnd->jenis_id == 2 ? $dnd->nama : "-" ?></td>
                                             <td><?= $dnd->jenis_id == 3 ? $dnd->nama : "-" ?></td>
                                             <td> <?= rupiah($dnd->jenis_id == 1 ? $dnd->biaya * $pesanan->terlambat : $dnd->biaya); ?></td>

                                             </tr>

                                          <?php }; ?>
                                       <?php endforeach; ?>

                                    <?php else : ?>
                                       <tr>
                                          <td><?= $row + 1; ?></td>
                                          <td col><?= $list_pesanan->nama_mobil; ?></td>
                                          <?php if (isset($list_pesanan->dendas[0])) :
                                             $dendanya = ($list_pesanan->dendas[0]->jenis_id == 1 && $list_pesanan->dendas[0]->id == 1) ? $list_pesanan->dendas[0]->biaya * $pesanan->terlambat : $list_pesanan->dendas[0]->biaya;

                                             $ttlDenda += $dendanya; ?>
                                             ?>
                                             <td><?= $list_pesanan->dendas[0]->jenis_id == 1 ? $list_pesanan->dendas[0]->nama : "-" ?></td>
                                             <td><?= $list_pesanan->dendas[0]->jenis_id == 2 ? $list_pesanan->dendas[0]->nama : "-" ?></td>
                                             <td><?= $list_pesanan->dendas[0]->jenis_id == 3 ? $list_pesanan->dendas[0]->nama : "-" ?></td>
                                             <td><?= rupiah(($list_pesanan->dendas[0]->jenis_id == 1 && $list_pesanan->dendas[0]->id == 1) ? $list_pesanan->dendas[0]->biaya * $pesanan->terlambat : $list_pesanan->dendas[0]->biaya); ?></td>

                                          <?php else :; ?>
                                             <td>-</td>
                                             <td>-</td>
                                             <td>-</td>
                                          <?php endif; ?>
                                          <td><?= rupiah(0); ?></td>

                                       </tr>
                                    <?php endif; ?>

                                 <?php endforeach; ?>

                                 </tbody>
                                 <tfoot>
                                    <tr>
                                       <th colspan="5">Total Denda</td>
                                       <th><?= rupiah($ttlDenda); ?></th>
                                    </tr>
                                 </tfoot>

                              </table>
                           </div>
                        </div>
                     </div>

                     <center>
                        <?php if ($pesanan->status == 0) : ?>

                        <?php elseif ($pesanan->status == 2) : ?>
                           <span class="badge badge-danger">Sedang Berjalan dan Mobil Belum Di kembalikan</span>
                        <?php elseif ($pesanan->status == 3) : ?>
                           <form action="" method="post">
                              <input type="hidden" name="total" value="<?= $ttlDenda; ?>">
                              <button type="submit" class="btn btn-primary">Bayar Denda</button>
                           </form>
                        <?php else :; ?>
                           <span class="badge badge-success">Sudah Di Kembalikan Dan Lunas</span>

                        <?php endif; ?>
                     </center>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

   </div>
   <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
   <script>
      var baseurl = "<?= base_url() ?>";
   </script>
</body>

</html>