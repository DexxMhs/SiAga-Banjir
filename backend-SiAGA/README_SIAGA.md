# 🌊 SiAGA Banjir - Backend API

**Sistem Informasi dan Aplikasi Gabungan Antisipasi Banjir**

Backend API untuk aplikasi mobile monitoring dan pelaporan banjir dengan sistem notifikasi otomatis berbasis Laravel 10 dan Firebase Cloud Messaging.

---

## 📋 Deskripsi Sistem

SiAGA Banjir adalah sistem informasi terintegrasi untuk monitoring ketinggian air dan early warning system banjir yang melibatkan 3 jenis pengguna:

1. **Admin** - Mengelola stasiun, petugas, validasi laporan, dan broadcast notifikasi
2. **Petugas Lapangan** - Melaporkan kondisi stasiun pemantauan (tinggi air, curah hujan, status pompa)
3. **Masyarakat** - Melaporkan kondisi banjir di lokasi mereka dan menerima notifikasi peringatan

### Fitur Utama
- ✅ Multi-role authentication (Admin, Petugas, Public)
- ✅ Real-time flood monitoring
- ✅ Automatic notification system (Firebase FCM)
- ✅ Photo evidence upload
- ✅ Report validation workflow
- ✅ Geographic region management
- ✅ Emergency SOS feature
- ✅ RESTful API with Laravel Sanctum

---

## 🚀 Quick Start

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Laravel 10
- Firebase Project (untuk push notification)

### Installation

1. **Clone repository**
```bash
cd c:\laravel10\SiAGA_Banjir
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database** di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_siaga
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migration & seeder**
```bash
php artisan migrate
php artisan db:seed
```

6. **Create storage symlink**
```bash
php artisan storage:link
```

7. **Start development server**
```bash
php artisan serve
```

API akan berjalan di: `http://localhost:8000`

---

## 📚 Dokumentasi

### 1. [API Documentation](./API_DOCUMENTATION.md)
Dokumentasi lengkap semua endpoint API dengan contoh request/response:
- Authentication (Register, Login, Logout)
- Public endpoints (Stations, Regions)
- User/Warga endpoints (Report, Emergency, Area Status)
- Officer/Petugas endpoints (Submit Report, View Stations)
- Admin endpoints (CRUD Stations, Officers, Validation, etc.)

### 2. [Database Schema](./DATABASE_SCHEMA.md)
Struktur database lengkap dengan:
- ERD (Entity Relationship Diagram)
- Table structures dengan detail kolom
- Relations dan foreign keys
- System flows
- Access control matrix

### 3. [Flutter Quick Start Guide](./FLUTTER_QUICK_START.md)
Panduan untuk tim frontend Flutter:
- Setup dependencies
- API Service implementation
- Authentication manager
- Firebase Cloud Messaging setup
- Example implementations
- Testing guide
- Troubleshooting

---

## 🧪 Test Users (dari Seeder)

### Admin
```
Username: admin
Password: password
```

### Petugas Lapangan
```
Username: petugas1 / petugas2
Password: password
```

### Masyarakat
```
Username: warga1 / warga2 / warga3
Password: password
```

---

## 📁 Struktur Project

```
SiAGA_Banjir/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── Admin/
│   │   │       │   ├── StationController.php
│   │   │       │   ├── OfficerManagementController.php
│   │   │       │   ├── ReportValidationController.php
│   │   │       │   ├── RegionController.php
│   │   │       │   ├── PublicReportAdminController.php
│   │   │       │   └── NotificationController.php
│   │   │       ├── Officer/
│   │   │       │   └── OfficerReportController.php
│   │   │       └── Public/
│   │   │           ├── PublicStationController.php
│   │   │           └── PublicReportController.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Station.php
│   │   ├── Region.php
│   │   ├── OfficerReport.php
│   │   ├── PublicReport.php
│   │   ├── Notification.php
│   │   └── NotificationSettingRule.php
│   ├── Policies/
│   └── Services/
│       └── NotificationService.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
│   └── app/
│       └── public/
│           ├── officer_reports/
│           └── public_reports/
├── API_DOCUMENTATION.md
├── DATABASE_SCHEMA.md
├── FLUTTER_QUICK_START.md
└── README.md
```

---

## 🔑 API Authentication

API menggunakan **Laravel Sanctum** dengan Bearer Token.

### Cara Menggunakan:

1. **Login** untuk mendapatkan token
```bash
POST /api/login
{
  "username": "admin",
  "password": "password"
}
```

2. **Gunakan token** di header untuk request selanjutnya
```bash
Authorization: Bearer {your_access_token}
Accept: application/json
```

---

## 🌐 Endpoint Summary

### Public (No Auth)
- `POST /api/register` - Register user baru
- `POST /api/login` - Login

### Authenticated (All Roles)
- `GET /api/user` - Get profile
- `POST /api/logout` - Logout
- `POST /api/user/update-token` - Update FCM token
- `GET /api/stations` - List stasiun
- `GET /api/stations/{id}` - Detail stasiun
- `GET /api/regions` - List wilayah

### Role: Public (Warga)
- `POST /api/public/report` - Kirim laporan banjir
- `POST /api/public/emergency-report` - SOS darurat
- `GET /api/public/area-status` - Status wilayah domisili

### Role: Petugas
- `GET /api/officer/stations` - Stasiun yang ditugaskan
- `POST /api/officer/reports` - Submit laporan teknis
- `GET /api/officer/reports` - Riwayat laporan
- `GET /api/officer/reports/{id}` - Detail laporan

### Role: Admin
- **Stations:** GET, POST, PUT, DELETE `/api/admin/stations/*`
- **Officers:** GET, POST, PUT, DELETE `/api/admin/officers/*`
- **Validation:** GET, PUT `/api/admin/reports/officer/*`
- **Public Reports:** GET, PUT `/api/admin/reports/public/*`
- **Regions:** GET, POST, PUT `/api/admin/regions/*`
- **Notifications:** GET, PUT, POST `/api/admin/notifications/*`

---

## 🔔 Notification System

Sistem notifikasi otomatis menggunakan **Firebase Cloud Messaging (FCM)**:

### Trigger Otomatis:
Ketika admin meng-approve laporan petugas dan status berubah menjadi **SIAGA** atau **AWAS**, sistem akan:

1. ✅ Update status stasiun
2. ✅ Update status semua wilayah terdampak
3. ✅ Ambil template pesan dari database
4. ✅ Kirim push notification ke semua warga di wilayah terdampak
5. ✅ Simpan riwayat notifikasi ke database

### Manual Broadcast:
Admin dapat mengirim broadcast manual ke wilayah tertentu atau semua warga melalui endpoint:
```
POST /api/admin/notifications/broadcast
```

---

## 📊 Database

### Tables:
1. `users` - Data user (admin, petugas, public)
2. `stations` - Stasiun pemantauan
3. `regions` - Wilayah potensial banjir
4. `officer_reports` - Laporan petugas
5. `public_reports` - Laporan masyarakat
6. `notifications` - Riwayat notifikasi
7. `notification_setting_rules` - Template notifikasi
8. `station_user` - Pivot table petugas-stasiun

### Status Logic:
```
if (water_level >= threshold_awas) → status = "awas"
else if (water_level >= threshold_siaga) → status = "siaga"
else → status = "normal"
```

---

## 🎯 Workflow Utama

### 1. Pelaporan Petugas
```
Petugas → Submit laporan (foto + data) → Admin validasi
→ Status dihitung otomatis → Update stasiun & wilayah
→ Jika siaga/awas → Notifikasi terkirim ke warga
```

### 2. Pelaporan Masyarakat
```
Warga → Submit laporan (foto + lokasi + tinggi air)
→ Admin monitor → Update status laporan
```

### 3. Emergency (SOS)
```
Warga → Klik tombol SOS → Laporan darurat langsung terkirim
→ Admin segera koordinasi penanganan
```

---

## 🔧 Development

### Running Tests
```bash
php artisan test
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Generate API Documentation
```bash
# Sudah tersedia di API_DOCUMENTATION.md
```

---

## 📱 Frontend Integration

Tim frontend Flutter dapat mulai integrasi dengan:

1. **Baca dokumentasi:** [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)
2. **Setup project:** [FLUTTER_QUICK_START.md](./FLUTTER_QUICK_START.md)
3. **Test API:** Gunakan test users yang sudah disediakan
4. **Setup Firebase:** Untuk push notification

---

## 🐛 Troubleshooting

### Error: "Unauthenticated"
- Pastikan token valid
- Format header: `Authorization: Bearer {token}`

### Error: Upload foto gagal
- Max size: 2MB
- Format: jpg, jpeg, png
- Pastikan storage symlink sudah dibuat

### Error: CORS
- Konfigurasi di `config/cors.php`
- Tambahkan domain yang diizinkan

---

## 📞 Support

Untuk pertanyaan teknis atau issue, silakan hubungi tim backend developer.

---

## 📄 License

This project is private and proprietary.

---

**Version:** 1.0  
**Last Updated:** 25 Desember 2025  
**Built with:** Laravel 10 + Firebase FCM
