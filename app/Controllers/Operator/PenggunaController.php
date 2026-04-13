<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\UserModel;

/**
 * PenggunaController (Operator)
 *
 * Mengelola akun masyarakat:
 *   - Daftar semua akun masyarakat
 *   - Update status akun (aktif / nonaktif)
 */
class PenggunaController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ================================================================
    // INDEX — Daftar masyarakat
    // ================================================================

    public function index(): string
    {
        $cari = $this->request->getGet('cari');

        $builder = $this->userModel
            ->select('users.*, roles.nama AS role_nama')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.role_id', 1) // hanya masyarakat
            ->orderBy('users.created_at', 'DESC');

        if ($cari) {
            $builder->groupStart()
                        ->like('users.nama_lengkap', $cari)
                        ->orLike('users.email', $cari)
                        ->orLike('users.nik', $cari)
                    ->groupEnd();
        }

        $pengguna = $builder->paginate(20, 'default');
        $pager    = $this->userModel->pager;

        return view('operator/pengguna/index', [
            'title'    => 'Kelola Pengguna',
            'user'     => $this->getCurrentUser(),
            'pengguna' => $pengguna,
            'pager'    => $pager,
            'cari'     => $cari,
        ]);
    }

    // ================================================================
    // UPDATE STATUS — Aktifkan / nonaktifkan akun
    // ================================================================

    public function updateStatus(int $id)
    {
        $pengguna = $this->userModel->find($id);

        if (! $pengguna) {
            return redirect()->to(base_url('operator/pengguna'))
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        // Toggle status: aktif ↔ nonaktif
        $statusBaru = $pengguna['status'] === 'aktif' ? 'nonaktif' : 'aktif';

        $this->userModel->updateStatus($id, $statusBaru);

        $pesan = $statusBaru === 'aktif'
            ? 'Akun "' . esc($pengguna['nama_lengkap']) . '" berhasil diaktifkan.'
            : 'Akun "' . esc($pengguna['nama_lengkap']) . '" berhasil dinonaktifkan.';

        return redirect()
            ->to(base_url('operator/pengguna'))
            ->with('success', $pesan);
    }
}