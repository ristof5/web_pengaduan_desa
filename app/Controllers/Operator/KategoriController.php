<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

/**
 * KategoriController (Operator)
 *
 * CRUD kategori pengaduan:
 *   - Tampil daftar + form tambah (satu halaman)
 *   - Edit & update kategori
 *   - Hapus kategori
 */
class KategoriController extends BaseController
{
    protected KategoriModel $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // ================================================================
    // INDEX — Daftar + form tambah kategori
    // ================================================================

    public function index(): string
    {
        return view('operator/kategori/index', [
            'title'    => 'Kelola Kategori',
            'user'     => $this->getCurrentUser(),
            'kategori' => $this->kategoriModel
                               ->orderBy('urutan', 'ASC')
                               ->findAll(),
            'errors'   => session()->getFlashdata('errors') ?? [],
        ]);
    }

    // ================================================================
    // BUAT — Tampilkan form tambah (jika diakses via GET terpisah)
    // ================================================================

    public function buat()
    {
        // Redirect ke index karena form ada di sana (inline)
        return redirect()->to(base_url('operator/kategori'));
    }

    // ================================================================
    // SIMPAN — Proses tambah kategori baru
    // ================================================================

    public function simpan()
    {
        $rules = [
            'nama'      => 'required|min_length[3]|max_length[100]',
            'icon'      => 'permit_empty|max_length[50]',
            'deskripsi' => 'permit_empty',
            'urutan'    => 'permit_empty|integer|greater_than[0]',
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama kategori wajib diisi.',
                'min_length' => 'Nama kategori minimal 3 karakter.',
            ],
            'urutan' => [
                'integer'      => 'Urutan harus berupa angka.',
                'greater_than' => 'Urutan harus lebih dari 0.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->insert([
            'nama'      => trim($this->request->getPost('nama')),
            'icon'      => trim($this->request->getPost('icon')) ?: 'tag',
            'deskripsi' => trim($this->request->getPost('deskripsi') ?? ''),
            'urutan'    => (int) ($this->request->getPost('urutan') ?: 99),
            'aktif'     => 1,
        ]);

        return redirect()
            ->to(base_url('operator/kategori'))
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // ================================================================
    // EDIT — Form edit kategori
    // ================================================================

    public function edit(int $id)
    {
        $data = $this->kategoriModel->find($id);

        if (! $data) {
            return redirect()->to(base_url('operator/kategori'))
                ->with('error', 'Kategori tidak ditemukan.');
        }

        return view('operator/kategori/form', [
            'title'  => 'Edit Kategori',
            'user'   => $this->getCurrentUser(),
            'data'   => $data,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    // ================================================================
    // UPDATE — Proses update kategori
    // ================================================================

    public function update(int $id)
    {
        $existing = $this->kategoriModel->find($id);

        if (! $existing) {
            return redirect()->to(base_url('operator/kategori'))
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = [
            'nama'   => 'required|min_length[3]|max_length[100]',
            'urutan' => 'permit_empty|integer|greater_than[0]',
        ];

        $messages = [
            'nama' => ['required' => 'Nama kategori wajib diisi.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->update($id, [
            'nama'      => trim($this->request->getPost('nama')),
            'icon'      => trim($this->request->getPost('icon')) ?: 'tag',
            'deskripsi' => trim($this->request->getPost('deskripsi') ?? ''),
            'urutan'    => (int) ($this->request->getPost('urutan') ?: 99),
            'aktif'     => $this->request->getPost('aktif') ? 1 : 0,
        ]);

        return redirect()
            ->to(base_url('operator/kategori'))
            ->with('success', 'Kategori "' . esc($this->request->getPost('nama')) . '" berhasil diperbarui.');
    }

    // ================================================================
    // HAPUS — Hapus kategori
    // ================================================================

    public function hapus(int $id)
    {
        $data = $this->kategoriModel->find($id);

        if (! $data) {
            return redirect()->to(base_url('operator/kategori'))
                ->with('error', 'Kategori tidak ditemukan.');
        }

        // Cegah hapus jika masih ada pengaduan dengan kategori ini
        $db     = \Config\Database::connect();
        $jumlah = $db->table('pengaduan')
                     ->where('kategori_id', $id)
                     ->countAllResults();

        if ($jumlah > 0) {
            return redirect()->to(base_url('operator/kategori'))
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh '
                    . $jumlah . ' laporan.');
        }

        $this->kategoriModel->delete($id);

        return redirect()
            ->to(base_url('operator/kategori'))
            ->with('success', 'Kategori "' . esc($data['nama']) . '" berhasil dihapus.');
    }
}