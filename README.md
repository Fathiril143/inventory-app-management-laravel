# Inventory Management System

Aplikasi inventaris berbasis Laravel untuk mengelola produk, kategori, supplier, akun staff, serta pergerakan stok barang masuk dan keluar.

## Teknologi

- PHP 8.2
- Laravel 12
- MySQL
- Blade

## Fitur

- Login dan logout
- Peran admin dan staff
- Admin dapat mengelola produk, kategori, supplier, dan akun staff
- Staff dapat melihat produk serta mengelola catatan barang masuk dan keluar
- Stok produk diperbarui saat catatan barang masuk/keluar dibuat, diubah, atau dihapus
- Validasi input dan perlindungan CSRF pada formulir

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- MySQL dari XAMPP
- Ekstensi PHP yang dibutuhkan Laravel dan Composer

## Instalasi

1. Salin folder proyek ke komputer, lalu buka terminal di folder proyek:

   ```text
   C:\xampp\htdocs\inventory-laravel
   ```

2. Pasang dependensi Laravel:

   ```bash
   composer install
   ```

3. Buat file `.env` dari `.env.example`. Di XAMPP Shell atau Git Bash, gunakan:

   ```bash
   cp .env.example .env
   ```

4. Buat database baru bernama `inventory_laravel_db` melalui phpMyAdmin.

5. Atur koneksi database di file `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_laravel_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` jika konfigurasi MySQL berbeda.

6. Buat application key, lalu buat tabel dan akun admin awal:

   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan db:seed --class=AdminUserSeeder
   ```

7. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

8. Buka alamat berikut di browser:

   ```text
   http://127.0.0.1:8000/login
   ```

## Akun awal

- Email: `admin@inventory.test`
- Password: `Admin123!`

Setelah login sebagai admin, buat akun staff melalui menu **Kelola staff**.

## Alur aplikasi

1. Admin login.
2. Admin menambahkan kategori dan supplier.
3. Admin menambahkan produk dan memilih kategori serta supplier.
4. Staff login dan membuka menu barang masuk/keluar.
5. Staff mengisi formulir transaksi.
6. Sistem memvalidasi data dan kecukupan stok.
7. Sistem menyimpan transaksi, memperbarui stok, lalu mengarahkan kembali ke daftar transaksi.
8. Daftar menampilkan transaksi yang tersimpan.

## Arsitektur MVC

- **Model** (`app/Models`) mewakili data dan hubungan database, misalnya `Product`, `Category`, `Supplier`, dan `StockMovement`.
- **View** (`resources/views`) menampilkan halaman HTML dengan Blade, seperti formulir login, daftar produk, dan formulir transaksi stok.
- **Controller** (`app/Http/Controllers`) menerima permintaan dari pengguna, memvalidasi input, menjalankan proses aplikasi, lalu memilih view atau redirect.
- **Route** (`routes/web.php`) menghubungkan alamat URL dan metode HTTP ke controller.
- **Migration** (`database/migrations`) mendefinisikan struktur tabel database.
- **Seeder** (`database/seeders`) mengisi data awal, termasuk akun admin.

## Bukti screenshot

Simpan screenshot untuk bukti tugas di folder `screenshots/`:

- `screenshots/routes.png` — route di `routes/web.php` atau hasil `php artisan route:list`
- `screenshots/crud-produk.png` — daftar produk dan aksi CRUD
- `screenshots/crud-stok.png` — formulir dan daftar barang masuk/keluar
- `screenshots/blade-view.png` — salah satu file Blade di VS Code
- `screenshots/alur-validasi.png` — pesan validasi saat SKU duplikat digunakan
- `screenshots/alur-lengkap.png` — formulir, hasil simpan, redirect, dan data yang tampil


## Catatan

- MySQL harus berjalan di XAMPP saat aplikasi dipakai.
- Jendela terminal yang menjalankan `php artisan serve` harus tetap terbuka selama aplikasi digunakan.
- Jangan memakai `php artisan migrate:fresh` pada database yang berisi data penting karena perintah itu menghapus tabel lalu membuatnya ulang.