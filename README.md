<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

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
