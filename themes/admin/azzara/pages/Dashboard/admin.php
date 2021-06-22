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
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-3  col-6">
              <div class="card card-stats card-round">
                <div class="card-body ">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-box"></i>
                      </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                      <div class="numbers">
                        <p class="card-category">Jenis Barang</p>
                        <h4 class="card-title"><?= $jumlah_jenis_barang; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3  col-6">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="fas fa-layer-group"></i>
                      </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                      <div class="numbers">
                        <p class="card-category">Kategori Barang</p>
                        <h4 class="card-title"><?= $jumlah_kategori; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3  col-6">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-info bubble-shadow-small">
                        <i class="fas fa-people-carry"></i>
                      </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                      <div class="numbers">
                        <p class="card-category">Sulpliers</p>
                        <h4 class="card-title"><?= $jumlah_suplier; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3  col-6">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                      <div class="numbers">
                        <p class="card-category">Pelanggan Terdaftar</p>
                        <h4 class="card-title"><?= $jumlah_pelanggan; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Pendapatan Harian</div>
                </div>
                <div class="card-body p-1">
                  <div class="chart-container">
                    <canvas id="pendapatan-harian"></canvas>
                  </div>
                  <div id="myChartLegend">
                    <ul class="0-legend html-legend">
                      <li class=""><span style="background-color:#f3545d"></span>Bulan Ini: <b><?= rupiah(array_sum(array_column($chart_pendapatan_harian, "bulan_ini"))); ?></b></li>
                      <li class=""><span style="background-color:#fdaf4b"></span>Bulan Kemarin: <b><?= rupiah(array_sum(array_column($chart_pendapatan_harian, "bulan_kemarin"))); ?></b></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">

            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Your Visit your Dashboard</div>
                    </div>
                    <div class="card-body">
                      <div class="chart-container">
                        <canvas id="userVisit"></canvas>
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
                    <div class="name"><?= $user->name; ?>,</div>
                    <div class="email"><?= $user->email; ?></div>
                    <div class="view-profile mt-4">
                      <a href="<?= base_url('admin/profile'); ?>" class="btn btn-secondary btn-block">View Full Profile</a>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>

      </div>
    </div>

    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>

  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
  <script src="<?= $thema_folder . "assets/js/plugin/chart.js/chart.min.js"; ?>"></script>

  <script>
    const myVisit = <?= json_encode($chartUserVisit) ?>;
    const pendapatan_harian = <?= json_encode($chart_pendapatan_harian) ?>;
    let barPendapatan = document.getElementById('pendapatan-harian').getContext('2d');
    let barChart = document.getElementById('userVisit').getContext('2d');
    let myBarPendapatan = new Chart(barPendapatan, {
      type: 'line',
      data: {
        labels: pendapatan_harian.map(view => view.day),
        datasets: [{
          label: "Bulan Ini",
          borderColor: '#f3545d',
          pointBackgroundColor: 'rgba(243, 84, 93, 0.2)',
          pointRadius: 0,
          backgroundColor: 'rgba(243, 84, 93, 0.1)',
          legendColor: '#f3545d',
          fill: true,
          borderWidth: 2,
          data: pendapatan_harian.map(view => view.bulan_ini),
        }, {
          label: "Bulan Lalu",
          borderColor: '#fdaf4b',
          pointBackgroundColor: 'rgba(253, 175, 75, 0.2)',
          pointRadius: 0,
          backgroundColor: 'rgba(253, 175, 75, 0.1)',
          legendColor: '#fdaf4b',
          fill: true,
          borderWidth: 2,
          data: pendapatan_harian.map(view => view.bulan_kemarin),
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
        layout: {
          padding: {
            left: 15,
            right: 15,
            top: 15,
            bottom: 15
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              fontColor: "rgba(0,0,0,0.5)",
              fontStyle: "500",
              beginAtZero: false,
              maxTicksLimit: 5,
              padding: 20
            },
            gridLines: {
              drawTicks: false,
              display: false
            }
          }],
          xAxes: [{
            gridLines: {
              zeroLineColor: "transparent"
            },
            ticks: {
              padding: 20,
              fontColor: "rgba(0,0,0,0.5)",
              fontStyle: "500"
            }
          }]
        },
        legendCallback: function(chart) {
          var text = [];
          text.push('<ul class="' + chart.id + '-legend html-legend">');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>');
            if (chart.data.datasets[i].label) {
              text.push(chart.data.datasets[i].label);
            }
            text.push('</li>');
          }
          text.push('</ul>');
          return text.join('');
        },
        tooltips: {
          bodySpacing: 4,
          mode: "nearest",
          intersect: 0,
          position: "nearest",
          xPadding: 10,
          yPadding: 10,
          caretPadding: 10,
          callbacks: {
            label: function(t, d) {
              var xLabel = d.datasets[t.datasetIndex].label;
              var yLabel = t.yLabel >= 1000 ? 'Rp. ' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Rp. ' + t.yLabel;
              return xLabel + ': ' + yLabel;
            }
          }
        }
      }
    });
    let myBarChart = new Chart(barChart, {
      type: 'bar',
      data: {
        labels: myVisit.map(view => view.day),
        datasets: [{
          label: "Kunjungan Anda",
          backgroundColor: 'rgb(23, 125, 255)',
          borderColor: 'rgb(23, 125, 255)',
          data: myVisit.map(view => view.countIsUser),
        }, {
          label: "Semua Kunjungan",
          backgroundColor: 'rgb(255, 188, 0)',
          borderColor: 'rgb(255, 188, 0)',
          data: myVisit.map(view => view.countAllUser),
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
      }
    });
  </script>

</body>

</html>