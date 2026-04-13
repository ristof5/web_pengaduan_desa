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
        font-weight: 600; font-size: 14px; display: inline-block; border: none; cursor: pointer;
    }
    .btn-green { background: var(--dark-green); color: #fff; }
    .btn-outline { background: transparent; border: 1px solid var(--silver-teal); color: #001e2b; }
    .btn-sm { padding: 6px 14px; font-size: 12px; }

    /* Filter Form */
    .filter-grid {
        display: grid; grid-template-columns: 1fr 1fr 1fr auto auto; gap: 15px; align-items: end;
    }
    .form-group label { display: block; font-size: 12px; color: #5c6c75; margin-bottom: 6px; text-transform: uppercase; }
    .form-control { width: 100%; padding: 10px; border: 1px solid var(--silver-teal); border-radius: 6px; font-family: inherit; }

    /* Table Styles */
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 14px 10px; text-align: left; border-bottom: 1px solid #e8edeb; }
    th { font-size: 12px; color: #5c6c75; text-transform: uppercase; letter-spacing: 1px; }
    td { font-size: 14px; }
    tr:hover { background-color: #f9fbfa; }

    .badge {
        padding: 6px 10px; border-radius: 100px; font-size: 11px; font-weight: 600;
        text-transform: uppercase; font-family: 'Source Code Pro', monospace;
    }
    .badge-menunggu { background: #fff3cd; color: #856404; }
    .badge-diproses { background: #cce5ff; color: #004085; }
    .badge-selesai { background: #d4edda; color: #155724; }
    .badge-ditolak { background: #f8d7da; color: #721c24; }
    
    .badge-prioritas-tinggi { background: #ffebee; color: #c62828; }
    .badge-prioritas-sedang { background: #fff8e1; color: #f57f17; }
    .badge-prioritas-rendah { background: #e0f2f1; color: #00695c; }

    .ticket-id { font-family: 'Source Code Pro', monospace; color: var(--action-blue); font-weight: 600; }
</style>

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
        <h1 style="margin-bottom: 24px;">Kelola Laporan Masyarakat</h1>

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
            <form action="/operator/pengaduan" method="GET" class="filter-grid">
                <div class="form-group">
                    <label>Pencarian</label>
                    <input type="text" name="cari" class="form-control" placeholder="Cari tiket, judul, pelapor..." value="<?= esc($cari ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="menunggu" <?= ($filter['status'] ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="diproses" <?= ($filter['status'] ?? '') == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="selesai" <?= ($filter['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="ditolak" <?= ($filter['status'] ?? '') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <?php if(isset($kategori)): foreach($kategori as $kat): ?>
                            <option value="<?= $kat['id'] ?>" <?= ($filter['kategori'] ?? '') == $kat['id'] ? 'selected' : '' ?>><?= esc($kat['nama_kategori'] ?? $kat['nama']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-green">Terapkan Filter</button>
                </div>
                <div class="form-group">
                    <a href="/operator/pengaduan" class="btn btn-outline">Reset</a>
                </div>
            </form>
        </div>

        <div class="card">
            <?php if(!empty($pengaduan)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Tanggal Lapor</th>
                        <th>Pelapor</th>
                        <th>Judul & Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pengaduan as $row): ?>
                    <tr>
                        <td class="ticket-id">#<?= esc($row['kode_tiket']) ?></td>
                        <td>
                            <?= date('d M Y', strtotime($row['created_at'])) ?><br>
                            <small style="color: #5c6c75;"><?= date('H:i', strtotime($row['created_at'])) ?></small>
                        </td>
                        <td>
                            <strong><?= esc($row['nama_pelapor'] ?? 'Anonim') ?></strong><br>
                            <?php if(isset($row['is_rahasia']) && $row['is_rahasia']): ?>
                                <span style="font-size: 11px; color: #c62828;">🔒 Rahasia</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong style="display:block; margin-bottom: 4px;"><?= esc($row['judul']) ?></strong>
                            <span style="font-size: 12px; color: #5c6c75;">Kategori: <?= esc($row['nama_kategori'] ?? 'Umum') ?></span>
                        </td>
                        <td>
                            <span class="badge badge-<?= strtolower($row['status']) ?>"><?= esc($row['status']) ?></span>
                            <?php if(!empty($row['prioritas'])): ?>
                                <span class="badge badge-prioritas-<?= strtolower($row['prioritas']) ?>" style="margin-top: 5px; display: inline-block;">P: <?= esc($row['prioritas']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/operator/pengaduan/<?= $row['id'] ?>" class="btn btn-outline btn-sm">Buka Detail</a>
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
                    <div style="font-size: 40px; margin-bottom: 15px;">📭</div>
                    <h3 style="color: var(--forest-black); margin-bottom: 8px;">Tidak Ada Laporan</h3>
                    <p style="color: #5c6c75; font-size: 14px;">Belum ada data pengaduan yang sesuai dengan kriteria pencarian.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->include('layout/footer') ?>