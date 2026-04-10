<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// PUBLIK (Tidak perlu login)
// ============================================================
$routes->get('/', 'Home::index');  // Landing page

// ============================================================
// AUTH ROUTES
// ============================================================
$routes->group('auth', function ($routes) {
    $routes->get('login',           'Auth\AuthController::login');
    $routes->post('login',          'Auth\AuthController::loginProcess');
    $routes->get('register',        'Auth\AuthController::register');
    $routes->post('register',       'Auth\AuthController::registerProcess');
    $routes->get('logout',          'Auth\AuthController::logout');
});

// ============================================================
// MASYARAKAT ROUTES (Role: masyarakat)
// ============================================================
$routes->group('pengaduan', ['filter' => 'auth:masyarakat'], function ($routes) {
    $routes->get('/',                  'Masyarakat\PengaduanController::index');
    $routes->get('buat',               'Masyarakat\PengaduanController::buat');
    $routes->post('buat',              'Masyarakat\PengaduanController::simpan');
    $routes->get('detail/(:num)',      'Masyarakat\PengaduanController::detail/$1');
    $routes->post('komentar/(:num)',   'Masyarakat\PengaduanController::komentar/$1');
});

// ============================================================
// OPERATOR ROUTES (Role: operator)
// ============================================================
$routes->group('operator', ['filter' => 'auth:operator'], function ($routes) {
    $routes->get('/',                       'Operator\DashboardController::index');
    $routes->get('dashboard',               'Operator\DashboardController::index');

    // Pengaduan management
    $routes->get('pengaduan',               'Operator\PengaduanController::index');
    $routes->get('pengaduan/(:num)',        'Operator\PengaduanController::detail/$1');
    $routes->post('pengaduan/status/(:num)', 'Operator\PengaduanController::updateStatus/$1');
    $routes->post('pengaduan/komentar/(:num)', 'Operator\PengaduanController::komentar/$1');

    // Kategori management
    $routes->get('kategori',                'Operator\KategoriController::index');
    $routes->get('kategori/buat',           'Operator\KategoriController::buat');
    $routes->post('kategori/simpan',        'Operator\KategoriController::simpan');
    $routes->get('kategori/edit/(:num)',    'Operator\KategoriController::edit/$1');
    $routes->post('kategori/update/(:num)', 'Operator\KategoriController::update/$1');
    $routes->post('kategori/hapus/(:num)',  'Operator\KategoriController::hapus/$1');

    // Pengguna management
    $routes->get('pengguna',                'Operator\PenggunaController::index');
    $routes->post('pengguna/status/(:num)', 'Operator\PenggunaController::updateStatus/$1');
});