<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Azzara Bootstrap 4 Admin Dashboard</title>
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
<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="<?= $thema_folder; ?>assets/css/demo.css">
<link rel="stylesheet" href="<?= $thema_folder; ?>assets/css/style.css">
<script src="<?= $thema_folder; ?>assets/js/main.js"></script>