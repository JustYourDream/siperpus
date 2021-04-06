<!--MODAL QR-->
<div class="modal fade" id="modal_qr" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-xs modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modal-title-default">Scan QR Code</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
<script src="<?= base_url('https://rawgit.com/schmich/instascan-builds/master/instascan.min.js'); ?>"></script>
<script type="text/javascript">
let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
scanner.addListener('scan', function (content) {
  $("#buku").val(content);
  $('#modal_qr').modal('hide');
  scanner.stop();
  cari_buku(content);
});
function start_cam(){
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

function stop(){
  scanner.stop();
}
</script>
