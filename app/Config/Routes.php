<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// HALAMAN PUBLIK
// ============================================================
$routes->get('/', 'Home::index');

// ============================================================
// AUTH (login, register, logout)
// ============================================================
$routes->group('auth', function ($routes) {
    $routes->get('login',           'Auth\AuthController::login');
    $routes->post('login',          'Auth\AuthController::loginProcess');
    $routes->get('register',        'Auth\AuthController::register');
    $routes->post('register',       'Auth\AuthController::registerProcess');
    $routes->get('logout',          'Auth\AuthController::logout');
});

// ============================================================
// MASYARAKAT — harus login, role: masyarakat
// ============================================================
$routes->group('pengaduan', ['filter' => 'auth:masyarakat'], function ($routes) {
    $routes->get('/',               'Masyarakat\PengaduanController::index');       // daftar pengaduan saya
    $routes->get('buat',            'Masyarakat\PengaduanController::buat');        // form buat pengaduan
    $routes->post('buat',           'Masyarakat\PengaduanController::simpan');      // proses simpan
    $routes->get('detail/(:num)',   'Masyarakat\PengaduanController::detail/$1');   // detail + tracking
    $routes->post('komentar/(:num)','Masyarakat\PengaduanController::komentar/$1'); // kirim komentar
});

// ============================================================
// OPERATOR/PETUGAS — harus login, role: operator
// ============================================================
$routes->group('operator', ['filter' => 'auth:operator'], function ($routes) {
    $routes->get('/',                       'Operator\DashboardController::index');

    // Kelola pengaduan
    $routes->get('pengaduan',               'Operator\PengaduanController::index');
    $routes->get('pengaduan/(:num)',         'Operator\PengaduanController::detail/$1');
    $routes->post('pengaduan/status/(:num)', 'Operator\PengaduanController::updateStatus/$1');
    $routes->post('pengaduan/komentar/(:num)','Operator\PengaduanController::komentar/$1');

    // Kelola kategori
    $routes->get('kategori',                'Operator\KategoriController::index');
    $routes->get('kategori/buat',           'Operator\KategoriController::buat');
    $routes->post('kategori/simpan',        'Operator\KategoriController::simpan');
    $routes->get('kategori/edit/(:num)',    'Operator\KategoriController::edit/$1');
    $routes->post('kategori/update/(:num)', 'Operator\KategoriController::update/$1');
    $routes->post('kategori/hapus/(:num)',  'Operator\KategoriController::hapus/$1');

    // Kelola pengguna
    $routes->get('pengguna',                'Operator\PenggunaController::index');
    $routes->post('pengguna/status/(:num)', 'Operator\PenggunaController::updateStatus/$1');
});