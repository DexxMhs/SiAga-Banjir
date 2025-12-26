# 🗄️ Database Schema - SiAGA Banjir

## ERD (Entity Relationship Diagram)

```
┌─────────────────┐         ┌─────────────────┐
│     Users       │         │    Regions      │
├─────────────────┤         ├─────────────────┤
│ id              │         │ id              │
│ name            │         │ name            │
│ username        │◄────┐   │ flood_status    │
│ password        │     │   │ influenced_by..│
│ role            │     │   │                 │
│ region_id       │─────┘   └────────┬────────┘
│ notification... │                  │
└────────┬────────┘                  │
         │                           │
         │                    ┌──────▼──────────┐
         │                    │    Stations     │
         │                    ├─────────────────┤
         │                    │ id              │
         │                    │ name            │
         │                    │ location        │
         │                    │ latitude        │
         │                    │ longitude       │
         │                    │ water_level     │
         │                    │ status          │
         │                    │ threshold_siaga │
         │                    │ threshold_awas  │
         │                    │ last_update     │
         │                    └────────┬────────┘
         │                             │
         │                             │
   ┌─────▼────────┐            ┌──────▼─────────────┐
   │Public Reports│            │  Officer Reports   │
   ├──────────────┤            ├────────────────────┤
   │ id           │            │ id                 │
   │ user_id      │            │ officer_id         │
   │ location     │            │ station_id         │
   │ water_height │            │ water_level        │
   │ photo        │            │ rainfall           │
   │ status       │            │ pump_status        │
   │              │            │ photo              │
   └──────────────┘            │ note               │
                               │ validation_status  │
                               │ calculated_status  │
                               │ validated_by       │
                               └────────────────────┘

   ┌──────────────────┐        ┌─────────────────────────┐
   │ Notifications    │        │ NotificationSettingRules│
   ├──────────────────┤        ├─────────────────────────┤
   │ id               │        │ id                      │
   │ user_id          │        │ status_type             │
   │ title            │        │ message_template        │
   │ message          │        └─────────────────────────┘
   │ type             │
   │ data             │        ┌─────────────────────────┐
   │ read_at          │        │ station_user (pivot)    │
   └──────────────────┘        ├─────────────────────────┤
                               │ station_id              │
                               │ user_id                 │
                               └─────────────────────────┘
```

---

## Table Structures

### 1. users
Menyimpan data semua pengguna sistem (Admin, Petugas, Public)

| Column             | Type          | Null | Default | Description                    |
|--------------------|---------------|------|---------|--------------------------------|
| id                 | bigint        | NO   | AUTO    | Primary Key                    |
| name               | varchar(255)  | NO   | -       | Nama lengkap                   |
| username           | varchar(255)  | NO   | -       | Username (unique)              |
| password           | varchar(255)  | NO   | -       | Password (hashed)              |
| role               | enum          | NO   | -       | admin, petugas, public         |
| region_id          | bigint        | YES  | NULL    | FK ke regions (untuk public)   |
| notification_token | text          | YES  | NULL    | FCM token untuk push notif     |
| created_at         | timestamp     | YES  | NULL    | -                              |
| updated_at         | timestamp     | YES  | NULL    | -                              |

**Indexes:**
- PRIMARY KEY: `id`
- UNIQUE: `username`
- INDEX: `region_id`

**Relations:**
- `region_id` → `regions.id` (belongsTo)

---

### 2. stations
Stasiun pemantauan ketinggian air

| Column          | Type          | Null | Default | Description                        |
|-----------------|---------------|------|---------|------------------------------------|
| id              | bigint        | NO   | AUTO    | Primary Key                        |
| name            | varchar(255)  | NO   | -       | Nama stasiun                       |
| location        | varchar(255)  | NO   | -       | Lokasi detail                      |
| latitude        | decimal(10,8) | NO   | -       | Koordinat lintang                  |
| longitude       | decimal(11,8) | NO   | -       | Koordinat bujur                    |
| water_level     | decimal(8,2)  | NO   | 0.00    | Ketinggian air saat ini (cm)       |
| status          | enum          | NO   | normal  | normal, siaga, awas                |
| threshold_siaga | decimal(8,2)  | NO   | -       | Batas level siaga (cm)             |
| threshold_awas  | decimal(8,2)  | NO   | -       | Batas level awas (cm)              |
| last_update     | timestamp     | YES  | NULL    | Waktu update terakhir              |
| created_at      | timestamp     | YES  | NULL    | -                                  |
| updated_at      | timestamp     | YES  | NULL    | -                                  |

**Indexes:**
- PRIMARY KEY: `id`

---

### 3. regions
Wilayah potensial terdampak banjir

| Column                    | Type          | Null | Default | Description                    |
|---------------------------|---------------|------|---------|--------------------------------|
| id                        | bigint        | NO   | AUTO    | Primary Key                    |
| name                      | varchar(255)  | NO   | -       | Nama wilayah                   |
| flood_status              | enum          | NO   | normal  | normal, siaga, awas            |
| influenced_by_station_id  | bigint        | NO   | -       | FK ke stations                 |
| created_at                | timestamp     | YES  | NULL    | -                              |
| updated_at                | timestamp     | YES  | NULL    | -                              |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `influenced_by_station_id`

**Relations:**
- `influenced_by_station_id` → `stations.id` (belongsTo)

---

### 4. officer_reports
Laporan teknis dari petugas lapangan

| Column              | Type          | Null | Default | Description                       |
|---------------------|---------------|------|---------|-----------------------------------|
| id                  | bigint        | NO   | AUTO    | Primary Key                       |
| officer_id          | bigint        | NO   | -       | FK ke users (role: petugas)       |
| station_id          | bigint        | NO   | -       | FK ke stations                    |
| water_level         | decimal(8,2)  | NO   | -       | Ketinggian air (cm)               |
| rainfall            | decimal(8,2)  | NO   | -       | Curah hujan (mm)                  |
| pump_status         | enum          | NO   | -       | aktif, mati, rusak                |
| photo               | varchar(255)  | NO   | -       | Path foto bukti                   |
| note                | text          | YES  | NULL    | Catatan tambahan                  |
| validation_status   | enum          | NO   | pending | pending, approved, rejected       |
| calculated_status   | enum          | YES  | NULL    | normal, siaga, awas               |
| validated_by        | bigint        | YES  | NULL    | FK ke users (admin yang validasi) |
| created_at          | timestamp     | YES  | NULL    | -                                 |
| updated_at          | timestamp     | YES  | NULL    | -                                 |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `officer_id`, `station_id`, `validation_status`

**Relations:**
- `officer_id` → `users.id` (belongsTo)
- `station_id` → `stations.id` (belongsTo)
- `validated_by` → `users.id` (belongsTo)

---

### 5. public_reports
Laporan dari masyarakat umum

| Column       | Type          | Null | Default | Description                          |
|--------------|---------------|------|---------|--------------------------------------|
| id           | bigint        | NO   | AUTO    | Primary Key                          |
| user_id      | bigint        | NO   | -       | FK ke users (role: public)           |
| location     | varchar(255)  | NO   | -       | Deskripsi lokasi                     |
| water_height | decimal(8,2)  | NO   | -       | Ketinggian air (cm)                  |
| photo        | varchar(255)  | YES  | NULL    | Path foto (optional)                 |
| status       | enum          | NO   | pending | pending, diproses, selesai, emergency|
| created_at   | timestamp     | YES  | NULL    | -                                    |
| updated_at   | timestamp     | YES  | NULL    | -                                    |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `user_id`, `status`

**Relations:**
- `user_id` → `users.id` (belongsTo)

---

### 6. notifications
Riwayat notifikasi yang dikirim ke user

| Column     | Type          | Null | Default | Description                        |
|------------|---------------|------|---------|------------------------------------|
| id         | bigint        | NO   | AUTO    | Primary Key                        |
| user_id    | bigint        | NO   | -       | FK ke users                        |
| title      | varchar(255)  | NO   | -       | Judul notifikasi                   |
| message    | text          | NO   | -       | Isi pesan                          |
| type       | varchar(50)   | NO   | -       | flood_alert, broadcast_manual      |
| data       | json          | YES  | NULL    | Data tambahan (station_id, dll)    |
| read_at    | timestamp     | YES  | NULL    | Waktu dibaca                       |
| created_at | timestamp     | YES  | NULL    | -                                  |
| updated_at | timestamp     | YES  | NULL    | -                                  |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `user_id`, `read_at`

**Relations:**
- `user_id` → `users.id` (belongsTo)

---

### 7. notification_setting_rules
Template pesan notifikasi untuk status siaga dan awas

| Column            | Type          | Null | Default | Description                      |
|-------------------|---------------|------|---------|----------------------------------|
| id                | bigint        | NO   | AUTO    | Primary Key                      |
| status_type       | enum          | NO   | -       | siaga, awas                      |
| message_template  | text          | NO   | -       | Template dengan {station_name}   |
| created_at        | timestamp     | YES  | NULL    | -                                |
| updated_at        | timestamp     | YES  | NULL    | -                                |

**Indexes:**
- PRIMARY KEY: `id`
- UNIQUE: `status_type`

---

### 8. station_user (Pivot Table)
Relasi many-to-many antara petugas dan stasiun

| Column      | Type    | Null | Default | Description                |
|-------------|---------|------|---------|----------------------------|
| id          | bigint  | NO   | AUTO    | Primary Key                |
| station_id  | bigint  | NO   | -       | FK ke stations             |
| user_id     | bigint  | NO   | -       | FK ke users (role: petugas)|
| created_at  | timestamp| YES | NULL    | -                          |
| updated_at  | timestamp| YES | NULL    | -                          |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `station_id`, `user_id`

**Relations:**
- `station_id` → `stations.id`
- `user_id` → `users.id`

---

### 9. Laravel System Tables

#### personal_access_tokens
Sanctum tokens untuk API authentication

#### cache, cache_locks
Untuk caching sistem

#### jobs, job_batches, failed_jobs
Untuk queue processing

#### migrations
Tracking migration history

#### sessions
Session management (jika menggunakan session driver database)

---

## 🔄 System Flows

### Flow 1: User Registration & Login
```
1. User → POST /register
   ↓
2. Backend: Create user dengan role "public"
   ↓
3. Backend: Generate Sanctum token
   ↓
4. Response: Return token & user data
   ↓
5. Flutter: Save token ke secure storage
   ↓
6. Flutter: Navigate ke dashboard based on role
```

### Flow 2: Officer Report → Notification System
```
1. Officer → POST /officer/reports (dengan foto)
   ↓
2. Backend: Save laporan dengan status "pending"
   ↓
3. Admin → GET /admin/reports/officer (melihat pending reports)
   ↓
4. Admin → PUT /admin/reports/officer/{id}/approve
   ↓
5. Backend Process:
   ├─ Calculate status (normal/siaga/awas) based on thresholds
   ├─ Update officer_report.validation_status = "approved"
   ├─ Update officer_report.calculated_status
   ├─ Update stations.water_level, status, last_update
   ├─ Update regions.flood_status (semua wilayah terdampak)
   └─ IF status = "siaga" OR "awas":
       ├─ Get notification template from notification_setting_rules
       ├─ Get all users in affected regions
       ├─ Bulk insert to notifications table
       └─ Send push notification via Firebase FCM
   ↓
6. Flutter (Warga): Receive push notification
   ↓
7. Flutter: Show alert dialog + update dashboard
```

### Flow 3: Public Report Flow
```
1. Warga → POST /public/report (dengan foto)
   ↓
2. Backend: Save laporan dengan status "pending"
   ↓
3. Admin → GET /admin/reports/public
   ↓
4. Admin → PUT /admin/reports/public/{id}
   ↓
5. Backend: Update status menjadi "diproses" atau "selesai"
```

### Flow 4: Emergency (SOS) Flow
```
1. Warga → Click tombol SOS
   ↓
2. Flutter → POST /public/emergency-report
   ↓
3. Backend: Save report dengan status "emergency"
   ↓
4. Admin → GET /admin/reports/public (emergency muncul di top)
   ↓
5. Admin → Koordinasi petugas untuk evakuasi
```

### Flow 5: Manual Broadcast
```
1. Admin → POST /admin/notifications/broadcast
   ↓
2. Backend Process:
   ├─ Get target users (by region_id or all)
   ├─ Bulk insert to notifications table
   └─ Send push notification via Firebase FCM
   ↓
3. Flutter (Users): Receive push notification
```

---

## 📊 Status Logic

### Station Status Calculation
```php
if (water_level >= threshold_awas) {
    status = "awas";
} elseif (water_level >= threshold_siaga) {
    status = "siaga";
} else {
    status = "normal";
}
```

### Example:
- `threshold_siaga = 50 cm`
- `threshold_awas = 100 cm`

| Water Level | Status |
|------------|--------|
| 30 cm      | Normal |
| 60 cm      | Siaga  |
| 120 cm     | Awas   |

---

## 🔐 Access Control Matrix

| Endpoint                         | Admin | Petugas | Public |
|----------------------------------|-------|---------|--------|
| POST /register                   | ✅    | ✅      | ✅     |
| POST /login                      | ✅    | ✅      | ✅     |
| GET /user                        | ✅    | ✅      | ✅     |
| GET /stations                    | ✅    | ✅      | ✅     |
| GET /regions                     | ✅    | ✅      | ✅     |
| POST /public/report              | ❌    | ❌      | ✅     |
| POST /public/emergency-report    | ❌    | ❌      | ✅     |
| GET /public/area-status          | ❌    | ❌      | ✅     |
| GET /officer/stations            | ❌    | ✅      | ❌     |
| POST /officer/reports            | ❌    | ✅      | ❌     |
| GET /officer/reports             | ❌    | ✅      | ❌     |
| GET /admin/stations              | ✅    | ❌      | ❌     |
| POST /admin/stations             | ✅    | ❌      | ❌     |
| PUT /admin/stations/{id}         | ✅    | ❌      | ❌     |
| GET /admin/officers              | ✅    | ❌      | ❌     |
| POST /admin/officers             | ✅    | ❌      | ❌     |
| GET /admin/reports/officer       | ✅    | ❌      | ❌     |
| PUT /admin/reports/officer/{id}/approve | ✅ | ❌ | ❌ |
| GET /admin/reports/public        | ✅    | ❌      | ❌     |
| POST /admin/notifications/broadcast | ✅ | ❌   | ❌     |

---

## 📸 File Storage Structure

```
storage/app/public/
├── officer_reports/
│   ├── xyz789.jpg
│   └── abc123.jpg
└── public_reports/
    ├── def456.jpg
    └── ghi789.jpg
```

**Access URL:** `http://localhost:8000/storage/officer_reports/xyz789.jpg`

**💡 Note:** Jalankan `php artisan storage:link` untuk membuat symlink

---

## 🎯 Key Features Summary

### 1. Multi-Role System
- **Admin**: Full control (CRUD semua data, validasi laporan, broadcast notif)
- **Petugas**: Submit laporan teknis dari stasiun
- **Public**: Laporan kondisi banjir, SOS, monitoring wilayah

### 2. Intelligent Notification
- Otomatis trigger saat status berubah jadi siaga/awas
- Template customizable oleh admin
- Targeted notification berdasarkan wilayah

### 3. Real-time Status Update
- Status stasiun otomatis terupdate saat laporan approved
- Status wilayah ikut terupdate
- Warga dapat real-time info tentang wilayahnya

### 4. Photo Evidence
- Officer reports: Required photo
- Public reports: Optional photo
- Stored in separate folders

### 5. Validation System
- Laporan petugas harus divalidasi admin
- Prevent false alarm
- Admin bisa reject dengan alasan

---

## 🧪 Test Data (dari Seeder)

### Users
```
Admin:
- username: admin
- password: password

Petugas:
- username: petugas1, petugas2
- password: password

Public:
- username: warga1, warga2, warga3
- password: password
```

### Default Notification Templates
```
Siaga: "⚠️ Status SIAGA di {station_name}! ..."
Awas: "🚨 STATUS AWAS di {station_name}! ..."
```

---

**Last Updated:** 25 Desember 2025
