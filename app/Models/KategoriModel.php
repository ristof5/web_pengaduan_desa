<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * KategoriModel
 *
 * Model untuk tabel kategori pengaduan.
 * Dipakai di: form buat pengaduan, kelola kategori operator.
 */
class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nama',
        'icon',
        'deskripsi',
        'urutan',
        'aktif',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua kategori yang aktif, diurut berdasarkan kolom urutan.
     * Dipakai di form buat pengaduan (masyarakat).
     */
    public function getAktif(): array
    {
        return $this->where('aktif', 1)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }
}