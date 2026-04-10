<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Tabel pengaduan
 * Tabel inti yang menyimpan semua laporan dari masyarakat
 */
class CreatePengaduanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_tiket' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'comment'    => 'Format: SKS-2024-0001',
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'FK ke tabel users (pelapor)',
            ],
            'kategori_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'FK ke tabel kategori',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Alamat/lokasi kejadian',
            ],
            'prioritas' => [
                'type'       => 'ENUM',
                'constraint' => ['rendah', 'sedang', 'tinggi'],
                'default'    => 'sedang',
                'comment'    => 'Ditentukan oleh operator',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'diproses', 'selesai', 'ditolak'],
                'default'    => 'menunggu',
            ],
            'ditangani_oleh' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK ke users (operator yang menangani)',
            ],
            'catatan_operator' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Catatan internal dari operator',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('kode_tiket');
        $this->forge->addKey('status');
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id',      'users',    'id', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('kategori_id',  'kategori', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('ditangani_oleh','users',   'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('pengaduan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengaduan', true);
    }
}