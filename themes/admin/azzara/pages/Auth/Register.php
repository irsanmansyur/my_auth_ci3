<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?= $thema_folder; ?>assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= $thema_folder; ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['<?= $thema_folder; ?>assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= $thema_folder; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $thema_folder; ?>assets/css/azzara.min.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-signup animated fadeIn">
            <h3 class="text-center">Sign Up</h3>
            <?php $this->load->view($thema_load . "partials/_alert.php"); ?>
            <form method="post">
                <div class="login-form">
                    <div class="form-group form-floating-label">
                        <input id="fullname" value="<?= set_value("fullname"); ?>" name="fullname" type="text" class="form-control input-border-bottom">
                        <label for="fullname" class="placeholder">Fullname</label>
                        <?= form_error("fullname", "<div class='text-danger'>", "</div>"); ?>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="email" name="email" value="<?= set_value("email"); ?>" type=" email" class="form-control input-border-bottom" required>
                        <label for="email" class="placeholder">Email</label>
                        <?= form_error("email", "<div class='text-danger'>", "</div>"); ?>

                    </div>
                    <div class="form-group form-floating-label">
                        <input id="username" name="username" value="<?= set_value("username"); ?>" class="form-control input-border-bottom" required>
                        <label for="username" class="placeholder">Username</label>
                        <?= form_error("username", "<div class='text-danger'>", "</div>"); ?>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="passwordsignin" name="passwordsignin" type="password" class="form-control input-border-bottom" required>
                        <label for="passwordsignin" class="placeholder">Password</label>
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                        <?= form_error("passwordsignin", "<div class='text-danger'>", "</div>"); ?>

                    </div>
                    <div class="form-group form-floating-label">
                        <input id="confirmpassword" name="confirmpassword" type="password" class="form-control input-border-bottom" required>
                        <label for="confirmpassword" class="placeholder">Confirm Password</label>
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                        <?= form_error("confirmpassword", "<div class='text-danger'>", "</div>"); ?>

                    </div>
                    <div class="row form-sub m-0">
                        <!-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                        <label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
                    </div> -->
                    </div>
                    <div class="form-action">
                        <a href="<?= base_url(); ?>" id="show-signin" class="btn btn-danger btn-rounded btn-login mr-3">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= $thema_folder; ?>assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/core/popper.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/core/bootstrap.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/ready.js"></script>
</body>

</html>