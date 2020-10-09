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
                                                        <i class="fas fa-money-bill-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Pendapatan Hari Ini</p>
                                                        <h4 class="card-title"><?= rupiah($pendapatan->hari_ini ?? 0)  ?></h4>
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
                                <div class="col-sm-6 col-md-6">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                                        <i class="fas fa-shopping-bag"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ml-3 ml-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Transaksi Belum Di validasi</p>
                                                        <h4 class="card-title"><?= $pesanan->tidak_divalidasi; ?></h4>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Pendapatan Dalam Seminggu</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h2 class="display-5 text-success">Total Pendapatan</h2>
                                    <h3 class="text-danger">
                                        <?php
                                        $jml = 0;
                                        foreach ($chart as $row)
                                            $jml += $row['pendapatan'];
                                        echo rupiah($jml) ?>
                                    </h3>
                                </div>
                                <div class="col-md-8">
                                    <div class="chart-container">
                                        <canvas id="barChart"></canvas>
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
        console.log(addcommas(20000.303));
        const hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

        let start = new Date(),
            end = new Date();
        start.setDate(start.getDate() - 7);
        start.setHours(0, 0, 0, 0)
        var myBarChart = new Chart(barChart, {
            type: 'bar',
            data: {
                labels: chartku.map(pd => pd.day),
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