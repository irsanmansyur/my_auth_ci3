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
                                <a href=<?= base_url('admin/jenis_denda'); ?>>Daftar Jenis Denda</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item active">
                                <a href="#">Tambah jenis Denda</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit data Jenis Denda</div>
                        </div>
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="form-group form-group-default">
                                    <label for="nama">Nama Jenis Denda</label>
                                    <input class="form-control" id="nama" placeholder="Enter name Jenis Denda" name="nama" value="<?= set_value('nama') ?>" />
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>

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

        <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

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