# Petunjuk Deployment ke InfinityFree

## Struktur Folder yang Benar

Untuk membuat aplikasi Laravel berfungsi di InfinityFree, Anda perlu mengubah struktur folder agar folder 'public' menjadi root dokumentasi web server.

### Opsi 1: Mengganti isi folder htdocs (Direkomendasikan)
1. Setelah clone/download repository ini, copy semua isi folder ke folder htdocs di akun InfinityFree Anda
2. Di InfinityFree File Manager, rename file .htaccess di folder public/ menjadi .htaccess (timpa file .htaccess yang ada di htdocs)
3. File-file lainnya tetap pada tempatnya
4. Yang penting: folder public/ harus berisi file index.php yang merupakan entry point utama Laravel

### Opsi 2: Menggunakan .htaccess untuk redirect (Alternatif)
Jika tidak bisa mengganti struktur folder, Anda bisa menggunakan .htaccess di folder htdocs untuk mengarahkan ke folder public:

# .htaccess di htdocs/
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]

## Konfigurasi .env
1. Salin file .env.example menjadi .env
2. Sesuaikan konfigurasi database dengan detail dari InfinityFree
3. Generate APP_KEY dengan menjalankan: php artisan key:generate

## Instalasi
1. Upload semua file ke folder htdocs
2. Akses situs melalui SSH/File Manager InfinityFree
3. Jalankan: composer install
4. Jalankan: php artisan migrate --force
5. Jalankan: php artisan db:seed (jika diperlukan)

## Konfigurasi Tambahan
- Pastikan folder berikut dapat ditulis: storage/, bootstrap/cache/
- Jika menggunakan database MySQL InfinityFree, sesuaikan konfigurasi di .env
- Aktifkan rewrite module di .htaccess jika belum aktif