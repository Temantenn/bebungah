<h1 align="center">
  🌸 Temanten — Digital Wedding Invitation Platform
</h1>

<p align="center">
  Platform undangan pernikahan digital berbasis web yang elegan, responsif, dan mudah dikustomisasi.
  <br>
  Dibangun dengan <strong>Laravel 11</strong>, <strong>Tailwind CSS</strong>, dan <strong>Blade Templating</strong>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?style=flat-square&logo=tailwindcss" alt="Tailwind">
  <img src="https://img.shields.io/badge/license-MIT-green?style=flat-square" alt="License">
</p>

---

## ✨ Fitur Utama

### 🎨 Tema Undangan Unggulan (Premium Polish)
| Tema | Konsep | Eksklusivitas |
|---|---|---|
| **Jawa Keraton** 🆕 | Regal Sogan, Gunungan Emas, Sakral & Mewah | ⭐ Premium |
| **Sunda Asih** 🆕 | Megamendung, Rumah Panggung, Elegan & Bersih | ⭐ Premium |
| **Sekar Jagad** 🆕 | Batik Floral, Rose & Navy, Modern Tradisional | ⭐ Premium |
| **Midnight Garden** 🆕 | Silk Texture, Glitter, Golden Glow & Metallic Aura | ⭐ Premium |
| **Royal Glass** | Glassmorphism mewah modern | ✅ |
| **Emerald Garden** | Hijau emerald & emas elegan | ✅ |
| **Floral Pastel** | Romantis bunga pastel lembut | ✅ |
| **Rustic Green** | Natural kayu & dedaunan | ✅ |
| **Boho Terracotta** | Bohemian hangat & artistik | ✅ |

### 🛠️ Fitur Admin & Monetisasi
- 👥 **Manajemen Kelola Admin** 🆕 — Super Admin dapat menambah, melihat, dan menghapus akun staf atau admin lain secara langsung dari dashboard tanpa harus membuka database.
- 💰 **Manajemen Harga Per-Tema & Promo Spesial** 🆕 — Admin dapat mengatur harga dasar dan harga promo ("Harga Coret") untuk setiap tema melalui dashboard. Harga otomatis terupdate di katalog dan checkout form.
- 🏗️ **Katalog Dinamis & Filter Harga** — Katalog tema dilengkapi filter harga kustom dan dropdown premium untuk memudahkan navigasi.
- 🔐 **Persetujuan Undangan** — Kontrol penuh admin untuk mengaktifkan atau menonaktifkan undangan user.

### 👥 Dashboard Client
- 💳 **Amplop Digital Berbasis QRIS** 🆕 — Memungkinkan klien untuk mengunggah gambar Barcode QRIS guna mempermudah tamu dalam memberikan kado digital secara *cashless* yang langsung terintegrasi dengan beragam pilihan tema.
- 📊 **Statistik RSVP real-time** — Total, Hadir, Tidak Hadir, Pending + progress bar.
- 💍 **Kustomisasi Konten & Musik** — Diedit langsung melalui dashboard settings.
- 🔍 **Manajemen Tamu (CRM)** — Search, filter status, import Excel/CSV, dan template siap pakai.
- 💬 **WhatsApp Blast & Link Generator** — Kirim undangan personal otomatis via WA dengan URL-encoded message.
- 🔔 **Toast Notification System** — Notifikasi real-time untuk interaksi sukses/gagal.

### 🌐 Landing Page & Katalog
- 📱 **Dynamic Hero Mockup** — Tampilan mock-up interaktif pada tema populer dan fitur Live Preview iframe.
- ❓ **Tanya Jawab (FAQ) & Footer Modern** 🆕 — Bagian FAQ accordion intuitif dan layout footer 3 kolom fungsional terintegrasi langsung dengan WhatsApp Admin & Email.
- 💳 **Pemesanan Mudah** — Integrasi form order responsif yang menampilkan rincian harga, potongan harga, dan badge promo secara real-time.

### 🔐 Authentikasi & Role
- Login, Register, Verifikasi Email, Reset Password (Laravel Breeze)
- Role: **Admin** dan **Client**
- Admin dashboard: update harga tema, konfigurasi promo, approve undangan, reset password user

### 🛡️ Keamanan & Stabilitas
- Rate limiting pada endpoint ucapan & RSVP (10 request/menit)
- Ownership check sebelum hapus/edit data
- Activity logging untuk semua perubahan penting
- **Perbaikan Rute Dasbor** 🆕 — Perbaikan alur logika *redirection* sesi yang menjamin pemisahan ruang lingkup secara sempurna antara aktivitas Administrator dan Klien setelah melakukan pemesanan.

---

## 🚀 Instalasi & Setup

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Langkah Instalasi

```bash
# 1. Clone repo
git clone https://github.com/username/bebungah.git
cd bebungah

# 2. Install dependencies PHP
composer install

# 3. Install dependencies JS
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_DATABASE=bebungah
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
bebungah/
├── app/
│   ├── Http/Controllers/
│   │   ├── ClientController.php     # Dashboard, guest CRUD, import
│   │   ├── AdminController.php      # Admin panel
│   │   ├── InvitationController.php # Tampil & RSVP undangan
│   │   ├── OrderController.php      # Alur pemesanan
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
│   ├── client/
│   │   ├── dashboard.blade.php
│   │   └── settings.blade.php
│   ├── themes/
│   │   ├── catalog.blade.php
│   │   ├── floral-pastel/
│   │   ├── ocean-breeze/
│   │   ├── midnight-garden/  🆕
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
| `POST` | `/client/store-guest` | Tambah tamu manual |
| `DELETE` | `/client/delete-guest/{guest}` | Hapus tamu |
| `POST` | `/client/import-guests` | Import Excel/CSV |
| `GET` | `/client/download-template` | Download template |
| `GET` | `/client/settings` | Edit undangan |
| `PUT` | `/client/settings` | Update undangan |
| `GET` | `/admin/dashboard` | Admin panel |

---

## 🎵 Konvensi Aset

| Tipe | Path | Format |
|---|---|---|
| Musik tema | `public/assets/music/{slug}.mp3` | MP3 |
| Thumbnail kartu | `public/assets/thumbnail/{slug}.png` | PNG |
| Upload klien | `storage/app/public/invitations/{id}/` | Any |

---

## 🧑‍💻 Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Blade, Tailwind CSS, Vite, Vanilla JS
- **Database**: MySQL/MariaDB (Eloquent ORM)
- **Auth**: Laravel Breeze
- **Excel**: Maatwebsite/Laravel-Excel
- **Icons**: Phosphor Icons
- **Fonts**: Google Fonts (Cormorant Garamond, Jost, Pinyon Script, dll)

---

## 📄 License

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).

---
