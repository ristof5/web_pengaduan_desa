<?= $this->include('layout/header') ?>

<div style="background: linear-gradient(135deg, #001e2b 0%, #0a2f42 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="width: 100%; max-width: 550px;">
        
        <!-- Logo & Title -->
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="background: #00ed64; width: 60px; height: 60px; border-radius: 12px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#001e2b" stroke-width="2">
                    <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7zm0 9a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                </svg>
            </div>
            <h1 style="color: #fff; font-size: 28px; margin: 0 0 8px; font-family: Georgia, serif;">Sukasari Digital</h1>
            <p style="color: #b8c4c2; font-size: 14px; margin: 0; letter-spacing: 2px; text-transform: uppercase; font-family: 'Source Code Pro', monospace;">Daftar Akun Baru</p>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->has('errors')): ?>
            <div style="background: #8B0000; border-left: 4px solid #ff4444; color: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                <strong>❌ Validasi Gagal:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="/auth/register" method="POST" style="background: #001e2b; border: 1px solid #1c3a4a; border-radius: 16px; padding: 40px;">

            <!-- Nama Lengkap -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 6px; font-weight: 500;">Nama Lengkap <span style="color: #ff4444;">*</span></label>
                <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ?>"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 13px; box-sizing: border-box;"
                       placeholder="Nama lengkap Anda" required>
            </div>

            <!-- Email -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 6px; font-weight: 500;">Email <span style="color: #ff4444;">*</span></label>
                <input type="email" name="email" value="<?= old('email') ?>"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 13px; box-sizing: border-box;"
                       placeholder="email@example.com" required>
            </div>

            <!-- NIK -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 6px; font-weight: 500;">NIK <span style="color: #ff4444;">*</span></label>
                <input type="text" name="nik" value="<?= old('nik') ?>"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 13px; box-sizing: border-box;"
                       placeholder="Nomor Induk Kependudukan" maxlength="16" required>
            </div>

            <!-- No HP -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 6px; font-weight: 500;">No. HP</label>
                <input type="tel" name="no_hp" value="<?= old('no_hp') ?>"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 13px; box-sizing: border-box;"
                       placeholder="08XXXXXXXXXX">
            </div>

            <!-- Alamat -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 6px; font-weight: 500;">Alamat</label>
                <textarea name="alamat" 
                          style="width: 100%; padding: 10px 14px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 13px; box-sizing: border-box; font-family: inherit; min-height: 80px; resize: vertical;"
                          placeholder="Alamat lengkap Anda"><?= old('alamat') ?></textarea>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 6px; font-weight: 500;">Password <span style="color: #ff4444;">*</span></label>
                <input type="password" name="password"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 13px; box-sizing: border-box;"
                       placeholder="Minimal 6 karakter" required>
                <small style="display: block; color: #5c6c75; margin-top: 4px;">💡 Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" style="width: 100%; background: #00ed64; color: #001e2b; border: none; padding: 12px; border-radius: 100px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; margin-top: 24px; margin-bottom: 16px;">
                ✓ Daftar Sekarang
            </button>

            <!-- Login Link -->
            <p style="color: #b8c4c2; text-align: center; font-size: 14px; margin: 0;">
                Sudah punya akun? <a href="/auth/login" style="color: #00ed64; text-decoration: none; font-weight: 600;">Masuk di sini</a>
            </p>

        </form>

    </div>
</div>

<?= $this->include('layout/footer') ?>