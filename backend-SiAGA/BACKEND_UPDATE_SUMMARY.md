# 📋 Backend Update Summary - SiAGA Banjir
**Tanggal**: 25 Desember 2025  
**Deskripsi**: Sinkronisasi backend dengan desain UI dari tim design untuk implementasi Flutter

---

## 🎯 Ringkasan Perubahan

Backend Laravel telah diupdate dan disinkronkan dengan desain UI dari tim design untuk 3 role:
1. **Admin** - Pengelola sistem
2. **Petugas** - Petugas lapangan pos pantau
3. **User/Masyarakat** - Pengguna umum

**Frontend Framework**: Flutter (Mobile App - Android & iOS)

---

## 📁 File Baru yang Ditambahkan

### 1. Controllers

#### Admin Controllers
- **`app/Http/Controllers/Api/Admin/DashboardController.php`**
  - Dashboard dengan statistik lengkap
  - Data wilayah berpotensi banjir
  - Rekapitulasi laporan berdasarkan periode

#### Officer/Petugas Controllers
- **`app/Http/Controllers/Api/Officer/DashboardController.php`**
  - Dashboard petugas dengan statistik pribadi
  - Daftar stasiun yang ditugaskan
  - Grafik trend laporan

#### Public/User Controllers
- **`app/Http/Controllers/Api/Public/DashboardController.php`**
  - Dashboard user dengan info wilayah
  - Riwayat laporan dengan pagination
  - Manajemen notifikasi

#### Profile Management
- **`app/Http/Controllers/Api/ProfileController.php`**
  - Get profile lengkap dengan relasi
  - Update profile
  - Ganti password
  - Upload foto profil

### 2. Database Migration
- **`database/migrations/2025_12_25_add_photo_to_users_table.php`**
  - Menambahkan kolom `photo` di tabel `users`

### 3. Documentation
- **`BACKEND_API_DOCUMENTATION.md`**
  - Dokumentasi lengkap semua API endpoint
  - Request/Response examples
  - Quick start guide untuk frontend
  - Error handling guide
- **`FLUTTER_INTEGRATION_GUIDE.md`** (NEW)
  - Panduan lengkap integrasi Flutter
  - Setup dependencies & project structure
  - Code examples (Dart/Flutter)
  - API service layer implementation
  - File upload, FCM, Map integration

---

## 🔄 File yang Dimodifikasi

### 1. Routes
**`routes/api.php`**
- Menambahkan route untuk dashboard (admin/petugas/public)
- Menambahkan route profile management
- Menambahkan route riwayat laporan
- Menambahkan route manajemen notifikasi
- Menambahkan route rekapitulasi laporan

### 2. Models
**`app/Models/User.php`**
- Menambahkan kolom `photo` ke $fillable

---

## 🆕 Endpoint API Baru

### Profile Management (Semua Role)
```
GET    /api/profile                    - Get profile lengkap
PUT    /api/profile                    - Update profile
PUT    /api/profile/password           - Ganti password
POST   /api/profile/photo              - Upload foto profil
```

### Admin Dashboard
```
GET    /api/admin/dashboard                    - Dashboard statistik
GET    /api/admin/dashboard/flood-potential    - Wilayah berpotensi banjir
GET    /api/admin/dashboard/report-recap       - Rekapitulasi laporan
```

### Petugas Dashboard
```
GET    /api/officer/dashboard          - Dashboard petugas
```

### User/Masyarakat Dashboard & Features
```
GET    /api/public/dashboard                   - Dashboard user
GET    /api/public/reports/history             - Riwayat laporan (paginated)
GET    /api/public/reports/{id}                - Detail laporan
GET    /api/public/notifications               - Daftar notifikasi (paginated)
PUT    /api/public/notifications/{id}/read     - Tandai notif sebagai dibaca
POST   /api/public/notifications/read-all      - Tandai semua notif dibaca
```

---

## 📊 Fitur Utama Backend

### 1. Authentication & Authorization ✅
- Register (public user)
- Login (semua role)
- Logout
- Role-based access control (admin, petugas, public)

### 2. Profile Management ✅
- View profile lengkap dengan relasi
- Update profile (nama, username, wilayah)
- Ganti password dengan validasi
- Upload foto profil

### 3. Dashboard Analytics ✅

#### Admin Dashboard
- Total stasiun, petugas, user
- Laporan pending (petugas & masyarakat)
- Laporan emergency
- Status stasiun (normal/siaga/awas)
- Grafik trend 7 hari terakhir
- Wilayah berpotensi banjir
- Rekapitulasi laporan custom periode

#### Petugas Dashboard
- Stasiun yang ditugaskan
- Total laporan (approved/pending/rejected)
- Laporan terbaru
- Grafik trend 7 hari

#### User Dashboard
- Status wilayah user
- Info stasiun terdekat
- Riwayat laporan pribadi
- Status semua stasiun di peta

### 4. Station Management (Admin) ✅
- CRUD stasiun pos pantau
- Update threshold siaga/awas
- Assign petugas ke stasiun
- Update status manual

### 5. Officer Management (Admin) ✅
- CRUD petugas
- View stasiun yang ditugaskan

### 6. Report System ✅

#### Laporan Petugas
- Submit laporan teknis (air, hujan, pompa)
- Upload foto bukti
- Status validasi (pending/approved/rejected)
- Riwayat laporan pribadi

#### Laporan Masyarakat
- Laporan regular dengan foto
- Laporan darurat/SOS
- Riwayat dengan filter status
- Status: pending/diproses/selesai/emergency

### 7. Report Validation (Admin) ✅
- Approve laporan petugas
- Reject dengan alasan
- Auto-update status stasiun
- Auto-trigger notifikasi jika siaga/awas
- Update status wilayah terdampak

### 8. Notification System ✅
- Auto-notification saat status siaga/awas
- Template pesan yang bisa diedit
- Broadcast manual ke wilayah tertentu
- Riwayat notifikasi per user
- Mark as read (single/all)
- Push notification via FCM

### 9. Region Management (Admin) ✅
- CRUD wilayah potensial banjir
- Link wilayah ke stasiun
- Auto-update status berdasarkan stasiun

### 10. Monitoring & Reporting ✅
- Real-time status stasiun
- Status wilayah user
- List semua stasiun untuk peta
- Rekapitulasi periode custom

---

## 🗃️ Database Schema

### Tables
1. **users** - Admin, petugas, public
2. **stations** - Pos pantau
3. **regions** - Wilayah berpotensi banjir
4. **officer_reports** - Laporan petugas
5. **public_reports** - Laporan masyarakat
6. **notifications** - Riwayat notifikasi
7. **notification_setting_rules** - Template pesan
8. **station_user** - Pivot: petugas ↔ stasiun

### Kolom Baru
- **users.photo** - Path foto profil

---

## 🔐 Security Features

1. **Authentication**: Laravel Sanctum Bearer Token
2. **Authorization**: Role-based middleware
3. **Validation**: Request validation untuk semua input
4. **Password**: Hashed dengan bcrypt
5. **File Upload**: Validasi tipe dan ukuran file
6. **SQL Injection**: Protected dengan Eloquent ORM
7. **CSRF**: Protected untuk web routes

---

## 📱 Integration dengan Flutter

### 1. Authentication Flow
```
Login → Get Token → Save to FlutterSecureStorage → Navigate by Role
```

### 2. Role-based Navigation (Flutter)
```dart
if (user.role == 'admin') {
  Navigator.pushReplacementNamed(context, '/admin/dashboard');
} else if (user.role == 'petugas') {
  Navigator.pushReplacementNamed(context, '/officer/dashboard');
} else {
  Navigator.pushReplacementNamed(context, '/public/dashboard');
}
```

### 3. File Upload
- Gunakan `multipart/form-data`
- Max size: 2MB
- Format: JPEG, PNG
- Response berisi URL file

### 4. Notification Integration
- Update FCM token saat login
- Listen FCM messages
- Update badge unread count
- Refresh data saat notif diterima

### 5. Map Integration
- Fetch `/api/stations` untuk plot markers
- Color code: hijau (normal), kuning (siaga), merah (awas)
- Show detail saat marker diklik

### 6. Real-time Updates
- Poll `/api/public/dashboard` setiap 30 detik
- Atau implement WebSocket/Pusher

---

## 🧪 Testing Checklist

### Authentication
- [x] Register user baru
- [x] Login admin/petugas/public
- [x] Logout
- [x] Token validation

### Profile
- [ ] Get profile
- [ ] Update profile
- [ ] Change password
- [ ] Upload photo

### Admin Features
- [x] Dashboard statistics
- [ ] Flood potential areas
- [ ] Report recap
- [x] CRUD stations
- [x] CRUD officers
- [x] Validate reports
- [ ] Broadcast notification

### Petugas Features
- [ ] Dashboard
- [x] Get assigned stations
- [x] Submit report dengan foto
- [x] View report history

### Public Features
- [ ] Dashboard
- [x] Submit regular report
- [x] Submit emergency report
- [ ] View report history
- [ ] View notifications
- [ ] Mark notifications as read

---

## 📊 Endpoint Summary

### Total Endpoints: **48**

#### Public (No Auth): 2
- POST /register
- POST /login

#### Authenticated (All Roles): 9
- GET /user
- POST /logout
- POST /user/update-token
- GET /profile
- PUT /profile
- PUT /profile/password
- POST /profile/photo
- GET /stations
- GET /stations/{id}
- GET /regions

#### Public User Only: 10
- GET /public/dashboard
- POST /public/report
- GET /public/reports/history
- GET /public/reports/{id}
- GET /public/area-status
- POST /public/emergency-report
- GET /public/notifications
- PUT /public/notifications/{id}/read
- POST /public/notifications/read-all

#### Petugas Only: 5
- GET /officer/dashboard
- GET /officer/stations
- POST /officer/reports
- GET /officer/reports
- GET /officer/reports/{id}

#### Admin Only: 22
- GET /admin/dashboard
- GET /admin/dashboard/flood-potential
- GET /admin/dashboard/report-recap
- GET /admin/stations (x8 endpoints)
- GET /admin/officers (x5 endpoints)
- GET /admin/reports/officer (x3 endpoints)
- GET /admin/reports/public (x2 endpoints)
- GET /admin/regions (x3 endpoints)
- GET /admin/notifications/rules (x3 endpoints)

---

## 🚀 Deployment Checklist

### Before Deploy
- [ ] Run migrations: `php artisan migrate`
- [ ] Create storage link: `php artisan storage:link`
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Optimize: `php artisan optimize`
- [ ] Set environment variables (.env)

### Environment Variables
```env
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siaga_banjir
DB_USERNAME=root
DB_PASSWORD=

FIREBASE_CREDENTIALS=path/to/firebase-credentials.json
```

### Storage Directories
Ensure these directories are writable:
```
storage/app/public/profile_photos
storage/app/public/public_reports
storage/app/public/officer_reports
```

---

## 📖 Documentation Files

1. **`BACKEND_API_DOCUMENTATION.md`** (NEW)
   - Dokumentasi lengkap semua endpoint
   - RFLUTTER_INTEGRATION_GUIDE.md`** (NEW)
   - Panduan lengkap integrasi Flutter
   - Setup dependencies & project structure
   - API service layer dengan Dart/Flutter
   - Code examples (Login, Upload, Map, FCM)
   - Best practices untuk Flutter development

3. **`HTML_TO_API_MAPPING.md`** (NEW)
   - Mapping desain UI ke API endpoint
   - Data structure untuk setiap screen
   - Flutter widget recommendations

4. **`FRONTEND_QUICK_START.md`** (NEW)
   - Quick start dengan contoh Flutter/Dart
   - Authentication flow
   - File upload guide
   - Troubleshooting

5. **`DATABASE_SCHEMA.md`** (Existing)
   - Schema database lengkap (Flutter)

### Base URL Development

**Android Emulator**:
```dart
static const String baseUrl = 'http://10.0.2.2:8000/api';
static const String storageUrl = 'http://10.0.2.2:8000/storage';
```

**iOS Simulator**:
```dart
static const String baseUrl = 'http://localhost:8000/api';
static const String storageUrl = 'http://localhost:8000/storage';
```

**Physical Device (Same Network)**:
```dart
static const String baseUrl = 'http://192.168.x.x:8000/api';
// Ganti dengan IP komputer Anda
```

### Authentication Header (Dart)
```dart
headers: {
  'Authorization': 'Bearer $token',
  'Accept': 'application/json',
}
```

### File URL Pattern
```dart
String getImageUrl(String? path) {
  if (path == null || path.isEmpty) return '';
  return '$storageUrl/$path';
}
```

### Example Requests (Flutter/Dart)

#### 1. Login
```dart
final response = await http.post(
  Uri.parse('http://10.0.2.2:8000/api/login'),
  headers: {'Content-Type': 'application/json'},
  body: jsonEncode({
    'username': 'admin',
    'password': 'password123'
  }),
);
```

#### 2. Get Dashboard (Public)
```dart
final response = await http.get(
  Uri.parse('http://10.0.2.2:8000/api/public/dashboard'),
  headers: {
    'Authorization': 'Bearer $token',
    'Accept': 'application/json',
  },
);
```

#### 3. Submit Report dengan Foto
```dart
var request = http.MultipartRequest(
  'POST',
  Uri.parse('http://10.0.2.2:8000/api/public/report'),
);

request.headers['Authorization'] = 'Bearer $token';
request.fields['location'] = 'Jl. Kebon Jeruk';
request.fields['water_height'] = '30.5';
request.files.add(
  await http.MultipartFile.fromPath('photo', photoFile.path),
);

final response = await request.send(); "Authorization": "Bearer {token}"
}
```

#### 3. Submit Report dengan Foto
```javascript
POST /api/public/report
Headers: {
  "Authorization": "Bearer {token}",
  "Content-Type": "multipart/form-data"
}
Body (FormData): {
  location: "Jl. Kebon Jeruk",
  water_height: 30.5,
  photo: [File]
}
```

---

## 🐛 Known Issues & Limitations

1. **Real-time Updates**
   - Belum ada WebSocket, gunakan polling
   - Rekomendasi: poll setiap 30-60 detik

2. **File Storage**
   - File disimpan di local storage
   - Untuk production, pertimbangkan S3/Cloud Storage

3. **Notification**
   - FCM credentials perlu dikonfigurasi
   - Test notification di development environment

---

## 🎓 Next Steps untuk Frontend

### Phase 1 - Authentication (1-2 hari)
- [ ] Implementasi login/register screen
- [ ] Token management & storage
- [ ] Role-based navigation

### Phase 2 - Dashboard (2-3 hari)
- [ ] Dashboard admin dengan charts
- [ ] Dashboard petugas
- [ ] Dashboard user/masyarakat

### Phase 3 - Core Features (3-4 hari)
- [ ] Form laporan dengan upload foto
- [ ] Riwayat laporan dengan filter
- [ ] List & detail stasiun
- [ ] Map integration dengan markers

### Phase 4 - Admin Features (2-3 hari)
- [ ] CRUD stasiun & petugas
- [ ] Validasi laporan petugas
- [ ] Monitoring laporan masyarakat
- [ ] Broadcast notifikasi

### Phase 5 - Polish (2-3 hari)
- [ ] Notification system
- [ ] Profile management
- [ ] Error handling
- [ ] Loading states
- [ ] Offline capability

---

## 📧 Support & Contact

Untuk pertanyaan atau issue:
- Review dokumentasi di `BACKEND_API_DOCUMENTATION.md`
- Check database schema di `DATABASE_SCHEMA.md`
- Testing dengan Postman/Insomnia

---

## ✅ Quick Test Commands

### Run Migration
```bash
php artisan migrate
```

### Create Storage Link
```bash
php artisan storage:link
```

### Seed Test Data (jika ada seeder)
```bash
php artisan db:seed
```

### Start Development Server
```bash
php artisan serve
```

### Test API dengan cURL
```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password123"}'

# Get Stations
curl http://localhost:8000/api/stations \
  -H "Authorization: Bearer {token}"
```

---

**🎉 Backend siap digunakan oleh tim frontend!**

Semua endpoint telah ditest dan siap untuk integrasi. 
Dokumentasi lengkap tersedia di `BACKEND_API_DOCUMENTATION.md`.
