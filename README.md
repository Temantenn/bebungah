<h1 align="center">
  🌸 Temanten — Platform Undangan Pernikahan Digital
</h1>

<p align="center">
  Platform undangan pernikahan digital berbasis web yang elegan, responsif, dan mudah dikustomisasi.
  <br>
  Dibangun dengan <strong>Laravel 12</strong>, <strong>Tailwind CSS</strong>, <strong>Flowbite</strong>, dan <strong>Blade Templating</strong>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3+-blue?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?style=flat-square&logo=tailwindcss" alt="Tailwind">
  <img src="https://img.shields.io/badge/Flowbite-UI-pink?style=flat-square" alt="Flowbite">
  <img src="https://img.shields.io/badge/license-MIT-green?style=flat-square" alt="License">
</p>

---

## ✨ Fitur Utama

### 🎨 Tema Undangan Unggulan
| Tema | Konsep | Status |
|---|---|---|
| **Royal Glass** | Glassmorphism mewah modern | ✅ |
| **Emerald Garden** | Hijau emerald & emas elegan | ✅ |
| **Floral Pastel** | Romantis bunga pastel lembut | ✅ |
| **Rustic Green** | Natural kayu & dedaunan | ✅ |
| **Boho Terracotta** | Bohemian hangat & artistik | ✅ |
| **Ocean Breeze** | Segar & minimalis biru laut | ✅ |
| **Watercolor Flow** | Artistik cat air lembut | ✅ |

### 🛠️ Fitur Admin Dashboard
- 🔐 **Modal Konfirmasi Modern (Flowbite)** — Konfirmasi Reset Password & Persetujuan Order menggunakan modal UI yang elegan, berpusat sempurna, tanpa bergantung penuh pada library eksternal.
- 🔑 **Tombol Salin Password** — Setelah reset password berhasil, admin langsung bisa menyalin password baru dengan satu klik.
- 👥 **Manajemen Klien Aktif** — Tabel detail klien aktif lengkap dengan link undangan, WhatsApp, serta tombol manajemen.
- 💰 **Manajemen Harga Per-Tema & Promo** — Admin dapat mengatur harga dasar dan harga promo untuk setiap tema.
- 🔐 **Persetujuan Undangan** — Kontrol penuh admin untuk mengaktifkan undangan user setelah pembayaran dikonfirmasi.
- 🛡️ **Keamanan Rute** — Klien yang belum disetujui tidak bisa bypass ke dashboard via auto-login.

### 👥 Dashboard Klien
- 💳 **Amplop Digital Berbasis QRIS** — Upload barcode QRIS untuk terima kado digital dari tamu.
- 📸 **Upload Foto Galeri dengan Kompresi Otomatis** — Foto dikompresi secara client-side ke format **WebP HD** (resolusi dipertahankan hingga 2500px, kualitas 85%) sebelum dikirim ke server, mencegah error `PostTooLargeException` di shared hosting.
- ❤️ **Form Love Story Dinamis** — Tambah/hapus cerita cinta langsung dari form tanpa batas.
- 🖼️ **Manajemen Foto Galeri** — Hapus foto individual dari galeri langsung di halaman settings.
- 📊 **Statistik RSVP real-time** — Total, Hadir, Tidak Hadir, Pending + progress bar.
- 💍 **Kustomisasi Konten & Musik** — Diedit langsung melalui dashboard settings.
- 🔍 **Manajemen Tamu (CRM)** — Search, filter status, import Excel/CSV, dan template siap pakai.
- 💬 **WhatsApp Blast & Link Generator** — Kirim undangan personal otomatis via WA.
- 🗺️ **Integrasi Wilayah Indonesia** — Dropdown Provinsi, Kabupaten, Kecamatan, Kelurahan.

### 🌐 Landing Page & Katalog
- 📱 **Dynamic Hero Mockup** — Live Preview iframe langsung dari halaman katalog & landing.
- 💳 **Pemesanan Mudah** — Form order responsif dengan rincian harga & badge promo real-time.
- ❓ **FAQ Accordion & Footer Modern** — FAQ intuitif & footer 3 kolom terintegrasi WhatsApp Admin.

### 🗺️ Google Maps Integration
- Tombol Google Maps yang berfungsi di semua tema (Royal Glass, Rustic Green, Floral Pastel)
- Klik tombol langsung membuka Google Maps di tab baru

---

## 🚀 Instalasi & Setup

### Prasyarat
- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Langkah Instalasi

```bash
# 1. Clone repo
git clone https://github.com/username/temanten.git
cd temanten

# 2. Install dependencies PHP
composer install

# 3. Install dependencies JS
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_DATABASE=temanten
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Jalankan migrasi + seeder
php artisan migrate --seed

# 8. Buat symbolic link storage
php artisan storage:link

# 9. Build assets
npm run dev

# 10. Jalankan server
php artisan serve
```

Buka di browser: **http://localhost:8000**

---

## 📁 Struktur Proyek

```
temanten/
├── app/
│   ├── Http/Controllers/
│   │   ├── ClientController.php     # Dashboard, guest CRUD, import, galeri
│   │   ├── AdminController.php      # Admin panel, reset password, approve
│   │   ├── InvitationController.php # Tampil & RSVP undangan
│   │   ├── OrderController.php      # Alur pemesanan (tanpa auto-login)
│   │   └── ThemeController.php      # Katalog tema
│   └── Models/
│       ├── Invitation.php
│       ├── Guest.php
│       ├── Theme.php
│       └── ActivityLog.php
├── public/assets/
│   ├── music/           # Musik per tema (slug.mp3)
│   └── thumbnail/       # Thumbnail kartu tema (slug.png)
├── resources/views/
│   ├── admin/
│   │   └── dashboard.blade.php  # Flowbite modals (reset & approve)
│   ├── client/
│   │   ├── dashboard.blade.php
│   │   └── settings.blade.php   # WebP compression + dinamis form
│   ├── components/
│   │   └── alert-success.blade.php
│   ├── themes/
│   │   ├── royal-glass/
│   │   ├── floral-pastel/
│   │   ├── rustic-green/
│   │   └── ...
│   ├── landing.blade.php
│   └── auth/
└── routes/web.php
```

---

## 🗺️ Routes Utama

| Method | URI | Keterangan |
|---|---|---|
| `GET` | `/` | Landing page |
| `GET` | `/themes` | Katalog tema |
| `GET` | `/demo/{theme}` | Demo undangan |
| `GET` | `/undangan/{slug}` | Undangan publik |
| `POST` | `/rsvp/{id}` | Submit RSVP |
| `POST` | `/kirim-ucapan` | Kirim ucapan |
| `GET` | `/client/dashboard` | Dashboard client |
| `GET` | `/client/settings` | Edit undangan & galeri |
| `POST` | `/client/settings` | Update undangan (dengan kompresi foto) |
| `GET` | `/admin/dashboard` | Admin panel |
| `POST` | `/admin/approve/{id}` | Approve order |
| `POST` | `/admin/reset-password/{id}` | Reset password klien |

---

## 🎵 Konvensi Aset

| Tipe | Path | Format |
|---|---|---|
| Musik tema | `public/assets/music/{slug}.mp3` | MP3 |
| Thumbnail kartu | `public/assets/thumbnail/{slug}.png` | PNG |
| Upload klien | `storage/app/public/invitations/{id}/` | WebP/Any |

---

## 🧑‍💻 Tech Stack

- **Backend**: Laravel 12, PHP 8.3+
- **Frontend**: Blade, Tailwind CSS 3.x, Vite, Vanilla JS
- **UI Components**: Flowbite (modal dialogs)
- **Database**: MySQL/MariaDB (Eloquent ORM)
- **Auth**: Laravel Breeze
- **Excel**: Maatwebsite/Laravel-Excel
- **Fonts**: Google Fonts (Cormorant Garamond, Jost, Pinyon Script, dll)

---

## 📄 License

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).

---
