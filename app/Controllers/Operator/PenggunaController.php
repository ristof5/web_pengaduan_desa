<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;

class PenggunaController extends BaseController
{
    public function index()
    {
        if ($this->userRole() !== 'operator') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Kelola Pengguna',
            'user'  => $this->getCurrentUser(),
        ];

        return view('operator/pengguna/index', $data);
    }

    public function updateStatus($id)
    {
        // TODO: Update status pengguna
        return redirect()->back()->with('success', 'Status pengguna berhasil diupdate');
    }
}