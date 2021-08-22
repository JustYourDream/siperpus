<!---->
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
            <div class="col-xl-10 col-lg-6 col-md-8 px-5">
              <h1 class="text-white"><?= $judul_ebook; ?></h1>
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
        <div class="col-xl-12 d-flex justify-content-center">
          <iframe id="pdf-js-viewer" src="<?= base_url('assets/vendor/pdf.js/web/viewer.html?file=').base_url('assets/eBook/PDF/'.$file_ebook); ?>" title="webviewer" frameborder="0" width="600" height="700"></iframe>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php include("_partials/js.php") ?>
</body>
</html>
