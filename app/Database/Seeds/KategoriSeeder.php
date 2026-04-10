<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'       => 'Jalan & Infrastruktur',
                'icon'       => 'road',
                'deskripsi'  => 'Kerusakan jalan, jembatan, drainase, dan infrastruktur desa.',
                'urutan'     => 1,
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Sampah & Kebersihan',
                'icon'       => 'trash',
                'deskripsi'  => 'Penumpukan sampah, got tersumbat, dan kebersihan lingkungan.',
                'urutan'     => 2,
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Keamanan & Ketertiban',
                'icon'       => 'shield',
                'deskripsi'  => 'Gangguan keamanan, lampu jalan mati, dan ketertiban umum.',
                'urutan'     => 3,
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Administrasi & Pelayanan',
                'icon'       => 'file-text',
                'deskripsi'  => 'Keluhan pelayanan administrasi desa, surat menyurat, dan KTP.',
                'urutan'     => 4,
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Fasilitas Umum',
                'icon'       => 'home',
                'deskripsi'  => 'Kerusakan fasilitas umum: posyandu, balai desa, tempat ibadah.',
                'urutan'     => 5,
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Lainnya',
                'icon'       => 'more-horizontal',
                'deskripsi'  => 'Pengaduan lain yang tidak termasuk kategori di atas.',
                'urutan'     => 6,
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kategori')->insertBatch($data);
        echo "✓ KategoriSeeder selesai (6 kategori)\n";
    }
}