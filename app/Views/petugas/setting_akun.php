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
    <div class="header bg-primary pb-6">
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
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-secondary"><i class="ni ni-paper-diploma"></i> Cetak</a>
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
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="no" class="form-control-label">Nomor Identitas</label>
                      <div class="input-group input-group-merge">
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
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input class="form-control" placeholder="Nama Lengkap" type="text" name="nama">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="jabatan" class="form-control-label">Jabatan</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input class="form-control" placeholder="Jabatan Pekerjaan" type="text" name="role">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="telp" class="form-control-label">Nomor Telepon</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input class="form-control" placeholder="Nomor Telepon" type="text" name="telp">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alamat" class="form-control-label">Alamat</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input class="form-control" placeholder="Alamat Rumah" type="text" name="address">
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

        $('#btnSave').text('Simpan Perubahan'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
        $('#account').load("http://siperpus.amga/petugas/akun_petugas #account"); //Reload topnav
        Swal.fire(
          'Berhasil',
          'Data berhasil diupdate!',
          'success'
        );

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        Swal.fire(
          'Gagal',
          'Data gagal diupdate!',
          'error'
        );
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
</script>
<!--MODAL-->
<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <form id="form-modal" action="<?php echo site_url('Petugas/Akun_Petugas/ganti_pass')?>" method="post">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Form Ubah Password</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
          <div class="form-group">
            <label for="old" class="form-control-label">Password Lama</label>
            <div class="input-group input-group-merge">
              <input class="form-control" placeholder="Masukkan Password Lama" type="password" name="old">
            </div>
          </div>
          <div class="form-group">
            <label for="new" class="form-control-label">Password Baru</label>
            <div class="input-group input-group-merge">
              <input class="form-control" placeholder="Masukkan Password Baru" type="password" name="new">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Ubah Password</button>
          <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Tutup</button>
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