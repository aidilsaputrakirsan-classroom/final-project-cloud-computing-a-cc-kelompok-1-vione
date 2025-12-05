# 🐾 PawCare - Sistem Informasi Booking Appointment Klinik Dokter Hewan dan Adopsi Hewan Berbasis Web

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat\&logo=php\&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat\&logo=bootstrap\&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

**PawCare** adalah aplikasi web berbasis Laravel yang menyediakan layanan untuk membantu pemilik hewan, dokter hewan, dan pengelola shelter dalam melakukan manajemen hewan, rekam medis, appointment klinik, serta proses adopsi hewan shelter secara digital, praktis, dan terintegrasi.

---

## Daftar Isi

* [Fitur Utama](#fitur-utama)
* [Tech Stack](#tech-stack)
* [Persyaratan Sistem](#persyaratan-sistem)
* [Instalasi](#instalasi)
* [Konfigurasi](#konfigurasi)
* [Role & Permissions](#role--permissions)
* [Fitur Berdasarkan Role](#fitur-berdasarkan-role)
* [Generate Dokumen](#generate-dokumen)
* [Import / Upload Data](#import--upload-data)
* [Screenshot](#screenshot)
* [Struktur Database](#struktur-database)
* [Penggunaan](#penggunaan)
* [Deployment](#deployment)
* [Kontribusi](#kontribusi)
* [Lisensi](#lisensi)

---

# Fitur Utama

### Manajemen Hewan Peliharaan

* ✅ **CRUD Hewan** – Tambah, edit, hapus, dan lihat data hewan
* ✅ **Upload Foto Hewan** – Menyimpan foto di storage
* ✅ **Informasi Komprehensif** – Jenis, ras, umur, catatan kesehatan
* ✅ **Relasi dengan User** – Hewan terhubung dengan pemilik yang login

### Rekam Medis

* ✅ **Pencatatan Rekam Medis** – Diagnosa, catatan dokter, tindakan medis
* ✅ **Riwayat Kesehatan** – Rekam medis tampil berdasarkan hewan
* ✅ **Terhubung Appointment** – Rekam medis dibuat melalui pemeriksaan

### Appointment Dokter Hewan

* ✅ **Booking Online** – User membuat janji pemeriksaan
* ✅ **Approval Admin/Dokter** – Admin mengatur status appointment
* ✅ **Status Kontrol** – Pending, Approved, Completed
* ✅ **Catatan Dokter** – Dokter dapat menambahkan feedback pemeriksaan

### Adopsi Hewan Shelter

* ✅ **Daftar Hewan Shelter** – Hewan yang siap diadopsi
* ✅ **Detail Hewan Shelter** – Foto, deskripsi, usia, kondisi
* ✅ **Request Adopsi** – User dapat mengajukan adopsi
* ✅ **Approval Admin** – Admin menerima atau menolak permintaan adopsi
* ✅ **Status Otomatis** – Status hewan berubah menjadi *Adopted*

### Manajemen Dokter

* ✅ **CRUD Dokter** – Admin mengelola profil dokter
* ✅ **Foto & Kontak Dokter** – Data lengkap disimpan dalam model VetProfile
* ✅ **Relasi Appointment** – Appointment terhubung dengan dokter

### Dashboard Admin

* ✅ **Statistik Keseluruhan** – Total hewan, hewan shelter, appointment
* ✅ **Daftar Permintaan Adopsi** – Monitoring permintaan terbaru
* ✅ **Log Aktivitas Pengguna** – Semua aktivitas tercatat otomatis

### Activity Log

* ✅ **Pencatatan Otomatis** – Login, edit data, adopsi, appointment
* ✅ **Monitoring Admin** – Riwayat aktivitas dapat diakses melalui dashboard

---

# Tech Stack

### Backend

* **Laravel 12.x**
* **PHP 8.2+**
* **MySQL / MariaDB**

### Frontend

* **Blade Template**
* **Bootstrap 5.3**
* **JavaScript Vanilla**

### Libraries & Packages

* **Laravel Breeze** – Autentikasi
* **Laravel Storage** – Upload foto hewan, dokter, shelter

---

# Persyaratan Sistem

* PHP >= 8.2
* MySQL / MariaDB
* Composer
* Node.js & NPM
* Extension PHP:

  * OpenSSL
  * PDO
  * Mbstring
  * Tokenizer
  * XML
  * JSON
  * GD

---

# Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/aidilsaputrakirsan-classroom/final-project-cloud-computing-a-cc-kelompok-1-vione
cd final-project-cloud-computing-a-cc-kelompok-1-vione
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pawcare
DB_USERNAME=A1Vione
DB_PASSWORD=A1pawcare
```

### 5. Migrasi Database

```bash
php artisan migrate --seed
```

### 6. Setup Storage

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run dev
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

---

# Konfigurasi

### Email (opsional)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@pawcare.com
MAIL_FROM_NAME="PawCare System"
```

---

# Role & Permissions

| Role      | Deskripsi                                             |
| --------- | ----------------------------------------------------- |
| **User**  | Pemilik hewan yang dapat membuat appointment & adopsi |
| **Admin** | Mengelola seluruh fitur aplikasi PawCare              |

---

# Fitur Berdasarkan Role

### User

* 🐶 Mengelola hewan peliharaan
* 📅 Membuat appointment
* 🏠 Mengajukan adopsi
* 🩺 Melihat rekam medis hewan
* 👤 Mengatur profil

### Admin

* 👨‍⚕️ Mengelola data dokter
* 🐾 Mengelola hewan peliharaan
* 🏠 Mengelola hewan shelter
* 📅 Mengelola appointment
* 📝 Mengelola rekam medis
* 🔍 Memproses request adopsi
* 📊 Mengakses dashboard dan activity log

---

# Generate Dokumen

Karena PawCare tidak memiliki fitur PDF bawaan, bagian ini diadaptasi menjadi:

### Dokumentasi yang Dapat Diekspor / Dicetak

* 🖨 **Detail Appointment** dapat dicetak dari browser
* 🖨 **Rekam Medis Hewan** dapat dicetak
* 🖨 **Detail Hewan Shelter** juga dapat dicetak

*(Pengembangan fitur PDF dapat ditambahkan melalui DomPDF jika diperlukan.)*

---

# Import / Upload Data

### Upload yang Dapat Dilakukan:

* 📤 Upload foto hewan peliharaan
* 📤 Upload foto dokter
* 📤 Upload foto hewan shelter
* 📤 Upload profil user

### Cara Upload:

* Gunakan form pada halaman manajemen masing-masing
* File disimpan di `storage/app/public`
* Link file secara otomatis dibuat dengan `storage:link`

---

# Struktur Database

### Tabel Utama

* **users**
* **pets**
* **appointments**
* **pet_medical_histories**
* **vet_profiles**
* **shelter_pets**
* **adoption_requests**
* **activity_logs**
* **password_reset_tokens**
* **personal_access_tokens**
* **jobs**
* **failed_jobs**

### Relasi Inti

```
users (1) --- (n) pets
pets (1) --- (n) pet_medical_histories

users (1) --- (n) appointments
vet_profiles (1) --- (n) appointments

shelter_pets (1) --- (n) adoption_requests
users       (1) --- (n) adoption_requests
```

---

# Penggunaan

### Alur Penggunaan:

1. User login
2. User menambahkan hewan peliharaannya
3. User membuat appointment
4. Dokter/ Admin menyetujui appointment
5. Setelah pemeriksaan, rekam medis dibuat
6. User dapat melihat rekam medis
7. User dapat mengajukan adopsi hewan shelter
8. Admin memproses permintaan adopsi

---


# Deployment
### Requirements Production

- PHP 8.2 atau lebih tinggi
- MySQL/MariaDB
- Composer
- Node.js & NPM
- Web server dengan SSL certificate

### Production Setup

1. Clone repository ke server
2. Install dependencies
3. Setup environment production
4. Optimize aplikasi:

```bash
# Optimize configuration
php artisan config:cache

# Optimize routes
php artisan route:cache

# Optimize views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

5. Setup cron job untuk scheduled tasks:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

6. Setup queue worker (optional):

```bash
php artisan queue:work --daemon
```

### GitHub Actions

Project ini sudah dilengkapi dengan GitHub Actions untuk auto-deployment. Konfigurasi dapat dilihat di `.github/workflows/deploy.yml`.

## Kontribusi

Kontribusi selalu diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Coding Standards

- Ikuti PSR-12 coding standard
- Gunakan meaningful variable dan function names
- Tambahkan komentar untuk logika yang kompleks
- Write clean dan maintainable code

## Optimize Application
```
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## Cron Jobs (opsional)
```
* * * * * php artisan schedule:run
```

# Lisensi
Project ini dilisensikan di bawah [MIT License](LICENSE).

# Credits
- **Laravel Framework** - [https://laravel.com](https://laravel.com)
- **Bootstrap**

# Support
Jika memiliki pertanyaan:
- Hubungi tim developer  
- Buat issue melalui GitHub repository  

---

**Developed with ❤️ for Vione_KelompokA1 Program Studi Sistem Informasi Institut Teknologi Kalimantan**

*Last updated: 5 Desember 2025*