# 📘 Swift Planetarium - Documentation

Aplikasi ini adalah sistem backend modern yang menggabungkan **RESTful API** yang aman dan **Admin Panel** yang user-friendly. Dibangun menggunakan Laravel 11, Filament v3, dan JWT Authentication.

---

## 🏗️ Arsitektur Aplikasi

### Technology Stack
-   **Framework**: Laravel 11
-   **Language**: PHP 8.2+
-   **Database**: MySQL
-   **Authentication**: JWT (JSON Web Token) via `php-open-source-saver/jwt-auth`
-   **Admin Panel**: FilamentPHP v3
-   **Server**: Apache/Nginx (Local: `php artisan serve`)

### Struktur Folder Utama
-   `app/Http/Controllers/Api`: Menangani logic request & response API.
-   `app/Http/Resources`: Mengatur format JSON response agar konsisten.
-   `app/Http/Requests`: Validasi input request terpusat.
-   `app/Filament`: Logic untuk Admin Panel (Resources, Widgets, Pages).
-   `routes/api.php`: Definisi endpoint API.

---

## 🔐 Alur Autentikasi (JWT)

Sistem ini menggunakan **Stateless Authentication** dengan JWT. Client (Frontend/Mobile) tidak perlu menyimpan session/cookie, cukup menyimpan **Token**.

### 1. Proses Login
1.  Client mengirim `POST /api/login` dengan `email` dan `password`.
2.  Server memvalidasi kredensial.
3.  Jika valid, Server men-generate **Access Token** (String JWT panjang).
4.  Server merespons dengan JSON berisi `token`, `token_type` (Bearer), dan `expires_in`.

### 2. Mengakses Protected Route
1.  Client ingin mengakses data produk (`GET /api/products`).
2.  Client **WAJIB** menyertakan token di Header request:
    ```http
    Authorization: Bearer <token_anda_disini>
    ```
3.  Server memvalidasi signature dan masa berlaku token.
4.  Jika valid -> Request diproses.
5.  Jika expired/invalid -> Server merespons `401 Unauthorized`.

### 3. Refresh Token
Token memiliki masa berlaku (default 60 menit). Jika expired:
1.  Client mengirim request ke `POST /api/refresh` dengan token lama di header.
2.  Server mem-blacklist token lama dan memberikan **Token Baru**.

---

## 🔌 API Integration Guide

### Standar Response
Semua endpoint menggunakan format JSON standar:

**Sukses (200 OK / 201 Created)**
```json
{
    "success": true,
    "message": "Operasi berhasil",
    "data": { ... } // Object atau Array data
}
```

**Gagal (400 - 500)**
```json
{
    "success": false,
    "message": "Pesan error yang jelas",
    "error": "Detail teknis error (opsional)"
}
```

### Daftar Endpoint Utama

#### Auth
-   `POST /api/register`: Pendaftaran user baru.
-   `POST /api/login`: Mendapatkan token, wajib untuk askes fitur lain.
-   `POST /api/logout`: Menghapus sesi token.
-   `GET /api/user`: Mendapatkan profil user yang sedang login.

#### Products (CRUD)
-   `GET /api/products`: Mengambil semua data produk (Terbaru diatas).
-   `POST /api/products`: Tambah produk baru (Perlu validasi).
-   `GET /api/products/{id}`: Detail satu produk.
-   `PUT /api/products/{id}`: Update data produk.
-   `DELETE /api/products/{id}`: Hapus produk selamanya.

---

## 🖥️ Admin Panel (Filament)

Aplikasi memiliki backend dashboard untuk administrator mengelola konten tanpa koding.

**Fitur Utama:**
1.  **Dashboard**: Statistik ringkas (Total Produk, Stok, Nilai Aset).
2.  **Manajemen Produk**: Tabel data dengan fitur pencarian, filter, edit, dan hapus.
3.  **Lokalisasi Indonesia**:
    -   Mata Uang: **Rupiah (Rp)**.
    -   Format Angka: Menggunakan pemisah ribuan titik (contoh: `150.000`).
    -   Label: Semua menu dan form menggunakan Bahasa Indonesia.
4.  **Multi-Bahasa**: Switcher bahasa (ID/EN) di pojok kanan atas.

---

## 💾 Skema Database

### `users`
Menyimpan data otentikasi admin dan user API.
-   `id`: Primary Key.
-   `name`: Nama lengkap.
-   `email`: Email unik untuk login.
-   `password`: Hash password (Bcrypt).

### `products`
Menyimpan katalog barang.
-   `id`: Primary Key.
-   `name`: Nama produk (String).
-   `description`: Penjelasan detail produk (Text/Nullable).
-   `price`: Harga satuan (Decimal).
-   `stock`: Jumlah stok tersedia (Integer).
-   `created_at`, `updated_at`: Timestamp otomatis.

---

## 🚀 Deployment & Setup Production

Jika aplikasi ini akan di-deploy ke server production (VPS/Hosting):

1.  **Environment**: Ubah `.env`:
    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://domain-anda.com
    ```
2.  **JWT Secret**: Generate secret baru yang kuat:
    ```bash
    php artisan jwt:secret
    ```
3.  **Optimization**: Cache konfigurasi dan route untuk performa:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
4.  **Admin User**: Pastikan membuat user admin baru yang aman.
