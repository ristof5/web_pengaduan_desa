<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\UserModel;
use App\Models\KategoriModel;

/**
 * DashboardController (Operator)
 *
 * Halaman utama panel operator.
 * Menampilkan statistik ringkasan, tren 7 hari,
 * distribusi per kategori, dan laporan terbaru.
 */
class DashboardController extends BaseController
{
    protected PengaduanModel $pengaduanModel;
    protected UserModel      $userModel;
    protected KategoriModel  $kategoriModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->userModel      = new UserModel();
        $this->kategoriModel  = new KategoriModel();
    }

    public function index(): string
    {
        // --- Statistik utama ---
        $stat = $this->pengaduanModel->getStatistik();

        // --- Tren 7 hari terakhir (untuk chart bar) ---
        $trend = $this->pengaduanModel->getTrend(7);

        // --- Distribusi per kategori ---
        $perKategori = $this->pengaduanModel->getStatistikPerKategori();

        // --- 6 Laporan terbaru ---
        $terbaru = $this->pengaduanModel
            ->select('pengaduan.*, kategori.nama AS nama_kategori,
                      users.nama_lengkap AS nama_pelapor')
            ->join('kategori', 'kategori.id = pengaduan.kategori_id')
            ->join('users',    'users.id    = pengaduan.user_id')
            ->orderBy('pengaduan.created_at', 'DESC')
            ->limit(6)
            ->find();

        // --- Total warga terdaftar ---
        $totalWarga = $this->userModel
            ->where('role_id', 1)
            ->countAllResults();

        // --- Rata-rata hari penyelesaian ---
        $rataRow = \Config\Database::connect()->query("
            SELECT ROUND(AVG(DATEDIFF(updated_at, created_at)), 1) AS rata
            FROM pengaduan WHERE status = 'selesai'
        ")->getRowArray();

        $rataRata = $rataRow['rata'] ?? 0;

        return view('operator/dashboard', [
            'title'       => 'Dashboard Operator',
            'user'        => $this->getCurrentUser(),
            'stat'        => $stat,
            'trend'       => $trend,
            'perKategori' => $perKategori,
            'terbaru'     => $terbaru,
            'totalWarga'  => $totalWarga,
            'rataRata'    => $rataRata,
        ]);
    }
}