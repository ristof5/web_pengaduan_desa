<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFotoPengaduanTable extends Migration
{
    public function up()
    {
        // -------------------------------------------------------
        // Tabel foto_pengaduan
        // -------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pengaduan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'path_foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Path relatif dari public/uploads/',
            ],
            'tipe' => [
                'type'       => 'ENUM',
                'constraint' => ['sebelum', 'sesudah', 'pendukung'],
                'default'    => 'pendukung',
                'comment'    => 'Jenis foto pengaduan',
            ],
            'ukuran' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'comment'    => 'Ukuran file dalam bytes',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('pengaduan_id');
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('foto_pengaduan', true);

        // -------------------------------------------------------
        // Tabel komentar
        // -------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pengaduan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'is_internal' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = hanya terlihat operator, 0 = publik',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('pengaduan_id');
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id',      'users',     'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('komentar', true);

        // -------------------------------------------------------
        // Tabel status_log — history perubahan status
        // -------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pengaduan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'Siapa yang mengubah status',
            ],
            'status_lama' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'diproses', 'selesai', 'ditolak'],
                'null'       => true,
            ],
            'status_baru' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'diproses', 'selesai', 'ditolak'],
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Alasan perubahan status',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('pengaduan_id');
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id',      'users',     'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('status_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('status_log',    true);
        $this->forge->dropTable('komentar',      true);
        $this->forge->dropTable('foto_pengaduan',true);
    }
}