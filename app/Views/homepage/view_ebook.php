<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIPERPUS | Baca Ebook</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Favicons
    ================================================== -->
<link rel="icon" href="<?= base_url('../login_page/images/icons/favicon.ico') ?>" type="image/png">
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
<div id="testimonials" width="100%">
  <div class="container">
    <div class="section-title text-center" style="margin-bottom: 20px; padding-top: 20px">
      <h2><?= $judul_ebook; ?></h2>
    </div>
    <div class="row" align="center" style="margin-bottom: 20px;">
      <div class="col-md-8 col-md-offset-2">
        <iframe id="pdf-js-viewer" src="<?= base_url('assets/vendor/pdf.js/web/viewer.html?file=').base_url('assets/eBook/PDF/'.$file_ebook); ?>" title="webviewer" frameborder="0" width="100%" height="800"></iframe>
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
</body>
</html>
