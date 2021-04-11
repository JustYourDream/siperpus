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
<body class="bg-default">
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-4 pt-5 pb-5">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Selamat Datang!</h1>
              <p class="text-lead text-white">Silahkan inputkan nomor anggota atau scan kartu anggota untuk absensi kunjungan.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-8 pt-3">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-header bg-transparent pb-2">
              <div class="text-muted text-center mt-2 mb-3"><medium>Absen Dengan</medium></div>
              <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-md-row" id="tabs-icons-text" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 active" id="input-tab" data-toggle="tab" href="#div-input" role="tab" aria-controls="div-input" aria-selected="true" onclick="scan_stop()"><i class="fas fa-keyboard"></i> Input</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="scan-tab" data-toggle="tab" href="#div-scan" role="tab" aria-controls="div-scan" aria-selected="false" onclick="scan_start()"><i class="fas fa-qrcode"></i> Scan</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5" id="Fill">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="div-input" role="tabpanel" aria-labelledby="input-tab">
                  <form action="#">
                    <div class="form-group">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        </div>
                        <input class="form-control" placeholder="Nomor Anggota" type="text" name="no_anggota" id="no_anggota">
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn btn-primary my-4" onclick="absensi(document.getElementById('no_anggota').value)">Masuk</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="div-scan" role="tabpanel" aria-labelledby="scan-tab">
                  <form id="form_qr" action="#">
                    <div class="row">
                      <video id="preview" style="width: 100%; height: auto;"></video>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php include("_partials/js.php") ?>
</body>
<script>

function absensi(no_anggota){
  $.ajax({
    url : "<?php echo site_url('Petugas/Form_Kunjungan/absensi')?>/" + no_anggota,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      if(data[0]){
        window.location.href = "<?php echo base_url('Petugas/Form_Kunjungan/insert_kunjungan')?>/" + data[0].no_anggota;
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

//SCANNER
let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

//SCANNER BUKU
scanner.addListener('scan', function (content) {
  absensi(content);
});

function scan_start(){
  $('.modal-title').text('Scan QR Code Buku');
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });
}

function scan_stop(){
  scanner.stop();
}
//END OF SCANNER
</script>

</html>
