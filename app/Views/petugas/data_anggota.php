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
              <h6 class="h2 text-white d-inline-block mb-0">Data Anggota</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dataanggota_petugas')?>">Data Anggota</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-secondary" onclick="tambah_anggota()"><i class="fas fa-plus"></i> Tambah</button>
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
              <h3 class="mb-0"><i class="fas fa-users"></i> Data Anggota</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>No. Anggota</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Agama</th>
                    <th>Jenis Kelamin</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>No. Anggota</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Agama</th>
                    <th>Jenis Kelamin</th>
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
        "url": "<?php echo base_url('Petugas/DataAnggota_Petugas/ajax_list')?>",
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

function tambah_anggota()
{
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Tambah Anggota'); // Set Title to Bootstrap modal title
  $('.induk').prop('readonly',false);
  $('#target').attr('src','../../assets/img/profile_pic/no-image.png');
}

function edit_anggota(NoAnggota)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('.induk').prop('readonly',true);

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Petugas/DataAnggota_Petugas/ajax_edit')?>/" + NoAnggota,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            $('[name="NoAnggota"]').val(data[0].no_anggota);
            $('[name="Nama"]').val(data[0].nama_anggota);
            $('[name="Tempat"]').val(data[0].tempat_lahir);
            $('[name="Tanggal"]').val(data[0].tanggal_lahir);
            $('[name="Alamat"]').val(data[0].alamat_anggota);
            $('[name="Agama"]').val(data[0].agama_anggota);
            $('[name="Jkel"]').val(data[0].jkel_anggota);
            $('#target').attr('src','../../assets/img/profile_pic/'+data[0].foto_anggota);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data Anggota'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function save()
{
  $('#btnSave').text('Menyimpan...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable
  var url;

  if(save_method == 'add') {
    url = "<?php echo site_url('Petugas/DataAnggota_Petugas/ajax_add')?>";
  } else {
    url = "<?php echo site_url('Petugas/DataAnggota_Petugas/ajax_update')?>";
  }

  // ajax adding data to database
  var form = new FormData(document.getElementById('form'));
  $.ajax({
    url: url,
    type:"POST",
    enctype: 'multipart/form-data',
    data: form,
    contentType: false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data)
    {

      if(data.status) //if success close modal and reload ajax table
      {
        $('#modal_form').modal('hide');
        reload_table();
      }

      if (url = "<?php echo site_url('Petugas/DataAnggota_Petugas/ajax_add')?>"){
        Swal.fire({
          title: 'Berhasil',
          text: "Data anggota berhasil ditambahkan!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
      }else if(url = "<?php echo site_url('Petugas/DataAnggota_Petugas/ajax_update')?>"){
        Swal.fire({
          title: 'Berhasil',
          text: "Data anggota berhasil diupdate!",
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
        text: "Gagal update / tambah anggota!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable

    }
  });
}

function hapus_anggota(NoAnggota)
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
          url : "<?php echo site_url('Petugas/DataAnggota_Petugas/ajax_delete')?>/"+NoAnggota,
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

function showImage(src, target) {
  var fr = new FileReader();

  fr.onload = function(){
    target.src = fr.result;
  }
  fr.readAsDataURL(src.files[0]);
}

function putImage() {
  var src = document.getElementById("file");
  var target = document.getElementById("target");
  showImage(src, target);
}
</script>

<!--MODAL-->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
    <div class="modal-content">
    <form id="form" action="#" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-default">Form Anggota</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="induk" class="form-control-label">Nomor Anggota</label>
                <input class="form-control induk" type="text" name="NoAnggota" placeholder="Nomor Anggota">
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="nama" class="form-control-label">Nama Anggota</label>
                <input class="form-control" type="text" name="Nama" placeholder="Nama Anggota">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="tempat" class="form-control-label">Tempat Lahir</label>
                <input class="form-control" type="text" name="Tempat" placeholder="Tempat Lahir">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tanggal" class="form-control-label">Tanggal Lahir</label>
                <input class="form-control" type="date" name="Tanggal" placeholder="Tanggal Lahir">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="alamat" class="form-control-label">Alamat</label>
                <input class="form-control" type="text" name="Alamat" placeholder="Alamat">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="agama" class="form-control-label">Agama</label>
                <select name="Agama" class="form-control">
                  <option value="">--Pilih Agama--</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen Protestan">Kristen Protestan</option>
                  <option value="Katolik">Katolik</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Buddha">Buddha</option>
                  <option value="Konghucu">Konghucu</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="jkel" class="form-control-label">Jenis Kelamin</label>
                <select name="Jkel" class="form-control">
                  <option value="">--Jenis Kelamin--</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="file" class="form-control-label">Foto</label>
                <input type="file" class="form-control" name="file" id="file" onchange="putImage()">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
              <div class="form-group" align="center">
                <img id="target" class="rounded-circle" height="150px" width="150px">
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer" style="padding-top: 0px;">
        <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Simpan</button>
        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!--End Of Modal-->
</html>
