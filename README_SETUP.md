# Laravel Project Setup

## Spesifikasi
- Laravel 11 (Latest)
- PHP 8.2+
- MySQL
- Laravel Sanctum (Auth API)
- Filament v3 (Admin Panel)

## Instalasi

1. **Clone & Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

2. **Setup Database**
   - Pastikan MySQL berjalan.
   - Buat database `laravel` (atau sesuaikan di module `.env`).
   - Copy `.env.example` ke `.env` (sudah dilakukan saat install).
   - Generate Key:
     ```bash
     php artisan key:generate
     ```

3. **Migrate & Seed**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   *Seeder akan membuat User dummy dan 10 Product dummy.*

4. **Create Admin User (Filament)**
   ```bash
   php artisan make:filament-user
   ```
   Ikuti langkah-langkahnya (Name, Email, Password).

5. **Run Server**
   ```bash
   php artisan serve
   ```

## Fitur API

Base URL: `http://127.0.0.1:8000/api`

### Auth API
- **POST** `/register`
  - Body: `{name, email, password}`
- **POST** `/login`
  - Body: `{email, password}`
- **POST** `/logout` (Bearer Token required)
- **GET** `/user` (Bearer Token required)

### Product API (Protected: Bearer Token)
- **GET** `/products` - List products
- **POST** `/products` - Create product
  - Body: `{name, description, price, stock}`
- **GET** `/products/{id}` - Detail product
- **PUT** `/products/{id}` - Update product
- **DELETE** `/products/{id}` - Delete product

**Format Header Auth:**
`Authorization: Bearer <your_token_here>`

## Admin Panel (Filament)

Akses: `http://127.0.0.1:8000/admin`
Login menggunakan user yang dibuat dengan `make:filament-user` atau user dari seeder (jika ada role admin, tapi default Filament user model auth sama dengan app User model).
*Catatan: Filament memerlukan implementasi `FilamentUser` interface untuk restrict access di production, tapi di local environment biasanya `canAccessPanel` return true jika tidak didefine.*
(Default Filament panel access check: semua user bisa login di local environment jika `FilamentUser` interface tidak diimplementasikan secara strict, atau cek `AdminPanelProvider` configuration).

## Testing Postman

1. **Register/Login**
   - Hit endpoint `/api/login` dengan credentials valid.
   - Copy `token` dari response JSON.
2. **Access Protected Route**
   - Buka tab baru di Postman.
   - Pilih tab **Authorization**.
   - Type: **Bearer Token**.
   - Paste token.
   - Hit `/api/products`.
