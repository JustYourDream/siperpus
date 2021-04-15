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
              <h6 class="h2 text-white d-inline-block mb-0">Buku Digital</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url('/anggota/dashboard_anggota')?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('/anggota/baca_buku')?>">Baca Buku</a></li>
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
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0"><i class="fas fa-book-open"></i> Baca Buku</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group">
                    <?php
                    $form_keyword = [
                      'type'  => 'text',
                      'name'  => 'keyword',
                      'id'    => 'keyword',
                      'value' => $keyword,
                      'class' => 'form-control',
                      'placeholder' => 'Masukkan kata kunci...'
                    ];
                    echo form_input($form_keyword);
                    ?>
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button" id="search_buku"><i class="fas fa-search"></i> Cari</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="katalog_ebook" style="margin-top: 30px;">
                <?php foreach ($ebook as $key => $data): ?>
                  <div class="col-sm-3" style="padding-left: 30px; padding-right: 30px;">
                    <div class="card border-primary mb-">
                      <img class="card-img-top" src="<?= base_url('assets/eBook/Cover/'.$data['cover_ebook']); ?>" alt="Card image cap">
                      <div class="card-body">
                        <h5 class="card-title" align="center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong><?= $data['judul_ebook']; ?></strong></h5>
                        <a href="<?= base_url('assets/eBook/PDF/'.$data['file_ebook']); ?>" target="_blank" class="btn btn-default btn-block" title="<?= $data['judul_ebook']; ?>">Baca</a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-3">
                  <?= $pager->links('ebook', 'bootstrap_pagination') ?>
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
    $("#search_buku").click(function(){
        filter();
    });
    var filter = function(){
        var keyword = $("#keyword").val();
        window.location.replace("baca_buku?keyword="+keyword);
    }
});
</script>
</html>
