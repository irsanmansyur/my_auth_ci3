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
                        <a href="#">Kerusakan</a>
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
                                 <th scope="col">Nama Mobil</th>
                                 <th scope="col">Kerusakan</th>
                                 <th scope="col">Biaya</th>
                                 <th scope="col">Gambar</th>
                                 <th scope="col">tanggal</th>

                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $no = 1;
                              foreach ($mobils as $jenis) : ?>
                                 <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $jenis->nama_mobil; ?></td>

                                    <td><?= $jenis->denda; ?></td>
                                    <td><?= $jenis->biaya_denda; ?></td>

                                    <td><img src="<?= base_url('assets/mobils/' . $jenis->gambar); ?>" alt="" style="width:100px;height:100px"> </td>
                                    <td>
                                       <?= date("d, M Y", strtotime($jenis->date_created)); ?>
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

      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
         <div class="title">Settings</div>
         <div class="custom-content">
            <div class="switcher">
               <div class="switch-block">
                  <h4>Topbar</h4>
                  <div class="btnSwitch">
                     <button type="button" class="changeMainHeaderColor" data-color="blue"></button>
                     <button type="button" class="selected changeMainHeaderColor" data-color="purple"></button>
                     <button type="button" class="changeMainHeaderColor" data-color="light-blue"></button>
                     <button type="button" class="changeMainHeaderColor" data-color="green"></button>
                     <button type="button" class="changeMainHeaderColor" data-color="orange"></button>
                     <button type="button" class="changeMainHeaderColor" data-color="red"></button>
                  </div>
               </div>
               <div class="switch-block">
                  <h4>Background</h4>
                  <div class="btnSwitch">
                     <button type="button" class="changeBackgroundColor" data-color="bg2"></button>
                     <button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
                     <button type="button" class="changeBackgroundColor" data-color="bg3"></button>
                  </div>
               </div>
            </div>
         </div>
         <div class="custom-toggle">
            <i class="flaticon-settings"></i>
         </div>
      </div>
      <!-- End Custom template -->
   </div>
   <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

</body>

</html>