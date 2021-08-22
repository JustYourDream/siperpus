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
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <?php
                  $db = \Config\Database::connect();
                  $query_buku = $db->table('data_buku')->selectCount('no_induk');
                  $query_buku_perbulan = $db->table('insert_buku')->selectCount('no_induk')->where(['MONTH(tanggal_insert)' => date('m')]);

                  $query_eksemplar = $db->table('insert_buku')->selectSum('eksemplar_buku')->get();
                  $query_eksemplar_perbulan = $db->table('insert_buku')->selectSum('eksemplar_buku')->where(['MONTH(tanggal_insert)' => date('m')])->get();

                  $query_peminjaman = $db->table('data_peminjaman')->selectCount('id_peminjaman');
                  $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('m')]);

                  $query_denda = $db->table('data_pengembalian')->selectSum('denda')->get();
                  $query_belum_bayar = $db->table('data_pengembalian')->selectSum('denda')->where(['status_pembayaran' => "Belum Dibayar"])->get();

                  //Hasil
                  $jml_buku = $query_buku->countAllResults();
                  $jml_buku_perbulan = $query_buku_perbulan->countAllResults();

                  $jml_eksemplar = $query_eksemplar->getResult();
                  $jml_eksemplar_perbulan = $query_eksemplar_perbulan->getResult();

                  $jml_peminjaman = $query_peminjaman->countAllResults();
                  $jml_peminjaman_perbulan = $query_peminjaman_perbulan->countAllResults();

                  $jml_denda = $query_denda->getResult();
                  $jml_belum_bayar = $query_belum_bayar->getResult();
                  ?>
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Buku</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jml_buku ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="fas fa-book"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $jml_buku_perbulan ?></span>
                    <span class="text-nowrap">Penambahan bulan ini</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <?php foreach ($jml_eksemplar as $value):
                      if($value->eksemplar_buku == NULL){
                        $value->eksemplar_buku = 0;
                      }
                    ?>
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Eksemplar</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $value->eksemplar_buku ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="fas fa-swatchbook"></i>
                      </div>
                    </div>
                  </div>
                  <?php foreach ($jml_eksemplar_perbulan as $value){
                    if($value->eksemplar_buku == NULL){
                      $value->eksemplar_buku = 0;
                    }
                  ?>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $value->eksemplar_buku ?></span>
                    <span class="text-nowrap">Penambahan bulan ini</span>
                  </p>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Peminjaman</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jml_peminjaman ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
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
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <?php foreach ($jml_denda as $value): ?>
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pemasukan Denda</h5>
                      <span class="h2 font-weight-bold mb-0"><?= "Rp ".number_format($value->denda,0,',','.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="fas fa-donate"></i>
                      </div>
                    </div>
                  </div>
                  <?php foreach ($jml_belum_bayar as $value): ?>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><?= "Rp ".number_format($value->denda,0,',','.'); ?></span>
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
                  <h6 class="text-light text-uppercase ls-1 mb-1">Grafik Peminjaman</h6>
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Grafik Pengunjung</h6>
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
      <div class="row">
        <div class="col-xl-4">
          <!-- Progress track -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Grafik Pengunjung</h6>
                  <h5 class="h4 mb-0">Per Jurusan</h5>
                </div>
              </div>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-pengunjung-jurusan" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <!-- Members list group card -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Data Anggota</h6>
                  <h5 class="h4 mb-0">Per Gender</h5>
                </div>
              </div>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-gender" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <!-- Checklist -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Data Anggota</h6>
                  <h5 class="h4 mb-0">Per Jurusan</h5>
                </div>
              </div>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-jurusan" class="chart-canvas"></canvas>
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
var pengunjung_jurusan = document.getElementById("chart-pengunjung-jurusan").getContext('2d');
var gender = document.getElementById("chart-gender").getContext('2d');
var jurusan = document.getElementById("chart-jurusan").getContext('2d');

//Chart Peminjaman
var chartPeminjaman = new Chart(peminjaman, {
  type: 'bar',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
    datasets: [{
      label: 'Peminjaman bulan ini',
      data: [
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('1')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('2')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('3')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('4')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('5')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('6')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('7')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('8')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('9')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('10')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('11')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_peminjaman_perbulan = $db->table('data_peminjaman')->selectCount('id_peminjaman')->where(['MONTH(tanggal_pinjam)' => date('12')])->where(['YEAR(tanggal_pinjam)' => date('Y')])->countAllResults(); ?>
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
      label: 'Pengunjung bulan ini',
      data: [
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('1')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('2')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('3')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('4')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('5')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('6')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('7')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('8')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('9')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('10')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('11')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
        <?php echo $query_kunjungan_perbulan = $db->table('data_pengunjung')->selectCount('no')->where(['MONTH(tanggal_kunjungan)' => date('12')])->where(['YEAR(tanggal_kunjungan)' => date('Y')])->countAllResults(); ?>,
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

//Chart Pengunjung per Jurusan
var chartJurusan = new Chart(pengunjung_jurusan, {
  type: 'bar',
  data: {
    labels: ["DPIB", "TITL", "TPM", "TLAS", "TKRO", "TAV", "ELIND", "TKJ", "TB"],
    datasets: [{
      label: 'Jumlah pengunjung',
      data: [
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Desain Pemodelan dan Informasi Bangunan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Instalasi Tenaga Listrik'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Pemesinan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Pengelasan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Kendaraan Ringan Otomotif'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Audio Video'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Elektronika Industri'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Komputer dan Jaringan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_pengunjung')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Tata Busana'])->countAllResults(); ?>,
      ],
      backgroundColor: 'rgba(62, 26, 244, 0.54)',
      borderColor: 'rgba(62, 26, 244, 1)',
      borderWidth: 2,
    }]
  }
});

//Chart Gender
var chartGender = new Chart(gender, {
  type: 'doughnut',
  data: {
    labels: ["Laki-laki", "Perempuan"],
    datasets: [{
      label: 'Jumlah anggota',
      data: [
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jkel_anggota' => 'Laki-laki'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jkel_anggota' => 'Perempuan'])->countAllResults(); ?>
      ],
      backgroundColor: ['rgba(54, 162, 235, 0.2)','rgba(219, 57, 122, 0.42)'],
      borderColor: ['rgba(54, 162, 235, 1)','rgba(219, 57, 122, 1)'],
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
  },
});

//Chart Jurusan
var chartJurusan = new Chart(jurusan, {
  type: 'bar',
  data: {
    labels: ["DPIB", "TITL", "TPM", "TLAS", "TKRO", "TAV", "ELIND", "TKJ", "TB"],
    datasets: [{
      label: 'Jumlah anggota',
      data: [
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Desain Pemodelan dan Informasi Bangunan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Instalasi Tenaga Listrik'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Pemesinan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Pengelasan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Kendaraan Ringan Otomotif'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Audio Video'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Elektronika Industri'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Teknik Komputer dan Jaringan'])->countAllResults(); ?>,
        <?php echo $jml_gender = $db->table('data_anggota')->selectCount('no_anggota')->where(['jurusan_anggota' => 'Tata Busana'])->countAllResults(); ?>,
      ],
      backgroundColor: 'rgba(224, 120, 46, 0.54)',
      borderColor: 'rgba(224, 120, 46, 1)',
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
