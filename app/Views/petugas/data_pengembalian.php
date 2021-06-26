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
                  <li class="breadcrumb-item"><a href="<?= base_url('/petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('/petugas/datapengembalian_petugas')?>">Data Pengembalian</a></li>
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
              <h3 class="mb-0"><i class="fas fa-angle-double-down"></i> Data Pengembalian</h3>
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
                    <th>Aksi</th>
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
                    <th>Aksi</th>
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
      "url": "<?php echo base_url('Petugas/DataPengembalian_Petugas/ajax_list')?>",
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

function konfirmasi_bayar(id)
{
  Swal.fire({
    title: 'Konfirmasi pembayaran denda?',
    text: "Pilihan yang dipilih tidak dapat dibatalkan!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#5e72e4',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Konfirmasi',
    cancelButtonText: 'Batal',
    preConfirm: function(){
      return new Promise(function(resolve){
        $.ajax({
          url : "<?php echo site_url('Petugas/DataPengembalian_Petugas/ajax_bayar')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            //if success reload ajax table
            Swal.fire({
              title: 'Berhasil',
              text: "Konfirmasi pembayaran denda berhasil!",
              type: 'success',
              confirmButtonColor: '#5e72e4'
            });
            $('#modal_form').modal('hide');
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            Swal.fire({
              title: 'Gagal',
              text: "Konfirmasi pembayaran denda gagal!",
              type: 'error',
              confirmButtonColor: '#5e72e4'
            });
          }
        });
      })
    },
    allowOutsideClick: false
  });
}

function showDetail(NoAnggota){
  $.ajax({
    url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/cari_anggota')?>/" + NoAnggota,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      var tgl_lahir = moment(data[0].tanggal_lahir).format('DD-MM-YYYY');
      $('.NoAggota').text(data[0].no_anggota);
      $('.Nama').text(data[0].nama_anggota);
      $('.Jurusan').text(data[0].jurusan_anggota);
      $('.Lahir').text(data[0].tempat_lahir+', '+tgl_lahir);
      $('.Jkel').text(data[0].jkel_anggota);
      $('.Alamat').text(data[0].alamat_anggota);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error get data!');
    }
  });
}
</script>
<!--MODAL Detail-->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-default">Detail Peminjam</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#form')[0].reset()">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table" cellpadding="5" cellspacing="10">
                <tr>
                  <td width="160px"><b>No. Anggota</b></td>
                  <td width="20px">:</td>
                  <td class="NoAggota">
                </tr>
                <tr>
                  <td><b>Nama</b></td>
                  <td>:</td>
                  <td class="Nama">
                </tr>
                <tr>
                  <td><b>Jurusan</b></td>
                  <td>:</td>
                  <td class="Jurusan">
                </tr>
                <tr>
                  <td><b>Tgl. Lahir</b></td>
                  <td>:</td>
                  <td class="Lahir">
                </tr>
                <tr>
                  <td><b>Jns. Kelamin</b></td>
                  <td>:</td>
                  <td class="Jkel">
                </tr>
                <tr>
                  <td><b>Alamat</b></td>
                  <td>:</td>
                  <td class="Alamat">
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<!--End Of Modal Detail-->
</html>
