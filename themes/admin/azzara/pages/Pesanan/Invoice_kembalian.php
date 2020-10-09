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
               <div class="card" style="background: white!important;">
                  <div class="card-header d-flex  justify-content-between">
                     <h1>Invoice</h1>
                     <div class="app">
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
                  <div class="card-body">
                     <div class="informasi d-flex  justify-content-between">
                        <div class="date">
                           <h6>Tanggal</h6>
                           <span><?= date("d, M Y"); ?></span>
                        </div>
                        <div class="date">
                           <h6>Invoice ID</h6>
                           <span><?= @$id_invoice ?></span>
                        </div>
                        <div class="date">
                           <h6>Invoice to</h6>
                           <span><?= $user->nama_user ?></span>
                        </div>
                     </div>
                     <hr>
                     <h3>Order Summary</h3>
                     <table class="table">
                        <thead class="thead-dark">
                           <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama Mobil</th>
                              <th scope="col">Denda Ringan</th>
                              <th scope="col">Denda Sedang</th>
                              <th scope="col">Denda Berat</th>
                              <th scope="col">Total Denda</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           $subtotal = 0;
                           foreach ($pesanans as $key => $val) : ?>
                              <tr>
                                 <td><?= $no++; ?></td>
                                 <td><?= $val->nama_mobil; ?></td>
                                 <td><?= rupiah($val->harga_sewa); ?></td>
                                 <td><?= rupiah($val->biaya_driver); ?></td>
                                 <td><?= $val->durasi; ?></td>
                                 <td><?= rupiah($val->total); ?></td>
                                 <?php $subtotal += $val->total; ?>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th colspan="5" class="text-center"><b>Subtotal</b></th>
                              <th><?= rupiah($subtotal); ?></th>
                           </tr>
                        </tfoot>
                     </table>
                     <hr>
                     <div class="informasi d-flex  justify-content-between mt-5">
                        <div class="bank">
                           <h4>Bank Transfer</h4>
                           <div class="d-flex  justify-content-between">
                              <span>Account Name</span>
                              <span class="ml-auto">Syamsuddin</li>
                           </div>
                           <div class="d-flex  justify-content-between">
                              <span class="pr-3">Account Number</span>
                              <span class="ml-auto">096252556</li>
                           </div>
                        </div>
                        <div class="total text-center">
                           <h4>Total Amount</h4>
                           <h5><?= rupiah($subtotal); ?></h5>
                           taxes Included
                        </div>
                     </div>
                     <hr>
                     <hr>
                     <form method="POST" enctype="multipart/form-data" action="<?= base_url('invoice/tambah_pesanan'); ?>">
                        <span class="text-danger">Harap input bukti transfer (Foto/Screenshot) dengan jelas total pengiriman dan nama pengirim</span>
                        <div class="form-group mt-3">
                           <div class="custom-file">
                              <input type="hidden" name="jumlah_bayar" value="<?= @$subtotal; ?>">
                              <input type="hidden" name="id_invoice" value="<?= @$id_invoice; ?>">
                              <?php foreach ($transaksis as $key => $val) : ?>
                                 <input type="hidden" name="transaksi_id[]" value="<?= @$val->id; ?>">
                              <?php endforeach; ?>
                              <input type="file" name="bukti_transfer" class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Bukti Transfer</label>
                           </div>
                        </div>
                        <div class="text-center">
                           <button type="submit" class="btn btn-primary pl-5 pr-5">Pesan Sekarang</button></div>
                     </form>
                     <hr>
                     <h3><b> Notes</b></h3>
                     <p>We reale appreciate your business and if there’s anything elsse we can do, please let us know!. Also, should you need us to add VAT or anything else to this order. It’s super eassy since this is a template, so just ask!</p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

   </div>
   <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
   <script src="<?= $thema_folder; ?>assets/js/plugin/select2/js/select2.min.js"></script>
   <script>
      var baseurl = "<?= base_url() ?>";
      $(document).ready(function() {

      });

      [...document.querySelectorAll(".delete")].forEach(del => {
         del.addEventListener('click', e => {
            e.preventDefault();
            swal({
               title: 'Are you sure?',
               text: "You won't be able to revert this!",
               type: 'warning',
               buttons: {
                  cancel: {
                     visible: true,
                     text: 'No, cancel!',
                     className: 'btn btn-danger'
                  },
                  confirm: {
                     text: 'Yes, delete it!',
                     className: 'btn btn-success'
                  }
               }
            }).then((willDelete) => {
               if (willDelete) {
                  window.location = del.getAttribute('href');
               } else {
                  swal("tidak jadi menghapus!", {
                     buttons: {
                        confirm: {
                           className: 'btn btn-success'
                        }
                     }
                  });
               }
            });

         })
      });
   </script>
</body>

</html>