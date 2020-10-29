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