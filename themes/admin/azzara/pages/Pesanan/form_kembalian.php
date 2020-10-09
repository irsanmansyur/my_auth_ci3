<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view($thema_load . "partials/_head.php"); ?>
    <link rel="stylesheet" href="<?= $thema_folder; ?>assets/js/plugin/select2/css/select2.min.css">
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
                                    <h1>Nomor Invoice</h1>
                                    <h2 class="text-danger"><?= $pesanan->id_invoice; ?></h2>

                                </div>
                                <div class="jumlah ml-auto">
                                    <h1>Tanggal Sekarang</h1>
                                    <h2 class="text-danger"><?= date("d, M Y", time()) ?></h2>
                                    <h1 class="mt-5">Tanggal Jatuh Tempo</h1>
                                    <h2><?= date("d, M Y", strtotime($pesanan->sampai_tanggal)) ?></h2>

                                </div>
                                <div class="user ml-auto">
                                    <h1 class="text-dark">Nama Pemesan</h1>
                                    <h2 class="text-danger"><?= $pesanan->nama_user; ?></h2>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Daftar Kembalian</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 col-md-3">
                                            <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd nav-pills-icons" id="v-pills-tab-with-icon" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link active show" id="v-pills-home-tab-icons" data-toggle="pill" href="#v-pills-home-icons" role="tab" aria-controls="v-pills-home-icons" aria-selected="true">
                                                    <i class="flaticon-home"></i>
                                                    Daftar Pesanan
                                                </a>
                                                <a class="nav-link" id="v-pills-profile-tab-icons" data-toggle="pill" href="#v-pills-profile-icons" role="tab" aria-controls="v-pills-profile-icons" aria-selected="false">
                                                    <i class="flaticon-user-4"></i>
                                                    Set Denda
                                                </a>

                                            </div>
                                        </div>
                                        <div class="col-8 col-md-9">
                                            <div class="tab-content" id="v-pills-with-icon-tabContent">
                                                <div class="tab-pane fade active show" id="v-pills-home-icons" role="tabpanel" aria-labelledby="v-pills-home-tab-icons">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Nama Mobil</th>
                                                                <th scope="col">Harga sewa/Hari</th>
                                                                <th scope="col">Driver</th>
                                                                <th scope="col">Biaya Driver / hari</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($pesanan->list as $row => $list_pesaanan) : ?>
                                                                <tr>
                                                                    <td><?= $row + 1; ?></td>
                                                                    <td><?= $list_pesaanan->nama_mobil; ?></td>
                                                                    <td><?= rupiah($list_pesaanan->harga_sewa); ?></td>
                                                                    <td><?= $list_pesaanan->nama_driver; ?></td>
                                                                    <td><?= rupiah($list_pesaanan->biaya_driver); ?></td>

                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-profile-icons" role="tabpanel" aria-labelledby="v-pills-profile-tab-icons">
                                                    <?php if ($pesanan->status == 2) : ?>
                                                        <form action="" method="post">
                                                            <?php
                                                            foreach ($pesanan->list as $row => $pesanan_list) : ?>
                                                                <input type="hidden" name="mobil_id[]" value="<?= $pesanan_list->mobil_id; ?>">
                                                                <input type="hidden" id="idPesanan<?= $row ?>" name="mobil_sewa_id[]" value="<?= $pesanan_list->id; ?>" class="form-control">
                                                                <div class="form-group">
                                                                    <label for="denda<?= $row ?>"><?= $row + 1 ?>. Pilih Denda Untuk mobil <span class="text-danger"><?= $pesanan_list->nama_mobil; ?></span></label><br>
                                                                    <select class="js-example-basic-multiple form-control w-100" name="denda<?= $pesanan_list->id ?>[]" id="denda<?= $row ?>" multiple="multiple">
                                                                        <?php
                                                                        $groupid = "ok";
                                                                        $star = false;
                                                                        foreach ($dendas as $key => $denda) : ?>

                                                                            <?php if ($denda->jenis_id != $groupid) : ?>
                                                                                <?= $star ? "</optgroup>" : ''; ?>
                                                                                <optgroup label="<?= $denda->nama_jenis; ?>">
                                                                                    <option <?= $pesanan->terlambat > 0 && $denda->jenis_id == 1 && $denda->id == 1 ? 'selected' : ''; ?> class="rid_akun" value="<?= $denda->id; ?>"><?php echo $denda->nama_jenis . ' ' . '-' . ' ' . $denda->nama; ?></option>
                                                                                    <?php $groupid = $denda->jenis_id;
                                                                                    $start = true; ?>
                                                                                <?php else : ?>
                                                                                    <option class="rid_akun" value="<?= $denda->id; ?>" <?= $pesanan->terlambat > 0 && $denda->jenis_id == 1 && $denda->id == 1 ? 'selected' : ''; ?>><?php echo $denda->nama_jenis . ' ' . '-' . ' ' . $denda->nama; ?></option>

                                                                            <?php endif;
                                                                        endforeach; ?>
                                                                                </optgroup>

                                                                    </select>
                                                                </div>
                                                            <?php endforeach; ?>
                                                            <div class="form-group">

                                                                <input type="submit" class="btn btn-danger" value="Simpan">
                                                            </div>
                                                        </form>
                                                    <?php else :; ?>
                                                        <h3 class="text-center">Sudah Di Verifikasi</h3>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <center>
                                <?php if ($pesanan->status == 0) : ?>

                                <?php elseif ($pesanan->status == 2) : ?>
                                    <span class="badge badge-danger">Sedang Berjalan dan Mobil Belum Di kembalikan</span>
                                <?php else : ?>
                                    <span class="badge badge-primary">Sudah Di kembalikan</span>
                                <?php endif; ?>
                            </center>

                            <h1> Bukti transfer</h1>
                            <center>
                                <img src="<?= base_url("assets/bukti_transfer/" . $pesanan->bukti_transfer); ?>" alt="" style="max-width: 70%;">
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

    </div>
    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
    <!-- Sweet Alert -->
    <script src="<?= $thema_folder; ?>assets/js/plugin/select2/js/select2.min.js"></script>
    <script>
        var baseurl = "<?= base_url() ?>";
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                width: '100%'
            });
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