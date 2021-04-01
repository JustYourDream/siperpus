<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" href="../../pages/dashboards/dashboard.html">
        <img src="../../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
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
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="dashboard_petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/dashboard_petugas')?>">
              <i class="ni ni-basket text-purple"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
        </ul>
        <!--Master-->
        <hr class="my-3">
        <h6 class="navbar-heading p-0 text-muted">Master</h6>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="databuku_petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/databuku_petugas')?>">
              <i class="ni ni-books text-orange"></i>
              <span class="nav-link-text">Data Buku</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/widgets.html">
              <i class="ni ni-single-02 text-pink"></i>
              <span class="nav-link-text">Data Anggota</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="datapeminjaman_petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/datapeminjaman_petugas')?>">
              <i class="fas fa-upload text-green"></i>
              <span class="nav-link-text">Data Peminjaman</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="datapengembalian_petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/datapengembalian_petugas')?>">
              <i class="fas fa-download text-teal"></i>
              <span class="nav-link-text">Data Pengembalian</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <h6 class="navbar-heading p-0 text-muted">Laporan</h6>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../../pages/widgets.html">
              <i class="ni ni-single-copy-04 text-yellow"></i>
              <span class="nav-link-text">Buat Laporan</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">Akun</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="akun_petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/akun_petugas')?>">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Pengaturan Akun</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
