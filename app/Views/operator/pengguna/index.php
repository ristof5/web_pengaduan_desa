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
        background: var(--forest-black); border-right: 1px solid var(--teal-gray);
        padding: 20px; position: sticky; top: 0; height: 100vh; overflow-y: auto;
    }
    .sidebar-brand {
        display: flex; align-items: center; gap: 10px; margin-bottom: 30px; 
        padding-bottom: 20px; border-bottom: 1px solid var(--teal-gray); color: #fff;
    }
    .sidebar a {
        display: block; padding: 12px 15px; color: var(--silver-teal);
        text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: all 0.2s;
    }
    .sidebar a:hover, .sidebar a.active {
        background: rgba(0, 237, 100, 0.1); color: var(--mongodb-green); font-weight: 500;
    }

    .content { padding: 40px; }

    .card {
        background: #fff; border-radius: 12px; border: 1px solid var(--silver-teal);
        box-shadow: var(--forest-shadow); padding: 24px; margin-bottom: 24px;
    }

    .btn {
        padding: 10px 20px; border-radius: 100px; text-decoration: none;
        font-weight: 600; font-size: 14px; display: inline-block; border: none; cursor: pointer; transition: all 0.2s;
    }
    .btn-green { background: var(--dark-green); color: #fff; }
    .btn-green:hover { background: var(--mongodb-green); color: var(--forest-black); }
    .btn-outline { background: transparent; border: 1px solid var(--silver-teal); color: #001e2b; }
    .btn-outline:hover { background: #e8edeb; }
    .btn-danger { background: #ff4d4f; color: #fff; }
    .btn-sm { padding: 6px 14px; font-size: 12px; }

    /* Forms */
    .form-group { margin-bottom: 0; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--silver-teal); border-radius: 6px; font-family: inherit; }
    .filter-bar { display: flex; gap: 15px; margin-bottom: 20px; }

    /* Tables */
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 15px 10px; text-align: left; border-bottom: 1px solid #e8edeb; }
    th { font-size: 12px; color: #5c6c75; text-transform: uppercase; letter-spacing: 1px; }
    td { font-size: 14px; vertical-align: middle; }
    tr:hover { background-color: #f9fbfa; }
    
    .badge {
        padding: 6px 12px; border-radius: 100px; font-size: 11px; font-weight: 600;
        text-transform: uppercase; font-family: 'Source Code Pro', monospace;
    }
    .badge-aktif { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-nonaktif { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    
    .code-text { font-family: 'Source Code Pro', monospace; color: var(--action-blue); font-weight: 600; }
</style>

<div class="operator-layout">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div style="width: 30px; height: 30px; background: var(--mongodb-green); border-radius: 6px;"></div>
            <strong>SUKASARI <span style="font-weight:300;">ADMIN</span></strong>
        </div>
        <a href="/operator/dashboard">📊 Dashboard</a>
        <a href="/operator/pengaduan">📋 Kelola Pengaduan</a>
        <a href="/operator/kategori">🏷️ Kelola Kategori</a>
        <a href="/operator/pengguna" class="active">👥 Kelola Pengguna</a>
        <a href="/auth/logout" style="color: #ff4d4f; margin-top: 20px;">🚪 Keluar</a>
    </div>

    <div class="content">
        <h1 style="margin-bottom: 24px;">Data Masyarakat (Pengguna)</h1>

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

        <div class="card">
            <form action="/operator/pengguna" method="GET" class="filter-bar">
                <div class="form-group" style="flex: 1;">
                    <input type="text" name="cari" class="form-control" placeholder="Cari nama, email, atau NIK..." value="<?= esc($cari ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-green">Cari Pengguna</button>
                <?php if(!empty($cari)): ?>
                    <a href="/operator/pengguna" class="btn btn-outline">Reset</a>
                <?php endif; ?>
            </form>

            <?php if(!empty($pengguna)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Identitas / NIK</th>
                        <th>Kontak</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Akun</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pengguna as $row): ?>
                    <tr>
                        <td>
                            <strong style="display: block; margin-bottom: 4px; font-size: 15px;"><?= esc($row['nama_lengkap']) ?></strong>
                            <span class="code-text" style="font-size: 13px;"><?= esc($row['nik']) ?></span>
                        </td>
                        <td>
                            <div style="margin-bottom: 4px;">📧 <?= esc($row['email']) ?></div>
                            <div style="color: #5c6c75; font-size: 13px;">📞 <?= esc($row['no_hp'] ?? '-') ?></div>
                        </td>
                        <td style="color: #5c6c75;">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td>
                            <span class="badge badge-<?= strtolower($row['status']) ?>">
                                <?= esc($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <form action="/operator/pengguna/status/<?= $row['id'] ?>" method="POST" onsubmit="return confirm('Anda yakin ingin mengubah status akun ini?');">
                                <?php if($row['status'] === 'aktif'): ?>
                                    <button type="submit" class="btn btn-danger btn-sm" style="border: none; border-radius: 100px; width: 100%;">Nonaktifkan</button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-outline btn-sm" style="border-radius: 100px; width: 100%; color: var(--dark-green); border-color: var(--dark-green);">Aktifkan Akun</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <?= isset($pager) ? $pager->links('default', 'default_full') : '' ?>
            </div>

            <?php else: ?>
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="font-size: 40px; margin-bottom: 15px;">👥</div>
                    <h3 style="color: var(--forest-black); margin-bottom: 8px;">Tidak Ada Data Warga</h3>
                    <p style="color: #5c6c75; font-size: 14px;">Belum ada akun masyarakat yang terdaftar atau ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->include('layout/footer') ?>