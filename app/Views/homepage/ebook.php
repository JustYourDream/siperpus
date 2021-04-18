<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIPERPUS | Sistem Informasi Perpustakaan</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Favicons
    ================================================== -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="<?= base_url('../home_page/css/bootstrap.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('../home_page/fonts/font-awesome/css/font-awesome.css') ?>">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css" href="<?= base_url('../home_page/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('../home_page/css/nivo-lightbox/nivo-lightbox.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('../home_page/css/nivo-lightbox/default.css') ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation
    ==========================================-->
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand page-scroll" href="/home">SIPERPUS <font color="#6372ff">AMGA</font></a> </div>
  </div>
</nav>

<!-- Testimonials Section -->
<div id="testimonials">
  <div class="container">
    <div class="section-title text-center" style="margin-bottom: 20px; padding-top: 20px">
      <h2>Cari E-book</h2>
    </div>
    <div class="row" align="center" style="margin-bottom: 20px;">
      <div class="col-md-12">
        <div class="input-group">
          <?php
          $form_keyword = [
            'type'  => 'text',
            'name'  => 'keyword',
            'id'    => 'keyword',
            'value' => $keyword,
            'class' => 'form-control custom-input',
            'placeholder' => 'Masukkan kata kunci...'
          ];
          echo form_input($form_keyword);
          ?>
          <div class="input-group-btn">
            <button class="btn btn-custom" type="button" id="search">
              <span class="fa fa-search"></span> CARI
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="padding-top: 20px;">
      <?php foreach ($ebook as $key => $data): ?>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <a href="<?= base_url('assets/eBook/PDF/'.$data['file_ebook']); ?>" target="_blank" style="margin-bottom: 0px;" class="thumbnail" title="<?= $data['judul_ebook']; ?>">
              <img src="<?= base_url('assets/eBook/Cover/'.$data['cover_ebook']); ?>" style="height: auto; width: 100%;">
            </a>
          </div>
          <div class="panel-footer" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" align="center">
            <?= $data['judul_ebook']; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <?= $pager->links('ebook', 'bootstrap3_pagination') ?>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Footer Section -->
<div id="footer">
  <div class="container text-center">
    <p>&copy; <?php echo date("Y");?> SMK Negeri 1 Ampelgading. Design by <a href="http://www.templatewire.com" rel="nofollow">TemplateWire </a>| Made by Alfian Maulana</p>
  </div>
</div>
<script type="text/javascript" src="<?= base_url('../home_page/js/jquery.3.6.0.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/SmoothScroll.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/nivo-lightbox.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/jqBootstrapValidation.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/contact_me.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/main.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('../home_page/js/counter.js') ?>"></script>
<script>
$(document).ready(function(){
    $("#search").click(function(){
        filter();
    });
    var filter = function(){
        var keyword = $("#keyword").val();
        window.location.replace("ebook?keyword="+keyword);
    }
});
</script>
</body>
</html>
