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
            <div class="col-md-8">
              <div class="row">
                <div class="col-sm-6 col-md-3">
                  <div class="card card-stats card-round">
                    <div class="card-body ">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                          </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                          <div class="numbers">
                            <p class="card-category">Users</p>
                            <h4 class="card-title"><?= $countUser ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
    let barChart = document.getElementById('userVisit').getContext('2d');
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
        }],
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