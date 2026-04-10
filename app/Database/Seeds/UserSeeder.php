<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * UserSeeder
 * Membuat akun default:
 * - Operator : operator@sukasari.desa.id / admin123
 * - Masyarakat test: warga@sukasari.desa.id / warga123
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role_id'      => 2,
                'nama_lengkap' => 'Admin Desa Sukasari',
                'email'        => 'operator@sukasari.desa.id',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'no_hp'        => '08110000001',
                'nik'          => '3201010101010001',
                'alamat'       => 'Kantor Desa Sukasari',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'role_id'      => 1,
                'nama_lengkap' => 'Budi Santoso',
                'email'        => 'warga@sukasari.desa.id',
                'password'     => password_hash('warga123', PASSWORD_DEFAULT),
                'no_hp'        => '08120000002',
                'nik'          => '3201010101010002',
                'alamat'       => 'Jl. Sukasari No. 10 RT 001/002',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
        echo "✓ UserSeeder selesai\n";
        echo "  → Operator  : operator@sukasari.desa.id / admin123\n";
        echo "  → Masyarakat: warga@sukasari.desa.id / warga123\n";
    }
}