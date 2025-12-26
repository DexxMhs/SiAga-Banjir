# 📱 API Documentation - SiAGA Banjir
**Sistem Informasi Alerting dan Monitoring Banjir**

**Base URL**: `http://localhost:8000/api`  
**Authentication**: Bearer Token (Laravel Sanctum)  
**Last Updated**: 25 Desember 2025

---

## 📑 Table of Contents
1. [Authentication](#authentication)
2. [Profile Management](#profile-management)
3. [Public/User Endpoints](#publicuser-endpoints)
4. [Officer/Petugas Endpoints](#officerpetugas-endpoints)
5. [Admin Endpoints](#admin-endpoints)
6. [Response Format](#response-format)
7. [Error Codes](#error-codes)

---

## 🔐 Authentication

### 1. Register (Public User)
**Endpoint**: `POST /register`  
**Auth Required**: No  
**Description**: Mendaftarkan user baru dengan role `public`

**Request Body**:
```json
{
  "name": "John Doe",
  "username": "johndoe",
  "password": "password123",
  "password_confirmation": "password123",
  "region_id": 1
}
```

**Success Response (201)**:
```json
{
  "message": "Registrasi berhasil",
  "access_token": "1|abcdefghijklmnopqrstuvwxyz",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "John Doe",
    "username": "johndoe",
    "role": "public",
    "region_id": 1
  }
}
```

---

### 2. Login (All Roles)
**Endpoint**: `POST /login`  
**Auth Required**: No  
**Description**: Login untuk semua role (admin, petugas, public)

**Request Body**:
```json
{
  "username": "johndoe",
  "password": "password123"
}
```

**Success Response (200)**:
```json
{
  "message": "Login berhasil",
  "access_token": "2|abcdefghijklmnopqrstuvwxyz",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "John Doe",
    "username": "johndoe",
    "role": "public",
    "region_id": 1
  }
}
```

**Error Response (401)**:
```json
{
  "message": "Username atau password salah"
}
```

---

### 3. Logout
**Endpoint**: `POST /logout`  
**Auth Required**: Yes  
**Description**: Menghapus token dan logout

**Headers**:
```
Authorization: Bearer {token}
```

**Success Response (200)**:
```json
{
  "message": "Berhasil keluar"
}
```

---

### 4. Get Current User
**Endpoint**: `GET /user`  
**Auth Required**: Yes  
**Description**: Mendapatkan data user yang sedang login

**Headers**:
```
Authorization: Bearer {token}
```

**Success Response (200)**:
```json
{
  "id": 1,
  "name": "John Doe",
  "username": "johndoe",
  "role": "public",
  "region_id": 1,
  "notification_token": "fcm_token_here",
  "photo": "profile_photos/abc123.jpg",
  "created_at": "2025-12-25T10:00:00.000000Z",
  "updated_at": "2025-12-25T10:00:00.000000Z"
}
```

---

### 5. Update FCM Token
**Endpoint**: `POST /user/update-token`  
**Auth Required**: Yes  
**Description**: Update token FCM untuk push notification

**Request Body**:
```json
{
  "notification_token": "fcm_token_from_device"
}
```

**Success Response (200)**:
```json
{
  "message": "Token updated successfully"
}
```

---

## 👤 Profile Management

### 1. Get Profile
**Endpoint**: `GET /profile`  
**Auth Required**: Yes  
**Description**: Mendapatkan data profil lengkap dengan relasi

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "John Doe",
    "username": "johndoe",
    "role": "public",
    "region_id": 1,
    "photo": "profile_photos/abc123.jpg",
    "region": {
      "id": 1,
      "name": "Kelurahan Kebon Jeruk",
      "flood_status": "normal",
      "station": {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk",
        "water_level": 45.50,
        "status": "normal"
      }
    }
  }
}
```

---

### 2. Update Profile
**Endpoint**: `PUT /profile`  
**Auth Required**: Yes  
**Description**: Update data profil

**Request Body**:
```json
{
  "name": "John Doe Updated",
  "username": "johndoe2",
  "region_id": 2
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Profil berhasil diperbarui",
  "data": {
    "id": 1,
    "name": "John Doe Updated",
    "username": "johndoe2",
    "role": "public",
    "region_id": 2
  }
}
```

---

### 3. Change Password
**Endpoint**: `PUT /profile/password`  
**Auth Required**: Yes  
**Description**: Ganti password

**Request Body**:
```json
{
  "current_password": "password123",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Password berhasil diubah"
}
```

**Error Response (422)**:
```json
{
  "status": "error",
  "message": "Password lama tidak sesuai"
}
```

---

### 4. Upload Photo Profile
**Endpoint**: `POST /profile/photo`  
**Auth Required**: Yes  
**Description**: Upload foto profil

**Request Body** (multipart/form-data):
```
photo: [file] (max 2MB, jpeg/png/jpg)
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Foto profil berhasil diupload",
  "data": {
    "photo_url": "http://localhost:8000/storage/profile_photos/abc123.jpg"
  }
}
```

---

## 🏠 Public/User Endpoints

### 1. Dashboard User
**Endpoint**: `GET /public/dashboard`  
**Auth Required**: Yes (Role: public)  
**Description**: Mendapatkan data dashboard user/masyarakat

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "user_region": {
      "region_name": "Kelurahan Kebon Jeruk",
      "flood_status": "siaga",
      "station_name": "Pos Pantau Kebon Jeruk",
      "water_level": 85.50,
      "status": "siaga",
      "last_update": "2025-12-25T10:30:00.000000Z"
    },
    "summary": {
      "total_reports": 5,
      "pending_reports": 2,
      "stations_normal": 8,
      "stations_siaga": 3,
      "stations_awas": 1
    },
    "my_recent_reports": [
      {
        "id": 1,
        "location": "Jl. Kebon Jeruk No. 10",
        "water_height": 30.00,
        "status": "diproses",
        "created_at": "2025-12-25T09:00:00.000000Z"
      }
    ],
    "all_stations": [
      {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk",
        "location": "Kebon Jeruk",
        "latitude": -6.200000,
        "longitude": 106.816666,
        "water_level": 85.50,
        "status": "siaga",
        "last_update": "2025-12-25T10:30:00.000000Z"
      }
    ]
  }
}
```

---

### 2. Submit Report (Regular)
**Endpoint**: `POST /public/report`  
**Auth Required**: Yes (Role: public)  
**Description**: Mengirim laporan banjir regular

**Request Body** (multipart/form-data):
```
location: "Jl. Kebon Jeruk No. 10"
water_height: 30.50
photo: [file] (optional, max 2MB)
```

**Success Response (201)**:
```json
{
  "status": "success",
  "message": "Laporan Anda berhasil dikirim dan sedang menunggu verifikasi.",
  "data": {
    "id": 1,
    "user_id": 1,
    "location": "Jl. Kebon Jeruk No. 10",
    "water_height": 30.50,
    "photo": "public_reports/abc123.jpg",
    "status": "pending",
    "created_at": "2025-12-25T10:00:00.000000Z"
  }
}
```

---

### 3. Emergency Report (SOS)
**Endpoint**: `POST /public/emergency-report`  
**Auth Required**: Yes (Role: public)  
**Description**: Mengirim sinyal darurat

**Request Body**:
```json
{
  "location": "Jl. Kebon Jeruk No. 10"
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Sinyal darurat telah dikirim ke pusat kendali! Petugas akan segera merespon.",
  "data": {
    "id": 2,
    "user_id": 1,
    "location": "Jl. Kebon Jeruk No. 10",
    "water_height": 0,
    "status": "emergency",
    "created_at": "2025-12-25T10:00:00.000000Z"
  }
}
```

---

### 4. Get Area Status
**Endpoint**: `GET /public/area-status`  
**Auth Required**: Yes (Role: public)  
**Description**: Cek status banjir wilayah user

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "region_name": "Kelurahan Kebon Jeruk",
    "status": "siaga",
    "water_level": 85.50,
    "station_name": "Pos Pantau Kebon Jeruk",
    "last_update": "2025-12-25T10:30:00.000000Z"
  }
}
```

---

### 5. Report History
**Endpoint**: `GET /public/reports/history`  
**Auth Required**: Yes (Role: public)  
**Description**: Riwayat laporan user dengan pagination

**Query Parameters**:
- `status` (optional): `all`, `pending`, `diproses`, `selesai`, `emergency`
- `page` (optional): halaman (default: 1)

**Example**: `GET /public/reports/history?status=pending&page=1`

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "location": "Jl. Kebon Jeruk No. 10",
        "water_height": 30.50,
        "photo": "public_reports/abc123.jpg",
        "status": "pending",
        "created_at": "2025-12-25T10:00:00.000000Z"
      }
    ],
    "total": 10,
    "per_page": 10,
    "last_page": 1
  }
}
```

---

### 6. Report Detail
**Endpoint**: `GET /public/reports/{id}`  
**Auth Required**: Yes (Role: public)  
**Description**: Detail laporan spesifik user

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "location": "Jl. Kebon Jeruk No. 10",
    "water_height": 30.50,
    "photo": "public_reports/abc123.jpg",
    "status": "pending",
    "created_at": "2025-12-25T10:00:00.000000Z",
    "updated_at": "2025-12-25T10:00:00.000000Z"
  }
}
```

---

### 7. Get Notifications
**Endpoint**: `GET /public/notifications`  
**Auth Required**: Yes (Role: public)  
**Description**: Daftar notifikasi user dengan pagination

**Query Parameters**:
- `read` (optional): `true` (sudah dibaca), `false` (belum dibaca)
- `page` (optional): halaman

**Example**: `GET /public/notifications?read=false&page=1`

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "user_id": 1,
        "title": "⚠️ PERINGATAN BANJIR: STATUS SIAGA",
        "message": "Pos Pantau Kebon Jeruk terpantau 85.50cm. Harap waspada!",
        "type": "flood_alert",
        "data": "{\"station_id\": 1}",
        "read_at": null,
        "created_at": "2025-12-25T10:30:00.000000Z"
      }
    ],
    "total": 20,
    "per_page": 20
  }
}
```

---

### 8. Mark Notification as Read
**Endpoint**: `PUT /public/notifications/{id}/read`  
**Auth Required**: Yes (Role: public)  
**Description**: Tandai satu notifikasi sebagai sudah dibaca

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Notifikasi ditandai sebagai sudah dibaca"
}
```

---

### 9. Mark All Notifications as Read
**Endpoint**: `POST /public/notifications/read-all`  
**Auth Required**: Yes (Role: public)  
**Description**: Tandai semua notifikasi sebagai sudah dibaca

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Semua notifikasi ditandai sebagai sudah dibaca"
}
```

---

### 10. Get All Stations
**Endpoint**: `GET /stations`  
**Auth Required**: Yes  
**Description**: Mendapatkan daftar semua stasiun

**Success Response (200)**:
```json
{
  "status": "success",
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

---

### 11. Get Station Detail
**Endpoint**: `GET /stations/{id}`  
**Auth Required**: Yes  
**Description**: Detail stasiun spesifik

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
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
}
```

---

### 12. Get All Regions
**Endpoint**: `GET /regions`  
**Auth Required**: Yes  
**Description**: Mendapatkan daftar semua wilayah

**Success Response (200)**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Kelurahan Kebon Jeruk",
      "flood_status": "siaga",
      "influenced_by_station_id": 1
    }
  ]
}
```

---

## 👮 Officer/Petugas Endpoints

### 1. Dashboard Petugas
**Endpoint**: `GET /officer/dashboard`  
**Auth Required**: Yes (Role: petugas)  
**Description**: Dashboard dengan statistik petugas

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
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
      "total_reports": 25,
      "approved": 20,
      "pending": 3,
      "rejected": 2,
      "total_stations": 2
    },
    "recent_reports": [
      {
        "id": 1,
        "station_id": 1,
        "water_level": 85.50,
        "rainfall": 15.00,
        "pump_status": "aktif",
        "validation_status": "approved",
        "created_at": "2025-12-25T09:00:00.000000Z"
      }
    ],
    "report_trend": [
      {
        "date": "2025-12-19",
        "total": 3
      },
      {
        "date": "2025-12-20",
        "total": 5
      }
    ]
  }
}
```

---

### 2. Get Assigned Stations
**Endpoint**: `GET /officer/stations`  
**Auth Required**: Yes (Role: petugas)  
**Description**: Stasiun yang ditugaskan ke petugas

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Daftar stasiun tugas berhasil diambil.",
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "location": "Kebon Jeruk",
      "status": "siaga"
    }
  ]
}
```

---

### 3. Submit Officer Report
**Endpoint**: `POST /officer/reports`  
**Auth Required**: Yes (Role: petugas)  
**Description**: Mengirim laporan teknis petugas

**Request Body** (multipart/form-data):
```
station_id: 1
water_level: 85.50
rainfall: 15.00
pump_status: aktif  // aktif, mati, rusak
photo: [file] (required, max 2MB)
note: "Pompa berfungsi normal" (optional)
```

**Success Response (201)**:
```json
{
  "status": "success",
  "message": "Laporan teknis berhasil dikirim. Menunggu validasi Admin.",
  "data": {
    "id": 1,
    "officer_id": 2,
    "station_id": 1,
    "water_level": 85.50,
    "rainfall": 15.00,
    "pump_status": "aktif",
    "photo": "officer_reports/abc123.jpg",
    "note": "Pompa berfungsi normal",
    "validation_status": "pending",
    "created_at": "2025-12-25T10:00:00.000000Z"
  }
}
```

---

### 4. Get Officer Reports
**Endpoint**: `GET /officer/reports`  
**Auth Required**: Yes (Role: petugas)  
**Description**: Riwayat laporan petugas

**Success Response (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "officer_id": 2,
      "station_id": 1,
      "water_level": 85.50,
      "rainfall": 15.00,
      "pump_status": "aktif",
      "photo": "officer_reports/abc123.jpg",
      "note": "Pompa berfungsi normal",
      "validation_status": "approved",
      "calculated_status": "siaga",
      "validated_by": 1,
      "created_at": "2025-12-25T10:00:00.000000Z",
      "station": {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk"
      }
    }
  ]
}
```

---

### 5. Get Officer Report Detail
**Endpoint**: `GET /officer/reports/{id}`  
**Auth Required**: Yes (Role: petugas)  
**Description**: Detail laporan spesifik petugas

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "officer_id": 2,
    "station_id": 1,
    "water_level": 85.50,
    "rainfall": 15.00,
    "pump_status": "aktif",
    "photo": "officer_reports/abc123.jpg",
    "note": "Pompa berfungsi normal",
    "validation_status": "approved",
    "calculated_status": "siaga",
    "validated_by": 1,
    "created_at": "2025-12-25T10:00:00.000000Z",
    "station": {
      "id": 1,
      "name": "Pos Pantau Kebon Jeruk",
      "location": "Kebon Jeruk"
    }
  }
}
```

---

## 👨‍💼 Admin Endpoints

### 1. Dashboard Admin
**Endpoint**: `GET /admin/dashboard`  
**Auth Required**: Yes (Role: admin)  
**Description**: Dashboard dengan statistik lengkap

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "summary": {
      "total_stations": 12,
      "total_officers": 8,
      "total_public_users": 150,
      "pending_officer_reports": 5,
      "pending_public_reports": 12,
      "emergency_reports": 2
    },
    "station_status": {
      "normal": 8,
      "siaga": 3,
      "awas": 1
    },
    "recent_officer_reports": [...],
    "recent_public_reports": [...],
    "report_trend": [
      {"date": "2025-12-19", "total": 8},
      {"date": "2025-12-20", "total": 12}
    ]
  }
}
```

---

### 2. Flood Potential Areas
**Endpoint**: `GET /admin/dashboard/flood-potential`  
**Auth Required**: Yes (Role: admin)  
**Description**: Daftar wilayah berpotensi banjir

**Success Response (200)**:
```json
{
  "status": "success",
  "data": {
    "regions": [
      {
        "id": 1,
        "region_name": "Kelurahan Kebon Jeruk",
        "flood_status": "siaga",
        "station_name": "Pos Pantau Kebon Jeruk",
        "water_level": 85.50,
        "station_status": "siaga",
        "last_update": "2025-12-25T10:30:00.000000Z"
      }
    ],
    "summary": {
      "awas": 1,
      "siaga": 3,
      "normal": 8
    }
  }
}
```

---

### 3. Report Recap
**Endpoint**: `GET /admin/dashboard/report-recap`  
**Auth Required**: Yes (Role: admin)  
**Description**: Rekapitulasi laporan berdasarkan periode

**Query Parameters**:
- `start_date` (required): YYYY-MM-DD
- `end_date` (required): YYYY-MM-DD
- `type` (optional): `officer`, `public`, `all` (default: all)

**Example**: `GET /admin/dashboard/report-recap?start_date=2025-12-01&end_date=2025-12-31&type=all`

**Success Response (200)**:
```json
{
  "status": "success",
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
      "details": [...]
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

---

### 4. Station Management

#### 4.1. Get All Stations
**Endpoint**: `GET /admin/stations`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
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
      "last_update": "2025-12-25T10:30:00.000000Z",
      "officers": [
        {"id": 2, "name": "Officer Name"}
      ]
    }
  ]
}
```

#### 4.2. Create Station
**Endpoint**: `POST /admin/stations`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "name": "Pos Pantau Baru",
  "location": "Kelapa Gading",
  "latitude": -6.200000,
  "longitude": 106.816666,
  "threshold_siaga": 80.00,
  "threshold_awas": 100.00,
  "officer_ids": [2, 3]
}
```

**Success Response (201)**:
```json
{
  "status": "success",
  "message": "Stasiun dan penugasan petugas berhasil disimpan.",
  "data": {
    "id": 2,
    "name": "Pos Pantau Baru",
    "location": "Kelapa Gading",
    "officers": [
      {"id": 2, "name": "Officer Name"}
    ]
  }
}
```

#### 4.3. Get Station Detail
**Endpoint**: `GET /admin/stations/{id}`  
**Auth Required**: Yes (Role: admin)

#### 4.4. Update Station
**Endpoint**: `PUT /admin/stations/{id}`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "name": "Pos Pantau Updated",
  "location": "Kelapa Gading",
  "latitude": -6.200000,
  "longitude": 106.816666,
  "threshold_siaga": 85.00,
  "threshold_awas": 105.00,
  "officer_ids": [2, 3, 4]
}
```

#### 4.5. Update Station Status
**Endpoint**: `PUT /admin/stations/{id}/status`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "status": "siaga"  // normal, siaga, awas
}
```

#### 4.6. Update Thresholds
**Endpoint**: `PUT /admin/stations/{id}/thresholds`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "threshold_siaga": 80.00,
  "threshold_awas": 100.00
}
```

#### 4.7. Assign Officers
**Endpoint**: `PUT /admin/stations/{id}/assign-officers`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "officer_ids": [2, 3, 4]
}
```

#### 4.8. Delete Station
**Endpoint**: `DELETE /admin/stations/{id}`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Stasiun berhasil dihapus"
}
```

---

### 5. Officer Management

#### 5.1. Get All Officers
**Endpoint**: `GET /admin/officers`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 2,
      "name": "Officer Name",
      "username": "officer1",
      "role": "petugas",
      "assigned_stations": [
        {"id": 1, "name": "Pos Pantau Kebon Jeruk"}
      ]
    }
  ]
}
```

#### 5.2. Create Officer
**Endpoint**: `POST /admin/officers`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "name": "New Officer",
  "username": "officer_new",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Success Response (201)**:
```json
{
  "status": "success",
  "message": "Petugas berhasil ditambahkan",
  "data": {
    "id": 3,
    "name": "New Officer",
    "username": "officer_new",
    "role": "petugas"
  }
}
```

#### 5.3. Get Officer Detail
**Endpoint**: `GET /admin/officers/{id}`  
**Auth Required**: Yes (Role: admin)

#### 5.4. Update Officer
**Endpoint**: `PUT /admin/officers/{id}`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "name": "Updated Officer Name",
  "username": "officer_updated"
}
```

#### 5.5. Delete Officer
**Endpoint**: `DELETE /admin/officers/{id}`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Petugas berhasil dihapus"
}
```

---

### 6. Report Validation

#### 6.1. Get Pending Officer Reports
**Endpoint**: `GET /admin/reports/officer`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Daftar laporan petugas berhasil diambil",
  "data": [
    {
      "id": 1,
      "officer_id": 2,
      "station_id": 1,
      "water_level": 85.50,
      "rainfall": 15.00,
      "pump_status": "aktif",
      "photo": "officer_reports/abc123.jpg",
      "validation_status": "pending",
      "created_at": "2025-12-25T10:00:00.000000Z",
      "officer": {
        "id": 2,
        "name": "Officer Name"
      },
      "station": {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk"
      }
    }
  ]
}
```

#### 6.2. Approve Officer Report
**Endpoint**: `PUT /admin/reports/officer/{id}/approve`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Laporan disetujui dengan status: siaga & notifikasi telah dikirim."
}
```

#### 6.3. Reject Officer Report
**Endpoint**: `PUT /admin/reports/officer/{id}/reject`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "note": "Data tidak valid, silakan input ulang"
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Laporan petugas telah ditolak.",
  "data": {
    "id": 1,
    "validation_status": "rejected",
    "note": "DITOLAK ADMIN: Data tidak valid, silakan input ulang"
  }
}
```

---

### 7. Public Report Management

#### 7.1. Get All Public Reports
**Endpoint**: `GET /admin/reports/public`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "location": "Jl. Kebon Jeruk No. 10",
      "water_height": 30.50,
      "photo": "public_reports/abc123.jpg",
      "status": "pending",
      "created_at": "2025-12-25T10:00:00.000000Z",
      "user": {
        "id": 1,
        "name": "John Doe"
      }
    }
  ]
}
```

#### 7.2. Update Public Report Status
**Endpoint**: `PUT /admin/reports/public/{id}`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "status": "diproses"  // pending, diproses, selesai, emergency
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Status laporan masyarakat diperbarui",
  "data": {
    "id": 1,
    "status": "diproses"
  }
}
```

---

### 8. Region Management

#### 8.1. Get All Regions
**Endpoint**: `GET /admin/regions`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Kelurahan Kebon Jeruk",
      "flood_status": "siaga",
      "influenced_by_station_id": 1,
      "station": {
        "id": 1,
        "name": "Pos Pantau Kebon Jeruk"
      }
    }
  ]
}
```

#### 8.2. Create Region
**Endpoint**: `POST /admin/regions`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "name": "Kelurahan Baru",
  "influenced_by_station_id": 1
}
```

#### 8.3. Update Region
**Endpoint**: `PUT /admin/regions/{id}`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "name": "Kelurahan Updated",
  "influenced_by_station_id": 2
}
```

---

### 9. Notification Management

#### 9.1. Get Notification Rules
**Endpoint**: `GET /admin/notifications/rules`  
**Auth Required**: Yes (Role: admin)

**Success Response (200)**:
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "status_type": "siaga",
      "message_template": "Pos Pantau {station_name} mencapai status SIAGA. Harap waspada!"
    },
    {
      "id": 2,
      "status_type": "awas",
      "message_template": "PERINGATAN! Pos Pantau {station_name} mencapai status AWAS. Segera evakuasi!"
    }
  ]
}
```

#### 9.2. Update Notification Rule
**Endpoint**: `PUT /admin/notifications/rules/{id}`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "message_template": "Template pesan baru dengan {station_name}"
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Template pesan siaga berhasil diperbarui",
  "data": {
    "id": 1,
    "status_type": "siaga",
    "message_template": "Template pesan baru dengan {station_name}"
  }
}
```

#### 9.3. Broadcast Manual Notification
**Endpoint**: `POST /admin/notifications/broadcast`  
**Auth Required**: Yes (Role: admin)

**Request Body**:
```json
{
  "title": "Pengumuman Penting",
  "message": "Harap waspada terhadap potensi banjir di wilayah Anda",
  "region_id": 1  // optional, jika null kirim ke semua
}
```

**Success Response (200)**:
```json
{
  "status": "success",
  "message": "Broadcast berhasil dikirim ke 50 warga."
}
```

---

## 📋 Response Format

### Success Response
Semua endpoint yang berhasil akan mengembalikan response dengan struktur:
```json
{
  "status": "success",
  "message": "Optional message",
  "data": {}
}
```

### Error Response
Endpoint yang gagal akan mengembalikan:
```json
{
  "status": "error",
  "message": "Error message description",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

---

## ❌ Error Codes

| HTTP Code | Description |
|-----------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized (Token tidak valid) |
| 403 | Forbidden (Tidak memiliki akses) |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Internal Server Error |

---

## 🔒 Authentication Headers

Semua endpoint yang memerlukan autentikasi harus menyertakan header:
```
Authorization: Bearer {your_access_token}
Content-Type: application/json
Accept: application/json
```

Untuk upload file (multipart/form-data):
```
Authorization: Bearer {your_access_token}
Content-Type: multipart/form-data
Accept: application/json
```

---

## 📦 File Upload Guidelines

### Accepted Image Formats
- JPEG (.jpg, .jpeg)
- PNG (.png)

### Maximum File Size
- 2 MB per file

### Storage Path
- Profile Photos: `storage/profile_photos/`
- Public Reports: `storage/public_reports/`
- Officer Reports: `storage/officer_reports/`

### Access URL
Files can be accessed via:
```
http://localhost:8000/storage/{path}
```

Example:
```
http://localhost:8000/storage/profile_photos/abc123.jpg
```

---

## 🚀 Quick Start for Frontend

### 1. Initialize Authentication
```javascript
// Login
const login = async (username, password) => {
  const response = await fetch('http://localhost:8000/api/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ username, password })
  });
  
  const data = await response.json();
  
  if (data.access_token) {
    // Save token to secure storage
    localStorage.setItem('token', data.access_token);
    localStorage.setItem('user', JSON.stringify(data.user));
    return data;
  }
};
```

### 2. Make Authenticated Request
```javascript
const fetchData = async (endpoint) => {
  const token = localStorage.getItem('token');
  
  const response = await fetch(`http://localhost:8000/api${endpoint}`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  });
  
  return await response.json();
};
```

### 3. Upload File
```javascript
const uploadReport = async (formData) => {
  const token = localStorage.getItem('token');
  
  const response = await fetch('http://localhost:8000/api/public/report', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    },
    body: formData // FormData object with files
  });
  
  return await response.json();
};
```

---

## 📝 Notes for Frontend Team

1. **Token Management**: 
   - Simpan token dengan aman (SecureStorage/Keychain untuk mobile)
   - Refresh token saat expired (401)
   - Clear token saat logout

2. **Role-based Navigation**:
   - Admin → Dashboard Admin
   - Petugas → Dashboard Petugas
   - Public → Dashboard User

3. **Real-time Updates**:
   - Implement FCM untuk push notification
   - Update UI saat notifikasi diterima

4. **Error Handling**:
   - Tampilkan pesan error yang user-friendly
   - Handle network errors
   - Validate form input sebelum submit

5. **Image Handling**:
   - Compress image sebelum upload
   - Show preview sebelum submit
   - Handle upload progress

6. **Pagination**:
   - Implement infinite scroll atau pagination
   - Cache data untuk performa

7. **Map Integration**:
   - Gunakan Google Maps / Mapbox
   - Plot stations dengan marker
   - Color code berdasarkan status (hijau/kuning/merah)

---

## 🆘 Support

Untuk pertanyaan atau bug report, hubungi:
- Backend Developer: [Your Contact]
- Documentation: [This File]
- Last Updated: 25 Desember 2025
