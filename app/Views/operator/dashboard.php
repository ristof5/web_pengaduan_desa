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
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--teal-gray);
        color: #fff;
    }

    .sidebar a {
        display: block;
        padding: 12px 15px;
        color: var(--silver-teal);
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.2s;
    }

    .sidebar a:hover, .sidebar a.active {
        background: rgba(0, 237, 100, 0.1);
        color: var(--mongodb-green);
        font-weight: 500;
    }

    /* Area Konten */
    .content { padding: 40px; }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--silver-teal);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .stat-card p {
        color: #5c6c75;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Source Code Pro', monospace;
        margin-bottom: 10px;
    }

    .stat-card h3 {
        font-size: 36px;
        color: var(--forest-black);
    }

    .card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--silver-teal);
        box-shadow: var(--forest-shadow);
        padding: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        padding: 15px 10px;
        text-align: left;
        border-bottom: 1px solid #e8edeb;
    }

    th {
        font-size: 12px;
        color: #5c6c75;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .badge-menunggu { background: #fff3cd; color: #856404; }
    .badge-diproses { background: #cce5ff; color: #004085; }
    .badge-selesai { background: #d4edda; color: #155724; }
    .badge-ditolak { background: #f8d7da; color: #721c24; }
</style>

<div class="operator-layout">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div style="width: 30px; height: 30px; background: var(--mongodb-green); border-radius: 6px;"></div>
            <strong>SUKASARI <span style="font-weight:300;">ADMIN</span></strong>
        </div>
        <a href="/operator/dashboard" class="active">📊 Dashboard</a>
        <a href="/operator/pengaduan">📋 Kelola Pengaduan</a>
        <a href="/operator/kategori">🏷️ Kelola Kategori</a>
        <a href="/operator/pengguna">👥 Kelola Pengguna</a>
        <a href="/auth/logout" style="color: #ff4d4f; margin-top: 20px;">🚪 Keluar</a>
    </div>

    <div class="content">
        <h1 style="margin-bottom: 24px;">Dashboard Overview</h1>

        <div class="stat-grid">
            <div class="stat-card" style="border-bottom: 4px solid var(--mongodb-green);">
                <p>Total Pengaduan</p>
                <h3><?= esc($stat['total'] ?? 0) ?></h3>
            </div>
            <div class="stat-card" style="border-bottom: 4px solid #ffc107;">
                <p>Menunggu</p>
                <h3><?= esc($stat['menunggu'] ?? 0) ?></h3>
            </div>
            <div class="stat-card" style="border-bottom: 4px solid var(--action-blue);">
                <p>Diproses</p>
                <h3><?= esc($stat['diproses'] ?? 0) ?></h3>
            </div>
            <div class="stat-card" style="border-bottom: 4px solid var(--dark-green);">
                <p>Selesai</p>
                <h3><?= esc($stat['selesai'] ?? 0) ?></h3>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 18px;">Laporan Terbaru</h2>
                    <a href="/operator/pengaduan" style="color: var(--action-blue); font-size: 14px; text-decoration: none;">Lihat Semua &rarr;</a>
                </div>
                
                <?php if(!empty($terbaru)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tiket</th>
                            <th>Pelapor</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($terbaru as $row): ?>
                        <tr>
                            <td style="font-family: 'Source Code Pro', monospace; color: var(--action-blue);">
                                <a href="/operator/pengaduan/<?= $row['id'] ?>" style="color: inherit; text-decoration: none;">#<?= esc($row['kode_tiket']) ?></a>
                            </td>
                            <td><?= esc($row['nama_pelapor']) ?></td>
                            <td><?= esc($row['nama_kategori']) ?></td>
                            <td><span class="badge badge-<?= strtolower($row['status']) ?>"><?= esc($row['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p style="text-align: center; color: #5c6c75; padding: 30px 0;">Belum ada laporan terbaru.</p>
                <?php endif; ?>
            </div>

            <div class="card">
                <h2 style="font-size: 18px; margin-bottom: 20px;">Insight Desa</h2>
                
                <div style="margin-bottom: 20px;">
                    <p style="color: #5c6c75; font-size: 12px; text-transform: uppercase;">Warga Terdaftar</p>
                    <h3 style="font-size: 28px; color: var(--forest-black);"><?= esc($totalWarga ?? 0) ?> <span style="font-size: 14px; font-weight: normal;">Akun</span></h3>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <p style="color: #5c6c75; font-size: 12px; text-transform: uppercase;">Rata-rata Penanganan</p>
                    <h3 style="font-size: 28px; color: var(--forest-black);"><?= esc($rataRata ?? 0) ?> <span style="font-size: 14px; font-weight: normal;">Hari</span></h3>
                </div>

                <hr style="border: 0; border-top: 1px solid #e8edeb; margin: 20px 0;">

                <h3 style="font-size: 14px; margin-bottom: 15px; color: #5c6c75; text-transform: uppercase;">Distribusi Kategori</h3>
                <?php if(!empty($perKategori)): ?>
                    <?php foreach($perKategori as $kat): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                            <span><?= esc($kat['nama'] ?? $kat['nama_kategori'] ?? 'Kategori') ?></span>
                            <strong style="background: #e8edeb; padding: 2px 8px; border-radius: 4px;"><?= esc($kat['total'] ?? 0) ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="font-size: 13px; color: #5c6c75;">Data belum tersedia.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->include('layout/footer') ?>