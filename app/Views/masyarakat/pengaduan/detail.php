<?= $this->include('layout/header') ?>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    :root {
        --forest-black: #001e2b;
        --mongodb-green: #00ed64;
        --dark-green: #00684a;
        --action-blue: #006cfa;
        --teal-gray: #3d4f58;
        --silver-teal: #b8c4c2;
        --forest-shadow: rgba(0, 30, 43, 0.12) 0px 26px 44px;
    }

    body {
        background: #f0f3f5;
        color: #001e2b;
    }

    .masyarakat-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
        background: var(--forest-black);
        border-right: 1px solid var(--teal-gray);
        padding: 20px;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--teal-gray);
        color: #fff;
    }

    .sidebar-menu { list-style: none; }
    .sidebar-menu li { margin-bottom: 5px; }
    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        color: var(--silver-teal);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .sidebar-menu a:hover, .sidebar-menu a.active {
        background: rgba(0, 237, 100, 0.1);
        color: var(--mongodb-green);
    }

    /* Content Styles */
    .content { padding: 40px; }
    
    .card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--silver-teal);
        box-shadow: var(--forest-shadow);
        padding: 30px;
        margin-bottom: 30px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Source Code Pro', monospace;
    }
    .badge-menunggu { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-diproses { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .badge-selesai { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-ditolak { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--silver-teal);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .info-item label {
        display: block;
        font-size: 12px;
        color: #5c6c75;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item .value {
        font-weight: 600;
        font-size: 15px;
    }

    .deskripsi-box {
        background: #f9fbfa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e8edeb;
        line-height: 1.6;
    }

    /* Timeline & Komentar Grid */
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    /* Timeline Styles */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--silver-teal);
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--mongodb-green);
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px var(--silver-teal);
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 100px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
        border: none;
        cursor: pointer;
    }
    .btn-outline { border: 1px solid var(--teal-gray); color: var(--forest-black); }
    .btn-green { background: var(--dark-green); color: #fff; }
</style>

<?php
// Fallback Variabel (Mencegah error jika data belum dipassing dari controller)
$tiket = $pengaduan['kode_tiket'] ?? 'SKS-XXXX-XXXX';
$judul = $pengaduan['judul'] ?? 'Memuat judul pengaduan...';
$deskripsi = $pengaduan['deskripsi'] ?? 'Deskripsi laporan akan muncul di sini setelah controller disesuaikan.';
$status = $pengaduan['status'] ?? 'menunggu';
$tanggal = isset($pengaduan['created_at']) ? date('d M Y H:i', strtotime($pengaduan['created_at'])) : date('d M Y H:i');
$lokasi = $pengaduan['lokasi'] ?? 'Belum ditentukan';
$kategori = $pengaduan['nama_kategori'] ?? 'Umum';
?>

<div class="masyarakat-layout">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div style="width: 30px; height: 30px; background: var(--mongodb-green); border-radius: 6px;"></div>
            <strong>SUKASARI <span style="font-weight:300;">DIGITAL</span></strong>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/pengaduan" class="active">📋 Pengaduan Saya</a></li>
            <li><a href="/pengaduan/buat">➕ Buat Pengaduan</a></li>
            <li><a href="/auth/logout" style="color: #ff4d4f; margin-top: 20px;">🚪 Keluar</a></li>
        </ul>
    </div>

    <div class="content">
        <a href="/pengaduan" class="btn btn-outline" style="margin-bottom: 20px;">← Kembali ke Daftar</a>

        <div class="card">
            <div class="detail-header">
                <div>
                    <h2 style="font-size: 24px; margin-bottom: 8px;"><?= esc($judul) ?></h2>
                    <p style="font-family: 'Source Code Pro', monospace; color: var(--action-blue);">#<?= esc($tiket) ?></p>
                </div>
                <div>
                    <span class="badge badge-<?= strtolower($status) ?>"><?= esc($status) ?></span>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Tanggal Lapor</label>
                    <div class="value"><?= esc($tanggal) ?></div>
                </div>
                <div class="info-item">
                    <label>Kategori</label>
                    <div class="value"><?= esc($kategori) ?></div>
                </div>
                <div class="info-item">
                    <label>Lokasi Kejadian</label>
                    <div class="value"><?= esc($lokasi) ?></div>
                </div>
            </div>

            <div class="info-item" style="margin-bottom: 10px;">
                <label>Deskripsi Laporan</label>
            </div>
            <div class="deskripsi-box">
                <?= nl2br(esc($deskripsi)) ?>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 18px;">Riwayat Tindak Lanjut</h3>
                
                <?php if(!empty($status_log)): ?>
                    <div class="timeline">
                        <?php foreach($status_log as $log): ?>
                        <div class="timeline-item">
                            <strong style="display:block; font-size: 14px;"><?= esc(ucfirst($log['status_baru'])) ?></strong>
                            <small style="color: #5c6c75;"><?= date('d M Y H:i', strtotime($log['created_at'])) ?></small>
                            <p style="margin-top: 5px; font-size: 14px;"><?= esc($log['catatan'] ?? 'Status diperbarui.') ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="timeline">
                        <div class="timeline-item">
                            <strong style="display:block; font-size: 14px;">Laporan Dibuat</strong>
                            <small style="color: #5c6c75;"><?= esc($tanggal) ?></small>
                            <p style="margin-top: 5px; font-size: 14px;">Menunggu verifikasi dari admin/petugas desa.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3 style="margin-bottom: 20px; font-size: 18px;">Diskusi & Tanggapan</h3>
                
                <div style="background: #f9fbfa; border: 1px solid #e8edeb; border-radius: 8px; padding: 20px; margin-bottom: 20px; max-height: 300px; overflow-y: auto;">
                    <?php if(!empty($komentar)): ?>
                        <?php foreach($komentar as $k): ?>
                            <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e8edeb;">
                                <strong><?= esc($k['nama_lengkap'] ?? 'Pengguna') ?></strong>
                                <small style="color: #5c6c75; float: right;"><?= date('d M H:i', strtotime($k['created_at'])) ?></small>
                                <p style="margin-top: 5px; font-size: 14px;"><?= esc($k['isi']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; color: #5c6c75; font-size: 14px;">Belum ada tanggapan.</p>
                    <?php endif; ?>
                </div>

                <form action="/pengaduan/komentar/<?= esc($id ?? 0) ?>" method="POST">
                    <textarea name="isi" required placeholder="Tuliskan pertanyaan atau tambahan info..." style="width: 100%; padding: 12px; border: 1px solid var(--silver-teal); border-radius: 8px; font-family: inherit; margin-bottom: 10px; resize: vertical; min-height: 80px;"></textarea>
                    <button type="submit" class="btn btn-green" style="width: 100%;">Kirim Komentar</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?= $this->include('layout/footer') ?>