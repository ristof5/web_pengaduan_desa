<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;

class KategoriController extends BaseController
{
    public function index()
    {
        if ($this->userRole() !== 'operator') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Kelola Kategori',
            'user'  => $this->getCurrentUser(),
        ];

        return view('operator/kategori/index', $data);
    }

    public function buat()
    {
        if ($this->userRole() !== 'operator') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Buat Kategori',
            'user'  => $this->getCurrentUser(),
        ];

        return view('operator/kategori/buat', $data);
    }

    public function simpan()
    {
        // TODO: Simpan kategori
        return redirect()->to('/operator/kategori')->with('success', 'Kategori berhasil ditambah');
    }

    public function edit($id)
    {
        if ($this->userRole() !== 'operator') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Edit Kategori',
            'user'  => $this->getCurrentUser(),
            'id'    => $id,
        ];

        return view('operator/kategori/edit', $data);
    }

    public function update($id)
    {
        // TODO: Update kategori
        return redirect()->to('/operator/kategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function hapus($id)
    {
        // TODO: Hapus kategori
        return redirect()->to('/operator/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}