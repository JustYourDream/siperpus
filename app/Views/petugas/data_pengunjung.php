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
              <h6 class="h2 text-white d-inline-block mb-0">Pengunjung</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url('/petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('/petugas/datapengunjung_petugas')?>">Data Pengunjung</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="<?= base_url('/petugas/form_kunjungan'); ?>" class="btn btn-sm btn-secondary" target="_blank"><i class="fas fa-address-book"></i> Form Kunjungan</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-3" style="width: 100%;">
            <div class="card-header">
              <div class="row">
                <div class="col-sm-6 col-7">
                  <h3 class="mb-0"><i class="fas fa-file-alt"></i> Cetak Data Pengunjung</h3>
                </div>
                <div class="col-sm-6 col-5 text-right">
                  <button class="btn btn-secondary btn-sm" data-toggle="collapse" href="#showPrint" role="button" aria-expanded="false" aria-controls="showPrint"><i id="iconCollapse" class="fas fa-chevron-down"></i></button>
                </div>
              </div>
            </div>
            <div class="card-body mb-0 pt-1 pb-0 collapse" id="showPrint">
              <form action="<?php echo base_url('Petugas/DataPengunjung_Petugas/cetak_data')?>" method="POST" target="_blank">
                <div class="row">
                  <div class="col-xl-12">
                    <?php if(!empty(session()->getFlashdata('error'))) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo session()->getFlashdata('error'); ?>
                      </div>
            				<?php endif; ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label for="jurusan" class="form-control-label">Jurusan</label>
                      <select name="Jurusan" class="form-control">
                        <option value="">--Pilih Jurusan--</option>
                        <?php
                          foreach ($form_jurusan as $jurusan) {
                            echo "<option value='".$jurusan."'>".$jurusan."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
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
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="year" class="form-control-label">Tahun</label>
                      <select name="Tahun" class="form-control">
                        <option value="">--Pilih Tahun--</option>
                        <?php
                          foreach ($form_tahun as $tahun) {
                            echo "<option value='".$tahun."'>".$tahun."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary btn-block" id="cetakPenambahan"><i class="fas fa-print"></i> Cetak</button>
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
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-street-view"></i> Data Pengunjung</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>No. Anggota</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Tanggal Kunjungan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>No. Anggota</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Tanggal Kunjungan</th>
                  </tr>
                </tfoot>
                <tbody>
                </tbody>
              </table>
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
<script type="text/javascript">
var table;
var currdate = new Date();
$(document).ready( function () {
  table = $('#myTable').DataTable({
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?php echo base_url('Petugas/DataPengunjung_Petugas/ajax_list')?>",
      "type": "POST"
    },
    //optional
    "lengthMenu": [[5, 10, 25], [5, 10, 25]],
    "language": {
      "paginate": {
        "previous" : "<i class='fas fa-angle-left'>",
        "next" : "<i class='fas fa-angle-right'>"
      },
    },
    "columnDefs": [
      {
        "targets": [],
        "orderable": false,
      },
    ],
  });

  $('#showPrint').on('hidden.bs.collapse', function(){
    $('#iconCollapse').addClass('fa-chevron-down').removeClass('fa-chevron-up');
  });
  $('#showPrint').on('shown.bs.collapse', function(){
    $('#iconCollapse').addClass('fa-chevron-up').removeClass('fa-chevron-down');
  });
});
</script>
</html>
