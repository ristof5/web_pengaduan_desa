<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * PengaduanModel
 *
 * Model utama untuk tabel pengaduan.
 * Dipakai oleh: Home, Masyarakat/PengaduanController,
 *               Operator/DashboardController, Operator/PengaduanController.
 */
class PengaduanModel extends Model
{
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'kode_tiket',
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lokasi',
        'prioritas',
        'status',
        'ditangani_oleh',
        'catatan_operator',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'user_id'     => 'required|integer',
        'kategori_id' => 'required|integer',
        'judul'       => 'required|min_length[10]|max_length[200]',
        'deskripsi'   => 'required|min_length[20]',
        'lokasi'      => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'judul' => [
            'min_length' => 'Judul pengaduan minimal 10 karakter.',
            'max_length' => 'Judul pengaduan maksimal 200 karakter.',
        ],
        'deskripsi' => [
            'min_length' => 'Deskripsi pengaduan minimal 20 karakter.',
        ],
    ];

    // ================================================================
    // GENERATE KODE TIKET
    // ================================================================

    /**
     * Generate kode tiket unik format: SKS-YYYY-XXXX
     * Contoh: SKS-2026-0001
     */
    public function generateKodeTiket(): string
    {
        $tahun  = date('Y');
        $prefix = 'SKS-' . $tahun . '-';

        // Cari nomor urut terakhir tahun ini
        $last = $this->like('kode_tiket', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();

        $nextNum = $last
            ? (int) substr($last['kode_tiket'], -4) + 1
            : 1;

        return $prefix . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }

    // ================================================================
    // QUERY DENGAN JOIN
    // ================================================================

    /**
     * Ambil data pengaduan lengkap (join kategori + user pelapor + operator).
     * Dipakai di halaman detail — masyarakat & operator.
     */
    
    public function getPengaduanLengkap(int $id): ?array
    {
        return $this->select('
                pengaduan.*,
                kategori.nama          AS nama_kategori,
                kategori.icon          AS icon_kategori,
                u1.nama_lengkap        AS nama_pelapor,
                u1.no_hp               AS hp_pelapor,
                u2.nama_lengkap        AS nama_operator
            ')
            ->join('kategori', 'kategori.id = pengaduan.kategori_id')
            ->join('users u1', 'u1.id = pengaduan.user_id')
            ->join('users u2', 'u2.id = pengaduan.ditangani_oleh', 'left')
            ->where('pengaduan.id', $id)
            ->first();
    }

    // ================================================================
    // STATISTIK
    // ================================================================

    /**
     * Statistik ringkasan semua pengaduan.
     * Dipakai di dashboard operator & landing page.
     *
     * @return array ['total','menunggu','diproses','selesai','ditolak']
     */
    public function getStatistik(): array
    {
        $row = $this->db->query("
            SELECT
                COUNT(*)                        AS total,
                SUM(status = 'menunggu')        AS menunggu,
                SUM(status = 'diproses')        AS diproses,
                SUM(status = 'selesai')         AS selesai,
                SUM(status = 'ditolak')         AS ditolak
            FROM pengaduan
        ")->getRowArray();

        return $row ?? [
            'total'    => 0,
            'menunggu' => 0,
            'diproses' => 0,
            'selesai'  => 0,
            'ditolak'  => 0,
        ];
    }

    /**
     * Statistik pengaduan milik satu user tertentu.
     * Dipakai di halaman daftar pengaduan masyarakat.
     *
     * @return array ['total','menunggu','diproses','selesai','ditolak']
     */
    public function getStatistikUser(int $userId): array
    {
        $row = $this->db->query("
            SELECT
                COUNT(*)                        AS total,
                SUM(status = 'menunggu')        AS menunggu,
                SUM(status = 'diproses')        AS diproses,
                SUM(status = 'selesai')         AS selesai,
                SUM(status = 'ditolak')         AS ditolak
            FROM pengaduan
            WHERE user_id = ?
        ", [$userId])->getRowArray();

        return $row ?? [
            'total'    => 0,
            'menunggu' => 0,
            'diproses' => 0,
            'selesai'  => 0,
            'ditolak'  => 0,
        ];
    }

    /**
     * Jumlah pengaduan per kategori (urut terbanyak).
     * Dipakai di dashboard operator — grafik distribusi.
     */
    public function getStatistikPerKategori(): array
    {
        return $this->select('kategori.nama, COUNT(pengaduan.id) AS total')
                    ->join('kategori', 'kategori.id = pengaduan.kategori_id')
                    ->groupBy('pengaduan.kategori_id')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }

    /**
     * Tren laporan masuk per hari untuk N hari terakhir.
     * Dipakai di chart bar dashboard operator.
     *
     * @param  int   $hari Jumlah hari ke belakang (default 7)
     * @return array [['tgl' => 'Y-m-d', 'total' => int], ...]
     */
    public function getTrend(int $hari = 7): array
    {
        return $this->db->query("
            SELECT DATE(created_at) AS tgl, COUNT(*) AS total
            FROM pengaduan
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY tgl ASC
        ", [$hari])->getResultArray();
    }
}