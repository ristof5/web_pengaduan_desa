<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 *
 * Mengelola tabel users — masyarakat & operator.
 * Method diselaraskan antara versi repo dan versi progress
 * sehingga AuthController dapat memanggil keduanya tanpa konflik.
 */
class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
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

    // ----------------------------------------------------------------
    // Validation rules — dipakai saat insert/update via Model
    // ----------------------------------------------------------------
    protected $validationRules = [
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'email'        => 'required|valid_email|max_length[100]|is_unique[users.email]',
        'nik'          => 'required|exact_length[16]|numeric|is_unique[users.nik]',
        'no_hp'        => 'required|min_length[10]|max_length[15]',
        'alamat'       => 'required|min_length[10]',
        'password'     => 'required|min_length[8]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique'   => 'Email ini sudah terdaftar. Gunakan email lain atau masuk ke akun Anda.',
            'valid_email' => 'Format email tidak valid.',
        ],
        'nik' => [
            'exact_length' => 'NIK harus tepat 16 digit angka.',
            'numeric'      => 'NIK hanya boleh berisi angka.',
            'is_unique'    => 'NIK ini sudah terdaftar dalam sistem.',
        ],
        'password' => [
            'min_length' => 'Password minimal 8 karakter.',
        ],
        'no_hp' => [
            'min_length' => 'Nomor HP minimal 10 digit.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // ================================================================
    // METHOD QUERY
    // ================================================================

    /**
     * Cari user berdasarkan email (tanpa join role).
     * Dipakai untuk cek duplikat atau ambil data dasar.
     * Nama method ini dipertahankan sesuai repo kamu.
     */
    public function getUserByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Cari user beserta data role-nya berdasarkan ID.
     * Mengembalikan field tambahan: role_nama, role_slug.
     * Nama method ini dipertahankan sesuai repo kamu.
     */
    public function getUserWithRole(int $id): ?array
    {
        return $this->select('users.*, roles.nama as role_nama, roles.slug as role_slug')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.id', $id)
                    ->first();
    }

    /**
     * Cari user beserta role berdasarkan EMAIL — versi satu langkah.
     * Dipakai oleh verifyLogin() dan bagian lain yang butuh data lengkap.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->select('users.*, roles.slug as role_slug, roles.nama as role_nama')
                    ->join('roles', 'roles.id = users.role_id')
                    ->where('users.email', $email)
                    ->first();
    }

    // ================================================================
    // METHOD AUTENTIKASI
    // ================================================================

    /**
     * Verifikasi password plain vs hash.
     * Nama method dipertahankan sesuai repo kamu.
     */
    public function validatePassword(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Verifikasi login sekaligus dalam satu method.
     * Lebih ringkas dari: getUserByEmail() + validatePassword() + getUserWithRole().
     *
     * @return array|null Data user lengkap dengan role jika valid, null jika gagal
     */
    public function verifyLogin(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if (! $user) {
            return null;
        }

        // Ambil hash password secara terpisah dari DB
        $raw = $this->db->table('users')
                        ->select('password')
                        ->where('id', $user['id'])
                        ->get()
                        ->getRowArray();

        if (! $raw || ! password_verify($password, $raw['password'])) {
            return null;
        }

        return $user;
    }

    // ================================================================
    // METHOD SESSION
    // ================================================================

    /**
     * Set session setelah login berhasil.
     *
     * Key yang di-set (konsisten di seluruh app):
     *   user_id    → ID user
     *   user_nama  → nama lengkap (dipakai di Views versi kita)
     *   user_name  → alias user_nama (dipakai di Views versi repo)
     *   user_email → email
     *   user_role  → slug role: 'masyarakat' atau 'operator'
     *   role_id    → id role (FK)
     *   logged_in  → true
     */
    public function setSession(array $user): void
    {
        session()->set([
            'user_id'    => $user['id'],
            'user_nama'  => $user['nama_lengkap'],
            'user_name'  => $user['nama_lengkap'],  // alias agar kompatibel kedua versi Views
            'user_email' => $user['email'],
            'user_role'  => $user['role_slug'],
            'role_id'    => $user['role_id'],
            'logged_in'  => true,
        ]);
    }

    // ================================================================
    // METHOD REGISTRASI
    // ================================================================

    /**
     * Daftarkan masyarakat baru — hash password & set role otomatis.
     * Nama method dipertahankan sesuai repo kamu.
     *
     * PENTING: Validasi form harus dilakukan di Controller
     *          SEBELUM memanggil method ini.
     *
     * @param  array      $data ['nama_lengkap','email','password','nik','no_hp','alamat']
     * @return int|false  ID user baru, atau false jika insert gagal
     */
    public function registerUser(array $data): int|false
    {
        $insertData = [
            'role_id'      => 1,   // selalu masyarakat saat registrasi publik
            'nama_lengkap' => trim($data['nama_lengkap']),
            'email'        => strtolower(trim($data['email'])),
            'password'     => password_hash($data['password'], PASSWORD_DEFAULT),
            'nik'          => $data['nik']    ?? null,
            'no_hp'        => $data['no_hp']  ?? null,
            'alamat'       => $data['alamat'] ?? null,
            'status'       => 'aktif',
        ];

        // Skip validasi model karena password sudah di-hash
        // dan validasi sudah dilakukan di controller
        $this->skipValidation(true);
        $id = $this->insert($insertData);
        $this->skipValidation(false);

        return $id ? (int) $id : false;
    }

    // ================================================================
    // METHOD UTILITY
    // ================================================================

    /**
     * Daftar masyarakat dengan pagination.
     */
    public function getMasyarakat(int $perPage = 15): array
    {
        return $this->select('users.*')
                    ->where('role_id', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Update status akun (aktif / nonaktif).
     */
    public function updateStatus(int $id, string $status): bool
    {
        return (bool) $this->update($id, ['status' => $status]);
    }
}