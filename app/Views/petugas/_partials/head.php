<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>SIPERPUS | <?php $uri = service('uri'); if($uri->getSegment(2)=="dashboard_petugas"){echo 'Dashboard';}
                                                 if($uri->getSegment(2)=="form_kunjungan"){echo 'Form Kunjungan';}
                                                 if($uri->getSegment(2)=="Form_Kunjungan"){echo 'Form Kunjungan';}
                                                 if($uri->getSegment(2)=="databuku_petugas"){echo 'Data Buku';}
                                                 if($uri->getSegment(2)=="ebook_petugas"){echo 'Data Ebook';}
                                                 if($uri->getSegment(2)=="dataanggota_petugas"){echo 'Data Anggota';}
                                                 if($uri->getSegment(2)=="datapeminjaman_petugas"){echo 'Data Peminjaman';}
                                                 if($uri->getSegment(2)=="datapengembalian_petugas"){echo 'Data Pengembalian';}
                                                 if($uri->getSegment(2)=="laporan_petugas"){echo 'Buat Laporan';}
                                                 if($uri->getSegment(2)=="akun_petugas"){echo 'Pengaturan Akun';}
  ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('../login_page/images/icons/favicon.ico') ?>" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?= base_url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700')?>">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/nucleo/css/nucleo.css')?>" type="text/css">
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')?>" type="text/css">
  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/animate.css/animate.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('../../assets/vendor/sweetalert2/dist/sweetalert2.min.css') ?>">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= base_url('../../assets/css/argon.css?v=1.1.0')?>" type="text/css">

</head>
