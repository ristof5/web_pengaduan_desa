<?= $this->include('layout/header') ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --forest-black: #001e2b;
        --mongodb-green: #00ed64;
        --dark-green: #00684a;
        --action-blue: #006cfa;
        --teal-gray: #3d4f58;
        --silver-teal: #b8c4c2;
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

    .form-container {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 30px;
        max-width: 800px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .form-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--forest-black);
    }

    .form-subtitle {
        font-size: 14px;
        color: #999;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--forest-black);
    }

    .form-label .required {
        color: #ff6b6b;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--mongodb-green);
        box-shadow: 0 0 0 3px rgba(0, 237, 100, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-hint {
        font-size: 12px;
        color: #999;
        margin-top: 4px;
    }

    .file-upload {
        position: relative;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }

    .file-upload:hover {
        border-color: var(--mongodb-green);
        background: rgba(0, 237, 100, 0.02);
    }

    .file-upload input[type="file"] {
        display: none;
    }

    .file-upload-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .file-upload-text {
        font-size: 13px;
        color: #999;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: var(--dark-green);
        color: #fff;
        flex: 1;
    }

    .btn-primary:hover {
        background: var(--mongodb-green);
        color: var(--forest-black);
    }

    .btn-secondary {
        background: transparent;
        color: #999;
        border: 1px solid #e0e0e0;
        flex: 1;
    }

    .btn-secondary:hover {
        background: #f5f5f5;
    }

    @media (max-width: 768px) {
        .masyarakat-layout {
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

<div class="masyarakat-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#001e2b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7zm0 9a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
                </svg>
            </div>
            <div class="sidebar-brand-text">PENGADUAN</div>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="/pengaduan" class="sidebar-menu-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Pengaduan Saya
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="/pengaduan/buat" class="sidebar-menu-link active">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Buat Pengaduan Baru
                </a>
            </li>
            <li class="sidebar-menu-item" style="border-top: 1px solid var(--teal-gray); padding-top: 10px; margin-top: 10px;">
                <a href="/auth/logout" class="sidebar-menu-link" style="color: #ff6b6b;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
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
            <h1 class="top-bar-title">Buat Pengaduan Baru</h1>
            <div class="top-bar-user">
                <div class="user-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
                <div class="user-info">
                    <div class="user-name"><?= $user['name'] ?></div>
                    <div class="user-role">Masyarakat</div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <div class="form-container">
                <h2 class="form-title">Form Pengaduan</h2>
                <p class="form-subtitle">Sampaikan laporan Anda dengan detail yang jelas agar dapat ditangani dengan baik.</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div style="background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div style="background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/pengaduan/buat" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label class="form-label">
                            Kategori Pengaduan <span class="required">*</span>
                        </label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="1">Jalan & Infrastruktur</option>
                            <option value="2">Sampah & Kebersihan</option>
                            <option value="3">Keamanan & Ketertiban</option>
                            <option value="4">Administrasi & Pelayanan</option>
                            <option value="5">Fasilitas Umum</option>
                            <option value="6">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Judul Pengaduan <span class="required">*</span>
                        </label>
                        <input type="text" name="judul" class="form-input" placeholder="Contoh: Jalan di Jl. Raya Sukasari berlubang" required value="<?= old('judul') ?>">
                        <p class="form-hint">Berikan judul singkat yang menggambarkan masalah Anda</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Deskripsi Detail <span class="required">*</span>
                        </label>
                        <textarea name="deskripsi" class="form-textarea" placeholder="Jelaskan masalah secara detail, lokasi tepatnya, dan dampak yang dirasakan..." required><?= old('deskripsi') ?></textarea>
                        <p class="form-hint">Semakin detail, semakin cepat kami dapat menangani</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Lokasi <span class="required">*</span>
                        </label>
                        <input type="text" name="lokasi" class="form-input" placeholder="Contoh: Jl. Raya Sukasari RT 001/002" required value="<?= old('lokasi') ?>">
                        <p class="form-hint">Lokasi kejadian atau area yang dimaksud</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Tingkat Prioritas <span class="required">*</span>
                        </label>
                        <select name="prioritas" class="form-select" required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="rendah">Rendah (Non-urgent)</option>
                            <option value="sedang">Sedang (Perlu ditangani)</option>
                            <option value="tinggi">Tinggi (Sangat urgent)</option>
                        </select>
                        <p class="form-hint">Berdasarkan urgensi masalah yang dilaporkan</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Foto Bukti (Opsional)
                        </label>
                        <label class="file-upload">
                            <div class="file-upload-icon">📸</div>
                            <input type="file" name="foto[]" accept="image/*" multiple>
                            <div class="file-upload-text">
                                <strong>Klik atau drag foto di sini</strong><br>
                                <small>Format: JPG, PNG | Max: 3MB per foto (Bisa pilih maksimal 3)</small>
                            </div>
                        </label>
                        <p class="form-hint">Foto bukti akan membantu verifikasi masalah Anda</p>
                    </div>

                    <div class="form-actions">
                        <a href="/pengaduan" class="btn btn-secondary" style="text-align: center;">Batal</a>
                        <button type="submit" class="btn btn-primary">✓ Kirim Pengaduan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>