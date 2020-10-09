 <!-- Sidebar -->
 <div class="sidebar">
     <div class="sidebar-wrapper scrollbar-inner">
         <div class="sidebar-content">
             <div class="user">
                 <div class="avatar-sm float-left mr-2">
                     <img src="<?= base_url('assets/img/profile/' . $user->profile); ?>" alt="..." class="avatar-img rounded-circle">
                 </div>
                 <div class="info">
                     <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                         <span>
                             <?= $user->name; ?>
                             <span class="user-level"><?= $user->rules->row()->name; ?></span>
                             <span class="caret"></span>
                         </span>
                     </a>
                     <div class="clearfix"></div>

                     <div class="collapse in" id="collapseExample">
                         <ul class="nav">
                             <li>
                                 <a href="<?= base_url('admin/profile'); ?>">
                                     <span class="link-collapse">My Profile</span>
                                 </a>
                             </li>

                             <?= $user->rules->row()->id; ?>
                             <?php if ($user->rules->row()->id == 1) : ?>
                                 <li>
                                     <a href="<?= base_url('admin/setting'); ?>">
                                         <span class="link-collapse">Settings</span>
                                     </a>
                                 </li>
                             <?php endif; ?>
                         </ul>
                     </div>
                 </div>
             </div>

             <ul class="nav">
                 <li class="nav-item">
                     <a href="<?= base_url('admin/dashboard'); ?>">
                         <i class="fas fa-home"></i>
                         <p>Dashboard</p>
                         <span class="badge badge-count">5</span>
                     </a>
                 </li>

                 <?php foreach ($user->menus as  $row) : ?>

                     <li class="nav-item menu">
                         <a data-toggle="collapse" href="#<?= $row->menu ?>">
                             <i class="fas fa-layer-group"></i>
                             <p><?= $row->menu; ?></p>
                             <span class="caret"></span>
                         </a>
                         <div class="collapse" id="<?= $row->menu; ?>">
                             <ul class="nav nav-collapse">
                                 <?php foreach ($row->submenu as $sm) : ?>
                                     <li class="s-menu">
                                         <a href="<?= base_url($sm->submenu_url); ?>">
                                             <span class="sub-item"><?= $sm->submenu_name; ?></span>
                                         </a>
                                     </li>
                                 <?php endforeach; ?>
                             </ul>
                         </div>
                     </li>
                 <?php endforeach; ?>
             </ul>
         </div>
     </div>

 </div>