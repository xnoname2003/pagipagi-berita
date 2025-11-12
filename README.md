<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>

# PagiPagi Berita

Sebuah aplikasi web berita sederhana berbasis Laravel 12. README ini diperbarui untuk mencerminkan perubahan terbaru pada proyek: penyiapan lewat composer scripts, penggunaan Filament (admin), model tambahan seperti, dan struktur migration/factory yang sudah ada dalam repo.

Repository ini berisi:
- Aplikasi Laravel 12 (PHP ^8.2)
- Filament admin (resource di `app/Filament/Resources`)
- Models: `News`, `Komentar`, `Wartawan`, `User`
- Migration, Factory, dan Seeder untuk pengisian data dummy

## Ringkasan Perubahan Terkini
- Menambahkan resource Filament untuk admin di `app/Filament/Resources`
- Menambah/menyesuaikan model serta relasi pada `News`
- Menyediakan factories di `database/factories` dan migration di `database/migrations`
- Menambahkan script composer `setup` untuk instalasi dan build otomatis

## Persyaratan
- PHP ^8.2
- Composer
- Node.js & npm
- Database (MySQL / PostgreSQL / SQLite)

## Instalasi (cepat)
Ikuti langkah berikut di macOS (zsh):

1) Clone repository

    ```bash
     git clone https://github.com/xnoname2003/pagipagi-berita.git
    ```
    ```bash
     cd pagipagi-berita
    ```

2) Install dependency PHP

    ```bash
     composer install
    ```

3) Copy file environment dan generate key

    ```bash
     cp .env.example .env
    ```
    ```bash
     php artisan key:generate
    ```

4) Sesuaikan `.env` untuk database lalu jalankan migration + seed (opsional)

    ```bash
     php artisan migrate --seed
    ```

5) Install dependency JS & jalankan Vite (development)

    ```bash
     npm install
    ```
    ```bash
     npm run dev
    ```

Jika ingin build untuk production:

```bash
npm run build
```

## Perintah Penting
- Menjalankan server pengembangan: `php artisan serve`
- Menjalankan test: `composer test` atau `php artisan test`
- Menjalankan queue listener (dipakai di script dev): `php artisan queue:listen`

## Filament (Admin)
Folder Filament ada di `app/Filament/Resources`. Untuk mengakses panel admin:

1) Buat user admin (jika belum ada). Contoh lewat tinker:

    ```bash
     php artisan make:filament-user
    ```

2) Login ke `/admin` (path default Filament). Jika Anda mengubah route atau guard, sesuaikan konfigurasi Filament.

## Database, Factories & Seeders
- Migrations tersedia di `database/migrations` (termasuk `news`, `wartawan`, `komentar`).
- Factories ada di `database/factories` untuk pembuatan data dummy (NewsFactory, WartawanFactory, KomentarFactory, dll).
- Seeder utama ada di `database/seeders/DatabaseSeeder.php`.

Contoh menjalankan seeder terpisah:

```bash
php artisan db:seed --class=NewsSeeder
```

## Testing
Untuk menjalankan unit/feature tests:

```bash
php artisan test
```

atau

```bash
composer test
```

## Struktur Utama (singkat)
- `app/Models` — model Eloquent (News, Kategori, Komentar, Wartawan, User)
- `app/Http/Controllers` — controller untuk frontend
- `app/Filament/Resources` — resource Filament (admin)
- `database/migrations` — migration schema
- `database/factories` — factory untuk testing / seeding
- `resources/views` — blade view untuk tampilan publik
- `routes/web.php` — route frontend

## Screenshot Hasil Running
1. Halaman Utama `/`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/3ebe4616-e656-463f-9af6-dbce1030525d" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/421a7da0-6d85-4241-9f72-c9ca4e99b3b3" />

2. Halaman Detail Berita `/news/{news}`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/22859d51-cb50-4eea-85f9-d1e6c4e56c14" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/e6f69866-a444-4a59-903d-ed8d9efb4fd5" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/f360f869-6841-4b96-8c28-571e04aa0fe8" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/35349fd2-3855-48f8-a2dd-c2e264c34021" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/f931a293-7887-4f86-aaad-a9398803e834" />

3. Halaman Tambah Komentar `/news/{news}/komentar`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/83639627-bbe2-4f8f-87a0-93c35cedb4d9" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/e58ab1c1-b2a9-4750-942c-edf861aff29c" />

4. Halaman Admin (Dashboard) `/admin`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/726e39e4-7a19-421a-b584-aaa86a64c49c" />

5. Halaman Admin (Komentars) `/admin/komentars`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/98e38b88-171d-41de-b6bb-787d0350939d" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/a9953c35-5957-4bb4-a79d-b723e8616778" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/10a62211-6d40-400c-b598-12e63b288d14" />

6. Halaman Admin (News) `/admin/news`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/457f620c-e252-403b-9fa5-00bd31320810" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/bfb93aa7-397e-49fd-bb30-c063dd69e3b2" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/a5dd3706-3325-4b9c-9065-3bc8bde236cc" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/ca7027a4-fb8d-4b07-a444-ed6f6bc517b0" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/ccba6c06-acd9-43fe-9fd2-527d9db222a7" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/55746a66-66d0-477c-bce4-01f8755345a5" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/cfccf359-719f-47f3-b4f4-39a236cd6b2a" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/ced3c5e9-369b-4dd3-a50f-02d41ef6e0c6" />

7. Halaman Admin (Wartawans) `/admin/wartawans`
    <img width="1470" height="924" alt="Image" src="https://github.com/ user-attachments/assets/9ae44794-831a-421d-ad13-192b5d6853bb" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/b6d090fb-42b2-42a7-a329-286a2c3dba3b" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/ea2e63d7-0bb4-41c9-b3e8-06e43d8a2a94" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/2335e0d9-da72-4c79-99ad-e7ee79db4bf1" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/26fcb6f5-594e-475d-b25f-7b5338467384" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/b06123a7-9ca0-40bf-9f4f-04d591ba2319" />
