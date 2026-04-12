<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * StatusLogModel
 *
 * Model untuk tabel status_log.
 * Merekam setiap perubahan status pengaduan secara kronologis.
 * Dipakai untuk menampilkan timeline riwayat di halaman detail.
 */
class StatusLogModel extends Model
{
    protected $table            = 'status_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'pengaduan_id',
        'user_id',
        'status_lama',
        'status_baru',
        'catatan',
    ];

    // Hanya ada created_at, tidak ada updated_at
    protected $useTimestamps = false;

    /**
     * Ambil seluruh riwayat perubahan status sebuah pengaduan.
     * Diurut dari yang paling lama ke paling baru (kronologis).
     *
     * @param  int   $pengaduanId
     * @return array Setiap row berisi: status_lama, status_baru,
     *               catatan, created_at, nama_lengkap, role_id
     */
    public function getRiwayat(int $pengaduanId): array
    {
        return $this
            ->select('status_log.*, users.nama_lengkap, users.role_id')
            ->join('users', 'users.id = status_log.user_id')
            ->where('status_log.pengaduan_id', $pengaduanId)
            ->orderBy('status_log.created_at', 'ASC')
            ->findAll();
    }

    /**
     * Catat satu perubahan status baru (dengan timestamp manual).
     *
     * @param int         $pengaduanId
     * @param int         $userId      ID user yang mengubah
     * @param string|null $statusLama  null jika ini log pertama
     * @param string      $statusBaru  Status baru
     * @param string|null $catatan     Catatan alasan perubahan
     */
    public function catat(
        int     $pengaduanId,
        int     $userId,
        ?string $statusLama,
        string  $statusBaru,
        ?string $catatan = null
    ): int|false {
        $id = $this->insert([
            'pengaduan_id' => $pengaduanId,
            'user_id'      => $userId,
            'status_lama'  => $statusLama,
            'status_baru'  => $statusBaru,
            'catatan'      => $catatan,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        return $id ? (int) $id : false;
    }
}