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
              <h6 class="h2 text-white d-inline-block mb-0">Laporan</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/laporan_petugas')?>">Pembuatan Laporan</a></li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-sticky-note"></i> Rekap Penambahan Bulanan</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('Petugas/Laporan_Petugas/penambahan_bulanan')?>" id="penambahan_bulanan" method="POST" target="_blank">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="month" class="form-control-label">Bulan</label>
                      <select name="Bulan" class="form-control">
                        <option value="">--Pilih Bulan--</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="year" class="form-control-label">Tahun</label>
                      <input class="form-control" placeholder="Tahun" type="text" name="year" maxlength="4">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary" id="cetakPenambahan"><i class="fas fa-print"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-sticky-note"></i> Rekap Peminjaman Bulanan</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('Petugas/Laporan_Petugas/peminjaman_bulanan')?>" id="peminjaman_bulanan" method="POST" target="_blank">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="monthRent" class="form-control-label">Bulan</label>
                      <select name="monthRent" class="form-control">
                        <option value="">--Pilih Bulan--</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="yearRent" class="form-control-label">Tahun</label>
                      <input class="form-control" placeholder="Tahun" type="text" name="yearRent" maxlength="4">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary" id="cetakPeminjaman"><i class="fas fa-print"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-copy"></i> Rekap Keseluruhan Bulanan</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('Petugas/Laporan_Petugas/keseluruhan_bulanan')?>" id="keseluruhan_bulanan" method="POST" target="_blank">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="month" class="form-control-label">Bulan</label>
                      <select name="monthAll" class="form-control">
                        <option value="">--Pilih Bulan--</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="year" class="form-control-label">Tahun</label>
                      <input class="form-control" placeholder="Tahun" type="text" name="years" maxlength="4">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary" id="cetakKeseluruhan"><i class="fas fa-print"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-copy"></i> Rekap Keseluruhan Tahunan</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('Petugas/Laporan_Petugas/keseluruhan_tahunan')?>" id="keseluruhan_tahunan" method="POST" target="_blank">
                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="year" class="form-control-label">Tahun</label>
                      <input class="form-control" placeholder="Tahun" type="text" name="yearAll" maxlength="4">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary" id="cetakKeseluruhan"><i class="fas fa-print"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-copy"></i> Rekap Denda Tahunan</h3>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('Petugas/Laporan_Petugas/denda_tahunan')?>" id="denda_tahunan" method="POST" target="_blank">
                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="year" class="form-control-label">Tahun</label>
                      <input class="form-control" placeholder="Tahun" type="text" name="yearAll" maxlength="4">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary" id="cetakKeseluruhan"><i class="fas fa-print"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
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
</html>
