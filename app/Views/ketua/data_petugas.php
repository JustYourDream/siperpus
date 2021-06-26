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
              <h6 class="h2 text-white d-inline-block mb-0">Data Petugas</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('ketua/dashboard_ketua')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('ketua/data_petugas')?>">Data Petugas</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-secondary" onclick="tambah_petugas()"><i class="fas fa-plus"></i> Tambah</button>
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
              <div class="row">
                <div class="col-sm-12 col-5">
                  <h3 class="mb-0"><i class="fas fa-user-shield"></i> Data Petugas</h3>
                </div>
              </div>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>ID Petugas</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>No. Telpon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>ID Petugas</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>No. Telpon</th>
                    <th>Alamat</th>
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
        "url": "<?php echo base_url('Ketua/Data_Petugas/ajax_list')?>",
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

function tambah_petugas()
{
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-control').removeClass('is-invalid');
  $('.invalid-feedback').text('');
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Tambah Petugas'); // Set Title to Bootstrap modal title
  $('.induk').prop('readonly',false);
  $('#target').attr('src','../../assets/img/profile_pic/no-image.png');
}

function edit_petugas(IdPetugas)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    $('.induk').prop('readonly',true);

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Ketua/Data_Petugas/ajax_edit')?>/" + IdPetugas,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            $('[name="IdPetugas"]').val(data[0].id_petugas);
            $('[name="Nama"]').val(data[0].nama_petugas);
            $('[name="Telp"]').val(data[0].no_telp_petugas);
            $('[name="Alamat"]').val(data[0].alamat_petugas);
            $('#target').attr('src','../../assets/img/profile_pic/'+data[0].foto_petugas);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data Petugas'); // Set title to Bootstrap modal title

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
    url = "<?php echo site_url('Ketua/Data_Petugas/ajax_add')?>";
  } else {
    url = "<?php echo site_url('Ketua/Data_Petugas/ajax_update')?>";
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

        if (url == "<?php echo site_url('Ketua/Data_Petugas/ajax_add')?>"){
          Swal.fire({
            title: 'Berhasil',
            text: "Data petugas berhasil ditambahkan!",
            type: 'success',
            confirmButtonColor: '#5e72e4'
          });
        }else if(url == "<?php echo site_url('Ketua/Data_Petugas/ajax_update')?>"){
          Swal.fire({
            title: 'Berhasil',
            text: "Data petugas berhasil diupdate!",
            type: 'success',
            confirmButtonColor: '#5e72e4'
          });
        }
      }else{
        for (var i = 0; i < data.inputerror.length; i++)
        {
          $('[name="'+data.error_string[i]+'"]').addClass('is-invalid'); //select parent twice to select div form-group class and add has-error class
          $('[name="'+data.error_string[i]+'"]').next().text(data.inputerror[i]); //select span help-block class set text error string
        }
      }

      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      Swal.fire({
        title: 'Gagal',
        text: "Gagal update / tambah petugas!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable

    }
  });
}

function hapus_petugas(IdPetugas)
{
  Swal.fire({
    title: 'Hapus data petugas ini?',
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
          url : "<?php echo site_url('Ketua/Data_Petugas/ajax_delete')?>/"+IdPetugas,
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
                <label for="induk" class="form-control-label">ID Petugas</label>
                <input class="form-control induk" type="text" name="IdPetugas" placeholder="ID Petugas">
                <span class="invalid-feedback"></span>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="nama" class="form-control-label">Nama Petugas</label>
                <input class="form-control" type="text" name="Nama" placeholder="Nama Petugas">
                <span class="invalid-feedback"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="telp" class="form-control-label">No. Telepon</label>
                <input class="form-control" type="text" name="Telp" placeholder="Nomor Telepon">
                <span class="invalid-feedback"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="alamat" class="form-control-label">Alamat</label>
                <input class="form-control" type="text" name="Alamat" placeholder="Alamat Petugas">
                <span class="invalid-feedback"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="file" class="form-control-label">Foto <font color="red"><i>(File foto maks. 4Mb)</i></font></label>
                <input type="file" class="form-control" name="file" id="file" onchange="putImage()">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              &nbsp;
            </div>
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
