# 📱 API Documentation - SiAGA Banjir
**Sistem Informasi dan Aplikasi Gabungan Antisipasi Banjir**

## 📋 Daftar Isi
- [Base URL & Authentication](#base-url--authentication)
- [Authentication Endpoints](#1-authentication-endpoints)
- [Public Endpoints](#2-public-endpoints)
- [User/Warga Endpoints](#3-userwarga-endpoints-role-public)
- [Officer/Petugas Endpoints](#4-officerpetugas-endpoints-role-petugas)
- [Admin Endpoints](#5-admin-endpoints-role-admin)
- [Error Handling](#error-handling)
- [Data Models](#data-models)

---

## Base URL & Authentication

### Base URL
```
http://localhost:8000/api
```

### Authentication
API ini menggunakan **Laravel Sanctum** dengan Bearer Token.

**Header yang diperlukan:**
```
Authorization: Bearer {your_access_token}
Accept: application/json
Content-Type: application/json
```

**Multipart/form-data untuk upload foto:**
```
Authorization: Bearer {your_access_token}
Content-Type: multipart/form-data
```

---

## 1. Authentication Endpoints

### 1.1 Register (Public)
**Endpoint:** `POST /register`  
**Auth:** Tidak perlu  
**Deskripsi:** Mendaftarkan user baru dengan role "public" (warga)

**Request Body:**
```json
{
  "name": "Budi Santoso",
  "username": "budi123",
  "password": "password123",
  "region_id": 1
}
```

**Response Success (201):**
```json
{
  "message": "Registrasi berhasil",
  "access_token": "1|abc123xyz...",
  "token_type": "Bearer",
  "user": {
    "id": 15,
    "name": "Budi Santoso",
    "username": "budi123",
    "role": "public",
    "region_id": 1,
    "notification_token": null,
    "created_at": "2025-12-25T10:30:00.000000Z",
    "updated_at": "2025-12-25T10:30:00.000000Z"
  }
}
```

---

### 1.2 Login (All Roles)
**Endpoint:** `POST /login`  
**Auth:** Tidak perlu  
**Deskripsi:** Login untuk semua role (admin, petugas, public)

**Request Body:**
```json
{
  "username": "admin",
  "password": "password123"
}
```

**Response Success (200):**
```json
{
  "message": "Login berhasil",
  "access_token": "2|xyz789abc...",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Administrator",
    "username": "admin",
    "role": "admin",
    "region_id": null
  }
}
```

**Response Error (401):**
```json
{
  "message": "Username atau password salah"
}
```

**💡 Tips Flutter:** Simpan `access_token` menggunakan `shared_preferences` atau `flutter_secure_storage`

---

### 1.3 Logout
**Endpoint:** `POST /logout`  
**Auth:** Required (Bearer Token)  
**Deskripsi:** Menghapus token aktif dan keluar dari sistem

**Response Success (200):**
```json
{
  "message": "Berhasil keluar"
}
```

---

### 1.4 Get User Profile
**Endpoint:** `GET /user`  
**Auth:** Required  
**Deskripsi:** Mendapatkan data profil user yang sedang login

**Response Success (200):**
```json
{
  "id": 5,
  "name": "Petugas Ahmad",
  "username": "ahmad_officer",
  "role": "petugas",
  "region_id": null,
  "notification_token": "fcm_token_here",
  "created_at": "2025-12-20T08:00:00.000000Z",
  "updated_at": "2025-12-25T09:15:00.000000Z"
}
```

---

### 1.5 Update Notification Token
**Endpoint:** `POST /user/update-token`  
**Auth:** Required  
**Deskripsi:** Memperbarui FCM token untuk push notification

**Request Body:**
```json
{
  "notification_token": "fcm_token_from_firebase"
}
```

**Response Success (200):**
```json
{
  "message": "Token updated successfully"
}
```

**💡 Tips Flutter:** Panggil endpoint ini setelah mendapatkan FCM token dari Firebase Cloud Messaging

---

## 2. Public Endpoints

### 2.1 Get All Stations
**Endpoint:** `GET /stations`  
**Auth:** Required  
**Deskripsi:** Mendapatkan daftar semua stasiun pemantauan

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Bendungan Katulampa",
      "location": "Bogor, Jawa Barat",
      "latitude": "-6.632911",
      "longitude": "106.830556",
      "water_level": 75,
      "status": "siaga",
      "last_update": "2025-12-25T10:30:00.000000Z",
      "regions": [
        {
          "id": 1,
          "name": "Kampung Melayu",
          "influenced_by_station_id": 1
        },
        {
          "id": 2,
          "name": "Bukit Duri",
          "influenced_by_station_id": 1
        }
      ]
    }
  ]
}
```

**Status Values:**
- `normal` - Aman
- `siaga` - Waspada
- `awas` - Bahaya

---

### 2.2 Get Station Detail
**Endpoint:** `GET /stations/{id}`  
**Auth:** Required  
**Deskripsi:** Mendapatkan detail stasiun tertentu

**Response Success (200):**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "Pos Pantau Bendungan Katulampa",
    "location": "Bogor, Jawa Barat",
    "latitude": "-6.632911",
    "longitude": "106.830556",
    "water_level": 75,
    "status": "siaga",
    "last_update": "2025-12-25T10:30:00.000000Z",
    "regions": [...]
  }
}
```

---

### 2.3 Get All Regions
**Endpoint:** `GET /regions`  
**Auth:** Required  
**Deskripsi:** Mendapatkan daftar semua wilayah potensial banjir

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Kampung Melayu",
      "flood_status": "siaga",
      "influenced_by_station_id": 1,
      "created_at": "2025-12-20T08:00:00.000000Z",
      "updated_at": "2025-12-25T10:30:00.000000Z",
      "station": {
        "id": 1,
        "name": "Pos Pantau Bendungan Katulampa",
        "status": "siaga"
      }
    }
  ]
}
```

---

## 3. User/Warga Endpoints (Role: public)

### 3.1 Submit Public Report
**Endpoint:** `POST /public/report`  
**Auth:** Required (Role: public)  
**Deskripsi:** Mengirim laporan kondisi banjir dari lokasi warga

**Request (multipart/form-data):**
```
location: "Jalan Raya No. 123, RT 01/05"
water_height: 50
photo: (file) gambar.jpg
```

**Response Success (201):**
```json
{
  "status": "success",
  "message": "Laporan Anda berhasil dikirim dan sedang menunggu verifikasi.",
  "data": {
    "id": 10,
    "user_id": 15,
    "location": "Jalan Raya No. 123, RT 01/05",
    "water_height": 50,
    "photo": "public_reports/abc123.jpg",
    "status": "pending",
    "created_at": "2025-12-25T11:00:00.000000Z",
    "updated_at": "2025-12-25T11:00:00.000000Z"
  }
}
```

**💡 Tips Flutter:** Gunakan `http` atau `dio` package dengan MultipartRequest untuk upload foto

---

### 3.2 Emergency Report (SOS)
**Endpoint:** `POST /public/emergency-report`  
**Auth:** Required (Role: public)  
**Deskripsi:** Mengirim sinyal darurat tanpa detail lengkap

**Request Body:**
```json
{
  "location": "Lokasi saya (optional)"
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Sinyal darurat telah dikirim ke pusat kendali! Petugas akan segera merespon.",
  "data": {
    "id": 11,
    "user_id": 15,
    "location": "Lokasi saya",
    "water_height": 0,
    "photo": null,
    "status": "emergency",
    "created_at": "2025-12-25T11:05:00.000000Z",
    "updated_at": "2025-12-25T11:05:00.000000Z"
  }
}
```

**💡 Tips Flutter:** Buat tombol SOS yang mudah diakses di halaman utama

---

### 3.3 Get Area Status
**Endpoint:** `GET /public/area-status`  
**Auth:** Required (Role: public)  
**Deskripsi:** Melihat status banjir berdasarkan wilayah domisili user

**Response Success (200):**
```json
{
  "status": "success",
  "data": {
    "region_name": "Kampung Melayu",
    "status": "siaga",
    "water_level": 75,
    "station_name": "Pos Pantau Bendungan Katulampa",
    "last_update": "2025-12-25T10:30:00.000000Z"
  }
}
```

**Response Error (400):**
```json
{
  "status": "error",
  "message": "Silakan lengkapi profil Anda dengan memilih wilayah domisili."
}
```

**💡 Tips Flutter:** Tampilkan status ini di halaman dashboard dengan warna berbeda (hijau=normal, kuning=siaga, merah=awas)

---

## 4. Officer/Petugas Endpoints (Role: petugas)

### 4.1 Get Assigned Stations
**Endpoint:** `GET /officer/stations`  
**Auth:** Required (Role: petugas)  
**Deskripsi:** Mendapatkan daftar stasiun yang ditugaskan ke petugas

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Daftar stasiun tugas berhasil diambil.",
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Bendungan Katulampa",
      "location": "Bogor, Jawa Barat",
      "status": "normal"
    }
  ]
}
```

---

### 4.2 Submit Officer Report
**Endpoint:** `POST /officer/reports`  
**Auth:** Required (Role: petugas)  
**Deskripsi:** Mengirim laporan teknis dari stasiun

**Request (multipart/form-data):**
```
station_id: 1
water_level: 75
rainfall: 120
pump_status: "aktif"
photo: (file) foto_lapangan.jpg
note: "Curah hujan tinggi sejak pagi"
```

**Response Success (201):**
```json
{
  "status": "success",
  "message": "Laporan teknis berhasil dikirim. Menunggu validasi Admin.",
  "data": {
    "id": 20,
    "officer_id": 5,
    "station_id": 1,
    "water_level": 75,
    "rainfall": 120,
    "pump_status": "aktif",
    "photo": "officer_reports/xyz789.jpg",
    "note": "Curah hujan tinggi sejak pagi",
    "validation_status": "pending",
    "calculated_status": null,
    "validated_by": null,
    "created_at": "2025-12-25T11:20:00.000000Z",
    "updated_at": "2025-12-25T11:20:00.000000Z"
  }
}
```

**Validation:**
- station_id: required, exists in stations table
- water_level: required, numeric, min:0
- rainfall: required, numeric, min:0
- pump_status: required, in:aktif,mati,rusak
- photo: required, image, max:2MB
- note: optional, string

---

### 4.3 Get Officer Reports History
**Endpoint:** `GET /officer/reports`  
**Auth:** Required (Role: petugas)  
**Deskripsi:** Melihat riwayat laporan yang telah dibuat petugas

**Response Success (200):**
```json
{
  "data": [
    {
      "id": 20,
      "officer_id": 5,
      "station_id": 1,
      "water_level": 75,
      "rainfall": 120,
      "pump_status": "aktif",
      "photo": "officer_reports/xyz789.jpg",
      "note": "Curah hujan tinggi sejak pagi",
      "validation_status": "approved",
      "calculated_status": "siaga",
      "validated_by": 1,
      "created_at": "2025-12-25T11:20:00.000000Z",
      "updated_at": "2025-12-25T11:25:00.000000Z",
      "station": {
        "id": 1,
        "name": "Pos Pantau Bendungan Katulampa",
        "location": "Bogor, Jawa Barat"
      }
    }
  ]
}
```

---

### 4.4 Get Officer Report Detail
**Endpoint:** `GET /officer/reports/{id}`  
**Auth:** Required (Role: petugas)  
**Deskripsi:** Melihat detail laporan tertentu milik petugas

**Response Success (200):**
```json
{
  "status": "success",
  "data": {
    "id": 20,
    "officer_id": 5,
    "station_id": 1,
    "water_level": 75,
    "rainfall": 120,
    "pump_status": "aktif",
    "photo": "officer_reports/xyz789.jpg",
    "note": "Curah hujan tinggi sejak pagi",
    "validation_status": "approved",
    "calculated_status": "siaga",
    "validated_by": 1,
    "created_at": "2025-12-25T11:20:00.000000Z",
    "updated_at": "2025-12-25T11:25:00.000000Z",
    "station": {...}
  }
}
```

---

## 5. Admin Endpoints (Role: admin)

### 5.1 Station Management

#### 5.1.1 Get All Stations (Admin)
**Endpoint:** `GET /admin/stations`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Pos Pantau Bendungan Katulampa",
      "location": "Bogor, Jawa Barat",
      "latitude": "-6.632911",
      "longitude": "106.830556",
      "water_level": 75,
      "status": "siaga",
      "threshold_siaga": 50,
      "threshold_awas": 100,
      "last_update": "2025-12-25T10:30:00.000000Z",
      "officers": [
        {
          "id": 5,
          "name": "Petugas Ahmad"
        }
      ]
    }
  ]
}
```

---

#### 5.1.2 Create Station
**Endpoint:** `POST /admin/stations`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "name": "Pos Pantau Manggarai",
  "location": "Jakarta Selatan",
  "latitude": "-6.123456",
  "longitude": "106.654321",
  "threshold_siaga": 50,
  "threshold_awas": 100,
  "officer_ids": [5, 6]
}
```

**Response Success (201):**
```json
{
  "status": "success",
  "message": "Stasiun dan penugasan petugas berhasil disimpan.",
  "data": {
    "id": 2,
    "name": "Pos Pantau Manggarai",
    "location": "Jakarta Selatan",
    "latitude": "-6.123456",
    "longitude": "106.654321",
    "water_level": 0,
    "status": "normal",
    "threshold_siaga": 50,
    "threshold_awas": 100,
    "last_update": null,
    "officers": [...]
  }
}
```

---

#### 5.1.3 Update Station
**Endpoint:** `PUT /admin/stations/{id}`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "name": "Pos Pantau Bendungan Katulampa (Updated)",
  "location": "Bogor, Jawa Barat",
  "latitude": "-6.632911",
  "longitude": "106.830556",
  "threshold_siaga": 60,
  "threshold_awas": 120,
  "officer_ids": [5]
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Data stasiun dan penugasan petugas berhasil diperbarui.",
  "data": {...}
}
```

---

#### 5.1.4 Update Station Status
**Endpoint:** `PUT /admin/stations/{id}/status`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "status": "awas"
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Status stasiun diperbarui",
  "data": {...}
}
```

---

#### 5.1.5 Update Station Thresholds
**Endpoint:** `PUT /admin/stations/{id}/thresholds`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "threshold_siaga": 60,
  "threshold_awas": 120
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Ambang batas stasiun Pos Pantau Bendungan Katulampa berhasil diperbarui.",
  "data": {
    "id": 1,
    "name": "Pos Pantau Bendungan Katulampa",
    "threshold_siaga": 60,
    "threshold_awas": 120
  }
}
```

---

#### 5.1.6 Assign Officers to Station
**Endpoint:** `PUT /admin/stations/{id}/assign-officers`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "officer_ids": [5, 6, 7]
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Daftar petugas untuk stasiun Pos Pantau Bendungan Katulampa berhasil diperbarui.",
  "data": {
    "id": 1,
    "name": "Pos Pantau Bendungan Katulampa",
    "officers": [...]
  }
}
```

---

#### 5.1.7 Delete Station
**Endpoint:** `DELETE /admin/stations/{id}`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Stasiun berhasil dihapus"
}
```

---

### 5.2 Officer Management

#### 5.2.1 Get All Officers
**Endpoint:** `GET /admin/officers`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 5,
      "name": "Petugas Ahmad",
      "username": "ahmad_officer",
      "role": "petugas",
      "region_id": null,
      "notification_token": null,
      "created_at": "2025-12-20T08:00:00.000000Z",
      "updated_at": "2025-12-20T08:00:00.000000Z",
      "assigned_stations": [
        {
          "id": 1,
          "name": "Pos Pantau Bendungan Katulampa"
        }
      ]
    }
  ]
}
```

---

#### 5.2.2 Create Officer
**Endpoint:** `POST /admin/officers`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "name": "Petugas Budi",
  "username": "budi_officer",
  "password": "password123",
  "station_ids": [1, 2]
}
```

**Response Success (201):**
```json
{
  "status": "success",
  "message": "Akun petugas berhasil dibuat dan ditugaskan",
  "data": {
    "id": 6,
    "name": "Petugas Budi",
    "username": "budi_officer",
    "role": "petugas",
    "assigned_stations": [...]
  }
}
```

---

#### 5.2.3 Update Officer
**Endpoint:** `PUT /admin/officers/{id}`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "name": "Petugas Ahmad (Updated)",
  "username": "ahmad_officer",
  "password": "newpassword123",
  "station_ids": [1]
}
```

**Note:** Password optional, hanya kirim jika ingin mengubah password

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Data petugas dan penugasan berhasil diperbarui",
  "data": {...}
}
```

---

#### 5.2.4 Delete Officer
**Endpoint:** `DELETE /admin/officers/{id}`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Akun petugas berhasil dihapus"
}
```

---

### 5.3 Report Validation (Officer Reports)

#### 5.3.1 Get Pending Officer Reports
**Endpoint:** `GET /admin/reports/officer`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Daftar laporan petugas berhasil diambil",
  "data": [
    {
      "id": 20,
      "officer_id": 5,
      "station_id": 1,
      "water_level": 75,
      "rainfall": 120,
      "pump_status": "aktif",
      "photo": "officer_reports/xyz789.jpg",
      "note": "Curah hujan tinggi sejak pagi",
      "validation_status": "pending",
      "calculated_status": null,
      "validated_by": null,
      "created_at": "2025-12-25T11:20:00.000000Z",
      "updated_at": "2025-12-25T11:20:00.000000Z",
      "officer": {
        "id": 5,
        "name": "Petugas Ahmad"
      },
      "station": {
        "id": 1,
        "name": "Pos Pantau Bendungan Katulampa"
      }
    }
  ]
}
```

---

#### 5.3.2 Approve Officer Report
**Endpoint:** `PUT /admin/reports/officer/{id}/approve`  
**Auth:** Required (Role: admin)

**Request Body:** Tidak diperlukan

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Laporan disetujui dengan status: siaga & notifikasi telah dikirim."
}
```

**Proses yang terjadi:**
1. Laporan disetujui dan status dihitung berdasarkan threshold
2. Data stasiun diperbarui (water_level, status, last_update)
3. Status semua wilayah terdampak diperbarui
4. Jika status "siaga" atau "awas", notifikasi push otomatis terkirim ke warga di wilayah terdampak

---

#### 5.3.3 Reject Officer Report
**Endpoint:** `PUT /admin/reports/officer/{id}/reject`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "note": "Data tidak valid, mohon periksa kembali"
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Laporan petugas telah ditolak.",
  "data": {...}
}
```

---

### 5.4 Public Report Monitoring

#### 5.4.1 Get All Public Reports
**Endpoint:** `GET /admin/reports/public`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 10,
      "user_id": 15,
      "location": "Jalan Raya No. 123, RT 01/05",
      "water_height": 50,
      "photo": "public_reports/abc123.jpg",
      "status": "pending",
      "created_at": "2025-12-25T11:00:00.000000Z",
      "updated_at": "2025-12-25T11:00:00.000000Z",
      "user": {
        "id": 15,
        "name": "Budi Santoso"
      }
    }
  ]
}
```

---

#### 5.4.2 Update Public Report Status
**Endpoint:** `PUT /admin/reports/public/{id}`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "status": "diproses"
}
```

**Status values:** `pending`, `diproses`, `selesai`

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Status laporan masyarakat berhasil diperbarui ke: diproses",
  "data": {...}
}
```

---

### 5.5 Region Management

#### 5.5.1 Get All Regions
**Endpoint:** `GET /admin/regions`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Kampung Melayu",
      "flood_status": "siaga",
      "influenced_by_station_id": 1,
      "created_at": "2025-12-20T08:00:00.000000Z",
      "updated_at": "2025-12-25T10:30:00.000000Z",
      "station": {
        "id": 1,
        "name": "Pos Pantau Bendungan Katulampa"
      }
    }
  ]
}
```

---

#### 5.5.2 Create Region
**Endpoint:** `POST /admin/regions`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "name": "Cawang",
  "influenced_by_station_id": 1,
  "flood_status": "normal"
}
```

**Response Success (201):**
```json
{
  "status": "success",
  "message": "Wilayah potensial berhasil ditambahkan",
  "data": {
    "id": 3,
    "name": "Cawang",
    "flood_status": "normal",
    "influenced_by_station_id": 1,
    "created_at": "2025-12-25T12:00:00.000000Z",
    "updated_at": "2025-12-25T12:00:00.000000Z"
  }
}
```

---

#### 5.5.3 Update Region
**Endpoint:** `PUT /admin/regions/{id}`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "name": "Kampung Melayu (Updated)",
  "influenced_by_station_id": 2,
  "flood_status": "awas"
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Data wilayah berhasil diperbarui",
  "data": {...}
}
```

---

### 5.6 Notification Management

#### 5.6.1 Get Notification Rules
**Endpoint:** `GET /admin/notifications/rules`  
**Auth:** Required (Role: admin)

**Response Success (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "status_type": "siaga",
      "message_template": "⚠️ Status SIAGA di {station_name}! Tinggi air mencapai tingkat berbahaya. Harap waspada dan pantau terus perkembangan situasi.",
      "created_at": "2025-12-20T08:00:00.000000Z",
      "updated_at": "2025-12-20T08:00:00.000000Z"
    },
    {
      "id": 2,
      "status_type": "awas",
      "message_template": "🚨 STATUS AWAS di {station_name}! Banjir sudah sangat tinggi. Segera amankan diri dan keluarga Anda!",
      "created_at": "2025-12-20T08:00:00.000000Z",
      "updated_at": "2025-12-20T08:00:00.000000Z"
    }
  ]
}
```

**💡 Note:** Template menggunakan placeholder `{station_name}` yang akan diganti otomatis

---

#### 5.6.2 Update Notification Rule
**Endpoint:** `PUT /admin/notifications/rules/{id}`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "message_template": "⚠️ PERINGATAN! Status SIAGA di {station_name}. Tinggi air mencapai level berbahaya. Mohon waspada!"
}
```

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Template pesan siaga berhasil diperbarui",
  "data": {...}
}
```

---

#### 5.6.3 Broadcast Manual Notification
**Endpoint:** `POST /admin/notifications/broadcast`  
**Auth:** Required (Role: admin)

**Request Body:**
```json
{
  "title": "Info Penting",
  "message": "Cuaca buruk diprediksi hingga malam hari. Harap waspada!",
  "region_id": 1
}
```

**Note:** `region_id` optional. Jika tidak diisi, akan dikirim ke semua warga.

**Response Success (200):**
```json
{
  "status": "success",
  "message": "Broadcast berhasil dikirim ke 150 warga."
}
```

---

## Error Handling

### Standard Error Responses

#### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

#### 403 Forbidden
```json
{
  "message": "This action is unauthorized."
}
```

#### 404 Not Found
```json
{
  "message": "No query results for model [App\\Models\\Station] 999"
}
```

#### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "username": ["The username field is required."],
    "password": ["The password field is required."]
  }
}
```

#### 500 Internal Server Error
```json
{
  "message": "Server Error"
}
```

---

## Data Models

### User Model
```json
{
  "id": 1,
  "name": "string",
  "username": "string (unique)",
  "role": "admin|petugas|public",
  "region_id": "integer (nullable, for public only)",
  "notification_token": "string (nullable, FCM token)",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### Station Model
```json
{
  "id": 1,
  "name": "string",
  "location": "string",
  "latitude": "decimal",
  "longitude": "decimal",
  "water_level": "decimal (current level in cm)",
  "status": "normal|siaga|awas",
  "threshold_siaga": "decimal (cm)",
  "threshold_awas": "decimal (cm)",
  "last_update": "timestamp (nullable)",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### Region Model
```json
{
  "id": 1,
  "name": "string",
  "flood_status": "normal|siaga|awas",
  "influenced_by_station_id": "integer",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### Officer Report Model
```json
{
  "id": 1,
  "officer_id": "integer",
  "station_id": "integer",
  "water_level": "decimal (cm)",
  "rainfall": "decimal (mm)",
  "pump_status": "aktif|mati|rusak",
  "photo": "string (path)",
  "note": "text (nullable)",
  "validation_status": "pending|approved|rejected",
  "calculated_status": "normal|siaga|awas (nullable)",
  "validated_by": "integer (admin id, nullable)",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### Public Report Model
```json
{
  "id": 1,
  "user_id": "integer",
  "location": "string",
  "water_height": "decimal (cm)",
  "photo": "string (path, nullable)",
  "status": "pending|diproses|selesai|emergency",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### Notification Model
```json
{
  "id": 1,
  "user_id": "integer",
  "title": "string",
  "message": "text",
  "type": "flood_alert|broadcast_manual",
  "data": "json (nullable)",
  "read_at": "timestamp (nullable)",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

---

## 📱 Tips Implementasi Flutter

### 1. Setup HTTP Client
```dart
// lib/services/api_service.dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'http://localhost:8000/api';
  
  Future<Map<String, dynamic>> login(String username, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json'},
      body: json.encode({
        'username': username,
        'password': password,
      }),
    );
    
    return json.decode(response.body);
  }
  
  Future<Map<String, dynamic>> getWithAuth(String endpoint, String token) async {
    final response = await http.get(
      Uri.parse('$baseUrl$endpoint'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    
    return json.decode(response.body);
  }
}
```

### 2. Handle Upload Foto
```dart
import 'package:http/http.dart' as http;

Future<void> uploadReport(File photo, double waterHeight, String location, String token) async {
  var request = http.MultipartRequest(
    'POST',
    Uri.parse('http://localhost:8000/api/public/report'),
  );
  
  request.headers['Authorization'] = 'Bearer $token';
  request.fields['water_height'] = waterHeight.toString();
  request.fields['location'] = location;
  request.files.add(await http.MultipartFile.fromPath('photo', photo.path));
  
  var response = await request.send();
  // Handle response
}
```

### 3. Role-Based Navigation
```dart
void navigateByRole(String role) {
  switch (role) {
    case 'admin':
      Navigator.pushReplacementNamed(context, '/admin-dashboard');
      break;
    case 'petugas':
      Navigator.pushReplacementNamed(context, '/officer-dashboard');
      break;
    case 'public':
      Navigator.pushReplacementNamed(context, '/user-dashboard');
      break;
  }
}
```

### 4. Firebase Cloud Messaging Setup
```dart
import 'package:firebase_messaging/firebase_messaging.dart';

Future<void> setupPushNotification() async {
  FirebaseMessaging messaging = FirebaseMessaging.instance;
  
  // Request permission
  await messaging.requestPermission();
  
  // Get token
  String? token = await messaging.getToken();
  
  // Send token to backend
  if (token != null) {
    await updateNotificationToken(token);
  }
  
  // Handle foreground messages
  FirebaseMessaging.onMessage.listen((RemoteMessage message) {
    // Show notification dialog
  });
}
```

### 5. Status Color Helper
```dart
Color getStatusColor(String status) {
  switch (status.toLowerCase()) {
    case 'normal':
      return Colors.green;
    case 'siaga':
      return Colors.orange;
    case 'awas':
      return Colors.red;
    default:
      return Colors.grey;
  }
}
```

---

## 🔐 Security Notes

1. **Jangan hardcode token** - Gunakan secure storage
2. **Validasi input** di sisi Flutter sebelum kirim ke API
3. **Handle expired token** - Redirect ke login jika dapat 401
4. **HTTPS di production** - Jangan gunakan HTTP di production
5. **Compress gambar** sebelum upload untuk menghemat bandwidth

---

## 📞 Support

Jika ada pertanyaan tentang API ini, silakan hubungi tim backend.

**Version:** 1.0  
**Last Updated:** 25 Desember 2025
