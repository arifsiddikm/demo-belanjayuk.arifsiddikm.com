# BelanjaYuk! — Toko Online Fashion & Produk Fisik

Website e-commerce lengkap untuk toko online produk fisik (fashion, elektronik, alat rumah tangga, dll), dilengkapi dashboard user, panel admin (webmin), integrasi payment gateway Midtrans, kalkulasi ongkir via RajaOngkir, dan fitur cek resi.

🌐 **Live Demo:** [demo-belanjayuk.arifsiddikm.com](https://demo-belanjayuk.arifsiddikm.com)

---

## Tech Stack

- **Backend:** PHP 8.3 + Laravel 11
- **Database:** MySQL
- **Frontend:** Tailwind CSS CDN · SweetAlert2 · CKEditor 4
- **Payment:** Midtrans (via Riplabs Snap Token)
- **Ongkir & Resi:** RajaOngkir Komerce API
- **Email:** PHPMailer (SMTP)

---

## Fitur

**Frontend Publik**
- Halaman Home dengan hero slider banner, produk unggulan, promo, new arrival, kategori & testimoni
- Halaman Produk dengan filter kategori, search, sorting & pagination
- Detail Produk: multi foto, pilih varian (size), add to cart, wishlist, ulasan pembeli
- Halaman Cek Resi (multi kurir: JNE, JNT, SiCepat, Anteraja, dll) dengan timeline pengiriman
- Search produk live dari navbar

**User Dashboard**
- Register & Login
- Manajemen alamat pengiriman (multi alamat, pilih default)
- Keranjang belanja + kode kupon diskon
- Checkout dengan kalkulasi ongkir real-time (RajaOngkir by district)
- Pembayaran via Midtrans Snap atau Bank Transfer manual + upload bukti
- Riwayat pesanan dengan filter status: Menunggu Bayar, Diproses, Dikirim, Diterima, Selesai, Dibatalkan
- Tracking resi langsung dari detail pesanan
- Wishlist & ulasan produk (setelah pesanan selesai)

**Admin Panel** (`/webmin`)
- Dashboard statistik (pesanan, pendapatan, produk, pengguna)
- Kelola Produk: CRUD + multi gambar + varian produk + rich text deskripsi (CKEditor)
- Kelola Kategori: CRUD
- Kelola Pesanan: update status, input nomor resi, konfirmasi pembayaran bank transfer
- Kelola Pengguna: tambah, toggle aktif/nonaktif, hapus
- Kelola Kupon Diskon
- Laporan & Cetak Transaksi
- Pengaturan Toko (nama, bank, WA, origin kota ongkir, dll)
- Notifikasi email otomatis (order baru, konfirmasi bayar)

---

## Instalasi

```bash
# 1. Clone repo
git clone https://github.com/arifsiddikm/belanjayuk.git
cd belanjayuk

# 2. Install dependencies
composer install

# 3. Copy dan konfigurasi .env
cp file env to .env and setting your password
php artisan key:generate

# 4. Buat database MySQL, lalu jalankan migrasi & seeder
php artisan migrate
php artisan db:seed

# 5. Storage link
php artisan storage:link

# 6. Jalankan server
php artisan serve
```

Akses di `http://localhost:8000`

---

## Login Admin

```
URL   : http://localhost:8000/webmin/dashboard
Email : admin@belanjayuk.com
Pass  : admin123
```

---

## Konfigurasi MySQL

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belanjayuk
DB_USERNAME=root
DB_PASSWORD=
```

Konfigurasi tambahan yang perlu diisi di `.env`:
```env
# Midtrans
MIDTRANS_CLIENT_KEY=
MIDTRANS_SERVER_KEY=
MIDTRANS_IS_PRODUCTION=false

# Riplabs
RIPLABS_KEY=
RIPLABS_SNAPTOKEN_URL=

# RajaOngkir
RAJAONGKIR_API_KEY=

# PHPMailer SMTP
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
ADMIN_EMAIL=

# Admin WhatsApp
ADMIN_WHATSAPP=
```

---

### Support me on

<a href="https://saweria.co/arifsiddikm" target="_blank"><img src="https://user-images.githubusercontent.com/26188697/180601310-e82c63e4-412b-4c36-b7b5-7ba713c80380.png" alt="Sawer me" height="41" width="174"></a>
