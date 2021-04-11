<!-- =========================================================
* Argon Dashboard PRO v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro
* Copyright 2019 Creative Tim (https://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 -->
<!DOCTYPE html>
<html>
<?php include("_partials/head.php") ?>
<body class="bg-default">
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-4 pt-6 pb-5">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <?php
                $db = \Config\Database::connect();
                $dateNow = date('Y-m-d');
                $query = $db->table('data_pengunjung')->selectCount('no')->where(array('tanggal_kunjungan' => $dateNow));
                $result = $query->countAllResults();
              ?>
              <h1 class="text-white">Kunjungan Hari ini : <?= $result; ?></h1>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-8 pt-3">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-header bg-transparent pb-1">
              <div class="text-muted text-center mt-2 mb-3"><medium>Selamat Datang</medium></div>
              <div class="nav-wrapper">
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5" id="Fill">
              <div class="text-center mt-2 mb-3"><large><?= $nama; ?> | <?= $no_anggota; ?></large></div>
              <div class="text-center">
                <a href="<?php echo base_url('petugas/form_kunjungan')?>" class="btn btn-primary my-4">Kembali</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php include("_partials/js.php") ?>
</body>
</html>
