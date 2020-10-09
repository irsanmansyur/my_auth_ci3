  <!--
				Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
		-->
  <div class="main-header" data-background-color="purple">
      <!-- Logo Header -->
      <div class="logo-header">

          <a href="<?= base_url(); ?>" class="logo text-white">
              <?= $settings->name_app; ?>
              <!-- <img src="<?= $thema_folder; ?>assets/img/logoazzara.svg" alt="navbar brand" class="navbar-brand"> -->
          </a>
          <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                  <i class="fa fa-bars"></i>
              </span>
          </button>
          <button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
          <div class="navbar-minimize">
              <button class="btn btn-minimize btn-rounded">
                  <i class="fa fa-bars"></i>
              </button>
          </div>
      </div>
      <!-- End Logo Header -->

      <!-- Navbar Header -->
      <nav class="navbar navbar-header navbar-expand-lg">

          <div class="container-fluid">

              <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

                  <li class="nav-item dropdown hidden-caret">
                      <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                          <div class="avatar-sm">
                              <img src="<?= base_url('assets/img/profile/' . $user->profile); ?>" alt="..." class="avatar-img rounded-circle">
                          </div>
                      </a>
                      <ul class="dropdown-menu dropdown-user animated fadeIn">
                          <li>
                              <div class="user-box">
                                  <div class="avatar-lg"><img src="<?= base_url('assets/img/profile/' . $user->profile); ?>" alt="image profile" class="avatar-img rounded"></div>
                                  <div class="u-text">
                                      <h4><?= $user->name; ?></h4>
                                      <p class="text-muted"><?= $user->email; ?></p>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?= base_url('admin/profile'); ?>">My Profile</a>

                              <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">Logout</a>
                          </li>
                      </ul>
                  </li>

              </ul>
          </div>
      </nav>
      <!-- End Navbar -->
  </div>