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
<body>
  <!-- Sidenav -->
  <?php include("_partials/sidebar.php") ?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <?php include("_partials/topnav.php") ?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Peminjaman</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url('/petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('/petugas/datapeminjaman_petugas')?>">Data Peminjaman</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_form" onclick="id_otomatis()"><i class="fas fa-plus"></i> Tambah</button>
              <button class="btn btn-sm btn-secondary"><i class="fas fa-print"></i> Cetak</button>
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
              <h3 class="mb-0"><i class="fas fa-angle-double-up"></i> Data Peminjaman</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>No. Peminjaman</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tgl. Kembali</th>
                    <th>ID Buku</th>
                    <th>Jml. Buku</th>
                    <th>ID Anggota</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>No. Peminjaman</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tgl. Kembali</th>
                    <th>ID Buku</th>
                    <th>Jml. Buku</th>
                    <th>ID Anggota</th>
                    <th>Status</th>
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
      "url": "<?php echo base_url('Petugas/DataPeminjaman_Petugas/ajax_list')?>",
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

function cari_buku(buku)
{
  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/cari_buku')?>/" + buku,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      if(data[0]){
        Swal.fire({
          title: 'Ditemukan',
          text: "Data buku ditemukan!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
        $('#jml').val(data[0].eksemplar_buku);
        $('#btnSave').attr('disabled',false);
      }
      if(!data[0]){
        Swal.fire({
          title: 'Tidak Ditemukan',
          text: "Data buku tidak ditemukan!",
          type: 'error',
          confirmButtonColor: '#5e72e4'
        });
        $('#buku').val(null);
        $('#btnSave').attr('disabled',true);
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      Swal.fire({
        title: 'Error',
        text: "Masukkan nomor induk dulu!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
    }
  });
}

function cari_anggota(anggota)
{
  //Ajax Load data from ajax
  $.ajax({
    url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/cari_anggota')?>/" + anggota,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      if(data[0]){
        Swal.fire({
          title: 'Ditemukan',
          text: "Anggota ditemukan!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
      }
      if(!data[0]){
        Swal.fire({
          title: 'Tidak Ditemukan',
          text: "Anggota tidak ditemukan!",
          type: 'error',
          confirmButtonColor: '#5e72e4'
        });
        $('#anggota').val(null);
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      Swal.fire({
        title: 'Error',
        text: "Masukkan nomor anggota dulu!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
    }
  });
}

function reload_table()
{
  table.ajax.reload(null,false); //reload datatable ajax
}

function id_otomatis(){
  $.ajax({
    url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/id_otomatis')?>",
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {
      $('[name="no"]').val(data);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Gagal Mendapatkan Kode');
    }
  });
}

function simpan_tambah(){
  $('#btnSave').text('Menyimpan...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable

  $.ajax({
    url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/ajax_add')?>",
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {

      if(data.status) //if success close modal and reload ajax table
      {
        $('#modal_form').modal('hide');
        $('#buku').val(null);
        $('#anggota').val(null);
        $('#jml').val(null);
        reload_table();
        Swal.fire({
          title: 'Berhasil',
          text: "Berhasil melakukan peminjaman!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
      }
      $('#btnSave').text('Simpan'); //change button text

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      Swal.fire({
        title: 'Gagal',
        text: "Gagal melakukan peminjaman!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable

    }
  });
}

function konfirmasi_pinjam(id)
{
  Swal.fire({
    title: 'Yakin konfirmasi peminjaman?',
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
          url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/ajax_confirm')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            //if success reload ajax table
            Swal.fire({
              title: 'Berhasil',
              text: "Konfirmasi peminjaman berhasil!",
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
              text: "Konfirmasi peminjaman gagal!",
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

function dikembalikan(id, induk)
{
  Swal.fire({
    title: 'Yakin konfirmasi pengembalian?',
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
          url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/ajax_kembali')?>/"+id+"/"+induk,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            //if success reload ajax table
            Swal.fire({
              title: 'Berhasil',
              text: "Konfirmasi pengembalian berhasil!",
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
              text: "Konfirmasi pengembalian gagal!",
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

function hapus_peminjaman(id, induk)
{
  Swal.fire({
    title: 'Yakin hapus data peminjaman?',
    text: "Data yang dihapus tidak dapat dikembalikan!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#5e72e4',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    preConfirm: function(){
      return new Promise(function(resolve){
        $.ajax({
          url : "<?php echo site_url('Petugas/DataPeminjaman_Petugas/ajax_delete')?>/"+id+"/"+induk,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            //if success reload ajax table
            Swal.fire({
              title: 'Berhasil',
              text: "Berhasil hapus data peminjaman!",
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
              text: "Gagal hapus data peminjaman!",
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

</script>
<!--MODAL ADD-->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-default">Form Peminjaman</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#form')[0].reset()">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
        <form id="form" action="#">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="no" class="form-control-label">No. Peminjaman</label>
                <input class="form-control" type="text" name="no" placeholder="Nomor Peminjaman" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="pinjam" class="form-control-label">Tgl. Pinjam</label>
                <input class="form-control" type="date" name="pinjam" id="pinjam" value="<?= date("Y-m-d"); ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="kembali" class="form-control-label">Tgl. Kembali</label>
                <input class="form-control" type="date" name="kembali" id="kembali" value="<?= date("Y-m-d", strtotime("+3 days")); ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="buku" class="form-control-label">No. Induk Buku</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="No. Induk" id="buku" name="buku">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="scan_buku" data-toggle="modal" data-target="#modal_qr" onclick="start_scan_buku()"><i class="fas fa-qrcode"></i></button>
                    <button class="btn btn-primary" type="button" id="cari" onclick="cari_buku(document.getElementById('buku').value)"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="anggota" class="form-control-label">No. Induk Anggota</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="No. Anggota" id="anggota" name="anggota">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="scan_anggota" data-toggle="modal" data-target="#modal_qr" onclick="start_scan_anggota()"><i class="fas fa-qrcode"></i></button>
                    <button class="btn btn-primary" type="button" id="search_anggota" onclick="cari_anggota(document.getElementById('anggota').value)"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="jml" class="form-control-label">Jumlah Pinjam</label>
                <input class="form-control" type="number" name="jml" id="jml" min="1">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSave" onclick="simpan_tambah()" disabled>Simpan</button>
        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal" onclick="$('#form')[0].reset()">Batal</button>
      </div>
    </div>
  </div>
</div>
<!--End Of Modal Add-->
<?php include('_partials/modal_scan.php'); ?>
</html>
