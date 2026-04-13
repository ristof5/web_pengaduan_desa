<?php

namespace App\Controllers\Masyarakat;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\KategoriModel;
use App\Models\FotoPengaduanModel;
use App\Models\KomentarModel;
use App\Models\StatusLogModel;

/**
 * PengaduanController (Masyarakat)
 *
 * Menangani semua fitur pengaduan dari sisi masyarakat:
 *   - Daftar pengaduan milik user
 *   - Form buat pengaduan + upload foto
 *   - Detail pengaduan + tracking timeline
 *   - Kirim komentar / pertanyaan ke petugas
 */
class PengaduanController extends BaseController
{
    protected PengaduanModel     $pengaduanModel;
    protected KategoriModel      $kategoriModel;
    protected FotoPengaduanModel $fotoModel;
    protected KomentarModel      $komentarModel;
    protected StatusLogModel     $statusLogModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->kategoriModel  = new KategoriModel();
        $this->fotoModel      = new FotoPengaduanModel();
        $this->komentarModel  = new KomentarModel();
        $this->statusLogModel = new StatusLogModel();
    }

    // ================================================================
    // INDEX — Daftar pengaduan milik user yang login
    // ================================================================

    public function index(): string
    {
        $userId = $this->userId();
        $status = $this->request->getGet('status');

        // Validasi nilai filter status
        $statusValid = ['menunggu', 'diproses', 'selesai', 'ditolak'];

        $builder = $this->pengaduanModel
            ->select('pengaduan.*, kategori.nama AS nama_kategori,
                      kategori.icon AS icon_kategori')
            ->join('kategori', 'kategori.id = pengaduan.kategori_id')
            ->where('pengaduan.user_id', $userId)
            ->orderBy('pengaduan.created_at', 'DESC');

        if ($status && in_array($status, $statusValid)) {
            $builder->where('pengaduan.status', $status);
        }

        $pengaduan = $builder->paginate(10, 'default');
        $pager     = $this->pengaduanModel->pager;

        // Statistik milik user ini
        $stat = $this->pengaduanModel->getStatistikUser($userId);

        return view('masyarakat/pengaduan/index', [
            'title'         => 'Laporan Saya',
            'user'          => $this->getCurrentUser(),
            'pengaduan'     => $pengaduan,
            'pager'         => $pager,
            'stat'          => $stat,
            'filter_status' => $status,
        ]);
    }

    // ================================================================
    // BUAT — Tampilkan form pengaduan baru
    // ================================================================

    public function buat(): string
    {
        return view('masyarakat/pengaduan/buat', [
            'title'    => 'Buat Laporan',
            'user'     => $this->getCurrentUser(),
            'kategori' => $this->kategoriModel->getAktif(),
            'errors'   => session()->getFlashdata('errors') ?? [],
        ]);
    }

    // ================================================================
    // SIMPAN — Proses form pengaduan baru
    // ================================================================

    public function simpan()
    {
        $rules = [
            'kategori_id' => 'required|integer',
            'judul'       => 'required|min_length[10]|max_length[200]',
            'deskripsi'   => 'required|min_length[20]',
            'lokasi'      => 'permit_empty|max_length[255]',
            'foto.*'      => 'permit_empty|is_image[foto]|max_size[foto,2048]
                              |ext_in[foto,jpg,jpeg,png,webp]',
        ];

        $messages = [
            'kategori_id' => ['required' => 'Silakan pilih kategori pengaduan.'],
            'judul'       => ['min_length' => 'Judul minimal 10 karakter.'],
            'deskripsi'   => ['min_length' => 'Deskripsi minimal 20 karakter.'],
            'foto'        => [
                'is_image' => 'File harus berupa gambar (jpg, jpeg, png, webp).',
                'max_size' => 'Ukuran foto maksimal 2MB per file.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // --- Generate kode tiket ---
        $kodeTiket = $this->pengaduanModel->generateKodeTiket();

        // --- Simpan pengaduan ---
        $pengaduanId = $this->pengaduanModel->insert([
            'kode_tiket'  => $kodeTiket,
            'user_id'     => $this->userId(),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'judul'       => $this->request->getPost('judul'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'status'      => 'menunggu',
            'prioritas'   => 'sedang',
        ]);

        if (! $pengaduanId) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['Gagal menyimpan laporan. Silakan coba lagi.']);
        }

        // --- Upload foto (opsional, maks 3) ---
        $this->prosesUploadFoto((int) $pengaduanId);

        // --- Catat status log awal ---
        $this->statusLogModel->catat(
            pengaduanId: (int) $pengaduanId,
            userId:      $this->userId(),
            statusLama:  null,
            statusBaru:  'menunggu',
            catatan:     'Laporan baru dikirimkan oleh masyarakat.'
        );

        return redirect()
            ->to(base_url('pengaduan/detail/' . $pengaduanId))
            ->with('success', 'Laporan berhasil dikirim! Kode tiket Anda: <strong>'
                . esc($kodeTiket) . '</strong>');
    }

    // ================================================================
    // DETAIL — Detail + tracking + komentar
    // ================================================================

    public function detail(int $id)
    {
        $pengaduan = $this->pengaduanModel->getPengaduanLengkap($id);

        if (! $pengaduan) {
            return redirect()->to(base_url('pengaduan'))
                ->with('error', 'Laporan tidak ditemukan.');
        }

        // Pastikan hanya pemilik laporan yang bisa akses
        if ((int) $pengaduan['user_id'] !== $this->userId()) {
            return redirect()->to(base_url('pengaduan'))
                ->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('masyarakat/pengaduan/detail', [
            'title'     => 'Detail Laporan — ' . $pengaduan['kode_tiket'],
            'user'      => $this->getCurrentUser(),
            'pengaduan' => $pengaduan,
            'fotos'     => $this->fotoModel->getFotoByPengaduan($id),
            'komentar'  => $this->komentarModel->getByPengaduan($id, false),
            'riwayat'   => $this->statusLogModel->getRiwayat($id),
        ]);
    }

    // ================================================================
    // KOMENTAR — Kirim komentar dari masyarakat
    // ================================================================

    public function komentar(int $id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        // Validasi kepemilikan
        if (! $pengaduan || (int) $pengaduan['user_id'] !== $this->userId()) {
            return redirect()->to(base_url('pengaduan'))
                ->with('error', 'Laporan tidak ditemukan.');
        }

        if (! $this->validate([
            'isi' => 'required|min_length[3]|max_length[1000]',
        ])) {
            return redirect()->back()
                ->with('error', 'Komentar tidak boleh kosong (minimal 3 karakter).');
        }

        $this->komentarModel->insert([
            'pengaduan_id' => $id,
            'user_id'      => $this->userId(),
            'isi'          => $this->request->getPost('isi'),
            'is_internal'  => 0,  // komentar masyarakat selalu publik
        ]);

        return redirect()
            ->to(base_url('pengaduan/detail/' . $id) . '#komentar')
            ->with('success', 'Komentar berhasil dikirim.');
    }

    // ================================================================
    // HELPER PRIVATE
    // ================================================================

    /**
     * Proses upload foto dari form (field name: foto[]).
     * Maksimal 3 file, masing-masing maks 2MB.
     */
    private function prosesUploadFoto(int $pengaduanId): void
    {
        $fotos = $this->request->getFileMultiple('foto');

        if (! $fotos || ! $fotos[0]->isValid()) {
            return;
        }

        $uploadPath = FCPATH . 'uploads/pengaduan/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach (array_slice($fotos, 0, 3) as $foto) {
            if (! $foto->isValid() || $foto->hasMoved()) {
                continue;
            }

            $namaFile = $foto->getRandomName();
            $foto->move($uploadPath, $namaFile);

            $this->fotoModel->simpanFoto([
                'pengaduan_id' => $pengaduanId,
                'nama_file'    => $namaFile,
                'path_foto'    => 'uploads/pengaduan/' . $namaFile,
                'tipe'         => 'pendukung',
                'ukuran'       => $foto->getSize(),
            ]);
        }
    }
}