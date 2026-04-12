<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * FotoPengaduanModel
 *
 * Model untuk tabel foto_pengaduan.
 * Menyimpan path foto yang diupload bersama laporan.
 */
class FotoPengaduanModel extends Model
{
    protected $table            = 'foto_pengaduan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'pengaduan_id',
        'nama_file',
        'path_foto',
        'tipe',
        'ukuran',
    ];

    // Hanya ada created_at, tidak ada updated_at
    protected $useTimestamps = false;

    /**
     * Ambil semua foto milik satu pengaduan.
     *
     * @param  int   $pengaduanId
     * @return array
     */
    public function getFotoByPengaduan(int $pengaduanId): array
    {
        return $this->where('pengaduan_id', $pengaduanId)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /**
     * Simpan satu record foto dengan timestamp manual.
     * Dipanggil setelah file berhasil dipindahkan ke folder upload.
     */
    public function simpanFoto(array $data): int|false
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $id = $this->insert($data);
        return $id ? (int) $id : false;
    }
}