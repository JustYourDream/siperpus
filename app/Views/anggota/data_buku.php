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
              <h6 class="h2 text-white d-inline-block mb-0">Buku</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('anggota/dashboard_anggota')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('anggota/pinjam_buku')?>">Pinjam Buku</a></li>
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
              <h3 class="mb-0"><i class="fas fa-book"></i> Pinjam Buku</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>No. Induk</th>
                    <th>ISBN</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kota Terbit</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Eksemplar</th>
                    <th>No. Rak</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>No. Induk</th>
                    <th>ISBN</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kota Terbit</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Eksemplar</th>
                    <th>No. Rak</th>
                    <th>Kategori</th>
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
var save_method;
var table;
$(document).ready( function () {
  table = $('#myTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        "url": "<?php echo base_url('Anggota/Pinjam_Buku/ajax_list')?>",
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

function pinjam_buku(NoInduk){
  $('#modal_form').modal('show');
  $.ajax({
    url : "<?php echo site_url('Anggota/Pinjam_Buku/id_otomatis')?>",
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

  $.ajax({
      url : "<?php echo site_url('Anggota/Pinjam_Buku/ajax_pinjam')?>/" + NoInduk,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
          console.log(data);
          $('[name="buku"]').val(data[0].no_induk);
          $('[name="jml"]').val(data[0].eksemplar_buku);

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
  });
}

function simpan_pinjam(){
  $('#btnSave').text('Menyimpan...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable

  $.ajax({
    url : "<?php echo site_url('Anggota/Pinjam_Buku/save_pinjam')?>",
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
          text: "Segera konfirmasi peminjaman ke petugas!",
          type: 'success',
          showCancelButton: true,
          cancelButtonText: 'Tutup',
          confirmButtonText: '<a href="/anggota/info_peminjaman" style="color: white;">Info Peminjaman</a>',
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

</script>
<!--MODAL-->
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
                <input type="text" class="form-control" placeholder="No. Induk" id="buku" name="buku" readonly>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="anggota" class="form-control-label">No. Induk Anggota</label>
                <input type="text" class="form-control" placeholder="No. Anggota" id="anggota" name="anggota" value="<?= session()->get('id'); ?>" readonly>
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
        <button type="button" class="btn btn-primary" id="btnSave" onclick="simpan_pinjam()">Pinjam</button>
        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal" onclick="$('#form')[0].reset()">Batal</button>
      </div>
    </div>
  </div>
</div>
<!--End Of Modal-->
</html>
