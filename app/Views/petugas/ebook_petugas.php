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
              <h6 class="h2 text-white d-inline-block mb-0">Data E-book</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/ebook_petugas')?>">Data E-book</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_form" onclick="tambah_ebook()"><i class="fas fa-plus"></i> Tambah</button>
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
              <h3 class="mb-0"><i class="fas fa-book-open"></i> Data E-book</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>NO</th>
                    <th>ID E-book</th>
                    <th>Sampul</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Kategori</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>ID E-book</th>
                    <th>Sampul</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
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
<script>
var save_method;
var table;
$(document).ready( function () {
  table = $('#myTable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        "url": "<?php echo base_url('Petugas/Ebook_Petugas/ajax_list')?>",
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

function tambah_ebook()
{
  $.ajax({
    url : "<?php echo site_url('Petugas/Ebook_Petugas/id_otomatis')?>",
    type: "POST",
    data: $('#form').serialize(),
    dataType: "JSON",
    success: function(data)
    {
      $('[name="NoEbook"]').val(data);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Gagal Mendapatkan Kode');
    }
  });
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Tambah E-book'); // Set Title to Bootstrap modal title
  $('#target').attr('src','../../assets/eBook/Cover/Default-Cover.png');
}

function edit_ebook(NoEbook)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Petugas/Ebook_Petugas/ajax_edit')?>/" + NoEbook,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            $('[name="NoEbook"]').val(data[0].id_ebook);
            $('[name="Judul"]').val(data[0].judul_ebook);
            $('[name="Pengarang"]').val(data[0].pengarang);
            $('[name="Penerbit"]').val(data[0].penerbit);
            $('[name="Kategori"]').val(data[0].kategori_ebook);
            $('#target').attr('src','../../assets/eBook/Cover/'+data[0].cover_ebook);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data E-book'); // Set title to Bootstrap modal title

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
    url = "<?php echo site_url('Petugas/Ebook_Petugas/ajax_add')?>";
  } else if(save_method == 'update'){
    url = "<?php echo site_url('Petugas/Ebook_Petugas/ajax_update')?>";
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

      if (url == "<?php echo site_url('Petugas/Ebook_Petugas/ajax_add')?>"){
        Swal.fire({
          title: 'Berhasil',
          text: "E-book berhasil ditambahkan!",
          type: 'success',
          confirmButtonColor: '#5e72e4'
        });
      }else if(url == "<?php echo site_url('Petugas/Ebook_Petugas/ajax_update')?>"){
        Swal.fire({
          title: 'Berhasil',
          text: "Data E-book berhasil diupdate!",
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
        text: "Gagal update / tambah E-book!",
        type: 'error',
        confirmButtonColor: '#5e72e4'
      });
      $('#btnSave').text('Simpan'); //change button text
      $('#btnSave').attr('disabled',false); //set button enable

    }
  });
}

function hapus_ebook(NoEbook)
{
  Swal.fire({
    title: 'Yakin hapus E-book ini??',
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
          url : "<?php echo site_url('Petugas/Ebook_Petugas/ajax_delete')?>/"+NoEbook,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
            //if success reload ajax table
            Swal.fire({
              title: 'Berhasil',
              text: "E-book berhasil dihapus!",
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
              text: "E-book gagal dihapus!",
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
  var src = document.getElementById("sampul");
  var target = document.getElementById("target");
  showImage(src, target);
}
</script>
</html>

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
                <label for="induk" class="form-control-label">Nomor E-book</label>
                <input class="form-control induk" type="text" name="NoEbook" placeholder="Nomor E-book" readonly>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="judul" class="form-control-label">Judul Buku</label>
                <input class="form-control" type="text" name="Judul" placeholder="Judul">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="pengarang" class="form-control-label">Pengarang</label>
                <input class="form-control" type="text" name="Pengarang" placeholder="Pengarang">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="penerbit" class="form-control-label">Penerbit</label>
                <input class="form-control" type="text" name="Penerbit" placeholder="Penerbit">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="kategori" class="form-control-label">Kategori</label>
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
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="file" class="form-control-label">File E-book</label>
                <input type="file" class="form-control" name="ebook" id="ebook">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="file" class="form-control-label">Sampul E-book <font color="red"><i>(File sampul maks. 4Mb)</i></font></label>
                <input type="file" class="form-control" name="sampul" id="sampul" onchange="putImage()">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
              <div class="form-group" align="center">
                <img id="target" class="rounded" height="200px" width="174px">
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
