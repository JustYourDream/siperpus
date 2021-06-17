<!DOCTYPE html>
<html>
<?php include("_partials/head.php") ?>
<style>
  .input-group-merge .form-control:not(:first-child){
     padding-left: 8px;
  }
</style>
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
              <h6 class="h2 text-white d-inline-block mb-0">Pengaturan Akun</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/dashboard_petugas')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('petugas/akun_petugas')?>">Pengaturan Akun</a></li>
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
        <div class="col-xl-12">
          <?php if(!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?php echo session()->getFlashdata('error'); ?>
            </div>
          <?php elseif(!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo session()->getFlashdata('success'); ?>
            </div>
  				<?php endif; ?>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-user-cog"></i> Pengaturan Akun</h3>
            </div>
              <div class="card-body">
                <!-- Input groups with icon -->
                <div class="row" style="padding-bottom: 30px;">
                  <div class="col-md-2">
                    <img alt="Image placeholder" id="profil" class="img-fluid rounded-circle">
                  </div>
                  <div class="col-md-2" style="padding-top: 20px;">
                    <div class="row" style="padding-bottom: 10px;">
                      <button class="btn btn-block btn-default" data-toggle="modal" data-target="#modal_foto">Ubah Foto</button>
                    </div>
                    <div class="row">
                      <a class="btn btn-block btn-danger" href="<?php echo base_url('Petugas/Akun_Petugas/hapus_foto')?>">Hapus Foto</a>
                    </div>
                  </div>
                </div>
              <form action="#" id="form">
                <style>
                  .rounded-right{
                      border-top-right-radius: .25rem !important;
                      border-bottom-right-radius: .25rem !important;
                  }
                </style>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="no" class="form-control-label">Nomor Identitas</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input class="form-control" placeholder="Nomor Identitas" type="text" name="id" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama" class="form-control-label">Nama</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input class="form-control rounded-right" placeholder="Nama Lengkap" type="text" name="nama">
                        <span class="invalid-feedback"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="jabatan" class="form-control-label">Jabatan</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input class="form-control rounded-right" placeholder="Jabatan Pekerjaan" type="text" name="role">
                        <span class="invalid-feedback"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="telp" class="form-control-label">Nomor Telepon</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input class="form-control rounded-right" placeholder="Nomor Telepon" type="text" name="telp">
                        <span class="invalid-feedback"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alamat" class="form-control-label">Alamat</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input class="form-control rounded-right" placeholder="Alamat Rumah" type="text" name="address">
                        <span class="invalid-feedback"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="simpan" class="form-control-label">&nbsp;</label>
                      <div class="input-group input-group-merge">
                        <button class="btn btn-primary btn-block" id="btnSave" onclick="simpan_perubahan()">Simpan Perubahan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-9">
                  <h3 class="mb-0">Ubah Password</h3>
                  <p class="text-sm mb-0">
                    Ubah password untuk proteksi yang kuat.
                  </p>
                </div>
                <div class="col-md-3" align="right">
                  <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-default">Ubah Password</button>
                </div>
              </div>
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
  $(document).ready(function(){
    $.ajax({
        url : "<?php echo site_url('Petugas/Akun_Petugas/showdata')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            $('[name="id"]').val(data[0].id_petugas);
            $('[name="nama"]').val(data[0].nama_petugas);
            $('[name="role"]').val(data[0].jabatan_petugas);
            $('[name="telp"]').val(data[0].no_telp_petugas);
            $('[name="address"]').val(data[0].alamat_petugas);
            $('#profil').attr('src','../../assets/img/profile_pic/'+data[0].foto_petugas);
            $('#target').attr('src','../../assets/img/profile_pic/'+data[0].foto_petugas);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    $('#new_pw, #verif_pw').on('keyup', function(){
      if($('#new_pw').val() == $('#verif_pw').val() && $('#new_pw').val() != ''){
        $('#save_pw').attr('disabled', false);
        $('#verif_pw').removeClass('is-invalid');
        $('#verif_pw').addClass('is-valid');
        $('#pw_feedback').removeClass('invalid-feedback');
        $('#pw_feedback').addClass('valid-feedback');
        $('#pw_feedback').text('Password Cocok');
      }else{
        $('#save_pw').attr('disabled', true);
        $('#verif_pw').removeClass('is-valid');
        $('#verif_pw').addClass('is-invalid');
        $('#pw_feedback').removeClass('valid-feedback');
        $('#pw_feedback').addClass('invalid-feedback');
        $('#pw_feedback').text('Password Tidak Cocok');
      }
    });
  });

  function simpan_perubahan(){
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    // ajax update data to database
    $.ajax({
      url : "<?php echo site_url('Petugas/Akun_Petugas/update_akun')?>",
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data)
      {
        if(data.status) //if success close modal and reload ajax table
        {
          $('#btnSave').text('Simpan Perubahan'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          $('#account').load("http://siperpus.amga/petugas/akun_petugas #account"); //Reload topnav
          Swal.fire({
            title: 'Berhasil',
            text: "Data berhasil diupdate!",
            type: 'success',
            confirmButtonColor: '#5e72e4'
          });
          $('.form-control').removeClass('is-invalid');
          $('.form-group').removeClass('has-danger');
          $('.invalid-feedback').text('');
        }else{
          for (var i = 0; i < data.inputerror.length; i++)
          {
            $('[name="'+data.error_string[i]+'"]').addClass('is-invalid');
            $('[name="'+data.error_string[i]+'"]').parent().parent().addClass('has-danger'); //select parent twice to select div form-group class and add has-error class
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
          text: "Data gagal diupdate!",
          type: 'error',
          confirmButtonColor: '#5e72e4'
        });
        $('#btnSave').text('Simpan Perubahan'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable

      }
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

  function resetForm(){
    $('#form-modal')[0].reset();
    $('#save_pw').attr('disabled', true);
    $('#verif_pw').removeClass('is-valid');
    $('#verif_pw').removeClass('is-invalid');
    $('#pw_feedback').removeClass('invalid-feedback');
    $('#pw_feedback').removeClass('valid-feedback');
    $('#pw_feedback').text('');
  }
</script>
<!--MODAL-->
<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <form id="form-modal" action="<?php echo site_url('Petugas/Akun_Petugas/ganti_pass')?>" method="post">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Form Ubah Password</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetForm()">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
          <div class="form-group">
            <label for="old" class="form-control-label">Password Lama</label>
            <div class="input-group">
              <input class="form-control rounded-right" placeholder="Masukkan Password Lama" type="password" name="old">
            </div>
          </div>
          <div class="form-group">
            <label for="new" class="form-control-label">Password Baru</label>
            <div class="input-group">
              <input class="form-control rounded-right" placeholder="Masukkan Password Baru" type="password" name="new" id="new_pw">
            </div>
          </div>
          <div class="form-group">
            <label for="verif" class="form-control-label">Konfirmasi Password Baru</label>
            <div class="input-group">
              <input class="form-control rounded-right" placeholder="Masukkan Ulang Password Baru" type="password" name="verif" id="verif_pw">
              <span class="" id="pw_feedback"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="save_pw" disabled>Ubah Password</button>
          <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal" onclick="resetForm()">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--End Of Modal-->

<!-- Modal Ubah Foto -->
<div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-xs modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <form id="form_foto" action="<?php echo site_url('Petugas/Akun_Petugas/upload_foto')?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Upload Foto Profil Baru</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
          <div class="row" style="padding-bottom: 30px;">
            <div class="col-md-12" align="center">
              <img id="target" class="rounded-circle" height="200px" width="200px">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group input-group-merge">
                  <input class="form-control" type="file" name="file" id="file" onchange="putImage()">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal" onclick="reset_upload()">Batal</button>
        </div>
      <form>
    </div>
  </div>
</div>
<!-- END of Modal Ubah Foto -->
</html>
