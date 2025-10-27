# 🍜 Rasanesia - Recipe Sharing Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-blue.svg" alt="PHP">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

<p align="center">
  <strong>A comprehensive recipe sharing and management platform built with Laravel</strong>
</p>

---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 About

**Rasanesia** is a full-featured recipe sharing platform that allows users to discover, create, and share their favorite Indonesian recipes. The platform features user authentication, recipe management, review and rating systems, favorites functionality, and admin dashboard for content management.

### Key Highlights

- 📱 **User-Friendly Interface** - Modern, responsive design for seamless experience
- 🔐 **Secure Authentication** - Complete authentication with email verification
- ⭐ **Review & Rating System** - Users can rate and review recipes
- 💾 **Favorites Management** - Save and organize favorite recipes
- 📊 **Admin Dashboard** - Full administrative control
- 📄 **PDF Export** - Download recipes as PDF
- 📥 **Excel Import** - Bulk import recipes from Excel

---

## ✨ Features

### Public Features
- 🏠 **Homepage** - Browse all recipes without registration
- 🔍 **Search Functionality** - Search recipes by name, description, or province
- 📖 **Recipe Detail** - View complete recipe information with ingredients and steps
- 👀 **Public Access** - View recipes without logging in

### User Features
- 👤 **User Registration & Login** - Secure authentication system
- ✉️ **Email Verification** - Verify email addresses
- 🔑 **Password Reset** - Forgot password functionality
- 📝 **Create & Manage Recipes** - Add, edit, and delete your own recipes
- ⭐ **Review Recipes** - Leave reviews and ratings (1-5 stars)
- ❤️ **Favorite Recipes** - Save recipes to favorites
- 📄 **Export to PDF** - Download recipe as PDF
- 🖼️ **Profile Management** - Update profile with photo

### Admin Features
- 🎛️ **Dashboard** - Overview of all system data
- 👥 **User Management** - Create, read, update, delete users
- 🍜 **Recipe Management** - Full CRUD operations for recipes
- 💬 **Review Management** - Manage user reviews
- ❤️ **Favorites Management** - View and manage favorites
- 📥 **Excel Import** - Import recipes from Excel files
- 🗑️ **Soft Delete** - Restore deleted items

---

## 🛠️ Tech Stack

### Backend
- **Laravel 10.x** - PHP web framework
- **PHP 8.1+** - Programming language
- **MySQL** - Database

### Frontend
- **Blade Templating** - Laravel's templating engine
- **Vite** - Build tool and development server
- **Axios** - HTTP client
- **Bootstrap** - CSS framework
- **Custom CSS** - Styled components

### Key Packages
- `barryvdh/laravel-dompdf` - PDF generation
- `maatwebsite/excel` - Excel import/export
- `laravel/sanctum` - API authentication
- `laravel/tinker` - REPL for Laravel

---

## 📋 Requirements

### Server Requirements
- PHP >= 8.1
- Composer
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js >= 16.x and NPM
- Web server (Apache/Nginx)

### PHP Extensions
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/rasanesia-project.git
cd rasanesia-project
```

### 2. Install Dependencies

Install PHP dependencies via Composer:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

### 3. Environment Configuration

Copy the environment configuration file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Edit `.env` file and configure:
- Database connection
- Mail configuration
- Application URL

### 4. Database Setup

Create a database and update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rasanesia
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

### 5. Storage Link

Create symbolic link for storage:

```bash
php artisan storage:link
```

### 6. Build Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## ⚙️ Configuration

### Mail Configuration

Update `.env` for email functionality:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### File Uploads

- Maximum upload size: `2048kb` (configure in `php.ini`)
- Allowed extensions: Images (jpg, jpeg, png, gif)
- Storage: `storage/app/public/profile_photos`

---

## 📖 Usage

### Default Admin Account

After running seeders:

```
Email: admin@rasanesia.com
Password: password
```

### Import Recipes from Excel

1. Prepare Excel file with columns: name, description, ingredients, steps, province
2. Place file in `storage/app/`
3. Run in Tinker:

```bash
php artisan tinker

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RecipesImport;
Excel::import(new RecipesImport, 'RESEP AMEL.xlsx');
```

### User Roles

- **Admin**: Full access to dashboard and management
- **User**: Can create recipes, reviews, and favorites

---

## 📁 Project Structure

```
rasanesia-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Application controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                 # Eloquent models
│   ├── Imports/                # Excel import classes
│   └── Notifications/          # Email notifications
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
├── public/
│   ├── assets/                 # Frontend assets (CSS, JS, images)
│   └── admin_assets/           # Admin panel assets
├── resources/
│   ├── views/
│   │   ├── frontend/           # Frontend views
│   │   ├── backend/            # Admin views
│   │   └── auth/               # Authentication views
│   ├── css/                    # CSS source files
│   └── js/                     # JavaScript source files
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
└── storage/
    └── app/                    # Application storage
```

---

## 🚀 Deployment

### Deployment Steps

1. **Update Environment**

```bash
# Edit production .env
cp .env.example .env
# Configure database, mail, etc.
```

2. **Install Dependencies**

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

3. **Generate Key & Optimize**

```bash
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4. **Run Migrations**

```bash
php artisan migrate --force
```

5. **Set Permissions**

```bash
chmod -R 775 storage bootstrap/cache
```

6. **Configure Web Server**

Point document root to `public/` directory.

### Maintenance Mode

```bash
# Enable
php artisan down

# Disable
php artisan up
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👥 Authors

- **Your Team** - *Initial work* - [GitHub](https://github.com/yourusername)

---

## 🙏 Acknowledgments

- Laravel framework and community
- All package contributors
- Indonesian culinary community

---

## 📞 Contact

For support, email support@rasanesia.com

---

<div align="center">
  Made with ❤️ using Laravel
</div>

---

# Rasanesia Project - Laravel Deployment & Maintenance Guide

## Table of Contents
- [Overview](#overview)
- [Deployment Guide](#deployment-guide)
  - [1. Persiapan Project di Local](#1-persiapan-project-di-local)
  - [2. Upload Project ke Server](#2-upload-project-ke-server)
  - [3. Install Dependency](#3-install-dependency)
  - [4. Atur File Environment](#4-atur-file-environment)
  - [5. Generate Application Key](#5-generate-application-key)
  - [6. Set Permissions](#6-set-permissions)
  - [7. Migrasi & Seed Database](#7-migrasi--seed-database)
  - [8. Optimasi Laravel](#8-optimasi-laravel)
  - [9. Atur Web Server](#9-atur-web-server)
  - [10. Cek Aplikasi](#10-cek-aplikasi)
- [Maintenance Guide](#maintenance-guide)
  - [1. Aktifkan Maintenance Mode](#1-aktifkan-maintenance-mode)
  - [2. Backup](#2-backup)
  - [3. Update Dependency](#3-update-dependency)
  - [4. Deploy Perubahan](#4-deploy-perubahan)
  - [5. Migrasi Database](#5-migrasi-database)
  - [6. Optimasi Ulang](#6-optimasi-ulang)
  - [7. Matikan Maintenance Mode](#7-matikan-maintenance-mode)
  - [8. Monitoring](#8-monitoring)
  - [9. Backup Berkala](#9-backup-berkala)
- [Tips Tambahan](#tips-tambahan)
- [Backup Otomatis](#backup-otomatis)
- [Referensi](#referensi)

---

## Overview
Panduan ini berisi langkah-langkah lengkap untuk melakukan deployment (men-deploy aplikasi ke server/hosting) dan maintenance (perawatan aplikasi) pada project Laravel Rasanesia. Cocok untuk pemula maupun yang sudah berpengalaman.

---

## Deployment Guide

### 1. Persiapan Project di Local
- Pastikan aplikasi berjalan baik di local.
- Cek konfigurasi `.env` untuk local dan siapkan untuk diubah di server.

### 2. Upload Project ke Server
**Via Git:**
```bash
git clone <repo-url> /path/to/project
```
**Via FTP/SFTP:**
- Upload semua file project ke server, kecuali folder `vendor` dan `node_modules`.

### 3. Install Dependency
Masuk ke folder project di server, lalu jalankan:
```bash
composer install --no-dev --optimize-autoloader
```
Jika ada asset frontend:
```bash
npm install
npm run build # atau npm run prod jika pakai Laravel Mix
```

### 4. Atur File Environment
- Copy `.env.example` menjadi `.env` jika belum ada.
- Edit `.env` untuk menyesuaikan konfigurasi server (database, mail, dsb).

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Set Permissions
Pastikan folder berikut bisa ditulis oleh web server:
- `storage`
- `bootstrap/cache`

Di Linux:
```bash
chmod -R 775 storage bootstrap/cache
```

### 7. Migrasi & Seed Database
```bash
php artisan migrate --force
# Jika perlu data awal:
php artisan db:seed --force
```

### 8. Optimasi Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9. Atur Web Server
- Pastikan root web server diarahkan ke folder `public` Laravel.
- Contoh Nginx:
  ```nginx
  root /path/to/project/public;
  ```
- Untuk Apache, pastikan `.htaccess` di folder `public` sudah benar.

### 10. Cek Aplikasi
- Akses domain/server, pastikan aplikasi berjalan dengan baik.

---

## Maintenance Guide

### 1. Aktifkan Maintenance Mode (Jika Perlu)
```bash
php artisan down
```

### 2. Backup
- Backup database dan file penting sebelum melakukan perubahan besar.

### 3. Update Dependency
```bash
composer update # atau update package tertentu
npm update      # jika ada perubahan frontend
```

### 4. Deploy Perubahan
- Upload file yang berubah atau pull dari repository.

### 5. Migrasi Database (Jika Ada)
```bash
php artisan migrate --force
```

### 6. Optimasi Ulang
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Matikan Maintenance Mode
```bash
php artisan up
```

### 8. Monitoring
- Cek log error di `storage/logs/laravel.log`
- Pantau performa aplikasi.

### 9. Backup Berkala
- Lakukan backup database dan file secara rutin.

---

## Tips Tambahan
- Gunakan `.env` yang berbeda untuk local dan production.
- Jangan upload folder `vendor` dan `node_modules` dari local, selalu install di server.
- Gunakan SSL/HTTPS di server production.
- Selalu test aplikasi setelah deployment/maintenance.
- Gunakan version control (Git) untuk memudahkan tracking perubahan.
- Untuk shared hosting, upload isi folder `public` ke root hosting dan sesuaikan path di `index.php`.

---

## Backup Otomatis

Backup otomatis sangat penting untuk menjaga keamanan data aplikasi. Berikut panduan backup otomatis database dan file di server Linux:

### 1. Backup Database Otomatis (MySQL/MariaDB)
Buat script backup, misal `backup_db.sh`:
```bash
#!/bin/bash
# backup_db.sh
DB_NAME="nama_database"
DB_USER="user_db"
DB_PASS="password_db"
BACKUP_DIR="/path/to/backup/folder"
DATE=$(date +"%Y-%m-%d_%H-%M-%S")

mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql
# Hapus backup lebih dari 7 hari
tmpwatch 168 $BACKUP_DIR # atau gunakan find -mtime +7 -delete
```
Jangan lupa beri izin eksekusi:
```bash
chmod +x backup_db.sh
```

### 2. Backup File Storage Otomatis
Buat script backup, misal `backup_files.sh`:
```bash
#!/bin/bash
# backup_files.sh
SOURCE_DIR="/path/to/laravel/storage"
BACKUP_DIR="/path/to/backup/folder"
DATE=$(date +"%Y-%m-%d_%H-%M-%S")

tar -czvf $BACKUP_DIR/storage_backup_$DATE.tar.gz $SOURCE_DIR
# Hapus backup lebih dari 7 hari
tmpwatch 168 $BACKUP_DIR # atau gunakan find -mtime +7 -delete
```

### 3. Penjadwalan Backup Otomatis dengan Cron
Edit crontab:
```bash
crontab -e
```
Tambahkan baris berikut untuk backup setiap hari jam 2 pagi:
```cron
0 2 * * * /path/to/backup_db.sh
0 2 * * * /path/to/backup_files.sh
```

### 4. Restore Backup
Untuk restore database:
```bash
mysql -u user_db -p nama_database < /path/to/backup/db_backup_YYYY-MM-DD_HH-MM-SS.sql
```
Untuk restore file:
```bash
tar -xzvf /path/to/backup/storage_backup_YYYY-MM-DD_HH-MM-SS.tar.gz -C /
```

### 5. Tips Backup
- Simpan backup di server berbeda/cloud jika memungkinkan.
- Pastikan backup bisa di-restore dengan mudah.
- Cek hasil backup secara berkala.

---

## Backup Otomatis di Windows

Jika server kamu menggunakan Windows, berikut panduan backup otomatis database dan file Laravel:

### 1. Backup Database Otomatis (MySQL/MariaDB)
Buat file batch, misal `backup_db.bat`:
```bat
@echo off
set DB_NAME=nama_database
set DB_USER=user_db
set DB_PASS=password_db
set BACKUP_DIR=C:\path\to\backup\folder
set DATE=%date:~10,4%-%date:~4,2%-%date:~7,2%_%time:~0,2%-%time:~3,2%-%time:~6,2%

"C:\path\to\mysql\bin\mysqldump.exe" -u %DB_USER% -p%DB_PASS% %DB_NAME% > "%BACKUP_DIR%\db_backup_%DATE%.sql"
REM Hapus backup lebih dari 7 hari (opsional, butuh forfiles)
forfiles /p "%BACKUP_DIR%" /s /m *.sql /d -7 /c "cmd /c del @path"
```

### 2. Backup File Storage Otomatis
Buat file batch, misal `backup_files.bat`:
```bat
@echo off
set SOURCE_DIR=C:\path\to\laravel\storage
set BACKUP_DIR=C:\path\to\backup\folder
set DATE=%date:~10,4%-%date:~4,2%-%date:~7,2%_%time:~0,2%-%time:~3,2%-%time:~6,2%

powershell Compress-Archive -Path "%SOURCE_DIR%" -DestinationPath "%BACKUP_DIR%\storage_backup_%DATE%.zip"
REM Hapus backup lebih dari 7 hari
forfiles /p "%BACKUP_DIR%" /s /m *.zip /d -7 /c "cmd /c del @path"
```

### 3. Penjadwalan Backup Otomatis dengan Task Scheduler
1. Buka **Task Scheduler** di Windows.
2. Pilih **Create Basic Task**.
3. Beri nama, lalu pilih trigger (misal: Daily, jam 2 pagi).
4. Pada **Action**, pilih **Start a program** dan arahkan ke file batch (`.bat`) yang sudah dibuat.
5. Selesai.

### 4. Restore Backup
Untuk restore database:
```bat
"C:\path\to\mysql\bin\mysql.exe" -u user_db -p nama_database < C:\path\to\backup\db_backup_YYYY-MM-DD_HH-MM-SS.sql
```
Untuk restore file:
- Klik kanan file ZIP hasil backup, pilih **Extract All** ke folder tujuan.

### 5. Tips Backup di Windows
- Jalankan batch file dengan hak akses administrator jika perlu.
- Simpan backup di drive berbeda atau cloud storage.
- Cek hasil backup secara berkala.

---

## Referensi
- [Laravel Deployment Docs](https://laravel.com/docs/deployment)
- [Laravel Maintenance Mode](https://laravel.com/docs/configuration#maintenance-mode)
- [Laravel File Permissions](https://laravel.com/docs/installation#file-permissions)
- [Laravel Optimization](https://laravel.com/docs/optimization)
