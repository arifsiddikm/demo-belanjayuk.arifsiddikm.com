# CLAUDE PROMPT — BelanjaYuk! E-Commerce Website

> Upload file ini ke Claude untuk membuat ulang website BelanjaYuk! dari awal.
> Semua API key, password, dan kredensial rahasia **tidak disertakan** — isi sendiri di bagian yang ditandai `[ISI_SENDIRI]`.

---

## Konsep Umum Proyek

Buat website e-commerce produk fisik bernama **BelanjaYuk!** — mirip Tokopedia/Shopee versi 1 toko (bukan marketplace). Nuansa warna **putih dan oranye**. Kategori produk: fashion pria & wanita, elektronik, alat rumah tangga, olahraga, kecantikan, sepatu & tas, mainan & hobi.

### Tech Stack
- **Backend:** PHP 8.3 + Laravel 11, MVC biasa (tanpa Filament)
- **Database:** MySQL
- **Frontend:** Tailwind CSS via CDN (`cdn.tailwindcss.com`) — semua custom CSS wajib ditulis native CSS di `<style>` tag, **bukan @apply**
- **Rich Text:** CKEditor 4 (untuk deskripsi produk, dll)
- **Konfirmasi UI:** SweetAlert2 (logout, hapus, konfirmasi aksi penting)
- **Email:** PHPMailer SMTP (smtp.hostinger.com, SSL, port 465)
- **Payment:** Midtrans via Riplabs Snap Token
- **Ongkir & Resi:** RajaOngkir Komerce API
- **Chart:** Chart.js (untuk dashboard admin)

### Aturan Penting
- Tailwind via CDN → **tidak ada @apply**, semua style pakai utility class atau native CSS
- Setiap halaman wajib punya **meta SEO** (title, description, og tags)
- Wajib ada **logo SVG + favicon** bertema BelanjaYuk
- Semua form input, button, checkbox, radio **wajib ada styling Tailwind yang benar**, tidak boleh ada elemen tanpa desain
- Sidebar dan menu admin harus rapi dan punya desain yang konsisten
- Security: CSRF token, validasi backend, middleware proteksi route admin
- Konfirmasi aksi penting (hapus, logout, batalkan pesanan) pakai **SweetAlert2**
- Halaman login admin: sertakan **tombol autofill** (isi form user/password otomatis tapi login tetap manual klik tombol)
- README.md berisi tutorial instalasi singkat, padat, jelas

---

## Struktur Halaman & Fitur

### 1. Home Page (`/`)
- **Hero Slider** — banner promo dengan gambar produk (dari seeder/unsplash dummy), tombol CTA
- **Section Produk Unggulan** — grid produk is_featured
- **Section Produk Promo** — grid produk is_promo
- **Section New Arrival** — produk terbaru
- **Section By Kategori** — list kategori dengan ikon & gambar
- **Section Testimoni** — ulasan dummy pembeli
- **Section CTA** — ajak ke halaman produk
- **Navbar** — logo, search bar (enter → redirect ke `/produk?search=...`), icon cart + badge, login/user menu
- **Footer** — info toko, link navigasi, sosmed

### 2. Halaman Produk (`/produk`)
- Grid produk dengan **pagination**
- Filter: by kategori, by harga, sorting (terbaru, terlaris, harga naik/turun)
- Search dari navbar langsung mengarah ke halaman ini
- URL: `/produk`, `/produk/search`, `/produk/kategori/{slug}`

### 3. Detail Produk (`/produk/{slug}`)
- **Multi foto slider** (swipe/klik thumbnail)
- Nama, harga, harga coret (sale_price), stok
- **Pilih varian** (ukuran/size) — price adjustment
- Tombol **+ Tambah ke Keranjang** & **Beli Sekarang**
- Tombol **Wishlist** (toggle)
- Deskripsi produk lengkap (dari CKEditor)
- **Ulasan pembeli** — tampil rating bintang, komentar, gambar ulasan, nama pembeli

### 4. Halaman Cek Resi (`/cek-resi`)
- Input nomor resi
- Pilih kurir (button tab: JNE, JNT, SiCepat, Anteraja, Tiki, POS, Ninja, SAP, Lion, Wahana)
- Hasil: informasi paket + **timeline perjalanan** kiriman
- API: RajaOngkir `POST /api/v1/track/waybill`

### 5. Auth
- **Register** — nama, email, no HP, password
- **Login** — email + password, redirect sesuai role
- **Logout** — konfirmasi SweetAlert2

---

### 6. Dashboard User (`/dashboard`)
- Ringkasan: total pesanan, total belanja
- Akses cepat: Pesanan, Profil, Alamat, Wishlist

### 7. Pesanan User (`/dashboard/pesanan`)
- List pesanan dengan **filter tombol status**:
  `Semua` | `Menunggu Bayar` | `Diproses` | `Dikirim` | `Diterima` | `Selesai` | `Dibatalkan`
- Detail pesanan: rincian produk, ongkir, total, metode bayar, nomor resi, status
- Tombol **Batalkan** (jika masih menunggu bayar/diproses)
- Tombol **Tandai Diterima** (jika status dikirim)
- Tombol **Lacak Resi** — panggil API RajaOngkir track, tampilkan timeline
- Setelah status `selesai` → muncul form **ulasan produk**

### 8. Profil & Alamat User
- Edit nama, email, no HP, foto profil
- Ganti password
- **Multi alamat pengiriman**: tambah, hapus, set default
- Form alamat: label, nama penerima, HP, alamat, dropdown provinsi → kota → kecamatan (RajaOngkir)

### 9. Wishlist User
- List produk yang di-wishlist
- Tombol hapus dari wishlist
- Tombol langsung ke detail produk / tambah ke keranjang

---

### 10. Keranjang (`/keranjang`)
- List item: foto, nama, varian, harga, quantity (+/−), hapus
- Input **kode kupon** → validasi → tampil diskon
- Ringkasan: subtotal, diskon, total
- Tombol **Checkout**

### 11. Checkout (`/checkout`)
- Pilih atau isi alamat pengiriman
- Dropdown provinsi → kota → kecamatan (AJAX via RajaOngkir)
- Pilih kurir + layanan → kalkulasi ongkir real-time (`POST /api/v1/calculate/district/domestic-cost`)
  - Kurir tersedia: jne, jnt, ninja, tiki, pos, anteraja, sicepat, sap, lion, wahana
- Data produk wajib ada field: **berat (gram)**, panjang, lebar, tinggi (untuk ongkir)
- Pilih metode pembayaran: **Midtrans** atau **Transfer Bank Manual**
- Ringkasan order sebelum konfirmasi
- Submit → buat order, redirect ke halaman bayar

### 12. Halaman Pembayaran (`/checkout/bayar/{orderNumber}`)
- **Midtrans:** tombol bayar → trigger Snap popup (Riplabs snap token)
- **Bank Transfer:** tampil nomor rekening toko, tombol upload bukti transfer
- Upload bukti: nama bank, nama pengirim, no rekening, nominal, foto bukti

### 13. Halaman Sukses (`/checkout/sukses/{orderNumber}`)
- Konfirmasi pesanan berhasil
- Ringkasan singkat order
- Tombol ke dashboard pesanan

---

### 14. Admin Panel (`/webmin`) — middleware auth + admin role

#### Dashboard Admin
- Statistik: total pesanan hari ini, pendapatan bulan ini, total produk, total pengguna
- Chart: grafik pesanan & pendapatan (Chart.js)
- Tabel pesanan terbaru

#### Kelola Pesanan (`/webmin/pesanan`)
- List semua pesanan + filter status + search
- Detail pesanan lengkap
- **Update status** (alur: menunggu_bayar → diproses → dikirim → diterima → selesai / dibatalkan)
- Saat status → **dikirim**: wajib input **nomor resi** + pilih kurir
- Konfirmasi Pembayaran Bank Transfer (approve/reject bukti transfer)

#### Kelola Produk (`/webmin/produk`)
- List produk + search + filter kategori
- **Buat produk**: nama, slug auto, SKU, kategori, harga, harga promo, stok, berat, dimensi, thumbnail, multi foto, deskripsi (CKEditor), varian, is_featured, is_promo, is_new, is_active
- Edit & hapus produk
- Upload gambar (file lokal ke storage)

#### Kelola Kategori (`/webmin/kategori`)
- CRUD kategori: nama, slug, ikon (emoji), gambar, deskripsi, sort_order, is_active

#### Kelola Pengguna (`/webmin/pengguna`)
- List pengguna + search
- Tambah user (nama, email, HP, role, password)
- Toggle aktif/nonaktif
- Hapus user

#### Pengaturan Toko (`/webmin/pengaturan`)
- Nama toko, tagline, email, HP, WA, alamat
- Info rekening bank (BCA, BNI, Mandiri)
- Kota asal pengiriman (untuk kalkulasi ongkir)
- Meta description

#### Laporan (`/webmin/laporan`)
- Filter by tanggal / bulan
- Total pendapatan, jumlah transaksi, produk terlaris
- Export / cetak laporan

---

## Database — Tabel Utama

```
users               — id, name, email, phone, password, role (admin/user), avatar, is_active
categories          — id, name, slug, icon, image, description, sort_order, is_active
products            — id, category_id, name, slug, sku, short_description, description(longText),
                      price, sale_price, stock, weight, length, width, height,
                      thumbnail, is_active, is_featured, is_promo, is_new, views, sold_count
product_images      — id, product_id, image, sort_order
product_variants    — id, product_id, name, value, price_adjustment, stock
coupons             — id, code, description, type(percentage/fixed), value, min_purchase,
                      max_discount, usage_limit, used_count, is_active, starts_at, expires_at
banners             — id, title, subtitle, image, link, button_text, sort_order, is_active
addresses           — id, user_id, label, recipient_name, phone, address,
                      province_id, province_name, city_id, city_name,
                      district_id, district_name, postal_code, is_default
carts               — id, user_id, product_id, product_variant_id, quantity
orders              — id, order_number, user_id, address_id, recipient_name, recipient_phone,
                      recipient_address, province_name, city_name, district_name, postal_code,
                      courier, courier_service, courier_service_name, shipping_cost, estimated_days,
                      subtotal, discount, coupon_code, total,
                      payment_method(bank_transfer/midtrans), payment_status(pending/paid/failed/expired),
                      payment_proof, midtrans_transaction_id, midtrans_snap_token, midtrans_response,
                      status(menunggu_bayar/diproses/dikirim/diterima/selesai/dibatalkan),
                      tracking_number, notes, cancel_reason,
                      paid_at, shipped_at, delivered_at, completed_at, cancelled_at
order_items         — id, order_id, product_id, product_variant_id, product_name,
                      product_thumbnail, variant_info, quantity, price, subtotal
payment_confirmations — id, order_id, user_id, bank_name, account_name, account_number,
                        amount, transfer_proof, status(pending/approved/rejected), admin_notes
product_reviews     — id, product_id, user_id, order_id, rating, comment, image, is_approved
wishlists           — id, user_id, product_id
store_settings      — id, key, value  (key-value config)

-- Default Laravel:
sessions, cache, jobs, password_reset_tokens (gabung di migration users)
```

---

## Integrasi API

### Midtrans via Riplabs
```
Endpoint  : POST https://restapi.riplabs.co.id/snaptokenbelanjayuk/getsnaptoken
Body form : key, order_id (prefix: BELANJAYUK + nomor), total_harga, nama, email, namaproduk
Response  : { "status": true, "snaptoken": "xxx..." }
Snap JS   : https://app.sandbox.midtrans.com/snap/snap.js (sandbox)
            https://app.midtrans.com/snap/snap.js (production)
Callback  : POST /midtrans/callback  — verifikasi dengan MIDTRANS_CALLBACK_KEY
```

### RajaOngkir Komerce
```
Base URL  : https://rajaongkir.komerce.id/api/v1
Header    : key: [API_KEY]

GET  /destination/province              — list provinsi
GET  /destination/city/{province_id}    — list kota
GET  /destination/district/{city_id}    — list kecamatan
POST /calculate/district/domestic-cost  — kalkulasi ongkir
     body: origin, destination, weight, courier
POST /track/waybill                     — cek resi
     body: awb (no resi), courier

Kurir valid: jne, jnt, ninja, tiki, pos, anteraja, sicepat, sap, lion, wahana
```

### PHPMailer SMTP
```
Host     : smtp.hostinger.com
Port     : 465
Security : SSL
From     : noreply@[DOMAIN_ANDA]
```

---

## Konfigurasi `.env` yang Diperlukan

```env
APP_NAME="BelanjaYuk!"
APP_URL=http://localhost
APP_LOCALE=id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belanjayuk
DB_USERNAME=root
DB_PASSWORD=[ISI_SENDIRI]

# Email admin notifikasi
ADMIN_EMAIL=[ISI_SENDIRI]

# Midtrans
MIDTRANS_CLIENT_KEY=[ISI_SENDIRI]
MIDTRANS_SERVER_KEY=[ISI_SENDIRI]
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SNAP_JS_URL=https://app.sandbox.midtrans.com/snap/snap.js
MIDTRANS_ORDER_PREFIX=INV

# Riplabs
RIPLABS_KEY=[ISI_SENDIRI]
RIPLABS_SNAPTOKEN_URL=https://restapi.riplabs.co.id/snaptokenbelanjayuk/getsnaptoken
MIDTRANS_CALLBACK_KEY=[ISI_SENDIRI]

# RajaOngkir
RAJAONGKIR_API_KEY=[ISI_SENDIRI]

# PHPMailer SMTP
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
MAIL_USERNAME=[ISI_SENDIRI]
MAIL_PASSWORD=[ISI_SENDIRI]
MAIL_FROM_ADDRESS=[ISI_SENDIRI]
MAIL_FROM_NAME="BelanjaYuk!"

# Admin WhatsApp
ADMIN_WHATSAPP=[ISI_SENDIRI]
```

---

## Seeder Data Dummy

Sertakan seeder dengan data berikut:
- **1 admin**: `admin@belanjayuk.com` / `admin123`
- **4 user dummy** dengan nama Indonesia
- **8 kategori** (fashion pria, fashion wanita, elektronik, alat rumah tangga, olahraga, kecantikan, sepatu & tas, mainan & hobi) — dengan gambar Unsplash
- **20 produk dummy** dengan gambar Unsplash, campuran is_featured, is_promo, is_new
- **Varian ukuran** S/M/L/XL untuk produk fashion (8 produk pertama)
- **4 banner hero** dengan gambar Unsplash
- **4 kupon diskon**: WELCOME10 (10%), HEMAT50 (Rp 50rb), FLASH20 (20%), GRATIS25K (Rp 25rb)
- **Review dummy** 2–4 review per produk (15 produk pertama)
- **Store settings**: nama toko, tagline, email, HP, WA, alamat, info rekening BCA/BNI/Mandiri, kota asal ongkir

---

## Catatan Desain

- Warna utama: **oranye** (`#f97316` / `orange-500`) + **putih**
- Aksen: oranye gelap untuk hover (`orange-600`)
- Font: sistem default Tailwind (atau Google Fonts Inter/Poppins)
- Setiap halaman: gradient subtle, card produk dengan shadow, badge status berwarna
- Navbar sticky dengan shadow saat scroll
- Mobile responsive di semua halaman
- Animasi scroll reveal ringan (IntersectionObserver) di home page
- Tombol "Hubungi via WhatsApp" floating di corner

---

## File yang Perlu Dibuat (Prioritas Utama)

```
app/
  Http/
    Controllers/
      Admin/
        DashboardController.php
        AdminOrderController.php
        AdminProductController.php
        AdminCategoryController.php
        AdminUserController.php
        AdminSettingController.php
        AdminReportController.php
      Auth/AuthController.php
      Api/RajaOngkirController.php
      HomeController.php
      ProductController.php
      CartController.php
      CheckoutController.php
      UserController.php
      CheckResiController.php
    Middleware/AdminMiddleware.php
  Models/
    User.php, Product.php, Category.php, Order.php, OrderItem.php,
    Cart.php, Address.php, Banner.php, Coupon.php, ProductVariant.php,
    ProductImage.php, ProductReview.php, PaymentConfirmation.php,
    Wishlist.php, StoreSetting.php
  Services/
    MidtransService.php, RajaOngkirService.php, MailService.php

database/
  migrations/  (semua tabel termasuk sessions, cache, jobs, password_reset_tokens)
  seeders/DatabaseSeeder.php

resources/views/
  layouts/app.blade.php, admin.blade.php
  pages/home.blade.php, products.blade.php, product-detail.blade.php, cek-resi.blade.php
  auth/login.blade.php, register.blade.php
  user/dashboard.blade.php, orders.blade.php, order-detail.blade.php,
        profile.blade.php, addresses.blade.php, wishlist.blade.php,
        cart.blade.php, checkout.blade.php, payment.blade.php, checkout-success.blade.php
  admin/dashboard.blade.php
        orders/index.blade.php, show.blade.php, pending-payments.blade.php
        products/index.blade.php, create.blade.php, edit.blade.php
        categories/index.blade.php
        users/index.blade.php
        reports/index.blade.php
        settings/index.blade.php
  components/product-card.blade.php
  emails/order-confirmation.blade.php, order-status.blade.php,
         admin-new-order.blade.php, admin-payment-proof.blade.php

routes/web.php
.env.example
README.md
```

---

## Instruksi untuk Claude

1. Buat semua file di atas sesuai struktur Laravel MVC standar
2. Ikuti semua aturan teknis yang disebutkan (Tailwind CDN, no @apply, SweetAlert, CKEditor, dll)
3. Pastikan semua form memiliki styling yang benar (tidak ada input/button tanpa desain)
4. Semua halaman responsif mobile
5. Implementasikan security: CSRF, validasi input, middleware admin, sanitasi data
6. Kirim file dalam batch ZIP — prioritaskan file inti terlebih dahulu
7. Jangan masukkan API key, password, atau kredensial rahasia di kode — gunakan env variable
