<?php

namespace App\Controllers\Masyarakat;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PengaduanController extends BaseController
{
    public function index()
    {
        if ($this->userRole() !== 'masyarakat') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Mengambil data pengaduan khusus milik user yang sedang login
        $db = \Config\Database::connect();
        $user = $this->getCurrentUser();
        $pengaduan = $db->table('pengaduan')
                        ->select('pengaduan.*, kategori.nama')
                        ->join('kategori', 'kategori.id = pengaduan.kategori_id', 'left')
                        ->where('user_id', $user['id'])
                        ->orderBy('pengaduan.created_at', 'DESC')
                        ->get()->getResultArray();

        $data = [
            'title'     => 'Pengaduan Saya',
            'user'      => $user,
            'pengaduan' => $pengaduan
        ];

        return view('masyarakat/pengaduan/index', $data);
    }

    public function buat()
    {
        if ($this->userRole() !== 'masyarakat') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Ambil data kategori untuk ditampilkan di form <select>
        $db = \Config\Database::connect();
        $kategori = $db->table('kategori')->get()->getResultArray();

        $data = [
            'title'    => 'Buat Pengaduan',
            'user'     => $this->getCurrentUser(),
            'kategori' => $kategori
        ];

        return view('masyarakat/pengaduan/buat', $data);
    }

    public function simpan()
    {
        // 1. Validasi Input Form
        $rules = [
            'kategori_id' => 'required',
            'judul'       => 'required|min_length[5]|max_length[150]',
            'deskripsi'   => 'required|min_length[10]',
            'lokasi'      => 'required',
            // Validasi foto (opsional tapi jika ada harus berupa gambar max 2MB)
            'foto'        => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form beserta pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $user = $this->getCurrentUser();
        
        // 2. Generate Kode Tiket Unik (Contoh: SKS-2026-A1B2C)
        $kodeTiket = 'SKS-' . date('Y') . '-' . strtoupper(substr(uniqid(), -5));

        // 3. Cek checkbox Anonim dan Rahasia (jika dicentang nilainya 1, jika tidak 0)
        $isAnonim = $this->request->getPost('is_anonim') ? 1 : 0;
        $isRahasia = $this->request->getPost('is_rahasia') ? 1 : 0;

        // Mulai Transaksi Database
        $db->transStart();

        try {
            // 4. Simpan ke tabel `pengaduan`
            $dataPengaduan = [
                'kode_tiket'  => $kodeTiket,
                'user_id'     => $user['id'],
                'kategori_id' => $this->request->getPost('kategori_id'),
                'judul'       => $this->request->getPost('judul'),
                'deskripsi'   => $this->request->getPost('deskripsi'),
                'lokasi'      => $this->request->getPost('lokasi'),
                'status'      => 'menunggu', // Status awal saat laporan dibuat
                'is_anonim'   => $isAnonim,
                'is_rahasia'  => $isRahasia,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            $db->table('pengaduan')->insert($dataPengaduan);
            $pengaduanId = $db->insertID(); // Ambil ID pengaduan yang baru saja disimpan

            // 5. Proses Upload Foto (jika user mengunggah foto)
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                // Buat nama random agar tidak ada file bentrok
                $namaFoto = $foto->getRandomName();
                // Pindahkan ke folder public/uploads/pengaduan
                $foto->move(FCPATH . 'uploads/pengaduan', $namaFoto);

                $dataFoto = [
                    'pengaduan_id' => $pengaduanId,
                    'path_foto'    => 'uploads/pengaduan/' . $namaFoto,
                    'tipe'         => 'bukti',
                    'created_at'   => date('Y-m-d H:i:s'),
                ];
                $db->table('foto_pengaduan')->insert($dataFoto);
            }

            // 6. Simpan ke tabel `status_log` sebagai riwayat pertama
            $dataLog = [
                'pengaduan_id' => $pengaduanId,
                'user_id'      => $user['id'],
                'status_baru'  => 'menunggu',
                'catatan'      => 'Laporan baru berhasil dikirim oleh masyarakat.',
                'created_at'   => date('Y-m-d H:i:s'),
            ];
            $db->table('status_log')->insert($dataLog);

            // Selesaikan transaksi
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Jika ada query yang gagal, kembalikan error dan otomatis rollback
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
            }

            // Jika sukses, arahkan kembali ke halaman index pengaduan warga
            return redirect()->to('/pengaduan')->with('success', 'Pengaduan berhasil dikirim! Kode Tiket: ' . $kodeTiket);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        // TODO: Implementasi detail pengaduan (akan dikerjakan selanjutnya)
        $data = [
            'title' => 'Detail Pengaduan',
            'user'  => $this->getCurrentUser(),
            'id'    => $id,
        ];

        return view('masyarakat/pengaduan/detail', $data);
    }

    public function komentar($id)
    {
        // TODO: Implementasi komentar (akan dikerjakan selanjutnya)
        return redirect()->back()->with('success', 'Komentar berhasil dikirim');
    }
}