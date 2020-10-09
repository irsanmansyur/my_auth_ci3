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
                        <h4 class="page-title">Mengatur aplikasi</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="<?= base_url(); ?>">
                                    <i class="flaticon-home">Home</i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Setting Aplikasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Setting Aplikasi</div>
                        </div>
                        <form class="form form-horizontal" method="post" action="">
                            <div class="card-body">
                                <?php foreach ($setting as $key => $val) : ?>
                                    <?php if ($key == "theme_public" || $key == "theme_admin") { ?>
                                        <div class="form-group">
                                            <label for="<?= $key; ?>"><?= $key; ?>
                                            </label>
                                            <select class="form-control" name="<?= $key; ?>" id="<?= $key; ?>">
                                                <?php foreach (${$key} as $rows => $value) : ?>
                                                    <option <?= $val == $value ? "selected" : '' ?> value="<?= $value; ?>" class="py-2"><?= $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php } elseif ($key == 'logo') { ?>
                                        <div class="form-group">
                                            <label for="<?= $key; ?>">Input file Image Only</label>
                                            <input type="file" class="form-control-file" name="<?= $key; ?>" id="<?= $key; ?>">
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group">
                                            <label for="<?= $val; ?>"><?= $key; ?>
                                            </label>
                                            <input class="form-control" value="<?= $val; ?>" id="<?= $val; ?>" name="<?= $key; ?>" placeholder="Input Here">
                                        </div>
                                    <?php } ?>
                                <?php endforeach; ?>


                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <button class="btn btn-danger" type="reset">Reset</button>
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

</body>

</html>