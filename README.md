# Sistem Pengaduan Masyarakat — Desa Sukasari
> Dibangun dengan CodeIgniter 4 + MySQL

---

## Prasyarat
- PHP >= 8.1
- MySQL >= 5.7 / MariaDB >= 10.3
- Composer
- Web server (Apache/Nginx) atau PHP built-in server

---

## Langkah Instalasi

### 1. Clone / buat project CI4
```bash
composer create-project codeigniter4/appstarter pengaduan-sukasari
cd pengaduan-sukasari
```

### 2. Copy semua file dari folder ini ke project CI4 kamu

### 3. Setup environment
```bash
# Copy file .env
cp .env.example .env

# Edit .env — sesuaikan database
nano .env
```

Isi bagian database di `.env`:
```
database.default.hostname = localhost
database.default.database = db_pengaduan_sukasari
database.default.username = root
database.default.password = YOUR_PASSWORD
```

### 4. Generate encryption key
```bash
php spark key:generate
```

### 5. Buat database di MySQL
```sql
CREATE DATABASE db_pengaduan_sukasari
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### 6. Jalankan migration
```bash
php spark migrate
```

### 7. Jalankan seeder (data awal)
```bash
php spark db:seed DatabaseSeeder
```

Output yang diharapkan:
```
✓ RoleSeeder selesai
✓ UserSeeder selesai
  → Operator  : operator@sukasari.desa.id / admin123
  → Masyarakat: warga@sukasari.desa.id / warga123
✓ KategoriSeeder selesai (6 kategori)
```

### 8. Jalankan server
```bash
php spark serve
```

Akses di: http://localhost:8080

---

## Akun Default

| Role       | Email                          | Password  |
|------------|-------------------------------|-----------|
| Operator   | operator@sukasari.desa.id     | admin123  |
| Masyarakat | warga@sukasari.desa.id        | warga123  |

> **PENTING**: Ganti password default sebelum deploy ke production!

---

## Struktur Folder Penting

```
app/
├── Config/
│   ├── App.php          ← Konfigurasi app
│   ├── Database.php     ← Konfigurasi database
│   ├── Filters.php      ← Daftar filter/middleware
│   └── Routes.php       ← Semua routing
├── Controllers/
│   ├── Auth/            ← Login, Register, Logout
│   ├── Masyarakat/      ← Fitur untuk warga
│   └── Operator/        ← Fitur untuk petugas
├── Database/
│   ├── Migrations/      ← Struktur tabel
│   └── Seeds/           ← Data awal
├── Filters/
│   └── AuthFilter.php   ← Middleware cek login & role
├── Models/              ← (langkah berikutnya)
└── Views/               ← (langkah berikutnya)
public/
├── .htaccess            ← Hapus index.php dari URL
└── uploads/             ← Folder upload foto (buat manual)
```

---

## Perintah Spark yang Berguna

```bash
php spark serve              # Jalankan server
php spark migrate            # Jalankan semua migration
php spark migrate:rollback   # Rollback migration terakhir
php spark migrate:refresh    # Reset + jalankan ulang semua migration
php spark db:seed DatabaseSeeder  # Jalankan seeder
php spark make:controller NamaController  # Buat controller baru
php spark make:model NamaModel            # Buat model baru
```

---

## Roadmap Pengerjaan

- [x] Setup konfigurasi CI4
- [x] Database migrations (7 tabel)
- [x] Seeder data awal
- [x] AuthFilter middleware
- [x] Routing lengkap
- [ ] Models (langkah berikutnya)
- [ ] Controllers Auth
- [ ] Controllers Masyarakat
- [ ] Controllers Operator
- [ ] Views & UI (MongoDB-inspired design)