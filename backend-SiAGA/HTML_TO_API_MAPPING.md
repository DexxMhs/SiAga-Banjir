# 🎨 UI Design to API Mapping Guide (Flutter)

**Panduan lengkap mapping antara desain UI dan API endpoint backend untuk Flutter Development**

---

## 📋 Table of Contents
1. [Admin Pages](#admin-pages)
2. [Petugas/Officer Pages](#petugasofficer-pages)
3. [User/Masyarakat Pages](#usermasyarakat-pages)
4. [Common Pages](#common-pages)
5. [Flutter Integration Notes](#flutter-integration-notes)

---

## 👨‍💼 Admin Pages

### 1. Dashboard Admin (`dashboard_admin.html`)

**API Endpoint**: `GET /api/admin/dashboard`

**Data yang ditampilkan**:
```javascript
{
  "summary": {
    "total_stations": 12,           // Card: Total Pos Pantau
    "total_officers": 8,            // Card: Total Petugas
    "total_public_users": 150,      // Card: Total User Masyarakat
    "pending_officer_reports": 5,   // Badge: Laporan Petugas Pending
    "pending_public_reports": 12,   // Badge: Laporan Masyarakat Pending
    "emergency_reports": 2          // Alert: Laporan Darurat
  },
  "station_status": {
    "normal": 8,    // Chart: Status Normal (Hijau)
    "siaga": 3,     // Chart: Status Siaga (Kuning)
    "awas": 1       // Chart: Status Awas (Merah)
  },
  "recent_officer_reports": [...],  // Tabel: 5 Laporan Petugas Terbaru
  "recent_public_reports": [...],   // Tabel: 5 Laporan Masyarakat Terbaru
  "report_trend": [...]             // Chart: Grafik Trend 7 Hari
}
```

**Komponen UI**:
- Summary Cards (4-6 cards)
- Pie/Donut Chart untuk status stasiun
- Line Chart untuk trend laporan
- Tabel laporan terbaru dengan pagination

---

### 2. Management Petugas (`management_petugas.html`)

**API Endpoints**:
- List: `GET /api/admin/officers`
- Create: `POST /api/admin/officers`
- Detail: `GET /api/admin/officers/{id}`
- Update: `PUT /api/admin/officers/{id}`
- Delete: `DELETE /api/admin/officers/{id}`

**Data Structure**:
```javascript
// List
{
  "data": [
    {
      "id": 2,
      "name": "Budi Santoso",
      "username": "budi.s",
      "role": "petugas",
      "assigned_stations": [
        {"id": 1, "name": "Pos Pantau Kebon Jeruk"}
      ]
    }
  ]
}

// Create/Update
{
  "name": "New Officer",
  "username": "officer_new",
  "password": "password123",  // Only for create
  "password_confirmation": "password123"  // Only for create
}
```

**Komponen UI**:
- DataTable dengan search & pagination
- Modal/Form untuk create/edit
- Confirmation dialog untuk delete
- Badge untuk jumlah stasiun yang ditugaskan

---

### 3. Management Pos Pantau (`management_pos_pantau.html`)

**API Endpoints**:
- List: `GET /api/admin/stations`
- Create: `POST /api/admin/stations`
- Detail: `GET /api/admin/stations/{id}`
- Update: `PUT /api/admin/stations/{id}`
- Delete: `DELETE /api/admin/stations/{id}`
- Update Status: `PUT /api/admin/stations/{id}/status`
- Update Threshold: `PUT /api/admin/stations/{id}/thresholds`
- Assign Officers: `PUT /api/admin/stations/{id}/assign-officers`

**Data Structure**:
```javascript
// List
{
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "location": "Kebon Jeruk, Jakarta Barat",
      "latitude": -6.200000,
      "longitude": 106.816666,
      "water_level": 85.50,
      "status": "siaga",  // normal/siaga/awas
      "threshold_siaga": 80.00,
      "threshold_awas": 100.00,
      "last_update": "2025-12-25T10:30:00.000000Z",
      "officers": [
        {"id": 2, "name": "Budi Santoso"}
      ]
    }
  ]
}

// Create/Update
{
  "name": "Pos Pantau Baru",
  "location": "Kelapa Gading",
  "latitude": -6.200000,
  "longitude": 106.816666,
  "threshold_siaga": 80.00,
  "threshold_awas": 100.00,
  "officer_ids": [2, 3, 4]  // IDs petugas yang ditugaskan
}
```

**Komponen UI**:
- DataTable dengan status badge (hijau/kuning/merah)
- Form dengan map picker untuk koordinat
- Multi-select untuk assign petugas
- Real-time water level indicator
- Last update timestamp

---

### 4. Potensi Banjir (`potensi_banjir.html`)

**API Endpoint**: `GET /api/admin/dashboard/flood-potential`

**Data yang ditampilkan**:
```javascript
{
  "regions": [
    {
      "id": 1,
      "region_name": "Kelurahan Kebon Jeruk",
      "flood_status": "siaga",  // normal/siaga/awas
      "station_name": "Pos Pantau Kebon Jeruk",
      "water_level": 85.50,
      "station_status": "siaga",
      "last_update": "2025-12-25T10:30:00.000000Z"
    }
  ],
  "summary": {
    "awas": 1,    // Total wilayah status awas
    "siaga": 3,   // Total wilayah status siaga
    "normal": 8   // Total wilayah status normal
  }
}
```

**Komponen UI**:
- Summary cards dengan jumlah per status
- Tabel wilayah dengan sortir berdasarkan prioritas (awas → siaga → normal)
- Status badge dengan color coding
- Filter berdasarkan status
- Auto refresh setiap 30 detik

---

### 5. Laporan Petugas (`laporan_petugas.html`)

**API Endpoints**:
- List Pending: `GET /api/admin/reports/officer`
- Approve: `PUT /api/admin/reports/officer/{id}/approve`
- Reject: `PUT /api/admin/reports/officer/{id}/reject`

**Data Structure**:
```javascript
// List
{
  "data": [
    {
      "id": 1,
      "officer": {
        "id": 2,
        "name": "Budi Santoso"
      },
      "station": {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk"
      },
      "water_level": 85.50,
      "rainfall": 15.00,
      "pump_status": "aktif",  // aktif/mati/rusak
      "photo": "officer_reports/abc123.jpg",
      "note": "Pompa berfungsi normal",
      "validation_status": "pending",  // pending/approved/rejected
      "created_at": "2025-12-25T10:00:00.000000Z"
    }
  ]
}

// Reject Body
{
  "note": "Data tidak valid, silakan input ulang"
}
```

**Komponen UI**:
- Tabel dengan filter status validasi
- Image lightbox untuk foto bukti
- Action buttons: Approve (hijau), Reject (merah)
- Modal reject dengan textarea untuk alasan
- Real-time badge update

---

### 6. Laporan Masyarakat (`laporan_masyarakat.html`)

**API Endpoints**:
- List: `GET /api/admin/reports/public`
- Update Status: `PUT /api/admin/reports/public/{id}`

**Data Structure**:
```javascript
// List
{
  "data": [
    {
      "id": 1,
      "user": {
        "id": 1,
        "name": "John Doe"
      },
      "location": "Jl. Kebon Jeruk No. 10",
      "water_height": 30.50,
      "photo": "public_reports/abc123.jpg",
      "status": "pending",  // pending/diproses/selesai/emergency
      "created_at": "2025-12-25T10:00:00.000000Z"
    }
  ]
}

// Update Status
{
  "status": "diproses"  // pending/diproses/selesai
}
```

**Komponen UI**:
- Tabel dengan filter status
- Emergency badge untuk laporan darurat (merah)
- Dropdown untuk update status
- Image viewer untuk foto
- Map untuk show lokasi (jika ada koordinat)

---

### 7. Rekap Laporan (`rekap_laporan.html`)

**API Endpoint**: `GET /api/admin/dashboard/report-recap`

**Query Parameters**:
```
start_date: 2025-12-01  (required)
end_date: 2025-12-31    (required)
type: all               (optional: officer/public/all)
```

**Data yang ditampilkan**:
```javascript
{
  "period": {
    "start_date": "2025-12-01",
    "end_date": "2025-12-31"
  },
  "data": {
    "officer_reports": {
      "summary": {
        "total": 50,
        "approved": 40,
        "rejected": 5,
        "pending": 5
      },
      "details": [...]  // List semua laporan dalam periode
    },
    "public_reports": {
      "summary": {
        "total": 100,
        "pending": 20,
        "diproses": 30,
        "selesai": 45,
        "emergency": 5
      },
      "details": [...]
    }
  }
}
```

**Komponen UI**:
- Date range picker
- Filter tipe laporan (officer/public/all)
- Summary cards
- Chart perbandingan status
- Export button (PDF/Excel)
- Tabel detail dengan pagination

---

### 8. Profil Admin (`profil.html`)

**API Endpoints**:
- Get: `GET /api/profile`
- Update: `PUT /api/profile`
- Change Password: `PUT /api/profile/password`
- Upload Photo: `POST /api/profile/photo`

**Data Structure**: Lihat [Common Pages - Profil](#profil-commonhtml)

---

## 👮 Petugas/Officer Pages

### 1. Dashboard Petugas (`dashboard_petugas.html`)

**API Endpoint**: `GET /api/officer/dashboard`

**Data yang ditampilkan**:
```javascript
{
  "assigned_stations": [
    {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "status": "siaga",
      "water_level": 85.50,
      "last_update": "2025-12-25T10:30:00.000000Z"
    }
  ],
  "summary": {
    "total_reports": 25,      // Card: Total Laporan
    "approved": 20,           // Card: Disetujui
    "pending": 3,             // Card: Pending
    "rejected": 2,            // Card: Ditolak
    "total_stations": 2       // Card: Stasiun Tugas
  },
  "recent_reports": [...],    // Tabel: 5 Laporan Terbaru
  "report_trend": [...]       // Chart: Trend 7 Hari
}
```

**Komponen UI**:
- Summary cards dengan icon
- List stasiun tugas dengan status badge
- Line chart trend laporan
- Tabel laporan terbaru
- Quick action button: "Buat Laporan Baru"

---

### 2. Lapor Pintu Air (`lapor_pintu_air.html`)

**API Endpoints**:
- Get Stations: `GET /api/officer/stations`
- Submit Report: `POST /api/officer/reports`

**Data Structure**:
```javascript
// Get Stations
{
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "location": "Kebon Jeruk",
      "status": "siaga"
    }
  ]
}

// Submit Report (multipart/form-data)
{
  station_id: 1,
  water_level: 85.50,
  rainfall: 15.00,
  pump_status: "aktif",  // aktif/mati/rusak
  photo: [File],         // Required
  note: "Catatan optional"
}
```

**Komponen UI**:
- Select dropdown untuk pilih stasiun
- Number input untuk water level & rainfall
- Radio button/Select untuk pump status
- Camera/Gallery picker untuk foto (REQUIRED)
- Textarea untuk catatan
- Preview foto sebelum submit
- Submit button dengan loading state

---

### 3. Riwayat Laporan (`riwayat_laporan.html`)

**API Endpoint**: `GET /api/officer/reports`

**Data yang ditampilkan**:
```javascript
{
  "data": [
    {
      "id": 1,
      "station": {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk"
      },
      "water_level": 85.50,
      "rainfall": 15.00,
      "pump_status": "aktif",
      "photo": "officer_reports/abc123.jpg",
      "note": "Pompa berfungsi normal",
      "validation_status": "approved",  // pending/approved/rejected
      "calculated_status": "siaga",      // normal/siaga/awas
      "created_at": "2025-12-25T10:00:00.000000Z"
    }
  ]
}
```

**Komponen UI**:
- List/Grid laporan dengan thumbnail foto
- Status badge (pending/approved/rejected)
- Filter berdasarkan status
- Search berdasarkan stasiun
- Tap untuk detail

---

### 4. Detail Laporan (`detail_laporan.html`)

**API Endpoint**: `GET /api/officer/reports/{id}`

**Data yang ditampilkan**:
```javascript
{
  "data": {
    "id": 1,
    "station": {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "location": "Kebon Jeruk"
    },
    "water_level": 85.50,
    "rainfall": 15.00,
    "pump_status": "aktif",
    "photo": "officer_reports/abc123.jpg",
    "note": "Pompa berfungsi normal",
    "validation_status": "approved",
    "calculated_status": "siaga",
    "validated_by": 1,  // ID admin yang validasi
    "created_at": "2025-12-25T10:00:00.000000Z"
  }
}
```

**Komponen UI**:
- Header dengan status badge
- Info stasiun
- Data pengukuran (water level, rainfall, pump status)
- Full-size image viewer
- Catatan/Note
- Status validasi dengan timestamp
- Admin validator info (jika sudah divalidasi)

---

### 5. Profil Petugas (`profil.html`)

**API Endpoints**: Sama dengan [Common Pages - Profil](#profil-commonhtml)

---

## 👥 User/Masyarakat Pages

### 1. Dashboard User (`dashboard_user.html`)

**API Endpoint**: `GET /api/public/dashboard`

**Data yang ditampilkan**:
```javascript
{
  "user_region": {
    "region_name": "Kelurahan Kebon Jeruk",
    "flood_status": "siaga",  // normal/siaga/awas
    "station_name": "Pos Pantau Kebon Jeruk",
    "water_level": 85.50,
    "status": "siaga",
    "last_update": "2025-12-25T10:30:00.000000Z"
  },
  "summary": {
    "total_reports": 5,        // Card: Total Laporan Saya
    "pending_reports": 2,      // Card: Laporan Pending
    "stations_normal": 8,      // Info: Stasiun Normal
    "stations_siaga": 3,       // Info: Stasiun Siaga
    "stations_awas": 1         // Info: Stasiun Awas
  },
  "my_recent_reports": [...], // List: 5 Laporan Terakhir Saya
  "all_stations": [...]       // Data untuk Map
}
```

**Komponen UI**:
- Alert card untuk status wilayah user (color coded)
- Summary cards
- Mini map dengan markers stasiun
- List laporan terbaru
- Quick action: "Lapor Banjir", "SOS Emergency"
- Badge notification count

---

### 2. Lapor Banjir (`lapor_banjir.html`)

**API Endpoints**:
- Regular Report: `POST /api/public/report`
- Emergency SOS: `POST /api/public/emergency-report`

**Data Structure**:
```javascript
// Regular Report (multipart/form-data)
{
  location: "Jl. Kebon Jeruk No. 10",
  water_height: 30.50,
  photo: [File]  // Optional
}

// Emergency SOS
{
  location: "Jl. Kebon Jeruk No. 10"  // Optional
}
```

**Komponen UI**:
- Text input untuk lokasi (atau GPS auto-fill)
- Number input untuk tinggi air
- Camera/Gallery picker (optional untuk regular)
- Preview foto
- Button "Kirim Laporan" (regular)
- Button "SOS DARURAT" (merah, prominent)
- Success/Error message

---

### 3. Riwayat Laporan (`riwayat_laporan.html`)

**API Endpoint**: `GET /api/public/reports/history`

**Query Parameters**:
```
status: pending/diproses/selesai/emergency/all
page: 1
```

**Data yang ditampilkan**:
```javascript
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "location": "Jl. Kebon Jeruk No. 10",
      "water_height": 30.50,
      "photo": "public_reports/abc123.jpg",
      "status": "diproses",  // pending/diproses/selesai/emergency
      "created_at": "2025-12-25T10:00:00.000000Z"
    }
  ],
  "total": 10,
  "per_page": 10,
  "last_page": 1
}
```

**Komponen UI**:
- Filter tabs (Semua/Pending/Diproses/Selesai/Emergency)
- List dengan thumbnail foto
- Status badge
- Pagination atau infinite scroll
- Tap untuk detail

---

### 4. Detail Laporan (`detail_laporan.html`)

**API Endpoint**: `GET /api/public/reports/{id}`

**Data yang ditampilkan**:
```javascript
{
  "data": {
    "id": 1,
    "location": "Jl. Kebon Jeruk No. 10",
    "water_height": 30.50,
    "photo": "public_reports/abc123.jpg",
    "status": "diproses",
    "created_at": "2025-12-25T10:00:00.000000Z",
    "updated_at": "2025-12-25T11:00:00.000000Z"
  }
}
```

**Komponen UI**:
- Header dengan status badge
- Lokasi
- Tinggi air
- Full-size image (jika ada)
- Timestamp submit & update
- Status tracking timeline (pending → diproses → selesai)

---

### 5. Monitoring Post (`monitoring_post.html`)

**API Endpoint**: `GET /api/stations`

**Data yang ditampilkan**:
```javascript
{
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "location": "Kebon Jeruk",
      "latitude": -6.200000,
      "longitude": 106.816666,
      "water_level": 85.50,
      "status": "siaga",
      "threshold_siaga": 80.00,
      "threshold_awas": 100.00,
      "last_update": "2025-12-25T10:30:00.000000Z"
    }
  ]
}
```

**Komponen UI**:
- List/Grid stasiun
- Status badge (hijau/kuning/merah)
- Water level progress bar
- Threshold indicators
- Last update timestamp
- Tap untuk detail stasiun

---

### 6. Peta (`peta.html`)

**API Endpoint**: `GET /api/stations`

**Data yang ditampilkan**: Sama dengan Monitoring Post

**Komponen UI**:
- Full-screen map (Google Maps/Mapbox)
- Markers dengan color coding:
  - 🟢 Hijau = Normal
  - 🟡 Kuning = Siaga
  - 🔴 Merah = Awas
- Info window saat marker diklik:
  - Nama stasiun
  - Water level
  - Status
  - Last update
- Filter untuk show/hide berdasarkan status
- Button "Lokasi Saya"
- Legend untuk status

---

### 7. Notifikasi & Berita (`notifikasi_berita.html`)

**API Endpoints**:
- List: `GET /api/public/notifications`
- Mark as Read: `PUT /api/public/notifications/{id}/read`
- Mark All: `POST /api/public/notifications/read-all`

**Query Parameters**:
```
read: true/false  (filter sudah dibaca/belum)
page: 1
```

**Data yang ditampilkan**:
```javascript
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "⚠️ PERINGATAN BANJIR: STATUS SIAGA",
      "message": "Pos Pantau Kebon Jeruk terpantau 85.50cm. Harap waspada!",
      "type": "flood_alert",  // flood_alert/broadcast_manual
      "data": "{\"station_id\": 1}",
      "read_at": null,  // null = belum dibaca
      "created_at": "2025-12-25T10:30:00.000000Z"
    }
  ],
  "total": 20,
  "per_page": 20
}
```

**Komponen UI**:
- List notifikasi dengan badge unread
- Filter: Semua/Belum Dibaca
- Icon berdasarkan type
- Tap untuk mark as read & show detail
- Button "Tandai Semua Sudah Dibaca"
- Pull to refresh
- Badge count di tab bar

---

### 8. Profil User (`profil_user.html`)

**API Endpoints**: Sama dengan [Common Pages - Profil](#profil-commonhtml)

---

## 🔄 Common Pages

### Profil (`profil.html` / `profil_user.html`)

**API Endpoints**:
- Get Profile: `GET /api/profile`
- Update Profile: `PUT /api/profile`
- Change Password: `PUT /api/profile/password`
- Upload Photo: `POST /api/profile/photo`

**Data Structure**:
```javascript
// Get Profile
{
  "data": {
    "id": 1,
    "name": "John Doe",
    "username": "johndoe",
    "role": "public",
    "region_id": 1,
    "photo": "profile_photos/abc123.jpg",
    "region": {  // Only for role: public
      "id": 1,
      "name": "Kelurahan Kebon Jeruk"
    },
    "assigned_stations": [...]  // Only for role: petugas
  }
}

// Update Profile
{
  "name": "John Doe Updated",
  "username": "johndoe2",
  "region_id": 2  // Only for public
}

// Change Password
{
  "current_password": "oldpass123",
  "new_password": "newpass123",
  "new_password_confirmation": "newpass123"
}

// Upload Photo (multipart/form-data)
{
  photo: [File]  // max 2MB, jpeg/png
}
```

**Komponen UI**:
- Avatar dengan foto profil
- Button edit foto
- Form edit profile (nama, username, wilayah)
- Button ganti password
- Info role
- Info stasiun tugas (untuk petugas)
- Button logout

---

### Login (`login_petugas.html` / `login_user.html`)

**API Endpoint**: `POST /api/login`

**Data Structure**:
```javascript
// Request
{
  "username": "johndoe",
  "password": "password123"
}

// Response
{
  "access_token": "2|abcd...",
  "user": {
    "id": 1,
    "role": "public"  // admin/petugas/public
  }
}
```

**Komponen UI**:
- Logo app
- Username input
- Password input (dengan show/hide)
- Button "Masuk"
- Link "Daftar" (hanya untuk user)
- Error message display

---

### Register (`register.html` / `register_user.html`)

**API Endpoint**: `POST /api/register`

**Data Structure**:
```javascript
// Request
{
  "name": "John Doe",
  "username": "johndoe",
  "password": "password123",
  "password_confirmation": "password123",
  "region_id": 1
}

// Response - Sama dengan Login
{
  "access_token": "1|abcd...",
  "user": {
    "id": 1,
    "role": "public"
  }
}
```

**Komponen UI**:
- Nama lengkap input
- Username input
- Password input (dengan strength indicator)
- Password confirmation
- Select/Dropdown wilayah
- Button "Daftar"
- Link "Sudah punya akun? Masuk"

---

## 🎯 Implementation Priority

### Phase 1: Authentication (1-2 hari)
1. Login page
2. Register page (untuk public)
3. Token management
4. Role-based routing

### Phase 2: Dashboard (2-3 hari)
1. Dashboard admin dengan charts
2. Dashboard petugas
3. Dashboard user

### Phase 3: Core Features (3-4 hari)
1. Form laporan (petugas & user)
2. Riwayat laporan
3. Detail laporan
4. Profile management

### Phase 4: Admin Features (2-3 hari)
1. CRUD stasiun
2. CRUD petugas
3. Validasi laporan petugas
4. Monitor laporan masyarakat

### Phase 5: Advanced (2-3 hari)
1. Map dengan markers
2. Notifikasi
3. Rekapitulasi
4. Potensi banjir

### Phase 6: Polish (2-3 hari)
1. Error handling
2. Loading states
3. Image optimization
4. Push notification
5. Testing

---

## 📝 Notes

### Image URL Pattern
```javascript
const imageUrl = `http://localhost:8000/storage/${data.photo}`;
```

### Date Formatting
```javascript
// Backend format: "2025-12-25T10:30:00.000000Z"
// Display: "25 Des 2025, 10:30"
```

### Status Color Coding
- **Normal**: `#4CAF50` (Hijau)
- **Siaga**: `#FFC107` (Kuning)
- **Awas**: `#F44336` (Merah)
- **Pending**: `#9E9E9E` (Abu-abu)
- **Emergency**: `#D32F2F` (Merah tua)

### Auto Refresh
- Dashboard: Setiap 30 detik
- Monitoring Post: Setiap 30 detik
- Peta: Setiap 30 detik
- Notifikasi: On pull/manual

---

**📚 Referensi Lengkap**: 
- `BACKEND_API_DOCUMENTATION.md` - Dokumentasi API lengkap
- `FRONTEND_QUICK_START.md` - Quick start guide
- `DATABASE_SCHEMA.md` - Schema database

---

**🎉 Happy Coding!**
