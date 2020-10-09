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
                                <a href="#">Mobil</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit data Mobil</div>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nama Mobil</label>
                                    <input class="form-control" id="name" placeholder="Enter name mobil" name="nama_mobil" value="<?= $mobil->nama_mobil ?>">
                                </div>
                                <div class="form-group">
                                    <label for="kapasitas">kapasitas</label>
                                    <input class="form-control" id="kapasitas" type="number" placeholder="Enter kapasitas mobil" name="kapasitas_orang" value="<?= $mobil->kapasitas_orang; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="harga_sewa">Harga sewa</label>
                                    <input class="form-control" id="harga_sewa" type="number" placeholder="Enter harga_sewa mobil" name="harga_sewa" value="<?= $mobil->harga_sewa; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok Mobil</label>
                                    <input class="form-control" id="stok" type="number" placeholder="Enter stok mobil" name="stok" value="<?= $mobil->stok; ?>">
                                </div>

                                <div class="form-check">
                                    <label>Status</label><br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="status" value="tersedia" <?= $mobil->status == 'tersedia' ? ' checked' : ''; ?>>
                                        <span class="form-radio-sign">tersedia</span>
                                    </label>
                                    <label class="form-radio-label ml-3">
                                        <input class="form-radio-input" type="radio" name="status" value="dipinjam" <?= $mobil->status == 'dipinjam' ? ' checked' : ''; ?>>
                                        <span class="form-radio-sign">dipinjam</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_id">Jenis Mobils</label>
                                    <select class="form-control" name="jenis_id" id="jenis_id">
                                        <?php foreach ($jenis_mobils as $jenis) : ?>
                                            <option value="<?= $jenis->id; ?>" <?= $mobil->jenis_id == $jenis->id ? " selected" : ''; ?>><?= $jenis->nama_jenis; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="transmisi">Transmisi</label>
                                    <select class="form-control" name="transmisi" id="transmisi">
                                        <option value="Manual">Manual</option>
                                        <option value="Matic">matic</option>
                                    </select>
                                </div>
                                <input type="file" name="gambar" id="imagechange" class="d-none" />
                                <div class="form-group">
                                    <h3>Ganti Gambar (Klik gambar di bawah)</h3>
                                    <div class="card-avatar">
                                        <a href="#pablo" id="changePhoto">
                                            <img class="img thumbnail rounded-circle" style="width: 100px;height:100px;" src="<?= base_url('assets/mobils/' . $mobil->gambar) ?>">
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