<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * KomentarModel
 *
 * Model untuk tabel komentar.
 * Mengelola diskusi antara masyarakat dan petugas desa.
 *
 * is_internal = 0 → komentar publik (terlihat masyarakat & operator)
 * is_internal = 1 → catatan internal (hanya terlihat operator)
 */
class KomentarModel extends Model
{
    protected $table            = 'komentar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'pengaduan_id',
        'user_id',
        'isi',
        'is_internal',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil komentar sebuah pengaduan beserta nama pengirim.
     *
     * @param int  $pengaduanId  ID pengaduan
     * @param bool $isOperator   true = tampilkan semua termasuk internal
     *                           false = hanya tampilkan komentar publik
     */
    public function getByPengaduan(int $pengaduanId, bool $isOperator = false): array
    {
        $builder = $this
            ->select('komentar.*, users.nama_lengkap, users.role_id')
            ->join('users', 'users.id = komentar.user_id')
            ->where('komentar.pengaduan_id', $pengaduanId);

        // Masyarakat hanya bisa lihat komentar publik
        if (! $isOperator) {
            $builder->where('komentar.is_internal', 0);
        }

        return $builder->orderBy('komentar.created_at', 'ASC')->findAll();
    }

    /**
     * Hitung total komentar publik sebuah pengaduan.
     */
    public function countPublik(int $pengaduanId): int
    {
        return $this->where('pengaduan_id', $pengaduanId)
                    ->where('is_internal', 0)
                    ->countAllResults();
    }
}