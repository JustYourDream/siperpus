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
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand page-scroll" href="#page-top">SIPERPUS <font color="#6372ff">AMGA</font></a> </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#features" class="page-scroll">Layanan</a></li>
        <li><a href="#about" class="page-scroll">Profil</a></li>
        <li><a href="#services" class="page-scroll">Data Perpustakaan</a></li>
        <li><a href="#portfolio" class="page-scroll">E-Book</a></li>
        <li><a href="#testimonials" class="page-scroll">Cari Buku</a></li>
        <li><a href="#team" class="page-scroll">Kepengurusan</a></li>
        <li><a href="../login/" target="_blank" class="page-scroll">Masuk</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
</nav>
<!-- Header -->
<header id="header">
  <div class="intro">
    <div class="overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 intro-text">
            <h1>Sistem Informasi Perpustakaan<span></span></h1>
            <p>Selamat datang di SIPERPUS, SIPERPUS merupakan aplikasi perpustakaan digital untuk membantu mengelola dan menyediakan informasi mengenai perpustakaan SMK Negeri 1 Ampelgading.</p>
            <a href="#features" class="btn btn-custom btn-lg page-scroll">Jelajahi</a> </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- Features Section -->
<div id="features" class="text-center">
  <div class="container">
    <div class="col-md-10 col-md-offset-1 section-title">
      <h2>Layanan</h2>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3"> <i class="fa fa-book"></i>
        <h3>Baca Buku</h3>
        <p>SIPERPUS menyediakan buku digital yang dapat dibaca kapanpun dan dimanapun.</p>
      </div>
      <div class="col-xs-6 col-md-3"> <i class="fa fa-cart-arrow-down"></i>
        <h3>Pinjam Buku</h3>
        <p>Anggota perpustakaan dapat melakukan peminjaman buku secara online.</p>
      </div>
      <div class="col-xs-6 col-md-3"> <i class="fa fa-search"></i>
        <h3>Pencarian Buku</h3>
        <p>Siswa-siswi dapat mencari buku yang tersedia melalui SIPERPUS.</p>
      </div>
      <div class="col-xs-6 col-md-3"> <i class="fa fa-info"></i>
        <h3>Informasi Perpustakaan</h3>
        <p>SIPERPUS menyediakan berbagai macam informasi mengenai perpustakaan.</p>
      </div>
    </div>
  </div>
</div>
<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6"> <img src="../home_page/img/perpus.jpg" class="img-responsive" alt=""> </div>
      <div class="col-xs-12 col-md-6">
        <div class="about-text">
          <h2>Profil Perpustakaan</h2>
          <p style="text-align: justify; text-indent: 0.5in;">Perpustakaan <b>INTI GADING</b> merupakan perpustakaan yang ada pada SMK Negeri 1 Ampelgading, perpustakaan ini dibangun dengan tujuan untuk memberikan berbagai macam informasi, pengetahuan, dan bahan pustaka guna mendukung kegiatan belajar mengajar di SMK Negeri 1 Ampelgading. Bahan pustaka di perpustakaan ini dapat dibaca maupun dipinjam secara langsung oleh siswa-siswi SMK Negeri 1 Ampelgading.</p>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- Services Section -->
<div id="services" class="text-center">
  <div class="container">
    <div class="section-title">
      <h2>Data Perpustakaan</h2>
    </div>
    <div class="row">
      <?php
        $db = \Config\Database::connect();

        //QUERY
        $query_buku = $db->table('data_buku')->selectCount('no_induk');
        $query_eksemplar = $db->table('insert_buku')->selectSum('eksemplar_buku')->get();
        $query_ebook = $db->table('data_ebook')->selectCount('id_ebook');
        $query_anggota = $db->table('data_anggota')->selectCount('no_anggota');
        $query_peminjaman = $db->table('data_peminjaman')->selectCount('id_peminjaman');
        $query_pengembalian = $db->table('data_pengembalian')->selectCount('id_peminjaman');
        $query_pengunjung = $db->table('data_pengunjung')->selectCount('no_anggota');

        //Result
        $jml_buku = $query_buku->countAllResults();
        $jml_eksemplar = $query_eksemplar->getResult();
        $jml_ebook = $query_ebook->countAllResults();
        $jml_anggota = $query_anggota->countAllResults();
        $jml_peminjaman = $query_peminjaman->countAllResults();
        $jml_pengembalian = $query_pengembalian->countAllResults();
        $jml_pengunjung = $query_pengunjung->countAllResults();
      ?>
      <div class="col-md-3"> <i class="fa timer count-title count-number" data-to="<?= $jml_buku; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>JUDUL</h3>
        </div>
      </div>
      <?php foreach ($jml_eksemplar as $value): ?>
      <div class="col-md-3"> <i class="fa timer count-title count-number" data-to="<?= $value->eksemplar_buku; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>EKSEMPLAR</h3>
        </div>
      </div>
      <?php endforeach; ?>
      <div class="col-md-3"> <i class="fa timer count-title count-number" data-to="<?= $jml_ebook; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>BUKU DIGITAL</h3>
        </div>
      </div>
      <div class="col-md-3"> <i class="fa timer count-title count-number" data-to="<?= $jml_anggota; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>ANGGOTA</h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4"> <i class="fa timer count-title count-number" data-to="<?= $jml_peminjaman; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>PEMINJAMAN</h3>
        </div>
      </div>
      <div class="col-md-4"> <i class="fa timer count-title count-number" data-to="<?= $jml_pengembalian; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>PENGEMBALIAN</h3>
        </div>
      </div>
      <div class="col-md-4"> <i class="fa timer count-title count-number" data-to="<?= $jml_pengunjung; ?>" data-speed="2000"></i>
        <div class="service-desc">
          <h3>PENGUNJUNG</h3>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Gallery Section -->
<div id="portfolio" class="text-center">
  <div class="container">
    <div class="section-title">
      <h2>Baca E-book</h2>
    </div>
    <div class="row">
      <?php
        $builder = $db->table('data_ebook');
        $query = $builder->get(8);
        $result = $query->getResult();

        foreach ($result as $row){

      ?>
      <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <a href="<?= base_url('view_ebook/view/'.$row->id_ebook); ?>" target="_blank" style="margin-bottom: 0px;" class="thumbnail" title="<?= $row->judul_ebook; ?>">
              <img src="<?= base_url('assets/eBook/Cover/'.$row->cover_ebook); ?>" style="height: auto; width: 100%;">
            </a>
          </div>
          <div class="panel-footer" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?= $row->judul_ebook; ?>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
    </div>
    <div class="row" style="margin: 20px;">
      <div class="col-sm-12 text-center">
        <a href="/ebook" class="btn btn-custom btn-lg">LIHAT LEBIH BANYAK</a>
      </div>
    </div>
  </div>
</div>
<!-- Testimonials Section -->
<div id="testimonials">
  <div class="container">
    <div class="section-title text-center">
      <h2>Cari Buku</h2>
    </div>
    <div class="row" align="center">
      <div class="col-md-12">
        <div class="input-group">
          <input type="text" class="form-control custom-input" placeholder="CARI BUKU YANG INGIN ANDA BACA" id="input_buku">
          <div class="input-group-btn">
            <button class="btn btn-custom" type="button" onclick="cari_buku(document.getElementById('input_buku').value)">
              <span class="fa fa-search"></span> CARI
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="padding-top: 20px;">
      <div class="col-sm-12" id="result">

      </div>
    </div>
  </div>
</div>
<!-- Team Section -->
<div id="team" class="text-center">
  <div class="container">
    <div class="col-md-8 col-md-offset-2 section-title">
      <h2>Kepengurusan</h2>
      <p>Struktur Kepengurusan Perpustakaan SMK N 1 Ampelgading</p>
    </div>
    <div id="row">
      <div class="col-md-3 col-sm-6 team">
        <div class="thumbnail"> <img src="../home_page/img/team/kepsek.jpg" alt="..." class="team-img">
          <div class="caption">
            <h4>Dra. Lutfiah Barliana, M.Pd</h4>
            <p>Kepala Sekolah</p>
          </div>
        </div>
      </div>
      <?php
      $query = $db->query('SELECT foto_petugas,nama_petugas FROM petugas WHERE jabatan_petugas = "Ketua"');
      $result = $query->getResult();

      foreach ($result as $row){
      ?>
      <div class="col-md-3 col-sm-6 team">
        <div class="thumbnail"> <img src="../assets/img/profile_pic/<?= $row->foto_petugas ?>" alt="..." class="team-img">
          <div class="caption">
            <h4><?= $row->nama_petugas ?></h4>
            <p>Kepala Perpustakaan</p>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
      <?php
      $query = $db->query('SELECT foto_petugas,nama_petugas FROM petugas WHERE jabatan_petugas = "Petugas"');
      $result = $query->getResult();

      foreach ($result as $row){
      ?>
      <div class="col-md-3 col-sm-6 team">
        <div class="thumbnail"> <img src="../assets/img/profile_pic/<?= $row->foto_petugas ?>" alt="..." class="team-img">
          <div class="caption">
            <h4><?= $row->nama_petugas ?></h4>
            <p>Petugas Perpustakaan</p>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>
<!-- Contact Section -->
<div id="contact">
  <div class="container">
    <div class="col-md-8">
      <div class="row">
        <div class="section-title" style="margin-bottom: 20px;">
          <h2>Peta Lokasi</h2>
        </div>
        <div class="col-md-12" style="padding: 0px; margin: 0px;">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15843.632271806318!2d109.5058772!3d-6.9015971!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7407a1161ae1c108!2sSMK%20Negeri%201%20Ampelgading!5e0!3m2!1sen!2ssg!4v1618946616118!5m2!1sen!2ssg" width="100%" height="280" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-md-offset-1 contact-info">
      <div class="contact-item">
        <h3>Info Kontak</h3>
        <p><span><i class="fa fa-map-marker"></i> Alamat</span>Jl. Raya Ujunggede, Ampelgading<br>
          Kabupaten Pemalang 52364</p>
      </div>
      <div class="contact-item">
        <p><span><i class="fa fa-phone"></i> Telepon</span> (0284) 5801200</p>
      </div>
      <div class="contact-item">
        <p><span><i class="fa fa-envelope-o"></i> Email</span> smkn_ampelgading@yahoo.co.id</p>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="social">
          <ul>
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
          </ul>
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
    $('#tabelBuku').hide();
  });

  function cari_buku(search){
    $('#tabelBuku').show();
    $.ajax({
        url: "<?php echo site_url('Home/cari_buku')?>/"+search,
        type: "POST",
        data: "{}",
        success: function(data){
          $('#result').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }
</script>
</body>
</html>
