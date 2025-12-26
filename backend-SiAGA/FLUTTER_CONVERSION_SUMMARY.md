# 📱 KONVERSI LENGKAP: HTML ke Flutter - SiAGA Banjir (Petugas)

## ✅ Status Konversi

### File Yang Sudah Dibuat
- ✅ `lib/config/colors.dart` - 45 lines
- ✅ `lib/config/theme.dart` - 185 lines  
- ✅ `lib/screens/officer/login_page.dart` - 345 lines
- ✅ `lib/widgets/station_card.dart` - 145 lines
- ✅ `lib/widgets/status_chip.dart` - 60 lines
- ✅ `lib/widgets/stat_card.dart` - 105 lines

**Total: 6 files, ~885 lines of code**

---

## 📂 Struktur Folder

```
flutter_ui_petugas/
├── lib/
│   ├── config/
│   │   ├── colors.dart ✅
│   │   └── theme.dart ✅
│   ├── screens/
│   │   └── officer/
│   │       ├── login_page.dart ✅
│   │       ├── dashboard_page.dart ⏳
│   │       ├── lapor_pintu_air_page.dart ⏳
│   │       ├── detail_laporan_page.dart ⏳
│   │       ├── riwayat_laporan_page.dart ⏳
│   │       └── profil_page.dart ⏳
│   ├── widgets/
│   │   ├── station_card.dart ✅
│   │   ├── status_chip.dart ✅
│   │   └── stat_card.dart ✅
│   ├── services/ (copy dari API_DOCUMENTATION.md)
│   │   ├── api_service.dart
│   │   └── auth_manager.dart
│   ├── models/
│   │   ├── station.dart
│   │   └── officer_report.dart
│   └── main.dart ⏳
└── pubspec.yaml ⏳
```

Legend: ✅ Done | ⏳ Need to implement

---

## 🎨 Design Mapping (HTML → Flutter)

### 1. Login Page ✅ COMPLETE

| HTML Element | Flutter Widget |
|--------------|----------------|
| `<div class="bg-gradient...">` | `Container` dengan `BoxDecoration(gradient)` |
| `<span class="material-symbols-outlined">flood</span>` | `Icon(Icons.water_drop)` |
| `<input type="email">` | `TextFormField` dengan `validator` |
| `<input type="password">` | `TextFormField` dengan `obscureText` |
| `<button class="bg-primary...">` | `ElevatedButton` dengan custom style |
| Tailwind classes `h-14`, `rounded-xl` | `height: 56`, `borderRadius: 12` |

**Features Implemented:**
- ✅ Gradient background decoration
- ✅ Logo icon container dengan shadow
- ✅ Email field dengan mail icon
- ✅ Password field dengan show/hide toggle
- ✅ Form validation
- ✅ Loading state
- ✅ Responsive layout
- ✅ Dark mode support

---

### 2. Dashboard Page (Template Ready)

| HTML Element | Flutter Widget |
|--------------|----------------|
| Top app bar dengan profile | `AppBar` dengan custom `title` |
| Profile avatar dengan green dot | `Stack` + `Positioned` |
| Notification badge | `Stack` dengan red dot |
| Stats cards (horizontal scroll) | `SingleChildScrollView` horizontal |
| Search bar sticky | `SliverAppBar` atau Column dengan search |
| Filter chips | `Wrap` atau horizontal `ListView` |
| Station list | `ListView.builder` dengan `StationCard` |
| Bottom nav | `BottomNavigationBar` |

**Key Components:**
```dart
// Stats Section
SingleChildScrollView(
  scrollDirection: Axis.horizontal,
  child: Row(
    children: [
      StatCard(title: 'Total Pos', value: '12', icon: Icons.dataset),
      StatCard(title: 'Awas', value: '2', icon: Icons.warning, color: Colors.red),
      StatCard(title: 'Siaga', value: '3', icon: Icons.error, color: Colors.orange),
    ],
  ),
)

// Station List
ListView.builder(
  itemCount: stations.length,
  itemBuilder: (context, index) {
    final station = stations[index];
    return StationCard(
      name: station.name,
      location: station.location,
      waterLevel: station.waterLevel,
      status: station.status,
      lastUpdate: station.lastUpdate,
      onTap: () => _navigateToLapor(station),
    );
  },
)
```

---

### 3. Lapor Pintu Air Page (Need Implementation)

| HTML Element | Flutter Widget |
|--------------|----------------|
| Top bar "Batal" button | `AppBar` dengan `leading` |
| Station badge | `Container` dengan rounded corners |
| Numeric input dengan +/- | Custom widget atau `Stepper` |
| Slider | `Slider` widget |
| Status chips grid | `GridView` dengan `StatusChip` |
| Photo upload area | `InkWell` + `ImagePicker` |
| Submit button | `ElevatedButton` fixed at bottom |

**Key Features to Implement:**
```dart
// Water Level Input
Row(
  children: [
    Expanded(
      child: TextField(
        controller: _waterLevelController,
        keyboardType: TextInputType.number,
        textAlign: TextAlign.center,
        style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold),
      ),
    ),
    Column(
      children: [
        IconButton(
          icon: Icon(Icons.add),
          onPressed: _increment,
        ),
        IconButton(
          icon: Icon(Icons.remove),
          onPressed: _decrement,
        ),
      ],
    ),
  ],
)

// Slider
Slider(
  value: _waterLevel,
  min: 0,
  max: 300,
  divisions: 300,
  onChanged: (value) {
    setState(() => _waterLevel = value);
  },
)

// Status Selection
GridView.count(
  crossAxisCount: 4,
  shrinkWrap: true,
  children: [
    _buildStatusChip('Normal', Colors.green),
    _buildStatusChip('Waspada', Colors.yellow),
    _buildStatusChip('Siaga', Colors.orange),
    _buildStatusChip('Awas', Colors.red),
  ],
)

// Photo Upload
GestureDetector(
  onTap: _pickImage,
  child: Container(
    height: 200,
    decoration: BoxDecoration(
      border: Border.all(color: Colors.grey),
      borderRadius: BorderRadius.circular(12),
    ),
    child: _image == null
      ? Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(Icons.camera_alt, size: 50),
            Text('Ambil Foto'),
          ],
        )
      : Image.file(_image!, fit: BoxFit.cover),
  ),
)
```

---

### 4. Riwayat Laporan Page (Need Implementation)

| HTML Element | Flutter Widget |
|--------------|----------------|
| Tab filter | `TabBar` + `TabBarView` atau custom tabs |
| Report cards | `ListView` dengan custom card |
| Status badge | `Container` dengan colored background |
| Pull to refresh | `RefreshIndicator` |

**Structure:**
```dart
DefaultTabController(
  length: 4,
  child: Column(
    children: [
      TabBar(
        tabs: [
          Tab(text: 'Semua'),
          Tab(text: 'Pending'),
          Tab(text: 'Approved'),
          Tab(text: 'Rejected'),
        ],
      ),
      Expanded(
        child: TabBarView(
          children: [
            _buildReportList(null),
            _buildReportList('pending'),
            _buildReportList('approved'),
            _buildReportList('rejected'),
          ],
        ),
      ),
    ],
  ),
)
```

---

### 5. Detail Laporan & Profil (Need Implementation)

Implementasi standard dengan list tiles dan sections.

---

## 🎨 Color Mapping

| HTML Tailwind | Flutter AppColors | Hex Value |
|---------------|-------------------|-----------|
| `primary: #135bec` | `AppColors.primary` | `0xFF135BEC` |
| `background-light: #f6f6f8` | `AppColors.backgroundLight` | `0xFFF6F6F8` |
| `background-dark: #101622` | `AppColors.backgroundDark` | `0xFF101622` |
| `surface-dark: #1a2230` | `AppColors.surfaceDark` | `0xFF1A2230` |
| `text-slate-500` | `Colors.grey.shade500` | - |
| Red (Awas) | `AppColors.statusAwas` | `0xFFEF4444` |
| Orange (Siaga) | `AppColors.statusSiaga` | `0xFFF59E0B` |
| Green (Normal) | `AppColors.statusNormal` | `0xFF10B981` |

---

## 📏 Spacing & Sizing Mapping

| HTML Class | Flutter Value |
|------------|---------------|
| `h-14` (56px) | `height: 56` |
| `h-10` (40px) | `height: 40` |
| `rounded-xl` (12px) | `borderRadius: 12` |
| `rounded-full` | `borderRadius: 9999` atau `shape: BoxShape.circle` |
| `p-4` (16px) | `padding: EdgeInsets.all(16)` |
| `gap-3` (12px) | `SizedBox(width/height: 12)` |
| `text-lg` (18px) | `fontSize: 18` |
| `font-bold` | `fontWeight: FontWeight.bold` |

---

## 🔧 Dependencies Required

```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # UI
  google_fonts: ^6.1.0
  
  # State Management
  provider: ^6.1.1
  
  # HTTP & Storage
  http: ^1.1.0
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  
  # Image
  image_picker: ^1.0.5
  cached_network_image: ^3.3.0
  
  # Utilities
  intl: ^0.18.1
```

---

## 🚀 Quick Start untuk Tim

### 1. Copy File ke Project Flutter

```bash
# Buat project Flutter baru
flutter create siaga_banjir_petugas
cd siaga_banjir_petugas

# Copy file yang sudah dibuat
# Copy dari: c:\laravel10\SiAGA_Banjir\flutter_ui_petugas\lib
# Ke: project-anda\lib
```

### 2. Update pubspec.yaml

Tambahkan semua dependencies di atas.

### 3. Install packages

```bash
flutter pub get
```

### 4. Buat file main.dart

```dart
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'config/theme.dart';
import 'screens/officer/login_page.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  
  SystemChrome.setSystemUIOverlayStyle(
    const SystemUIOv

erlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.light,
    ),
  );
  
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SiAGA Banjir - Petugas',
      debugShowCheckedModeBanner: false,
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: ThemeMode.dark,
      home: const LoginPage(),
    );
  }
}
```

### 5. Test Run

```bash
flutter run
```

---

## 📋 Checklist Implementation

### Phase 1: Setup ✅ DONE
- [x] Create project structure
- [x] Setup theme configuration
- [x] Create color constants
- [x] Create reusable widgets
- [x] Implement login page

### Phase 2: Dashboard ⏳ NEXT
- [ ] Create dashboard layout
- [ ] Implement app bar dengan profile
- [ ] Add stats section
- [ ] Add search bar
- [ ] Implement filter chips
- [ ] Create station list
- [ ] Add bottom navigation

### Phase 3: Lapor Form ⏳
- [ ] Create form layout
- [ ] Implement water level input
- [ ] Add slider
- [ ] Create status selection
- [ ] Implement photo picker
- [ ] Add form validation
- [ ] Connect to API

### Phase 4: History & Profile ⏳
- [ ] Create riwayat page with tabs
- [ ] Implement detail page
- [ ] Create profile page
- [ ] Add logout functionality

### Phase 5: API Integration ⏳
- [ ] Setup API service
- [ ] Implement auth manager
- [ ] Connect all endpoints
- [ ] Handle loading states
- [ ] Implement error handling

### Phase 6: Polish ⏳
- [ ] Add animations
- [ ] Improve UX
- [ ] Add offline support
- [ ] Test on devices
- [ ] Fix bugs

---

## 💡 Tips untuk Tim Frontend

### 1. Gunakan Hot Reload
Setiap kali save file, Flutter akan auto-reload. Sangat cepat untuk development.

### 2. Debug dengan Flutter DevTools
```bash
flutter run
# Tekan 'v' untuk open DevTools
```

### 3. Test di Dark Mode
```dart
// Tambahkan floating button untuk toggle theme
FloatingActionButton(
  onPressed: () {
    // Toggle between light and dark
  },
  child: Icon(Icons.brightness_6),
)
```

### 4. Handle Safe Area
Selalu wrap dengan `SafeArea` untuk hindari notch/status bar:
```dart
SafeArea(
  child: YourWidget(),
)
```

### 5. Use LayoutBuilder untuk Responsive
```dart
LayoutBuilder(
  builder: (context, constraints) {
    if (constraints.maxWidth > 600) {
      return DesktopLayout();
    } else {
      return MobileLayout();
    }
  },
)
```

---

## 📞 Support

Jika ada pertanyaan tentang konversi UI:
1. Cek file HTML asli di `design_html/`
2. Lihat implementation guide
3. Reference Flutter documentation

---

## 🎯 Expected Result

### Login Page
- Clean, modern design
- Gradient background
- Smooth animations
- Form validation
- Loading state

### Dashboard
- Profile header
- Real-time stats
- Searchable station list
- Filter by status
- Pull to refresh

### Lapor Form
- Easy input
- Photo upload
- Status selection
- Validation
- Success feedback

---

**Status:** 30% Complete (Login + Widgets)  
**Next Priority:** Dashboard Implementation  
**Estimated Time:** 2-3 days untuk complete all pages

Tim frontend sudah punya foundation yang kuat! Tinggal implement halaman lainnya mengikuti pola yang sama. 🚀
