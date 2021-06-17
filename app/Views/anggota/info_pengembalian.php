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
              <h6 class="h2 text-white d-inline-block mb-0">Pengembalian</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url('/anggota/dashboard_anggota')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('/anggota/info_pengembalian')?>">Info Pengembalian</a></li>
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
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-info-circle"></i> Info Pengembalian</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>No. Peminjaman</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tgl. Kembali</th>
                    <th>No. Anggota</th>
                    <th>Dikembalikan</th>
                    <th>Denda</th>
                    <th>Status Denda</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>No. Peminjaman</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tgl. Kembali</th>
                    <th>No. Anggota</th>
                    <th>Dikembalikan</th>
                    <th>Denda</th>
                    <th>Status Denda</th>
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
      "url": "<?php echo base_url('Anggota/Info_Pengembalian/ajax_list')?>",
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
});

function reload_table()
{
  table.ajax.reload(null,false); //reload datatable ajax
}

</script>
</html>
