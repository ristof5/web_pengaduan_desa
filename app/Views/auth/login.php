<?= $this->include('layout/header') ?>

<div style="background: linear-gradient(135deg, #001e2b 0%, #0a2f42 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="width: 100%; max-width: 450px;">
        
        <!-- Logo & Title -->
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="background: #00ed64; width: 60px; height: 60px; border-radius: 12px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#001e2b" stroke-width="2">
                    <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7zm0 9a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                </svg>
            </div>
            <h1 style="color: #fff; font-size: 28px; margin: 0 0 8px; font-family: Georgia, serif;">Sukasari Digital</h1>
            <p style="color: #b8c4c2; font-size: 14px; margin: 0; letter-spacing: 2px; text-transform: uppercase; font-family: 'Source Code Pro', monospace;">Masuk ke Akun</p>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: #8B0000; border-left: 4px solid #ff4444; color: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: #006400; border-left: 4px solid #00ed64; color: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="/auth/login" method="POST" style="background: #001e2b; border: 1px solid #1c3a4a; border-radius: 16px; padding: 40px;">

            <!-- Email -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 8px; font-weight: 500;">Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" 
                       style="width: 100%; padding: 12px 16px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 14px; box-sizing: border-box;"
                       placeholder="email@example.com" required>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; color: #fff; font-size: 14px; margin-bottom: 8px; font-weight: 500;">Password</label>
                <input type="password" name="password" 
                       style="width: 100%; padding: 12px 16px; border: 1px solid #3d4f58; border-radius: 8px; background: #0a2f42; color: #fff; font-size: 14px; box-sizing: border-box;"
                       placeholder="••••••••" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" style="width: 100%; background: #00684a; color: #fff; border: none; padding: 12px; border-radius: 100px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 16px;">
                Masuk Sekarang
            </button>

            <!-- Register Link -->
            <p style="color: #b8c4c2; text-align: center; font-size: 14px; margin: 0;">
                Belum punya akun? <a href="/auth/register" style="color: #00ed64; text-decoration: none; font-weight: 600;">Daftar di sini</a>
            </p>

        </form>

        <!-- Demo Credentials -->
        <div style="background: #0a2f42; border: 1px solid #1c3a4a; border-radius: 12px; padding: 20px; margin-top: 20px; color: #b8c4c2; font-size: 12px;">
            <p style="margin: 0 0 10px 0; color: #00ed64; font-weight: 600;">📝 Test Credentials:</p>
            <p style="margin: 5px 0;"><strong>Masyarakat:</strong> warga@sukasari.desa.id / warga123</p>
            <p style="margin: 5px 0;"><strong>Operator:</strong> operator@sukasari.desa.id / admin123</p>
        </div>

    </div>
</div>

<?= $this->include('layout/footer') ?>