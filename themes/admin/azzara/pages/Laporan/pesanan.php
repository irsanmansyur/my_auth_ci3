<!DOCTYPE html>
<html lang="en">

<head>
   <?php $this->load->view($thema_load . "partials/_head.php"); ?>
   <link rel="stylesheet" href="<?= $thema_folder . 'assets\js\plugin\jquery-ui-1.12.1\jquery-ui.min.css' ?>">
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
                  <div class="card-header  d-flex justify-content-between">
                     <div class="card-title"><?= $page_title; ?></div>

                  </div>
                  <div class="card-body">

                     <form action="" method="get">
                        <div class="row">
                           <div class="form-group col-md-6">
                              <label for="mulaiTgl">Mulai tanggal</label>
                              <input type="text" id="mulaiTgl" placeholder="Tanggal Mulai  Rental" class="form-control datepickers px-3" name="dari_tanggal">
                           </div>
                           <div class="form-group col-md-6">
                              <label for="sampaiTgl">Sampai Tanggal</label>
                              <input type="text" id="sampaiTgl" placeholder="Rencana Tanggal Kembali" name="sampai_tanggal" class="form-control datepickers px-3">
                           </div>
                           <div class="col-12 text-right">
                              <button type="submit" name="periode" class="btn btn-primary">Filter</button>
                           </div>
                        </div>
                     </form>

                     <div class="table-responsive">
                        <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Nama Customer</th>
                                 <th scope="col">Kode Invoice</th>
                                 <th scope="col">Tanggal Pesanan</th>
                                 <th scope="col">Total Pesanan</th>
                                 <th scope="col">Total Bayar</th>
                                 <th scope="col">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              foreach ($pesanans as $row => $pesanan) : ?>
                                 <tr>
                                    <td><?= $row + 1; ?></td>
                                    <td><?= $pesanan->nama_user; ?></td>
                                    <td><?= $pesanan->id_invoice; ?></td>
                                    <td><?= date("d, M Y", strtotime($pesanan->tgl_bayar)); ?></td>
                                    <td><?= count($pesanan->list); ?></td>
                                    <td><?= rupiah($pesanan->jumlah_bayar); ?></td>
                                    <td>
                                       <?php if ($pesanan->status == 0) : ?>
                                          <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                       <?php elseif ($pesanan->status == 2) : ?>
                                          <span class="badge badge-danger">Sudah Di bayar Dan Belum Di Kembalikan</span>

                                       <?php else : ?>
                                          <span class="badge badge-primary">Sudah Di kembalikan</span>
                                       <?php endif; ?>
                                    </td>

                                 </tr>
                              <?php endforeach; ?>

                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

   </div>
   <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
   <!-- Sweet Alert -->
   <script src="<?= $thema_folder; ?>assets\js\plugin\jquery-ui-1.12.1\jquery-ui.min.js"></script>
   <script>
      $(".datepickers").datepicker({
         changeYear: true,
         dateFormat: 'yy',
         showButtonPanel: true,
         viewMode: "year",
         onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1))
         }
      });
      // $(".datepickers").datepicker("option", "dateFormat", "yy-mm-dd");
      // $("   .datepickers").datepicker("option", "dateFormat", "yy");
   </script>
</body>

</html>