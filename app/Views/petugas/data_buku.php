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
              <h6 class="h2 text-white d-inline-block mb-0">Data Buku</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/databuku_petugas')?>">Data Buku</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-secondary" onclick="tambah_buku()"><i class="fas fa-plus"></i> Tambah</button>
              <a href="#" class="btn btn-sm btn-secondary"><i class="fas fa-print"></i> Cetak</a>
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
              <h3 class="mb-0"><i class="fas fa-book"></i> Data Buku</h3>
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
                    <th>QR Code</th>
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
                    <th>QR Code</th>
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
        "url": "<?php echo base_url('Petugas/DataBuku_Petugas/ajax_list')?>",
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
function edit_buku(NoInduk)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('.induk').prop('readonly',true);

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Petugas/DataBuku_Petugas/ajax_edit')?>/" + NoInduk,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            $('[name="NoInduk"]').val(data[0].no_induk);
            $('[name="Isbn"]').val(data[0].isbn);
            $('[name="Judul"]').val(data[0].judul_buku);
            $('[name="Pengarang"]').val(data[0].pengarang_buku);
            $('[name="KotaTerbit"]').val(data[0].kota_dibuat);
            $('[name="Penerbit"]').val(data[0].penerbit_buku);
            $('[name="TahunTerbit"]').val(data[0].tahun_buku);
            $('[name="Eksemplar"]').val(data[0].eksemplar_buku);
            $('[name="Rak"]').val(data[0].no_rak);
            $('[name="Kategori"]').val(data[0].kategori_buku);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Buku'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function tambah_buku()
{
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Tambah Buku'); // Set Title to Bootstrap modal title
  $('.induk').prop('readonly',false);
}

function reload_table()
{
  table.ajax.reload(null,false); //reload datatable ajax
}

function save()
{
  $('#btnSave').text('Menyimpan...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable
  var url;

  if(save_method == 'add') {
    url = "<?php echo site_url('Petugas/DataBuku_Petugas/ajax_add')?>";
  } else {
    url = "<?php echo site_url('Petugas/DataBuku_Petugas/ajax_update')?>";
  }

  // ajax adding data to database
  $.ajax({
    url : url,
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {

      if(data.status) //if success close modal and reload ajax table
      {
        $('#modal_form').modal('hide');
        reload_table();
      }

      if (url == "<?php echo site_url('Petugas/DataBuku_Petugas/ajax_add')?>"){
        Swal.fire({
          title: 'Berhasil',
          text: "Data buku berhasil ditambahkan!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
      }else if(url == "<?php echo site_url('Petugas/DataBuku_Petugas/ajax_update')?>"){
        Swal.fire({
          title: 'Berhasil',
          text: "Data buku berhasil diupdate!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
      }
      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable


    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      Swal.fire({
        title: 'Gagal',
        text: "Gagal update / tambah data buku!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable

    }
  });
}
function hapus_buku(NoInduk)
{
  Swal.fire({
    title: 'Yakin hapus data ini??',
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
          url : "<?php echo site_url('Petugas/DataBuku_Petugas/ajax_delete')?>/"+NoInduk,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            //if success reload ajax table
            Swal.fire({
              title: 'Berhasil',
              text: "Data berhasil dihapus!",
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
              text: "Data gagal dihapus!",
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
<!--MODAL-->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-default">Form Buku</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
        <form id="form" action="#">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="induk" class="form-control-label">Nomor Induk</label>
                <input class="form-control induk" type="text" name="NoInduk" placeholder="Nomor Induk">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="isbn" class="form-control-label">ISBN</label>
                <input class="form-control" type="text" name="Isbn" placeholder="Nomor ISBN">
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="judul" class="form-control-label">Judul</label>
                <input class="form-control" type="text" name="Judul" placeholder="Judul Buku">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="pengarang" class="form-control-label">Pengarang</label>
                <input class="form-control" type="text" name="Pengarang" placeholder="Nama Pengarang">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="kota" class="form-control-label">Kota Penerbitan</label>
                <input class="form-control" type="text" name="KotaTerbit" placeholder="Kota Penerbitan Buku">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="penerbit" class="form-control-label">Penerbit</label>
                <input class="form-control" type="text" name="Penerbit" placeholder="Nama Penerbit">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="tahun_terbit" class="form-control-label">Tahun Terbit</label>
                <input class="form-control" type="text" name="TahunTerbit" placeholder="Tahun Terbit Buku">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="eksmplar" class="form-control-label">Jml. Eksemplar</label>
                <input class="form-control" type="text" name="Eksemplar" placeholder="Jumlah Eksemplar">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="rak" class="form-control-label">No. Rak</label>
                <input class="form-control" type="text" name="Rak" placeholder="Nomor Rak Buku">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="cat" class="form-control-label">Kategori Buku</label>
                <select name="Kategori" class="form-control">
                  <option value="">--Pilih Kategori--</option>
                  <option value="Karya Umum">Karya Umum</option>
                  <option value="Filsafat Psikologi">Filsafat Psikologi</option>
                  <option value="Agama">Agama</option>
                  <option value="Ilmu Sosial">Ilmu Sosial</option>
                  <option value="Bahasa">Bahasa</option>
                  <option value="Ilmu-ilmu & Matematika">Ilmu-ilmu & Matematika</option>
                  <option value="Teknologi & Ilmu Terapan">Teknologi & Ilmu Terapan</option>
                  <option value="Kesenian, Hiburan & Olahraga">Kesenian, Hiburan & Olahraga</option>
                  <option value="Kesusastraan">Kesusastraan</option>
                  <option value="Sejarah Geografi">Sejarah Geografi</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Simpan</button>
        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!--End Of Modal-->
</html>
