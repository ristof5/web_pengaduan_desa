<?= $this->include('layout/header') ?>

<!-- HERO SECTION -->
<section style="background: linear-gradient(135deg, #001e2b 0%, #0a2f42 100%); color: #fff; padding: 100px 20px; text-align: center; position: relative; overflow: hidden;">
    <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 2;">
        <p style="font-family: 'Source Code Pro', monospace; color: #00ed64; margin-bottom: 20px; letter-spacing: 2px; text-transform: uppercase; font-size: 12px;">Portal Resmi Desa Sukasari</p>
        <h1 style="font-size: 84px; line-height: 1.1; margin-bottom: 24px; font-family: Georgia, serif; font-weight: 400;">
            Suara Anda adalah <span style="border-bottom: 4px solid #00ed64;">Aksi</span> Kami.
        </h1>
        <p style="font-size: 20px; color: #b8c4c2; margin-bottom: 40px; line-height: 1.6; font-weight: 300; max-width: 700px; margin-left: auto; margin-right: auto;">
            Laporkan masalah infrastruktur, layanan publik, atau saran untuk kemajuan Kelurahan Sukasari melalui sistem pengaduan terintegrasi.
        </p>
        
        <!-- CTA Buttons -->
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="/auth/register" style="background: #00ed64; color: #001e2b; padding: 15px 40px; border-radius: 100px; font-size: 16px; font-weight: 700; text-decoration: none; transition: all 0.3s; display: inline-block;">
                ✓ Mulai Lapor Sekarang
            </a>
            <a href="/auth/login" style="background: transparent; color: #fff; border: 2px solid #00ed64; padding: 13px 40px; border-radius: 100px; font-size: 16px; font-weight: 600; text-decoration: none; transition: all 0.3s; display: inline-block;">
                Masuk Akun
            </a>
        </div>
    </div>

    <!-- Decorative Background -->
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: rgba(0, 237, 100, 0.05); border-radius: 50%; z-index: 1;"></div>
</section>

<!-- STATS SECTION -->
<section style="background: #fff; padding: 60px 20px; border-top: 1px solid #b8c4c2; border-bottom: 1px solid #b8c4c2;">
    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; text-align: center;">
        <div>
            <div style="font-family: Georgia, serif; font-size: 48px; color: #00ed64; font-weight: 400; margin-bottom: 10px;">247</div>
            <p style="color: #5c6c75; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; font-family: 'Source Code Pro', monospace; margin: 0;">Laporan Masuk</p>
        </div>
        <div>
            <div style="font-family: Georgia, serif; font-size: 48px; color: #006cfa; font-weight: 400; margin-bottom: 10px;">89%</div>
            <p style="color: #5c6c75; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; font-family: 'Source Code Pro', monospace; margin: 0;">Diselesaikan</p>
        </div>
        <div>
            <div style="font-family: Georgia, serif; font-size: 48px; color: #00ed64; font-weight: 400; margin-bottom: 10px;">3 hari</div>
            <p style="color: #5c6c75; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; font-family: 'Source Code Pro', monospace; margin: 0;">Rata-rata Respon</p>
        </div>
    </div>
</section>

<!-- KATEGORI SECTION -->
<section style="padding: 80px 20px; background: #f9fbfa;">
    <div style="max-width: 1100px; margin: 0 auto;">
        <p style="font-family: 'Source Code Pro', monospace; color: #00684a; margin-bottom: 10px; letter-spacing: 2.5px; text-transform: uppercase; font-size: 12px;">Kategori Pengaduan</p>
        <h2 style="font-family: Georgia, serif; font-size: 42px; margin: 0 0 8px 0; color: #001e2b; font-weight: 400;">Apa yang ingin Anda laporkan?</h2>
        <p style="color: #5c6c75; margin-bottom: 40px; font-size: 16px; font-weight: 300;">Pilih kategori yang sesuai dengan laporan Anda.</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <!-- Card Jalan & Infrastruktur -->
            <div style="background: #fff; border: 1px solid #b8c4c2; border-radius: 16px; padding: 24px; transition: all 0.3s; box-shadow: rgba(0,30,43,0.12) 0px 2px 4px; border-top: 3px solid #00ed64;">
                <div style="width: 40px; height: 40px; background: #e8f5f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00684a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h18M3 6h18M3 18h18"/>
                    </svg>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #001e2b; margin: 0 0 8px 0;">Jalan & Infrastruktur</h3>
                <p style="color: #5c6c75; font-size: 13px; line-height: 1.6; margin: 0; font-weight: 300;">Jalan berlubang, jembatan rusak, drainase mampet, atau lampu jalan mati.</p>
            </div>

            <!-- Card Sampah & Kebersihan -->
            <div style="background: #fff; border: 1px solid #b8c4c2; border-radius: 16px; padding: 24px; transition: all 0.3s; box-shadow: rgba(0,30,43,0.12) 0px 2px 4px;">
                <div style="width: 40px; height: 40px; background: #e8f5f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00684a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18l-2 13H5L3 6zM8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/>
                    </svg>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #001e2b; margin: 0 0 8px 0;">Sampah & Kebersihan</h3>
                <p style="color: #5c6c75; font-size: 13px; line-height: 1.6; margin: 0; font-weight: 300;">Tumpukan sampah, got tersumbat, dan kebersihan lingkungan sekitar.</p>
            </div>

            <!-- Card Keamanan & Ketertiban -->
            <div style="background: #fff; border: 1px solid #b8c4c2; border-radius: 16px; padding: 24px; transition: all 0.3s; box-shadow: rgba(0,30,43,0.12) 0px 2px 4px;">
                <div style="width: 40px; height: 40px; background: #e8f5f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00684a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #001e2b; margin: 0 0 8px 0;">Keamanan & Ketertiban</h3>
                <p style="color: #5c6c75; font-size: 13px; line-height: 1.6; margin: 0; font-weight: 300;">Gangguan keamanan, ketertiban umum, dan hal mencurigakan di lingkungan.</p>
            </div>

            <!-- Card Administrasi & Pelayanan -->
            <div style="background: #fff; border: 1px solid #b8c4c2; border-radius: 16px; padding: 24px; transition: all 0.3s; box-shadow: rgba(0,30,43,0.12) 0px 2px 4px;">
                <div style="width: 40px; height: 40px; background: #e8f5f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00684a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #001e2b; margin: 0 0 8px 0;">Administrasi & Pelayanan</h3>
                <p style="color: #5c6c75; font-size: 13px; line-height: 1.6; margin: 0; font-weight: 300;">Keluhan pelayanan kantor desa, pengurusan surat, dan dokumen kependudukan.</p>
            </div>

            <!-- Card Fasilitas Umum -->
            <div style="background: #fff; border: 1px solid #b8c4c2; border-radius: 16px; padding: 24px; transition: all 0.3s; box-shadow: rgba(0,30,43,0.12) 0px 2px 4px;">
                <div style="width: 40px; height: 40px; background: #e8f5f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00684a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #001e2b; margin: 0 0 8px 0;">Fasilitas Umum</h3>
                <p style="color: #5c6c75; font-size: 13px; line-height: 1.6; margin: 0; font-weight: 300;">Kerusakan balai desa, posyandu, tempat ibadah, dan fasilitas umum lainnya.</p>
            </div>

            <!-- Card Lainnya -->
            <div style="background: #fff; border: 1px solid #b8c4c2; border-radius: 16px; padding: 24px; transition: all 0.3s; box-shadow: rgba(0,30,43,0.12) 0px 2px 4px;">
                <div style="width: 40px; height: 40px; background: #e8f5f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00684a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>
                    </svg>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #001e2b; margin: 0 0 8px 0;">Lainnya</h3>
                <p style="color: #5c6c75; font-size: 13px; line-height: 1.6; margin: 0; font-weight: 300;">Pengaduan lain yang tidak termasuk dalam kategori di atas.</p>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section style="background: #001e2b; padding: 80px 20px;">
    <div style="max-width: 1100px; margin: 0 auto;">
        <p style="font-family: 'Source Code Pro', monospace; color: #5c6c75; margin-bottom: 10px; letter-spacing: 2.5px; text-transform: uppercase; font-size: 12px;">Cara Kerja</p>
        <h2 style="font-family: Georgia, serif; font-size: 42px; color: #fff; margin: 0 0 40px 0; font-weight: 400;">Mudah, cepat, transparan.</h2>

        <div style="display: flex; flex-direction: column; gap: 0;">
            <!-- Step 1 -->
            <div style="display: flex; gap: 20px; align-items: flex-start; padding: 24px 0; border-bottom: 1px solid #1c3a4a;">
                <div style="font-family: 'Source Code Pro', monospace; font-size: 12px; color: #00ed64; letter-spacing: 2px; font-weight: 600; min-width: 40px;">01</div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 600; color: #fff; margin: 0 0 6px 0;">Daftar & masuk akun</h3>
                    <p style="color: #5c6c75; font-size: 14px; line-height: 1.6; margin: 0; font-weight: 300;">Buat akun menggunakan NIK dan email aktif Anda. Proses registrasi hanya butuh 2 menit.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div style="display: flex; gap: 20px; align-items: flex-start; padding: 24px 0; border-bottom: 1px solid #1c3a4a;">
                <div style="font-family: 'Source Code Pro', monospace; font-size: 12px; color: #00ed64; letter-spacing: 2px; font-weight: 600; min-width: 40px;">02</div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 600; color: #fff; margin: 0 0 6px 0;">Isi formulir pengaduan</h3>
                    <p style="color: #5c6c75; font-size: 14px; line-height: 1.6; margin: 0; font-weight: 300;">Ceritakan masalah dengan jelas, pilih kategori, dan sertakan foto sebagai bukti laporan.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div style="display: flex; gap: 20px; align-items: flex-start; padding: 24px 0; border-bottom: 1px solid #1c3a4a;">
                <div style="font-family: 'Source Code Pro', monospace; font-size: 12px; color: #00ed64; letter-spacing: 2px; font-weight: 600; min-width: 40px;">03</div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 600; color: #fff; margin: 0 0 6px 0;">Terima kode tiket</h3>
                    <p style="color: #5c6c75; font-size: 14px; line-height: 1.6; margin: 0; font-weight: 300;">Sistem otomatis memberi kode tiket unik (contoh: SKS-2026-0042) untuk melacak laporan Anda.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div style="display: flex; gap: 20px; align-items: flex-start; padding: 24px 0;">
                <div style="font-family: 'Source Code Pro', monospace; font-size: 12px; color: #00ed64; letter-spacing: 2px; font-weight: 600; min-width: 40px;">04</div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 600; color: #fff; margin: 0 0 6px 0;">Pantau & terima respons</h3>
                    <p style="color: #5c6c75; font-size: 14px; line-height: 1.6; margin: 0; font-weight: 300;">Petugas desa akan memproses dan membalas laporan Anda. Pantau statusnya secara real-time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>