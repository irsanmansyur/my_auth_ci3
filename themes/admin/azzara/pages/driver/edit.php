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
                                <a href=<?= base_url('admin/driver'); ?>>Driver</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item active">
                                <a href="#">edit Driver</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit data Driver</div>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group form-group-default">
                                    <label for="name">Nama Driver</label>
                                    <input class="form-control" id="name" placeholder="Enter name driver" name="nama" value="<?= $driver->nama ?>" />
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>

                                </div>
                                <div class="form-group form-group-default">
                                    <label for="alamat">Address</label>
                                    <input type="text" class="form-control" id="alamat" value="<?= $driver->alamat; ?>" name="alamat" placeholder="Address">
                                    <?= form_error('alamat    ', '<small class="text-danger">', '</small>'); ?>

                                </div>

                                <div class="form-group form-group-default">
                                    <label for="telp">Telp driver</label>
                                    <input class="form-control" id="telp" type="number" placeholder="Enter Telp driver" name="telp" value="<?= $driver->telp; ?>">
                                    <?= form_error('telp    ', '<small class="text-danger">', '</small>'); ?>

                                </div>
                                <div class="form-group form-group-default">
                                    <label for="biaya">Biaya driver</label>
                                    <input class="form-control" id="biaya" type="number" placeholder="Enter Biaya driver" name="biaya_driver" value="<?= $driver->biaya_driver; ?>">
                                </div>

                                <input type="file" name="gambar" id="imagechange" class="d-none" />
                                <div class="form-group form-group-default">
                                    <h3>Ganti Gambar (Klik gambar di bawah)</h3>
                                    <div class="card-avatar">
                                        <a href="#pablo" id="changePhoto">
                                            <img class="img thumbnail rounded-circle" style="width: 100px;height:100px;" src="<?= base_url('assets/driver/' . $driver->profile) ?>">
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <button class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
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