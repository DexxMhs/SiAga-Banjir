# 🚀 Quick Start Guide - Flutter Integration

## 📋 Persiapan

### 1. Pastikan Backend Berjalan
```bash
cd c:\laravel10\SiAGA_Banjir
php artisan serve
```
Backend akan berjalan di: `http://localhost:8000`

### 2. Base URL API untuk Flutter

**Android Emulator**:
```dart
static const String baseUrl = 'http://10.0.2.2:8000/api';
```

**iOS Simulator**:
```dart
static const String baseUrl = 'http://localhost:8000/api';
```

**Physical Device (Same Network)**:
```dart
static const String baseUrl = 'http://192.168.x.x:8000/api';
// Ganti dengan IP komputer Anda
```

### 3. Setup Flutter Project
```bash
flutter create siaga_banjir
cd siaga_banjir
```

Tambahkan dependencies di `pubspec.yaml`:
```yaml
dependencies:
  http: ^1.1.0
  provider: ^6.1.1
  flutter_secure_storage: ^9.0.0
  image_picker: ^1.0.5
  google_maps_flutter: ^2.5.0
  firebase_messaging: ^14.7.9
  cached_network_image: ^3.3.0
  intl: ^0.18.1
```

---

## 🔐 Authentication Flow

### 1. Register User Baru (Public)
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "username": "johndoe",
  "password": "password123",
  "password_confirmation": "password123",
  "region_id": 1
}

Response:
{
  "access_token": "1|abcd...",
  "user": {
    "id": 1,
    "role": "public"
  }
}
```

### 2. Login (Semua Role)
```http
POST /api/login
Content-Type: application/json

{
  "username": "johndoe",
  "password": "password123"
}

Response:
{
  "access_token": "2|abcd...",
  "user": {
    "id": 1,
    "role": "public"
  }
}
```

### 3. Simpan Token & Navigate by Role
```javascript
// Simpan token
localStorage.setItem('token', response.access_token);
localStorage.setItem('user', JSON.stringify(response.user));

// Navigate berdasarkan role
if (user.role === 'admin') {
  navigate('/admin/dashboard');
} else if (user.role === 'petugas') {
  navigate('/officer/dashboard');
} else {
  navigate('/public/dashboard');
}
```

---

## 📱 Contoh Request dengan Token

### Get Dashboard
```javascript
const token = localStorage.getItem('token');

fetch('http://localhost:8000/api/public/dashboard', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json'
  }
})
.then(res => res.json())
.then(data => console.log(data));
```

### Submit Laporan dengan Foto
```javascript
const formData = new FormData();
formData.append('location', 'Jl. Kebon Jeruk No. 10');
formData.append('water_height', 30.5);
formData.append('photo', fileInput.files[0]);

fetch('http://localhost:8000/api/public/report', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json'
  },
  body: formData
})
.then(res => res.json())
.then(data => console.log(data));
```

---

## 🗺️ Endpoint Berdasarkan Role

### 👥 Public/User (Masyarakat)
```
✅ Dashboard
GET /api/public/dashboard

✅ Kirim Laporan
POST /api/public/report
POST /api/public/emergency-report

✅ Riwayat
GET /api/public/reports/history
GET /api/public/reports/{id}

✅ Notifikasi
GET /api/public/notifications
PUT /api/public/notifications/{id}/read
POST /api/public/notifications/read-all

✅ Info Wilayah
GET /api/public/area-status
GET /api/stations
GET /api/regions
```

### 👮 Petugas
```
✅ Dashboard
GET /api/officer/dashboard

✅ Stasiun Tugas
GET /api/officer/stations

✅ Laporan
POST /api/officer/reports
GET /api/officer/reports
GET /api/officer/reports/{id}
```

### 👨‍💼 Admin
```
✅ Dashboard & Analytics
GET /api/admin/dashboard
GET /api/admin/dashboard/flood-potential
GET /api/admin/dashboard/report-recap

✅ Kelola Stasiun
GET    /api/admin/stations
POST   /api/admin/stations
PUT    /api/admin/stations/{id}
DELETE /api/admin/stations/{id}

✅ Kelola Petugas
GET    /api/admin/officers
POST   /api/admin/officers
PUT    /api/admin/officers/{id}
DELETE /api/admin/officers/{id}

✅ Validasi Laporan
GET /api/admin/reports/officer
PUT /api/admin/reports/officer/{id}/approve
PUT /api/admin/reports/officer/{id}/reject

✅ Monitor Laporan Masyarakat
GET /api/admin/reports/public
PUT /api/admin/reports/public/{id}

✅ Notifikasi
POST /api/admin/notifications/broadcast
```

---

## 🎨 Mapping Desain HTML ke API

### Admin Pages

| HTML File | API Endpoints |
|-----------|---------------|
| `dashboard_admin.html` | `/api/admin/dashboard` |
| `management_petugas.html` | `/api/admin/officers` |
| `management_pos_pantau.html` | `/api/admin/stations` |
| `potensi_banjir.html` | `/api/admin/dashboard/flood-potential` |
| `laporan_petugas.html` | `/api/admin/reports/officer` |
| `laporan_masyarakat.html` | `/api/admin/reports/public` |
| `rekap_laporan.html` | `/api/admin/dashboard/report-recap` |
| `profil.html` | `/api/profile` |

### Petugas Pages

| HTML File | API Endpoints |
|-----------|---------------|
| `dashboard_petugas.html` | `/api/officer/dashboard` |
| `lapor_pintu_air.html` | `/api/officer/reports` (POST) |
| `riwayat_laporan.html` | `/api/officer/reports` (GET) |
| `detail_laporan.html` | `/api/officer/reports/{id}` |
| `profil.html` | `/api/profile` |

### User Pages

| HTML File | API Endpoints |
|-----------|---------------|
| `dashboard_user.html` | `/api/public/dashboard` |
| `lapor_banjir.html` | `/api/public/report` (POST) |
| `riwayat_laporan.html` | `/api/public/reports/history` |
| `detail_laporan.html` | `/api/public/reports/{id}` |
| `monitoring_post.html` | `/api/stations` |
| `peta.html` | `/api/stations` (untuk markers) |
| `notifikasi_berita.html` | `/api/public/notifications` |
| `profil_user.html` | `/api/profile` |

---

## 📊 Data Format

### Status Types

**Station Status**:
- `normal` → Hijau 🟢
- `siaga` → Kuning 🟡
- `awas` → Merah 🔴

**Report Status (Public)**:
- `pending` → Menunggu verifikasi
- `diproses` → Sedang ditangani
- `selesai` → Selesai
- `emergency` → Darurat

**Validation Status (Officer)**:
- `pending` → Menunggu validasi admin
- `approved` → Disetujui
- `rejected` → Ditolak

**Pump Status**:
- `aktif` → Pompa berfungsi
- `mati` → Pompa mati
- `rusak` → Pompa rusak

---

## 🎯 Priority Implementation

### Week 1 - Authentication & Basic Flow
1. ✅ Login/Register screen
2. ✅ Token management
3. ✅ Role-based navigation
4. ✅ Profile page (view & edit)

### Week 2 - Core Features
1. ✅ Dashboard untuk 3 role
2. ✅ Form laporan dengan foto
3. ✅ List laporan dengan filter
4. ✅ Detail laporan

### Week 3 - Advanced Features
1. ✅ Map dengan markers stasiun
2. ✅ Notifikasi (list & mark as read)
3. ✅ Admin: CRUD stasiun & petugas
4. ✅ Admin: Validasi laporan

### Week 4 - Polish & Testing
1. ✅ Error handling
2. ✅ Loading states
3. ✅ Image compression
4. ✅ FCM integration
5. ✅ Testing end-to-end

---

## 🔔 Push Notification Setup

### 1. Update FCM Token setelah Login
```javascript
// Setelah login dan dapat FCM token dari device
fetch('http://localhost:8000/api/user/update-token', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    notification_token: fcmToken
  })
});
```

### 2. Handle Notification Payload
```javascript
// Notification payload dari backend:
{
  "type": "flood_alert",  // atau "broadcast_manual"
  "title": "⚠️ PERINGATAN BANJIR: STATUS SIAGA",
  "body": "Pos Pantau Kebon Jeruk terpantau 85.50cm. Harap waspada!",
  "data": {
    "station_id": "1"
  }
}
```

---

## 🗺️ Map Integration Example

### Get Stations untuk Map Markers
```javascript
fetch('http://localhost:8000/api/stations', {
  headers: {
    'Authorization': `Bearer ${token}`
  }
})
.then(res => res.json())
.then(data => {
  data.data.forEach(station => {
    // Add marker dengan color berdasarkan status
    const color = station.status === 'normal' ? 'green' 
                : station.status === 'siaga' ? 'yellow' 
                : 'red';
    
    addMarker({
      lat: station.latitude,
      lng: station.longitude,
      title: station.name,
      color: color,
      info: `Level: ${station.water_level}cm`
    });
  });
});
```

---

## 📦 Image Upload Tips

### 1. Compress Before Upload
```javascript
// Compress image ke max 1MB sebelum upload
const compressedFile = await compressImage(file, {
  maxSizeMB: 1,
  maxWidthOrHeight: 1920
});
```

### 2. Show Preview
```javascript
// Preview sebelum submit
const reader = new FileReader();
reader.onload = (e) => {
  imagePreview.src = e.target.result;
};
reader.readAsDataURL(file);
```

### 3. Access Uploaded Image
```javascript
// URL pattern untuk akses gambar
const imageUrl = `http://localhost:8000/storage/${data.photo}`;
```

---

## 🐛 Error Handling

### Handle Common Errors
```javascript
fetch(url, options)
  .then(async res => {
    if (!res.ok) {
      const error = await res.json();
      throw new Error(error.message || 'Something went wrong');
    }
    return res.json();
  })
  .then(data => {
    // Success
  })
  .catch(error => {
    if (error.message.includes('401')) {
      // Token expired, redirect to login
      localStorage.clear();
      navigate('/login');
    } else {
      // Show error message
      showToast(error.message);
    }
  });
```

---

## 📚 Full Documentation

Dokumentasi lengkap tersedia di:
- **`BACKEND_API_DOCUMENTATION.md`** - Dokumentasi API lengkap dengan semua endpoint
- **`BACKEND_UPDATE_SUMMARY.md`** - Summary perubahan dan checklist
- **`DATABASE_SCHEMA.md`** - Schema database lengkap

---

## ✅ Test Credentials

### Admin
```
Username: admin
Password: (sesuai seeder atau buat manual)
```

### Petugas
```
Username: petugas1
Password: (sesuai seeder atau buat manual)
```

### Public
```
Daftar via POST /api/register
```

---

## 🆘 Troubleshooting

### 1. CORS Error
Pastikan `.env` Laravel sudah set:
```env
APP_URL=http://localhost:8000
```

Dan tambahkan di `config/cors.php` jika perlu.

### 2. 401 Unauthorized
- Token expired atau invalid
- Clear localStorage dan login ulang
- Pastikan header Authorization benar

### 3. 422 Validation Error
- Check response body untuk detail error
- Validasi input sebelum submit

### 4. File Upload Gagal
- Max size 2MB
- Format: JPEG, PNG only
- Gunakan `multipart/form-data`

### 5. Image Not Found
- Pastikan storage link sudah dibuat: `php artisan storage:link`
- URL pattern: `http://localhost:8000/storage/{path}`

---

## 📞 Contact & Support

Untuk pertanyaan atau issue:
1. Check dokumentasi lengkap di `BACKEND_API_DOCUMENTATION.md`
2. Review database schema di `DATABASE_SCHEMA.md`
3. Testing dengan Postman/Insomnia

---

**🎉 Selamat coding! Backend siap digunakan.**
