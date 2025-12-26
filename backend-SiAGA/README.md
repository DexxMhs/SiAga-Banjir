# 🌊 SiAGA Banjir - Backend API

**Sistem Informasi Alerting dan Monitoring Banjir**  
Laravel 10 + Flutter Mobile App

---

## 📱 Overview

SiAGA Banjir adalah sistem monitoring dan peringatan dini banjir berbasis mobile app (Flutter) dengan backend Laravel. Sistem ini melayani 3 role utama:

- **👨‍💼 Admin**: Mengelola stasiun, petugas, validasi laporan, dan broadcast notifikasi
- **👮 Petugas**: Melaporkan kondisi teknis stasiun (ketinggian air, curah hujan, status pompa)
- **👥 Masyarakat**: Melaporkan kejadian banjir, menerima peringatan, dan monitoring status wilayah

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/PostgreSQL
- Laravel 10

### Installation

1. **Install Dependencies**
```bash
composer install
```

2. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_DATABASE=siaga_banjir
DB_USERNAME=root
DB_PASSWORD=

FIREBASE_CREDENTIALS=path/to/firebase-credentials.json
```

3. **Run Migration**
```bash
php artisan migrate
php artisan db:seed  # Optional
```

4. **Create Storage Link**
```bash
php artisan storage:link
```

5. **Start Server**
```bash
php artisan serve
# Backend running at http://localhost:8000
```

---

## 📚 Documentation untuk Tim Frontend Flutter

### ⭐ START HERE
**[FLUTTER_INTEGRATION_GUIDE.md](FLUTTER_INTEGRATION_GUIDE.md)** - Panduan lengkap integrasi Flutter
- Setup project & dependencies
- API service layer (ready to copy Dart code)
- Authentication, file upload, FCM, maps
- Code examples & best practices

### 📖 Complete Documentation
1. **[BACKEND_API_DOCUMENTATION.md](BACKEND_API_DOCUMENTATION.md)** - 48 API endpoints lengkap
2. **[HTML_TO_API_MAPPING.md](HTML_TO_API_MAPPING.md)** - Mapping UI ke API
3. **[FRONTEND_QUICK_START.md](FRONTEND_QUICK_START.md)** - Quick start guide
4. **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)** - Database schema & ERD
5. **[BACKEND_UPDATE_SUMMARY.md](BACKEND_UPDATE_SUMMARY.md)** - Update summary

---

## 🎯 API Endpoints (48 Total)

- **Auth**: Register, Login, Logout (2 endpoints)
- **Profile**: Get, Update, Change Password, Upload Photo (4 endpoints)
- **Public/User**: Dashboard, Reports, Notifications (10 endpoints)
- **Officer**: Dashboard, Reports, Stations (5 endpoints)
- **Admin**: Dashboard, Stations, Officers, Validation, Analytics (22 endpoints)
- **Common**: Stations list, Regions list (5 endpoints)

**See full documentation**: [BACKEND_API_DOCUMENTATION.md](BACKEND_API_DOCUMENTATION.md)

---

## 🔐 Authentication

Backend menggunakan **Laravel Sanctum** (Bearer Token).

Flutter Example:
```dart
headers: {
  'Authorization': 'Bearer $token',
  'Accept': 'application/json',
}
```

---

## 📦 Main Features

✅ Role-based authentication (Admin, Petugas, Public)  
✅ Dashboard dengan analytics & grafik  
✅ Station management (CRUD, threshold, assign officers)  
✅ Officer management  
✅ Report system (officer & public)  
✅ Report validation workflow  
✅ Push notification (FCM)  
✅ Notification management  
✅ Region & flood potential monitoring  
✅ Profile management dengan photo  
✅ Real-time station status  
✅ Map data dengan koordinat  

---

## 🤝 Untuk Tim Frontend

### Base URL Flutter:

**Android Emulator**:
```dart
static const String baseUrl = 'http://10.0.2.2:8000/api';
```

**iOS Simulator**:
```dart
static const String baseUrl = 'http://localhost:8000/api';
```

### Integration Steps:
1. Read: [FLUTTER_INTEGRATION_GUIDE.md](FLUTTER_INTEGRATION_GUIDE.md)
2. Copy API service layer (Dart code ready)
3. Implement authentication flow
4. Build screens sesuai [HTML_TO_API_MAPPING.md](HTML_TO_API_MAPPING.md)
5. Test dengan backend

---

## 📝 Notes

- Response format: JSON
- File max: 2MB (jpeg/png)
- Pagination: 10-20 items
- Date format: ISO 8601

---

## 📧 Support

Need help?
- **API Docs**: [BACKEND_API_DOCUMENTATION.md](BACKEND_API_DOCUMENTATION.md)
- **Flutter Guide**: [FLUTTER_INTEGRATION_GUIDE.md](FLUTTER_INTEGRATION_GUIDE.md)
- **Database Schema**: [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)

---

**🎉 Backend ready untuk integrasi Flutter!**

Last Updated: 25 Desember 2025

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
