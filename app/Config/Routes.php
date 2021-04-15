<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//Petugas
$routes->get('petugas/dashboard_petugas', 'Petugas/Dashboard_Petugas::index',['filter' => 'auth']);
$routes->get('petugas/form_kunjungan','Petugas/Form_Kunjungan::index',['filter' => 'auth']);
$routes->get('petugas/form_kunjungan/sukses','Petugas/Form_Kunjungan::welcome',['filter' => 'auth']);
$routes->get('petugas/databuku_petugas', 'Petugas/DataBuku_Petugas::index',['filter' => 'auth']);
$routes->get('petugas/ebook_petugas', 'Petugas/Ebook_Petugas::index',['filter' => 'auth']);
$routes->get('petugas/dataanggota_petugas', 'Petugas/DataAnggota_Petugas::index',['filter' => 'auth']);
$routes->get('petugas/datapeminjaman_petugas','Petugas/DataPeminjaman_Petugas::index',['filter' => 'auth']);
$routes->get('petugas/datapengembalian_petugas','Petugas/DataPengembalian_Petugas::index',['filter' => 'auth']);
$routes->get('petugas/akun_petugas','Petugas/Akun_Petugas::index',['filter' => 'auth']);

//Anggota
$routes->get('anggota/dashboard_anggota', 'Anggota/Dashboard_Anggota::index',['filter' => 'auth_anggota']);
$routes->get('anggota/pinjam_buku', 'Anggota/DataBuku_Anggota::index',['filter' => 'auth_anggota']);
$routes->get('anggota/baca_buku', 'Anggota/Baca_Buku::index',['filter' => 'auth_anggota']);
$routes->get('anggota/info_peminjaman', 'Anggota/Info_Peminjaman::index',['filter' => 'auth_anggota']);
$routes->get('anggota/info_pengembalian', 'Anggota/Info_Pengembalian::index',['filter' => 'auth_anggota']);
$routes->get('anggota/setting_akun', 'Anggota/Setting_Akun::index',['filter' => 'auth_anggota']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
