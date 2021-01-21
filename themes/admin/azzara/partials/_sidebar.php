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
               <span class="user-level"><?= $user->roles()->first() ? $user->roles()->first()->name : "No Role"; ?></span>
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

               <?php if (in_role("Super Admin")) : ?>
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

         <?php foreach ($user->menus as  $menu) : ?>
           <li class="nav-item menu">
             <a data-toggle="collapse" href="#<?= $menu->name ?>">
               <i class="fas fa-layer-group"></i>
               <p><?= $menu->name; ?></p>
               <span class="caret"></span>
             </a>
             <div class="collapse" id="<?= $menu->name; ?>">
               <ul class="nav nav-collapse">
                 <?php foreach ($menu->submenus as $submenu) : ?>
                   <li class="s-menu">
                     <a href="<?= base_url($submenu->url); ?>">
                       <span class="sub-item"><?= $submenu->name; ?></span>
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