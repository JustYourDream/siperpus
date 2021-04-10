<!--MODAL QR-->
<div class="modal fade" id="modal_qr" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-xs modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-default scan">Scan QR Code</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="stop()">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body form" style="padding-top:0px; padding-bottom:0px;">
        <form id="form_qr" action="#">
          <div class="row">
            <div class="col-md-12">
              <p>Arahkan QR Code ke Kamera</p>
              <video id="preview" style="width: 100%; height: auto;"></video>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal" onclick="stop()">Batal</button>
      </div>
    </div>
  </div>
</div>
<!--End Of Modal QR-->

<!--InstaScan-->
<script type="text/javascript">
let scanner_buku = new Instascan.Scanner({ video: document.getElementById('preview') });
let scanner_anggota = new Instascan.Scanner({ video: document.getElementById('preview') });

//SCANNER BUKU
scanner_buku.addListener('scan', function (content) {
  $("#buku").val(content);
  cari_buku(content);
  $('#modal_qr').modal('hide');
  scanner_buku.stop();
});

function start_scan_buku(){
  $('.modal-title').text('Scan QR Code Buku');
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner_buku.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });
}

//SCANNER ANGGOTA
scanner_anggota.addListener('scan', function (content) {
  $("#anggota").val(content);
  cari_anggota(content);
  $('#modal_qr').modal('hide');
  scanner_anggota.stop();
});

function start_scan_anggota(){
  $('.modal-title').text('Scan QR Code Anggota');
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner_anggota.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });
}

//STOP SCANNER
function stop(){
  scanner_buku.stop();
  scanner_anggota.stop();
}
</script>
