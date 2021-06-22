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
                                <a href=<?= base_url('permission/user/list'); ?>>User List</a>
                            </li>

                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item active">
                                <a href="#">Tambah User</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-with-nav">
                                <div class="card-header">
                                    <h3 class="mt-4">Identitssa user</h3>
                                    <?php echo validation_errors(); ?>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="nama_user" placeholder="Name" value="insert naame">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username" placeholder="Name" value="insert username">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="aktif">aktif</option>
                                                        <option value="non aktif">Non Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Pilih level Admin</label>
                                                    <select class="form-control" id=role_id name=role_id>
                                                        <?php foreach ($roles as $role) : ?>
                                                            <option value="<?= $role->id; ?>" <?= $ ;?>  ><?= $role->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Name email" value="hello@example.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="form-group form-group-default">
                                                    <h3>Ganti Gambar (Klik gambar di bawah)</h3>
                                                    <div class="card-avatar">
                                                        <input type="file" name="gambar" id="imagechange" class="d-none" />

                                                        <a href="#pablo" id="changePhoto">
                                                            <img class="img thumbnail rounded-circle" style="width: 100px;height:100px;" src="<?= base_url('assets/mobils/default.jpg') ?>">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right mt-3 mb-3">
                                            <button class="btn btn-success" type="submit">Save</button>
                                            <button class="btn btn-danger" type="resets">Reset</button>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <!-- card profile -->
                        <div class="col-md-4">
                          <?php $this->load->view($thema_load . "partials/_card-profile.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
   
        <!-- End Custom template -->
    </div>
    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
    <script>
        // scrip ganti gambar
        $("#changePhoto").click(function() {
            $('input#imagechange').click();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#changePhoto').find('.img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('input#imagechange').change(function() {
            readURL(this);
        });
    </script>
</body>

</html>