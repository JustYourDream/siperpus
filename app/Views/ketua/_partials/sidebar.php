<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" href="<?= base_url('/ketua/dashboard_ketua'); ?>">
        <img src="../../assets/img/brand/merk.png" class="navbar-brand-img" alt="...">
      </a>
      <div class="ml-auto">
        <!-- Sidenav toggler -->
        <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="dashboard_ketua" || $uri->getSegment(2)=="Dashboard_Ketua" || $uri->getSegment(1)=="login"){echo 'active';} ?>" href="<?php echo base_url('ketua/dashboard_ketua')?>">
              <i class="ni ni-basket text-purple"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
        </ul>
        <!--Master-->
        <hr class="my-3">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="data_petugas" || $uri->getSegment(2)=="Data_Petugas"){echo 'active';} ?>" href="<?php echo base_url('ketua/data_petugas')?>">
              <i class="fas fa-users text-orange"></i>
              <span class="nav-link-text">Data Petugas</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="setting_akun" || $uri->getSegment(2)=="Setting_Akun"){echo 'active';} ?>" href="<?php echo base_url('ketua/setting_akun')?>">
              <i class="ni ni-settings"></i>
              <span class="nav-link-text">Pengaturan Akun</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
