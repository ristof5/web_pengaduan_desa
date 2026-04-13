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

    body { background: #f0f3f5; color: #001e2b; }

    .operator-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        min-height: 100vh;
    }

    /* Sidebar Operator */
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
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 30px; padding-bottom: 20px;
        border-bottom: 1px solid var(--teal-gray); color: #fff;
    }
    .sidebar a {
        display: block; padding: 12px 15px; color: var(--silver-teal);
        text-decoration: none; border-radius: 8px; margin-bottom: 5px;
        transition: all 0.2s;
    }
    .sidebar a:hover, .sidebar a.active {
        background: rgba(0, 237, 100, 0.1); color: var(--mongodb-green); font-weight: 500;
    }

    .content { padding: 40px; }

    .btn {
        padding: 10px 20px; border-radius: 100px; text-decoration: none;
        font-weight: 600; font-size: 14px; display: inline-block; border: none; cursor: pointer;
    }
    .btn-outline { border: 1px solid var(--teal-gray); color: var(--forest-black); }
    .btn-green { background: var(--dark-green); color: #fff; }
    .btn-blue { background: var(--action-blue); color: #fff; }

    .card {
        background: #fff; border-radius: 12px; border: 1px solid var(--silver-teal);
        box-shadow: var(--forest-shadow); padding: 30px; margin-bottom: 30px;
    }

    .badge {
        padding: 6px 12px; border-radius: 100px; font-size: 12px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 1px; font-family: 'Source Code Pro', monospace;
    }
    .badge-menunggu { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-diproses { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .badge-selesai { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-ditolak { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 24px; }
    .info-item label { display: block; font-size: 12px; color: #5c6c75; margin-bottom: 4px; text-transform: uppercase; }
    .info-item .value { font-weight: 600; font-size: 15px; }
    
    .deskripsi-box { background: #f9fbfa; padding: 20px; border-radius: 8px; border: 1px solid #e8edeb; line-height: 1.6; }
    
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; }
    .form-control { width: 100%; padding: 12px; border: 1px solid var(--silver-teal); border-radius: 8px; font-family: inherit; }
    
    .comment-item { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e8edeb; }
    .comment-internal { background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; }
</style>

<?php
// Fallback Variabel
$id = $pengaduan['id'] ?? 0;
$tiket = $pengaduan['kode_tiket'] ?? 'SKS-XXXX';
$judul = $pengaduan['judul'] ?? 'Memuat...';
$deskripsi = $pengaduan['deskripsi'] ?? '-';
$status = $pengaduan['status'] ?? 'menunggu';
$tanggal = isset($pengaduan['created_at']) ? date('d M Y H:i', strtotime($pengaduan['created_at'])) : '-';
$lokasi = $pengaduan['lokasi'] ?? '-';
$kategori = $pengaduan['nama_kategori'] ?? 'Umum';
$pelapor = $pengaduan['nama_pelapor'] ?? 'Anonim';
?>

<div class="operator-layout">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div style="width: 30px; height: 30px; background: var(--mongodb-green); border-radius: 6px;"></div>
            <strong>SUKASARI <span style="font-weight:300;">ADMIN</span></strong>
        </div>
        <a href="/operator/dashboard">📊 Dashboard</a>
        <a href="/operator/pengaduan" class="active">📋 Kelola Pengaduan</a>
        <a href="/operator/kategori">🏷️ Kelola Kategori</a>
        <a href="/operator/pengguna">👥 Kelola Pengguna</a>
        <a href="/auth/logout" style="color: #ff4d4f; margin-top: 20px;">🚪 Keluar</a>
    </div>

    <div class="content">
        <a href="/operator/pengaduan" class="btn btn-outline" style="margin-bottom: 20px;">← Kembali ke Daftar</a>

        <?php if(session()->getFlashdata('success')): ?>
            <div style="background: var(--dark-green); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div style="background: #ff4d4f; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <div>
                <div class="card">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px; border-bottom: 1px solid var(--silver-teal); padding-bottom: 20px;">
                        <div>
                            <p style="font-family: 'Source Code Pro'; color: var(--action-blue); font-size: 14px; margin-bottom: 5px;">#<?= esc($tiket) ?></p>
                            <h2 style="font-size: 24px;"><?= esc($judul) ?></h2>
                        </div>
                        <div>
                            <span class="badge badge-<?= strtolower($status) ?>"><?= esc($status) ?></span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nama Pelapor</label>
                            <div class="value"><?= esc($pelapor) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Tanggal & Waktu</label>
                            <div class="value"><?= esc($tanggal) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Kategori</label>
                            <div class="value"><?= esc($kategori) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Lokasi</label>
                            <div class="value"><?= esc($lokasi) ?></div>
                        </div>
                    </div>

                    <div class="info-item" style="margin-bottom: 10px;"><label>Deskripsi Laporan</label></div>
                    <div class="deskripsi-box">
                        <?= nl2br(esc($deskripsi)) ?>
                    </div>
                </div>

                <div class="card" id="komentar">
                    <h3 style="margin-bottom: 20px; font-size: 18px;">Diskusi & Catatan Internal</h3>
                    
                    <div style="margin-bottom: 24px;">
                        <?php if(!empty($komentar)): ?>
                            <?php foreach($komentar as $k): ?>
                                <?php $isInternal = isset($k['is_internal']) && $k['is_internal'] == 1; ?>
                                <div class="comment-item <?= $isInternal ? 'comment-internal' : '' ?>">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <strong><?= esc($k['nama_lengkap'] ?? 'User') ?> <?= $isInternal ? '<span style="color:#856404; font-size:12px;">(Internal Only)</span>' : '' ?></strong>
                                        <small style="color: #5c6c75;"><?= date('d M H:i', strtotime($k['created_at'])) ?></small>
                                    </div>
                                    <p style="font-size: 14px; line-height: 1.5; margin: 0;"><?= nl2br(esc($k['isi'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: #5c6c75; font-size: 14px; text-align: center;">Belum ada diskusi.</p>
                        <?php endif; ?>
                    </div>

                    <form action="/operator/pengaduan/komentar/<?= esc($id) ?>" method="POST">
                        <div class="form-group">
                            <textarea name="isi" required class="form-control" rows="3" placeholder="Tulis tanggapan atau catatan..."></textarea>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 14px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="is_internal" value="1"> Jadikan Catatan Internal (Warga tidak bisa melihat)
                            </label>
                            <button type="submit" class="btn btn-blue">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="card" style="background: var(--forest-black); color: #fff; border: none;">
                    <h3 style="margin-bottom: 20px; font-size: 18px; color: var(--mongodb-green);">Update Status</h3>
                    <form action="/operator/pengaduan/status/<?= esc($id) ?>" method="POST">
                        <div class="form-group">
                            <select name="status" class="form-control" style="background: #1c2d38; color: #fff; border-color: var(--teal-gray);">
                                <option value="menunggu" <?= $status == 'menunggu' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                                <option value="diproses" <?= $status == 'diproses' ? 'selected' : '' ?>>Sedang Diproses</option>
                                <option value="selesai" <?= $status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="ditolak" <?= $status == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-green" style="width: 100%;">Simpan Status</button>
                    </form>
                </div>

                <div class="card">
                    <h3 style="margin-bottom: 20px; font-size: 16px;">Log Aktivitas</h3>
                    <div style="border-left: 2px solid var(--silver-teal); margin-left: 10px; padding-left: 20px;">
                        <?php if(!empty($status_log)): ?>
                            <?php foreach($status_log as $log): ?>
                            <div style="position: relative; margin-bottom: 15px;">
                                <div style="position: absolute; left: -27px; top: 0; width: 12px; height: 12px; border-radius: 50%; background: var(--action-blue);"></div>
                                <strong style="font-size: 13px; display: block; text-transform: uppercase;"><?= esc($log['status_baru']) ?></strong>
                                <small style="color: #5c6c75;"><?= date('d M Y H:i', strtotime($log['created_at'])) ?></small>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="font-size: 13px; color: #5c6c75;">Belum ada log aktivitas.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->include('layout/footer') ?>