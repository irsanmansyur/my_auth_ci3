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
                                <a href="#">list User</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header  d-flex justify-content-between">
                            <div class="card-title"><?= $page_title; ?></div>
                            <a href="<?= base_url('admin/user/add'); ?>" class="btn btn-primary">Add</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="table table-hover display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">nama User</th>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($users->result_object() as $user) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $user->name; ?></td>
                                                <td><img src="<?= base_url('assets/img/profile/' . $user->profile); ?>" alt="" style="width:100px;height:100px"> </td>
                                                <td>
                                                    <a href="<?= base_url('admin/user/edit/' . $user->id); ?>" class="btn btn-warning btn-sm rounded">Edit</a>
                                                    <a href="<?= base_url('admin/user/delete/' . $user->id); ?>" class="delete btn btn-danger btn-sm rounded">Delete</a>
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