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

    .masyarakat-layout {
        display: grid; grid-template-columns: 250px 1fr; min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        background: var(--forest-black); border-right: 1px solid var(--teal-gray);
        padding: 20px; position: sticky; top: 0; height: 100vh; overflow-y: auto;
    }
    .sidebar-brand {
        display: flex; align-items: center; gap: 10px; margin-bottom: 30px;
        padding-bottom: 20px; border-bottom: 1px solid var(--teal-gray);
    }
    .sidebar-brand-icon {
        width: 40px; height: 40px; background: var(--mongodb-green); border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }
    .sidebar-brand-text { color: #fff; font-weight: 600; font-size: 14px; }
    
    .sidebar-menu { list-style: none; margin: 0; padding: 0; }
    .sidebar-menu-item { margin-bottom: 8px; }
    .sidebar-menu-link {
        display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #b8c4c2;
        text-decoration: none; border-radius: 8px; transition: all 0.3s; font-size: 14px; font-weight: 500;
    }
    .sidebar-menu-link:hover, .sidebar-menu-link.active {
        background: #0a2f42; color: var(--mongodb-green);
    }
    .sidebar-menu-link.active { border-left: 3px solid var(--mongodb-green); padding-left: 13px; }

    /* Layout Utama */
    .main-content { padding: 0; display: flex; flex-direction: column; }
    
    .top-bar {
        background: #fff; border-bottom: 1px solid #e0e0e0; padding: 20px 30px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .top-bar-title { font-size: 24px; font-weight: 600; color: var(--forest-black); }
    
    .top-bar-user { display: flex; align-items: center; gap: 15px; }
    .user-avatar {
        width: 40px; height: 40px; background: var(--mongodb-green); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: var(--forest-black);
        font-weight: 700; font-size: 16px;
    }
    .user-info { display: flex; flex-direction: column; gap: 2px; }
    .user-name { font-size: 14px; font-weight: 600; color: var(--forest-black); }
    .user-role { font-size: 12px; color: #5c6c75; }

    .content { padding: 30px; flex: 1; overflow-y: auto; }
    
    .section {
        background: #fff; border: 1px solid #e0e0e0; border-radius: 12px;
        padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .section-title { font-size: 18px; font-weight: 600; color: var(--forest-black); }

    .btn {
        padding: 10px 20px; border-radius: 8px; border: none; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-block;
    }
    .btn-primary { background: var(--dark-green); color: #fff; }
    .btn-primary:hover { background: var(--mongodb-green); color: var(--forest-black); }
    .btn-outline { background: transparent; border: 1px solid var(--teal-gray); color: var(--forest-black); border-radius: 100px; padding: 6px 16px; }
    .btn-outline:hover { background: #f0f3f5; }

    .empty-state {
        background: #f9fbfa; border-radius: 8px; padding: 40px 20px; text-align: center; color: #999;
    }
    .empty-state-icon { font-size: 48px; margin-bottom: 10px; }

    /* Badge Status (Penting) */
    .badge {
        display: inline-block; padding: 6px 12px; border-radius: 100px; font-size: 11px;
        font-weight: 600; text-transform: uppercase; font-family: 'Source Code Pro', monospace;
    }
    .badge-menunggu { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-diproses { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .badge-selesai { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-ditolak { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    /* Card Pengaduan */
    .ticket-card {
        border: 1px solid var(--silver-teal); border-radius: 8px; padding: 20px;
        display: flex; justify-content: space-between; align-items: center; background: #fff; margin-bottom: 15px;
    }
    .ticket-card:hover { border-color: var(--mongodb-green); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }

    @media (max-width: 768px) {
        .masyarakat-layout { grid-template-columns: 1fr; }
        .sidebar { position: fixed; left: -250px; top: 0; height: 100%; z-index: 999; transition: left 0.3s; }
        .sidebar.active { left: 0; }
        .ticket-card { flex-direction: column; align-items: flex-start; gap: 15px; }
        .ticket-card > div:last-child { text-align: left; width: 100%; }
    }
</style>

<div class="masyarakat-layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#001e2b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7zm0 9a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                </svg>
            </div>
            <div class="sidebar-brand-text">SUKASARI DIGITAL</div>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="/pengaduan" class="sidebar-menu-link active">📋 Pengaduan Saya</a>
            </li>
            <li class="sidebar-menu-item">
                <a href="/pengaduan/buat" class="sidebar-menu-link">➕ Buat Pengaduan Baru</a>
            </li>
            <li class="sidebar-menu-item" style="border-top: 1px solid var(--teal-gray); padding-top: 10px; margin-top: 10px;">
                <a href="/auth/logout" class="sidebar-menu-link" style="color: #ff6b6b;">🚪 Logout</a>
            </li>
        </ul>
    </aside>

    <div class="main-content">
        <div class="top-bar">
            <h1 class="top-bar-title">Pengaduan Saya</h1>
            <div class="top-bar-user">
                <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?></div>
                <div class="user-info">
                    <div class="user-name"><?= esc($user['name'] ?? $user['nama_lengkap'] ?? 'Warga') ?></div>
                    <div class="user-role">Masyarakat</div>
                </div>
            </div>
        </div>

        <div class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div style="background: #d4edda; border-left: 4px solid #00ed64; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div style="background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 class="section-title" style="margin: 0;">Daftar Laporan Anda</h2>
                    <a href="/pengaduan/buat" class="btn btn-primary">+ Buat Baru</a>
                </div>

                <?php if(!empty($pengaduan)): ?>
                    <div style="display: grid; gap: 15px;">
                        <?php foreach($pengaduan as $item): ?>
                            <div class="ticket-card">
                                <div>
                                    <div style="font-family: 'Source Code Pro', monospace; color: var(--action-blue); font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                                        #<?= esc($item['kode_tiket'] ?? 'SKS-XXXX') ?>
                                    </div>
                                    <h3 style="font-size: 16px; margin-bottom: 5px; color: var(--forest-black);"><?= esc($item['judul']) ?></h3>
                                    <div style="font-size: 13px; color: #5c6c75;">
                                        🗓️ <?= date('d M Y, H:i', strtotime($item['created_at'])) ?> &nbsp;&bull;&nbsp; 🏷️ <?= esc($item['nama_kategori'] ?? 'Umum') ?>
                                    </div>
                                </div>
                                <div style="text-align: right; display: flex; flex-direction: column; gap: 10px; align-items: flex-end;">
                                    <?php 
                                        $statusClass = strtolower($item['status'] ?? 'menunggu');
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>">
                                        <?= esc($item['status'] ?? 'Menunggu') ?>
                                    </span>
                                    
                                    <a href="/pengaduan/detail/<?= $item['id'] ?>" class="btn btn-outline">Lihat Detail &rarr;</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <p style="margin: 0 0 5px 0;"><strong>Belum ada pengaduan</strong></p>
                        <small>Mulai buat laporan Anda sekarang untuk membantu perbaikan desa Sukasari</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>