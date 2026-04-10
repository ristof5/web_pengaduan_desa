<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'         => 1,
                'nama'       => 'Masyarakat',
                'slug'       => 'masyarakat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 2,
                'nama'       => 'Operator / Petugas Desa',
                'slug'       => 'operator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('roles')->insertBatch($data);
        echo "✓ RoleSeeder selesai\n";
    }
}