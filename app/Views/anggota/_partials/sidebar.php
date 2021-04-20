<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" href="../../pages/dashboards/dashboard.html">
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
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="dashboard_anggota"){echo 'active';} ?>" href="<?php echo base_url('anggota/dashboard_anggota')?>">
              <i class="ni ni-basket text-purple"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
        </ul>
        <!--Master-->
        <hr class="my-3">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="pinjam_buku"){echo 'active';} ?>" href="<?php echo base_url('anggota/pinjam_buku')?>">
              <i class="ni ni-books text-orange"></i>
              <span class="nav-link-text">Pinjam Buku</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="baca_buku"){echo 'active';} ?>" href="<?php echo base_url('anggota/baca_buku')?>">
              <i class="fas fa-book-open text-green"></i>
              <span class="nav-link-text">Baca Buku</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="info_peminjaman"){echo 'active';} ?>" href="<?php echo base_url('anggota/info_peminjaman')?>">
              <i class="fas fa-upload text-pink"></i>
              <span class="nav-link-text">Info Peminjaman</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="info_pengembalian"){echo 'active';} ?>" href="<?php echo base_url('anggota/info_pengembalian')?>">
              <i class="fas fa-download text-teal"></i>
              <span class="nav-link-text">Info Pengembalian</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="setting_akun"){echo 'active';} ?>" href="<?php echo base_url('anggota/setting_akun')?>">
              <i class="ni ni-settings"></i>
              <span class="nav-link-text">Pengaturan Akun</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
