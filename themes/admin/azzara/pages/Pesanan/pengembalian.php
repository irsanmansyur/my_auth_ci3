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
                        <div class="card-header  d-flex justify-content-between">
                            <div class="card-title"><?= $page_title; ?></div>
                        </div>
                        <div class="card-body">
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
                                            <th scope="col">Jaminan</th>
                                            <th scope="col">Action</th>
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
                                                        <span class="badge badge-danger">Sudah Di bayar dan Belum Di kembalikan</span>

                                                    <?php else : ?>
                                                        <span class="badge badge-primary">Sudah Di kembalikan</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $pesanan->nama_jaminan; ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/pesanan/dikembalikan/' . $pesanan->id_invoice); ?>" class="btn btn-primary btn-sm rounded">Lihat</a>
                                                    <a href="<?= base_url('admin/pesanan/delete/' . $pesanan->id_invoice); ?>" class="delete btn btn-danger btn-sm rounded">Delete</a>
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
    <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script>
        var baseurl = "<?= base_url() ?>";

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