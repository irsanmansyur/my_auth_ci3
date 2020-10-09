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
                                <a href="#">Daftar Denda</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header  d-flex justify-content-between">
                            <div class="card-title"><?= $page_title; ?></div>
                            <a href="<?= base_url('admin/denda/action/tambah'); ?>" class="btn btn-primary">Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">nama</th>
                                            <th scope="col">biaya</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($dendas as $denda) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $denda->nama; ?></td>
                                                <td><?= rupiah($denda->biaya); ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/denda/action/' . $denda->id . "/edit"); ?>" class="btn btn-warning btn-sm rounded">Edit</a>
                                                    <a href="<?= base_url('admin/denda/action/' . $denda->id . "/delete"); ?>" class="delete btn btn-danger btn-sm rounded">Delete</a>
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