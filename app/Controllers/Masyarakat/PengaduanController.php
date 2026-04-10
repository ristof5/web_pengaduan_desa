<?php

namespace App\Controllers\Masyarakat;

use App\Controllers\BaseController;

class PengaduanController extends BaseController
{
    public function index()
    {
        // Hanya masyarakat yang bisa akses
        if ($this->userRole() !== 'masyarakat') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Pengaduan Saya',
            'user'  => $this->getCurrentUser(),
        ];

        return view('masyarakat/pengaduan/index', $data);
    }

    public function buat()
    {
        if ($this->userRole() !== 'masyarakat') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Buat Pengaduan',
            'user'  => $this->getCurrentUser(),
        ];

        return view('masyarakat/pengaduan/buat', $data);
    }

    public function simpan()
    {
        // TODO: Implementasi simpan pengaduan
        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim');
    }

    public function detail($id)
    {
        // TODO: Implementasi detail pengaduan
        $data = [
            'title' => 'Detail Pengaduan',
            'user'  => $this->getCurrentUser(),
            'id'    => $id,
        ];

        return view('masyarakat/pengaduan/detail', $data);
    }

    public function komentar($id)
    {
        // TODO: Implementasi komentar
        return redirect()->back()->with('success', 'Komentar berhasil dikirim');
    }
}