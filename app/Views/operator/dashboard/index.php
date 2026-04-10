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
    }

    .sidebar-brand-icon {
        width: 40px;
        height: 40px;
        background: var(--mongodb-green);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-brand-text {
        color: #fff;
        font-weight: 600;
        font-size: 14px;
    }

    .sidebar-menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-menu-item {
        margin-bottom: 8px;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        color: #b8c4c2;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s;
        font-size: 14px;
        font-weight: 500;
    }

    .sidebar-menu-link:hover,
    .sidebar-menu-link.active {
        background: #0a2f42;
        color: var(--mongodb-green);
    }

    .sidebar-menu-link.active {
        border-left: 3px solid var(--mongodb-green);
        padding-left: 13px;
    }

    .main-content {
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    .top-bar {
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .top-bar-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--forest-black);
    }

    .top-bar-user {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--mongodb-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--forest-black);
        font-weight: 700;
        font-size: 16px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--forest-black);
    }

    .user-role {
        font-size: 12px;
        color: #5c6c75;
    }

    .content {
        padding: 30px;
        flex: 1;
        overflow-y: auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
    }

    .stat-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-label {
        font-size: 12px;
        color: #5c6c75;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 8px;
        font-family: 'Source Code Pro', monospace;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--mongodb-green);
        margin-bottom: 4px;
    }

    .stat-desc {
        font-size: 12px;
        color: #999;
    }

    .section {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--forest-black);
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: var(--dark-green);
        color: #fff;
    }

    .btn-primary:hover {
        background: var(--mongodb-green);
        color: var(--forest-black);
    }

    .btn-secondary {
        background: transparent;
        color: var(--forest-black);
        border: 1px solid #e0e0e0;
    }

    .btn-secondary:hover {
        background: #f5f5f5;
    }

    @media (max-width: 768px) {
        .operator-layout {
            grid-template-columns: 1fr;
        }

        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            height: 100%;
            z-index: 999;
            transition: left 0.3s;
        }

        .sidebar.active {
            left: 0;
        }
    }
</style>

<div class="operator-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#001e2b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7zm0 9a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                </svg>
            </div>
            <div class="sidebar-brand-text">OPERATOR</div>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="/operator" class="sidebar-menu-link active">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="/operator/pengaduan" class="sidebar-menu-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kelola Pengaduan
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="/operator/kategori" class="sidebar-menu-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Kategori
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="/operator/pengguna" class="sidebar-menu-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Kelola Pengguna
                </a>
            </li>
            <li class="sidebar-menu-item" style="border-top: 1px solid var(--teal-gray); padding-top: 10px; margin-top: 10px;">
                <a href="/auth/logout" class="sidebar-menu-link" style="color: #ff6b6b;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1 class="top-bar-title">Dashboard</h1>
            <div class="top-bar-user">
                <div class="user-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
                <div class="user-info">
                    <div class="user-name"><?= $user['name'] ?></div>
                    <div class="user-role">Operator</div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <!-- ALERT -->
            <?php if (session()->getFlashdata('success')): ?>
                <div style="background: #d4edda; border-left: 4px solid #00ed64; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div style="background: #f8d7da; border-left: 4px solid #ff6b6b; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">📥 Pengaduan Masuk</div>
                    <div class="stat-value">247</div>
                    <div class="stat-desc">Total laporan yang masuk</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">⏳ Dalam Proses</div>
                    <div class="stat-value" style="color: var(--action-blue);">28</div>
                    <div class="stat-desc">Menunggu penanganan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">✅ Selesai</div>
                    <div class="stat-value" style="color: #00a86b;">219</div>
                    <div class="stat-desc">Pengaduan yang ditangani</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">⚡ Respon Cepat</div>
                    <div class="stat-value" style="color: var(--mongodb-green);">89%</div>
                    <div class="stat-desc">Penyelesaian tepat waktu</div>
                </div>
            </div>

            <!-- SECTION: RECENT COMPLAINTS -->
            <div class="section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 class="section-title" style="margin: 0;">Pengaduan Terbaru</h2>
                    <a href="/operator/pengaduan" class="btn btn-primary">Lihat Semua</a>
                </div>

                <div style="background: #f9fbfa; border-radius: 8px; padding: 20px; text-align: center; color: #999;">
                    <p style="margin: 0;">📭 Tidak ada data pengaduan</p>
                    <small>Data pengaduan akan ditampilkan di sini</small>
                </div>
            </div>

            <!-- SECTION: QUICK ACTIONS -->
            <div class="section">
                <h2 class="section-title">Aksi Cepat</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                    <a href="/operator/pengaduan" class="btn btn-primary" style="text-align: center;">
                        📋 Kelola Pengaduan
                    </a>
                    <a href="/operator/kategori" class="btn btn-primary" style="text-align: center;">
                        🏷️ Kelola Kategori
                    </a>
                    <a href="/operator/pengguna" class="btn btn-primary" style="text-align: center;">
                        👥 Kelola Pengguna
                    </a>
                    <button class="btn btn-secondary" style="text-align: center;">
                        📊 Lihat Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>