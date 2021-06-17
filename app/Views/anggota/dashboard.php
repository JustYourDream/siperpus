<!DOCTYPE html>
<html>
<?php include("_partials/head.php") ?>
<body>
  <!-- Sidenav -->
  <?php include("_partials/sidebar.php") ?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <?php include("_partials/topnav.php") ?>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('anggota/dashboard_anggota')?>"><i class="fas fa-home"></i></a></li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- Card stats -->
          <?php
          $db = \Config\Database::connect();
          ?>
          <div class="row">
            <?php
            $nama = $db->table('data_anggota')->select('nama_anggota')->where(['no_anggota' => session()->get('id')])->get()->getResult();
            foreach ($nama as $value):
            ?>
            <div class="col-xl-12 col-md-6">
              <div class="jumbotron bg-secondary">
                <h1 class="display-4">Halo, <?= $value->nama_anggota; ?>!</h1>
                <p class="lead">Selamat datang di <b>SIPERPUS</b>, Sistem Informasi Perpustakaan SMK Negeri 1 Ampelgading.</p>
                <hr class="my-4">
                <p>Dapatkan informasi mengenai perpustakaan dengan menjelajahi setiap menu yang tersedia.</p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="row">
            <?php
            $query_peminjaman = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['no_anggota' => session()->get('id')]);
            $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('m')])->where(['no_anggota' => session()->get('id')]);

            $query_pengunjung = $db->table('data_pengunjung')->selectCount('no')->where(['no_anggota' => session()->get('id')]);
            $query_pengunjung_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['no_anggota' => session()->get('id')])->where(['MONTH(tanggal_kunjungan)' => date('m')]);

            $query_denda = $db->table('data_pengembalian')->selectSum('denda')->where(['no_anggota' => session()->get('id')])->get();
            $query_belum_bayar = $db->table('data_pengembalian')->selectSum('denda')->where(['status_pembayaran' => "Belum Dibayar"])->where(['no_anggota' => session()->get('id')])->get();

            //Hasil
            $jml_peminjaman = $query_peminjaman->countAllResults();
            $jml_peminjaman_perbulan = $query_peminjaman_perbulan->countAllResults();

            $jml_kunjungan = $query_pengunjung->countAllResults();
            $jml_kunjungan_perbulan = $query_pengunjung_perbulan->countAllResults();

            $jml_denda = $query_denda->getResult();
            $jml_belum_bayar = $query_belum_bayar->getResult();
            ?>
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Riwayat Peminjaman</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jml_peminjaman ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="fas fa-upload"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $jml_peminjaman_perbulan ?></span>
                    <span class="text-nowrap">Peminjaman bulan ini</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Riwayat Kunjungan</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jml_kunjungan ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="fas fa-street-view"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $jml_kunjungan_perbulan; ?></span>
                    <span class="text-nowrap">Penambahan bulan ini</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <?php foreach ($jml_denda as $value): ?>
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pembayaran Denda</h5>
                      <span class="h2 font-weight-bold mb-0"><?= "Rp ".number_format($value->denda,0,',','.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                        <i class="fas fa-exclamation"></i>
                      </div>
                    </div>
                  </div>
                  <?php foreach ($jml_belum_bayar as $value): ?>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-warning mr-2"><?= "Rp ".number_format($value->denda,0,',','.'); ?></span>
                    <span class="text-nowrap">Denda belum dibayar</span>
                  </p>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-7">
          <div class="card bg-default">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-light text-uppercase ls-1 mb-1">Grafik Peminjaman Siswa</h6>
                  <h5 class="h3 text-white mb-0">Tahun <?= date('Y'); ?></h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-peminjaman" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-5">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Grafik Kunjungan Siswa</h6>
                  <h5 class="h3 mb-0">Tahun <?= date('Y'); ?></h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-pengunjung" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php include("_partials/footer.php") ?>
    </div>
  </div>
</body>
<?php include("_partials/js.php") ?>
<script>
var peminjaman = document.getElementById("chart-peminjaman").getContext('2d');
var pengunjung = document.getElementById("chart-pengunjung").getContext('2d');

//Chart Peminjaman
var chartPeminjaman = new Chart(peminjaman, {
  type: 'bar',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
    datasets: [{
      label: 'Peminjaman bulan ini',
      data: [
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('1')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('2')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('3')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('4')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('5')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('6')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('7')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('8')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('9')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('10')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('11')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('12')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>
      ],
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});

//Chart Pengunjung
var chartPengunjung = new Chart(pengunjung, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
    datasets: [{
      label: 'Kunjungan bulan ini',
      data: [
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('1')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('2')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('3')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('4')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('5')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('6')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('7')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('8')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('9')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('10')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('11')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('12')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->where(['no_anggota' => session()->get('id')])->countAllResults(); ?>,
      ],
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 2,
    }]
  },
  options: {
    responsive: true,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>
</html>
