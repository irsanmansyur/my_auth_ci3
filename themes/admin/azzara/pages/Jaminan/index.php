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
                                <a href="#">Daftar Jaminan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header  d-flex justify-content-between">
                            <div class="card-title"><?= $page_title; ?></div>
                            <a href="<?= base_url('admin/jaminan/tambah'); ?>" class="btn btn-primary">Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">nama</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($jaminans->result_object() as $jaminan) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $jaminan->nama; ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/jaminan/edit/' . $jaminan->id); ?>" class="btn btn-warning btn-sm rounded">Edit</a>
                                                    <a href="<?= base_url('admin/jaminan/delete/' . $jaminan->id); ?>" class="delete btn btn-danger btn-sm rounded">Delete</a>
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