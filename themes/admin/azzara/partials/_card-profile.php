<div class="card card-profile card-secondary">
  <div class="card-header" style="background-image: url('<?= $thema_folder; ?>assets/img/blogpost.jpg')">
    <div class="profile-picture">
      <?php if (in_role("Admin")) : ?>
        <div class="avatar avatar-xl">
          <img src="<?= user()->getProfile() ?>" alt="..." class="avatar-img rounded-circle">
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="card-body">
    <div class="user-profile text-center">
      <h1>Selamat Datang!</h1>
      <div class="name"><?= $user->name; ?>,</div>
      <div class="email"><?= $user->email; ?></div>
      <?php if (current_url() != base_url('admin/profile')) : ?>
        <div class="view-profile mt-4">
          <a href="<?= base_url('admin/profile'); ?>" class="btn btn-secondary btn-block">Lihat Profil</a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>