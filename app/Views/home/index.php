<?= $this->include('layout/header') ?>

<section style="background-color: var(--forest-black); color: #fff; padding: 100px 20px; text-align: center;">
    <div style="max-width: 900px; margin: 0 auto;">
        <p class="label-tech" style="color: var(--mongodb-green); margin-bottom: 20px;">Portal Resmi Desa Sukasari</p>
        <h1 style="font-size: 84px; line-height: 1.1; margin-bottom: 24px;">
            Suara Anda adalah <span style="border-bottom: 4px solid var(--mongodb-green)">Aksi</span> Kami.
        </h1>
        <p style="font-size: 20px; color: var(--silver-teal); margin-bottom: 40px; line-height: 1.6;">
            Laporkan masalah infrastruktur, layanan publik, atau saran untuk kemajuan Kelurahan Sukasari melalui sistem pengaduan terintegrasi.
        </p>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="#form-pengaduan" class="btn-pill btn-green" style="padding: 15px 40px; font-size: 18px;">Mulai Lapor</a>
            <a href="#" class="btn-pill" style="border: 1px solid var(--silver-teal); color: #fff; padding: 15px 40px;">Lihat Statistik</a>
        </div>
    </div>
</section>

<section id="form-pengaduan" style="padding: 80px 20px; background-color: #f9fbfa;">
    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        
        <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1px solid var(--silver-teal); box-shadow: var(--forest-shadow);">
            <p class="label-tech" style="color: var(--action-blue); margin-bottom: 10px;">Quick Tracking</p>
            <h2 style="font-size: 32px; margin-bottom: 15px;">Cek Status Laporan</h2>
            <p style="margin-bottom: 24px; color: #5c6c75;">Masukkan ID Tiket untuk melihat progress tindak lanjut petugas.</p>
            
            <input type="text" placeholder="Contoh: SKS-2026-001" style="width: 100%; padding: 14px; border-radius: 8px; border: 1px solid var(--silver-teal); margin-bottom: 20px; font-family: 'Source Code Pro';">
            <button class="btn-pill btn-green" style="width: 100%; cursor: pointer;">Lacak Sekarang</button>
        </div>

        <div style="padding: 20px;">
            <h3 style="font-size: 24px; margin-bottom: 20px; font-weight: 500;">Bagaimana kami bekerja?</h3>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 20px; display: flex; gap: 15px;">
                    <span style="color: var(--mongodb-green); font-weight: 700; font-family: 'Source Code Pro';">01.</span>
                    <span>Warga mengirimkan laporan lengkap dengan bukti foto.</span>
                </li>
                <li style="margin-bottom: 20px; display: flex; gap: 15px;">
                    <span style="color: var(--mongodb-green); font-weight: 700; font-family: 'Source Code Pro';">02.</span>
                    <span>Admin Kelurahan melakukan verifikasi dalam 1x24 jam.</span>
                </li>
                <li style="margin-bottom: 20px; display: flex; gap: 15px;">
                    <span style="color: var(--mongodb-green); font-weight: 700; font-family: 'Source Code Pro';">03.</span>
                    <span>Petugas lapangan dikerahkan ke lokasi untuk penanganan.</span>
                </li>
            </ul>
        </div>

    </div>
</section>

<?= $this->include('layout/footer') ?>