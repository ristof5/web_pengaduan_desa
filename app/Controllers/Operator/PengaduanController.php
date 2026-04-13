<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\FotoPengaduanModel;
use App\Models\KomentarModel;
use App\Models\StatusLogModel;
use App\Models\KategoriModel;

/**
 * PengaduanController (Operator)
 *
 * Menangani pengelolaan pengaduan dari sisi petugas desa:
 *   - Daftar pengaduan dengan filter & pencarian
 *   - Detail pengaduan lengkap (semua komentar termasuk internal)
 *   - Update status + prioritas + catat di status_log
 *   - Balas komentar (publik atau internal)
 */
class PengaduanController extends BaseController
{
    protected PengaduanModel     $pengaduanModel;
    protected FotoPengaduanModel $fotoModel;
    protected KomentarModel      $komentarModel;
    protected StatusLogModel     $statusLogModel;
    protected KategoriModel      $kategoriModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->fotoModel      = new FotoPengaduanModel();
        $this->komentarModel  = new KomentarModel();
        $this->statusLogModel = new StatusLogModel();
        $this->kategoriModel  = new KategoriModel();
    }

    // ================================================================
    // INDEX — Tabel semua pengaduan + filter + pencarian
    // ================================================================

    public function index(): string
    {
        $status    = $this->request->getGet('status');
        $kategori  = $this->request->getGet('kategori');
        $prioritas = $this->request->getGet('prioritas');
        $cari      = $this->request->getGet('cari');

        $statusValid   = ['menunggu', 'diproses', 'selesai', 'ditolak'];
        $prioritasValid = ['rendah', 'sedang', 'tinggi'];

        $builder = $this->pengaduanModel
            ->select('pengaduan.*, kategori.nama AS nama_kategori,
                      users.nama_lengkap AS nama_pelapor,
                      users.no_hp        AS hp_pelapor')
            ->join('kategori', 'kategori.id = pengaduan.kategori_id')
            ->join('users',    'users.id    = pengaduan.user_id')
            ->orderBy('pengaduan.created_at', 'DESC');

        if ($status && in_array($status, $statusValid)) {
            $builder->where('pengaduan.status', $status);
        }

        if ($kategori && is_numeric($kategori)) {
            $builder->where('pengaduan.kategori_id', (int) $kategori);
        }

        if ($prioritas && in_array($prioritas, $prioritasValid)) {
            $builder->where('pengaduan.prioritas', $prioritas);
        }

        if ($cari) {
            $builder->groupStart()
                        ->like('pengaduan.judul', $cari)
                        ->orLike('pengaduan.kode_tiket', $cari)
                        ->orLike('users.nama_lengkap', $cari)
                    ->groupEnd();
        }

        $pengaduan = $builder->paginate(15, 'default');
        $pager     = $this->pengaduanModel->pager;

        return view('operator/pengaduan/index', [
            'title'            => 'Kelola Pengaduan',
            'user'             => $this->getCurrentUser(),
            'pengaduan'        => $pengaduan,
            'pager'            => $pager,
            'kategoriList'     => $this->kategoriModel->getAktif(),
            'filter_status'    => $status,
            'filter_kategori'  => $kategori,
            'filter_prioritas' => $prioritas,
            'cari'             => $cari,
        ]);
    }

    // ================================================================
    // DETAIL — Detail lengkap + semua komentar (termasuk internal)
    // ================================================================

    public function detail(int $id)
    {
        $pengaduan = $this->pengaduanModel->getPengaduanLengkap($id);

        if (! $pengaduan) {
            return redirect()->to(base_url('operator/pengaduan'))
                ->with('error', 'Laporan tidak ditemukan.');
        }

        return view('operator/pengaduan/detail', [
            'title'     => 'Detail — ' . $pengaduan['kode_tiket'],
            'user'      => $this->getCurrentUser(),
            'pengaduan' => $pengaduan,
            'fotos'     => $this->fotoModel->getFotoByPengaduan($id),
            'komentar'  => $this->komentarModel->getByPengaduan($id, true), // true = tampil internal juga
            'riwayat'   => $this->statusLogModel->getRiwayat($id),
        ]);
    }

    // ================================================================
    // UPDATE STATUS
    // ================================================================

    public function updateStatus(int $id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (! $pengaduan) {
            return redirect()->to(base_url('operator/pengaduan'))
                ->with('error', 'Laporan tidak ditemukan.');
        }

        $statusBaru = $this->request->getPost('status');
        $catatan    = trim($this->request->getPost('catatan') ?? '');
        $prioritas  = $this->request->getPost('prioritas');

        $statusValid   = ['menunggu', 'diproses', 'selesai', 'ditolak'];
        $prioritasValid = ['rendah', 'sedang', 'tinggi'];

        if (! in_array($statusBaru, $statusValid)) {
            return redirect()->back()
                ->with('error', 'Status tidak valid.');
        }

        // Susun data update
        $updateData = [
            'status'    => $statusBaru,
            'prioritas' => in_array($prioritas, $prioritasValid)
                           ? $prioritas
                           : $pengaduan['prioritas'],
        ];

        // Tandai operator yang pertama kali menangani
        if ($statusBaru === 'diproses' && ! $pengaduan['ditangani_oleh']) {
            $updateData['ditangani_oleh'] = $this->userId();
        }

        $this->pengaduanModel->update($id, $updateData);

        // Catat ke status_log
        $this->statusLogModel->catat(
            pengaduanId: $id,
            userId:      $this->userId(),
            statusLama:  $pengaduan['status'],
            statusBaru:  $statusBaru,
            catatan:     $catatan ?: null
        );

        $labelStatus = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Sedang Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
        ];

        return redirect()
            ->to(base_url('operator/pengaduan/' . $id))
            ->with('success', 'Status laporan diperbarui menjadi "'
                . ($labelStatus[$statusBaru] ?? $statusBaru) . '".');
    }

    // ================================================================
    // KOMENTAR — Balas dari operator (bisa internal)
    // ================================================================

    public function komentar(int $id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (! $pengaduan) {
            return redirect()->to(base_url('operator/pengaduan'))
                ->with('error', 'Laporan tidak ditemukan.');
        }

        if (! $this->validate([
            'isi' => 'required|min_length[3]|max_length[1000]',
        ])) {
            return redirect()->back()
                ->with('error', 'Isi balasan tidak boleh kosong (minimal 3 karakter).');
        }

        $isInternal = $this->request->getPost('is_internal') ? 1 : 0;

        $this->komentarModel->insert([
            'pengaduan_id' => $id,
            'user_id'      => $this->userId(),
            'isi'          => $this->request->getPost('isi'),
            'is_internal'  => $isInternal,
        ]);

        $pesan = $isInternal
            ? 'Catatan internal berhasil disimpan.'
            : 'Balasan berhasil dikirim ke pelapor.';

        return redirect()
            ->to(base_url('operator/pengaduan/' . $id) . '#komentar')
            ->with('success', $pesan);
    }
}