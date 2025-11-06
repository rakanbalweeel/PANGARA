# Sistem Login & Register - Pangara Kasir

## 🎯 Fitur yang Telah Dibuat

### 1. Landing Page
- Halaman utama yang modern dan menarik
- Menampilkan fitur-fitur sistem kasir
- Bagian promo dan paket harga
- Link ke login dan register

### 2. Sistem Authentication
- Halaman Login dengan validasi
- Halaman Register dengan pilihan role
- Logout functionality
- Session management

### 3. Multi-Role System
Sistem mendukung 3 role berbeda:

#### 👨‍💼 **ADMIN**
**Fungsi:**
- Kelola seluruh sistem
- Kelola pengguna (admin, kasir, pembeli)
- Kelola produk dan kategori
- Lihat semua transaksi
- Generate laporan lengkap
- Pengaturan sistem

**Dashboard Features:**
- Total penjualan
- Total transaksi
- Total produk
- Total pengguna
- Grafik penjualan
- Grafik produk terlaris
- Daftar transaksi terbaru
- Daftar pengguna baru

#### 💰 **KASIR**
**Fungsi:**
- Proses transaksi penjualan
- Scan barcode produk
- Input transaksi manual
- Cetak struk
- Lihat riwayat transaksi sendiri
- Cek stok produk
- Laporan harian

**Dashboard Features:**
- Penjualan hari ini
- Jumlah transaksi hari ini
- Rata-rata per transaksi
- Item terjual hari ini
- Quick actions (Transaksi Baru, Scan Barcode, dll)
- Tabel transaksi terbaru

#### 🛒 **PEMBELI**
**Fungsi:**
- Browse dan cari produk
- Tambah produk ke keranjang
- Checkout dan bayar
- Lihat riwayat pembelian
- Simpan produk favorit
- Lihat poin reward
- Review produk

**Dashboard Features:**
- Total pembelian
- Total belanja
- Produk favorit
- Poin reward
- Banner promo
- Produk terpopuler
- Riwayat pembelian terakhir

## 🔐 User Testing Credentials

Gunakan akun berikut untuk testing:

### Admin
- Email: `admin@pangara.com`
- Password: `password123`
- URL Dashboard: `/admin/dashboard`

### Kasir
- Email: `kasir@pangara.com`
- Password: `password123`
- URL Dashboard: `/kasir/dashboard`

### Pembeli
- Email: `pembeli@pangara.com`
- Password: `password123`
- URL Dashboard: `/pembeli/dashboard`

## 📁 File Structure

```
resources/views/
├── landing.blade.php          # Landing page
├── auth/
│   ├── login.blade.php        # Halaman login
│   └── register.blade.php     # Halaman register
└── dashboard/
    ├── admin.blade.php        # Dashboard admin
    ├── kasir.blade.php        # Dashboard kasir
    └── pembeli.blade.php      # Dashboard pembeli

app/Http/Controllers/
├── Auth/
│   ├── LoginController.php      # Logic login
│   └── RegisterController.php   # Logic register
└── DashboardController.php       # Logic dashboard

routes/
└── web.php                    # Routing

database/
├── migrations/
│   └── 2025_10_29_040819_add_role_to_users_table.php
└── seeders/
    └── UserSeeder.php         # Data dummy users
```

## 🚀 Cara Menjalankan

1. Pastikan server Laragon sudah running
2. Akses aplikasi di browser: `http://localhost/PANGARA`
3. Klik "Masuk" atau "Daftar Gratis" di landing page
4. Login menggunakan salah satu akun testing di atas
5. Anda akan diarahkan ke dashboard sesuai role

## 🎨 Design Features

- **Modern UI/UX** dengan Tailwind CSS
- **Responsive Design** untuk mobile dan desktop
- **Interactive Elements** dengan hover effects dan animations
- **Icon System** menggunakan Font Awesome
- **Color Scheme** purple gradient yang modern
- **Charts** menggunakan Chart.js (di dashboard admin)

## 🔄 Flow System

1. **User** mengunjungi landing page
2. **User** klik register → pilih role (admin/kasir/pembeli)
3. **System** create akun dan auto-login
4. **System** redirect ke dashboard sesuai role
5. **User** dapat logout kapan saja
6. **User** login kembali → redirect ke dashboard yang sesuai

## 🛡️ Security Features

- Password hashing dengan bcrypt
- CSRF protection
- Session management
- Role-based access control
- Input validation
- SQL injection protection (built-in Laravel)

## 📝 Notes

- Semua password untuk akun testing adalah: `password123`
- Pastikan database sudah ter-migrate dengan benar
- Untuk development, gunakan `.env` file yang sudah dikonfigurasi
- Dashboard masih menggunakan data dummy untuk demonstrasi

## 🎯 Next Development Steps

Setelah login system selesai, bisa dilanjutkan dengan:
1. CRUD Produk
2. Sistem Transaksi
3. Manajemen Stok
4. Laporan & Analytics
5. Sistem Pembayaran
6. Dan lain-lain sesuai kebutuhan

---

**Developed with ❤️ for Pangara POS System**
