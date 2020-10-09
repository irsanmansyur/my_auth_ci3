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
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body ">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                        <i class="fas fa-user-friends"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">jumlah User</p>
                                                        <h4 class="card-title"><?= $count_users ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                        <i class="fas fa-car-crash"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Jumlah Jenis Mobil</p>
                                                        <h4 class="card-title"><?= $mobil->jumlah; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                        <i class="fas fa-car"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Mobil Tersedia</p>
                                                        <h4 class="card-title"><?= $mobil->tersedia; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                                        <i class="fas fa-car-side"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Mobil Dipinjam</p>
                                                        <h4 class="card-title"><?= $mobil->terpakai; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                                        <i class="fas fa-people-carry"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Driver Ready</p>
                                                        <h4 class="card-title"><?= $driver->tersedia->jumlah; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                        <i class="fas fa-route"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">jumlah driver Keluar</p>
                                                        <h4 class="card-title"><?= $driver->keluar->jumlah; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-profile card-secondary">
                                <div class="card-header" style="background-image: url('<?= $thema_folder; ?>assets/img/blogpost.jpg')">
                                    <div class="profile-picture">
                                        <div class="avatar avatar-xl">
                                            <img src="<?= base_url('assets/img/profile/' . $user->profile) ?>" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-profile text-center">
                                        <h1>Welcome</h1>
                                        <div class="name"><?= $user->nama_user; ?>,</div>
                                        <div class="email"><?= $user->email; ?></div>
                                        <div class="view-profile mt-4">
                                            <a href="<?= base_url('admin/profile'); ?>" class="btn btn-secondary btn-block">View Full Profile</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Pendapatan Dalam Setahun</div>
                                </div>
                                <div class="card-body">
                                    <div class="card-title">Jumlah Pendapatan Tahun ini</div>
                                    <div class="card-category">1 Jannuari - <?= $iniBulan . " ( " . date("Y", time()) . " ) "; ?></div>
                                    <div class="mb-4 mt-2">
                                        <h1><?= rupiah($totalPendapatan); ?></h1>
                                    </div>
                                    <div class="chart-container">
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h2 class="text-danger"><?= $settings->name_app ?></h2>
                                    <div class="card-title">Jumlah Pendapatan</div>

                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <h1><?= rupiah($jumlah_pendapatan->jumlah); ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-info bg-info-gradient">
                                <div class="card-header">
                                    <h2 class="text-danger"><?= $settings->name_app ?></h2>

                                    <div class="card-title">jumlah Denda</div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <h1><?= rupiah($denda->total); ?></h1>
                                    </div>
                                </div>
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

    <!-- Chart JS -->
    <script src="<?= $thema_folder ?>assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="<?= $thema_folder ?>assets/js/myhelper.js"></script>
    <script>
        let chartku = <?= json_encode($chart) ?>;
        let barChart = document.getElementById('barChart').getContext('2d');

        var myBarChart = new Chart(barChart, {
            type: 'bar',
            data: {
                labels: chartku.map(pd => pd.nama_bulan),
                datasets: [{
                    label: "Pendapatan ",
                    backgroundColor: 'rgb(23, 125, 255)',
                    borderColor: 'rgb(23, 125, 255)',
                    data: chartku.map(pd => pd.pendapatan)
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: "#ECECEC",
                        },
                        ticks: {
                            fontSize: 10,
                            callback: function(value, index, values) {
                                return "Rp. " + formatRupiah(value);
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            let datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';

                            return datasetLabel + ": Rp. " + formatRupiah(tooltipItem.yLabel, '');
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>