# UMKM App

Aplikasi UMKM berbasis Laravel 12 untuk membantu pengelolaan usaha mikro, kecil, dan menengah.

## Deployment ke InfinityFree

Untuk mendeploy aplikasi ini ke InfinityFree, ikuti langkah-langkah berikut:

### 1. Persiapan
1. Fork atau clone repository ini
2. Pastikan semua dependensi telah terinstall:
   ```bash
   composer install
   npm install
   npm run build
   ```

### 2. Konfigurasi .env
1. Salin file `.env.example` menjadi `.env`
2. Generate APP_KEY:
   ```bash
   php artisan key:generate
   ```
3. Sesuaikan konfigurasi database sesuai dengan database InfinityFree

### 3. Upload ke InfinityFree
1. Registrasi akun di https://www.infinityfree.net/
2. Buat situs baru dan pilih subdomain
3. Upload semua file ke direktori root menggunakan FTP atau File Manager
4. Pastikan struktur folder berikut dapat ditulis:
   - storage/
   - bootstrap/cache/

### 4. Instalasi di Server
1. Akses situs Anda melalui terminal atau File Manager InfinityFree
2. Jalankan perintah:
   ```bash
   composer install --no-dev
   php artisan migrate --force
   php artisan db:seed
   php artisan storage:link
   ```

### 5. Konfigurasi Tambahan
- Pastikan file .htaccess sudah sesuai dengan konfigurasi InfinityFree
- Cek bahwa URL utama di .env sesuai dengan domain InfinityFree Anda

## Fitur Utama
- CRUD Produk UMKM
- CRUD Kategori Produk
- Sistem Keranjang Belanja
- Proses Checkout
- Dashboard Admin
- Responsive Design

## Teknologi yang Digunakan
- Laravel 12
- PHP 8.1+
- MySQL
- Tailwind CSS
- Vite
