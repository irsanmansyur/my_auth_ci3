<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Welcome to CodeIgniter</title>

  <link rel="stylesheet" href="<?= base_url("assets/bootstrap/bootstrap.min.css"); ?>">
  <script src="<?= base_url("assets\bootstrap\bootstrap.bundle.min.js"); ?>"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Welcome</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
        </ul>
        <div class="d-flex">
          <?php if (is_login()) : ?>
            <a href="<?= base_url("admin/dashboard"); ?>" class="btn btn-primary mr-2">Dashboard</a>
            <a href="<?= base_url("auth/logout"); ?>" class="btn btn-danger mr-2">Logout</a>
          <?php else : ?>
            <a href="<?= base_url("auth"); ?>" class="btn btn-primary mr-2">Login</a>
            <a href="<?= base_url("auth/register"); ?>" class="btn btn-secondary">Signup</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
  <div class="container py-5">

    <div class="card">
      <div class="card-header">
        <h1>Welcome to CodeIgniter!</h1>

      </div>
      <div class="card-body">
        <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

        <p>If you would like to edit this page you'll find it located at:</p>
        <code>application/views/welcome_message.php</code>

        <p>The corresponding controller for this page is found at:</p>
        <code>application/controllers/Welcome.php</code>

      </div>
      <div class="card-footer text-right">
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
      </div>
    </div>

  </div>

</body>

</html>