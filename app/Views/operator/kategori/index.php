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
    .btn-danger { background: #ff4d4f; color: #fff; }
    .btn-sm { padding: 6px 14px; font-size: 12px; }

    /* Forms */
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 12px; color: #5c6c75; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; padding: 12px; border: 1px solid var(--silver-teal); border-radius: 6px; font-family: inherit; }
    .form-control:focus { outline: none; border-color: var(--action-blue); box-shadow: 0 0 0 3px rgba(0, 108, 250, 0.1); }

    /* Tables */
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 15px 10px; text-align: left; border-bottom: 1px solid #e8edeb; }
    th { font-size: 12px; color: #5c6c75; text-transform: uppercase; letter-spacing: 1px; }
    td { font-size: 14px; vertical-align: top; }
    
    .badge {
        padding: 6px 12px; border-radius: 100px; font-size: 11px; font-weight: 600;
        text-transform: uppercase; font-family: 'Source Code Pro', monospace;
    }
    .badge-aktif { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-nonaktif { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .code-text { font-family: 'Source Code Pro', monospace; color: var(--action-blue); }

    /* Grid Layout */
    .page-grid { display: grid; grid-template-columns: 350px 1fr; gap: 30px; align-items: start; }
</style>

<div class="operator-layout">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div style="width: 30px; height: 30px; background: var(--mongodb-green); border-radius: 6px;"></div>
            <strong>SUKASARI <span style="font-weight:300;">ADMIN</span></strong>
        </div>
        <a href="/operator/dashboard">📊 Dashboard</a>
        <a href="/operator/pengaduan">📋 Kelola Pengaduan</a>
        <a href="/operator/kategori" class="active">🏷️ Kelola Kategori</a>
        <a href="/operator/pengguna">👥 Kelola Pengguna</a>
        <a href="/auth/logout" style="color: #ff4d4f; margin-top: 20px;">🚪 Keluar</a>
    </div>

    <div class="content">
        <h1 style="margin-bottom: 24px;">Kategori Laporan</h1>

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
        <?php if(!empty($errors)): ?>
            <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 20px;">
                <ul style="margin-left: 20px; font-size: 14px;">
                    <?php foreach($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="page-grid">
            <div class="card" id="form-container" style="background: var(--forest-black); color: #fff; border: none;">
                <h3 id="form-title" style="margin-bottom: 20px; font-size: 18px; color: var(--mongodb-green);">Tambah Kategori Baru</h3>
                
                <form id="kategori-form" action="/operator/kategori/simpan" method="POST">
                    <div class="form-group">
                        <label style="color: var(--silver-teal);">Nama Kategori</label>
                        <input type="text" id="input-nama" name="nama" class="form-control" required placeholder="Contoh: Infrastruktur" style="background: #1c2d38; color: #fff; border-color: var(--teal-gray);">
                    </div>
                    
                    <div class="form-group">
                        <label style="color: var(--silver-teal);">Deskripsi (Opsional)</label>
                        <textarea id="input-deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..." style="background: #1c2d38; color: #fff; border-color: var(--teal-gray);"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label style="color: var(--silver-teal);">Urutan Tampil</label>
                            <input type="number" id="input-urutan" name="urutan" class="form-control" value="99" style="background: #1c2d38; color: #fff; border-color: var(--teal-gray);">
                        </div>
                        <div class="form-group">
                            <label style="color: var(--silver-teal);">Status</label>
                            <div style="padding-top: 10px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #fff; font-size: 14px; text-transform: none;">
                                    <input type="checkbox" id="input-aktif" name="aktif" value="1" checked>
                                    Kategori Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 10px; display: flex; gap: 10px;">
                        <button type="submit" id="btn-submit" class="btn btn-green" style="flex: 1;">Simpan Data</button>
                        <button type="button" id="btn-batal" class="btn btn-outline" style="display: none; background: #fff;" onclick="resetForm()">Batal</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <?php if(!empty($kategori)): ?>
                <table>
                    <thead>
                        <tr>
                            <th width="80">Urutan</th>
                            <th>Nama Kategori</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($kategori as $kat): ?>
                        <tr>
                            <td class="code-text"><?= esc($kat['urutan'] ?? 99) ?></td>
                            <td>
                                <strong style="display: block; margin-bottom: 4px;"><?= esc($kat['nama'] ?? $kat['nama_kategori']) ?></strong>
                                <span style="font-size: 12px; color: #5c6c75;"><?= esc($kat['deskripsi'] ?? '-') ?></span>
                            </td>
                            <td>
                                <?php $isAktif = isset($kat['aktif']) ? $kat['aktif'] : 1; ?>
                                <span class="badge badge-<?= $isAktif ? 'aktif' : 'nonaktif' ?>">
                                    <?= $isAktif ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline btn-sm" 
                                    onclick="editKategori(
                                        <?= $kat['id'] ?>, 
                                        '<?= esc(addslashes($kat['nama'] ?? $kat['nama_kategori'])) ?>', 
                                        '<?= esc(addslashes($kat['deskripsi'] ?? '')) ?>', 
                                        <?= $kat['urutan'] ?? 99 ?>, 
                                        <?= $isAktif ?>
                                    )">Edit</button>

                                <form action="/operator/kategori/hapus/<?= $kat['id'] ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Anda yakin ingin menghapus kategori ini? Pastikan tidak ada pengaduan yang menggunakan kategori ini.');">
                                    <button type="submit" class="btn btn-danger btn-sm" style="border: none; border-radius: 100px;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div style="text-align: center; padding: 30px;">
                        <p style="color: #5c6c75;">Belum ada kategori pengaduan yang ditambahkan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function editKategori(id, nama, deskripsi, urutan, aktif) {
        // Ubah Judul & Action Form
        document.getElementById('form-title').innerText = 'Edit Kategori';
        document.getElementById('kategori-form').action = '/operator/kategori/update/' + id;
        
        // Isi Value Input
        document.getElementById('input-nama').value = nama;
        document.getElementById('input-deskripsi').value = deskripsi;
        document.getElementById('input-urutan').value = urutan;
        document.getElementById('input-aktif').checked = (aktif == 1);
        
        // Sesuaikan Tombol
        document.getElementById('btn-submit').innerText = 'Update Data';
        document.getElementById('btn-batal').style.display = 'block';

        // Scroll ke atas (opsional jika list panjang)
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        // Kembalikan ke mode Tambah
        document.getElementById('form-title').innerText = 'Tambah Kategori Baru';
        document.getElementById('kategori-form').action = '/operator/kategori/simpan';
        document.getElementById('kategori-form').reset();
        
        // Sesuaikan Tombol
        document.getElementById('btn-submit').innerText = 'Simpan Data';
        document.getElementById('btn-batal').style.display = 'none';
        document.getElementById('input-aktif').checked = true;
    }
</script>

<?= $this->include('layout/footer') ?>