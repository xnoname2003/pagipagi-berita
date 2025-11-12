<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
# PagiPagi Berita

Sebuah aplikasi web berita sederhana berbasis Laravel 12. README ini diperbarui untuk mencerminkan perubahan terbaru pada proyek: penyiapan lewat composer scripts, penggunaan Filament (admin), model tambahan seperti `Kategori`, dan struktur migration/factory yang sudah ada dalam repo.

Repository ini berisi:
- Aplikasi Laravel 12 (PHP ^8.2)
- Filament admin (resource di `app/Filament/Resources`)
- Models: `News`, `Kategori`, `Komentar`, `Wartawan`, `User`
- Migration, Factory, dan Seeder untuk pengisian data dummy

## Ringkasan Perubahan Terkini
- Menambahkan resource Filament untuk admin di `app/Filament/Resources`
- Menambah/menyesuaikan model `Kategori` serta relasi pada `News`
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
git clone <repository-url>
cd pagipagi-berita
```

2) Install dependency PHP

```bash
composer install
```

3) Copy file environment dan generate key

```bash
cp .env.example .env
php artisan key:generate
```

4) Sesuaikan `.env` untuk database lalu jalankan migration + seed (opsional)

```bash
php artisan migrate --seed
```

5) Install dependency JS & jalankan Vite (development)

```bash
npm install
npm run dev
```

Jika ingin build untuk production:

```bash
npm run build
```

Catatan: repo juga menyediakan script composer `setup` yang menjalankan rangkaian langkah instalasi dan build. Anda dapat menjalankannya dengan:

```bash
composer run setup
```

## Perintah Penting
- Menjalankan server pengembangan: `php artisan serve`
- Menjalankan test: `composer test` atau `php artisan test`
- Menjalankan queue listener (dipakai di script dev): `php artisan queue:listen`

## Filament (Admin)
Folder Filament ada di `app/Filament/Resources`. Untuk mengakses panel admin:

1) Buat user admin (jika belum ada). Contoh lewat tinker:

```bash
php artisan tinker
>>> \App\Models\User::factory()->create(['email' => 'admin@example.com', 'name' => 'Admin']);
```

2) Login ke `/admin` (path default Filament). Jika Anda mengubah route atau guard, sesuaikan konfigurasi Filament.

## Database, Factories & Seeders
- Migrations tersedia di `database/migrations` (termasuk `news`, `wartawan`, `komentar`, `kategoris`).
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

## Tips Pengembangan
- Gunakan eager loading (`with(...)`) untuk menghindari N+1 query pada relasi `news->wartawan` dan `news->komentar`.
- Gunakan `php artisan migrate:fresh --seed` saat ingin reset database lokal.

## Kontribusi
Silakan buka issue atau pull request. Ikuti standar code style (Laravel Pint tersedia).

## Lisensi
MIT

---

Jika Anda mau, saya bisa:
- menambahkan badge status (CI) di bagian atas README
- menambahkan instruksi spesifik untuk Docker / Sail
- atau membuat README versi bahasa Inggris.
Beritahu mana yang mau ditambahkan.

3. Halaman Tambah Komentar `/news/{news}/komentar`
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/425bad0e-5a5e-49d1-b77c-12dc9de0f2b6" />
    <img width="1470" height="924" alt="Image" src="https://github.com/user-attachments/assets/ca2084e5-38a6-4b40-bc3a-24513aca510c" />
