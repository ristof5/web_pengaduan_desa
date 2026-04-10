<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'role_id',
        'nama_lengkap',
        'email',
        'password',
        'no_hp',
        'nik',
        'alamat',
        'foto_profil',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
        'email'        => 'required|valid_email|is_unique[users.email]',
        'password'     => 'required|min_length[6]',
        'nama_lengkap' => 'required|min_length[3]',
        'nik'          => 'required|is_unique[users.nik]',
    ];

    protected $validationMessages = [
        'email'        => [
            'required'      => 'Email wajib diisi',
            'valid_email'   => 'Email tidak valid',
            'is_unique'     => 'Email sudah terdaftar',
        ],
        'password'     => [
            'required'      => 'Password wajib diisi',
            'min_length'    => 'Password minimal 6 karakter',
        ],
        'nama_lengkap' => [
            'required'      => 'Nama lengkap wajib diisi',
            'min_length'    => 'Nama minimal 3 karakter',
        ],
        'nik'          => [
            'required'      => 'NIK wajib diisi',
            'is_unique'     => 'NIK sudah terdaftar',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // ============================================================
    // CUSTOM METHODS
    // ============================================================

    /**
     * Cari user berdasarkan email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Cari user berdasarkan ID beserta role
     */
    public function getUserWithRole($id)
    {
        return $this->select('users.*, roles.nama as role_nama, roles.slug as role_slug')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.id', $id)
                    ->first();
    }

    /**
     * Validasi password
     */
    public function validatePassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Daftar user baru (untuk masyarakat)
     */
    public function registerUser($data)
    {
        $data['role_id'] = 1; // Default role masyarakat
        $data['status']  = 'aktif';
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->insert($data);
    }
}