<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" href="<?= base_url('/petugas/dashboard_petugas'); ?>">
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
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="dashboard_petugas" || $uri->getSegment(2)=="Dashboard_Petugas" || $uri->getSegment(1)=="login"){echo 'active';} ?>" href="<?php echo base_url('petugas/dashboard_petugas')?>">
              <i class="ni ni-basket text-purple"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
        </ul>
        <!--Master-->
        <hr class="my-3">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="databuku_petugas" || $uri->getSegment(2)=="DataBuku_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/databuku_petugas')?>">
              <i class="ni ni-books text-orange"></i>
              <span class="nav-link-text">Data Buku</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="ebook_petugas" || $uri->getSegment(2)=="Ebook_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/ebook_petugas')?>">
              <i class="fas fa-book-open text-green"></i>
              <span class="nav-link-text">Data E-book</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="dataanggota_petugas" || $uri->getSegment(2)=="DataAnggota_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/dataanggota_petugas')?>">
              <i class="ni ni-single-02 text-pink"></i>
              <span class="nav-link-text">Data Anggota</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="datapengunjung_petugas" || $uri->getSegment(2)=="DataPengunjung_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/datapengunjung_petugas')?>">
              <i class="fas fa-street-view text-orange"></i>
              <span class="nav-link-text">Data Pengunjung</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="datapeminjaman_petugas" || $uri->getSegment(2)=="DataPeminjaman_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/datapeminjaman_petugas')?>">
              <i class="fas fa-upload text-green"></i>
              <span class="nav-link-text">Data Peminjaman</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="datapengembalian_petugas" || $uri->getSegment(2)=="DataPengembalian_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/datapengembalian_petugas')?>">
              <i class="fas fa-download text-teal"></i>
              <span class="nav-link-text">Data Pengembalian</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="laporan_petugas" || $uri->getSegment(2)=="Laporan_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/laporan_petugas')?>">
              <i class="ni ni-single-copy-04 text-yellow"></i>
              <span class="nav-link-text">Buat Laporan</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link <?php $uri = service('uri'); if($uri->getSegment(2)=="akun_petugas" || $uri->getSegment(2)=="Akun_Petugas"){echo 'active';} ?>" href="<?php echo base_url('petugas/akun_petugas')?>">
              <i class="ni ni-settings"></i>
              <span class="nav-link-text">Pengaturan Akun</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
