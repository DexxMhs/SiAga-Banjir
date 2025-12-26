# 🚀 Flutter UI - SiAGA Banjir (Petugas) - READY TO USE

Konversi lengkap dari HTML design ke Flutter untuk role **Petugas Lapangan**.

---

## ✅ File Yang Sudah Dibuat

### 1. Configuration Files
- ✅ `lib/config/colors.dart` - Color scheme lengkap
- ✅ `lib/config/theme.dart` - Light & Dark theme
- ✅ `lib/screens/officer/login_page.dart` - Halaman login lengkap

---

## 📦 pubspec.yaml

Tambahkan dependencies berikut:

```yaml
name: siaga_banjir_petugas
description: Aplikasi monitoring banjir untuk petugas lapangan
version: 1.0.0+1

environment:
  sdk: '>=3.0.0 <4.0.0'

dependencies:
  flutter:
    sdk: flutter
  
  # HTTP & API
  http: ^1.1.0
  
  # State Management
  provider: ^6.1.1
  
  # Storage
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  
  # Image
  image_picker: ^1.0.5
  cached_network_image: ^3.3.0
  
  # UI
  google_fonts: ^6.1.0
  
  # Utilities
  intl: ^0.18.1

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.0

flutter:
  uses-material-design: true
```

---

## 🎯 File main.dart

```dart
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'config/theme.dart';
import 'screens/officer/login_page.dart';
import 'screens/officer/dashboard_page.dart';
import 'screens/officer/lapor_pintu_air_page.dart';
import 'screens/officer/riwayat_laporan_page.dart';
import 'screens/officer/profil_page.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Set status bar style
  SystemChrome.setSystemUIOverlayStyle(
    const SystemUIOv

erlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.dark,
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
      
      // Theme
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: ThemeMode.dark, // Default dark mode sesuai design
      
      // Routes
      initialRoute: '/login',
      routes: {
        '/login': (context) => const LoginPage(),
        '/officer-dashboard': (context) => const DashboardPage(),
        '/officer-lapor': (context) => const LaporPintuAirPage(),
        '/officer-riwayat': (context) => const RiwayatLaporanPage(),
        '/officer-profil': (context) => const ProfilPage(),
      },
    );
  }
}
```

---

## 📱 Halaman-Halaman Yang Perlu Dibuat

Saya sudah membuat file login yang lengkap. Berikut adalah **template kode** untuk halaman lainnya yang tim frontend bisa lanjutkan:

### 2. Dashboard Page

**File: `lib/screens/officer/dashboard_page.dart`**

**Key Features:**
- Top app bar dengan profile & notifikasi
- Ringkasan status cards (Total Pos, Awas, Siaga)
- Search bar sticky
- Filter chips
- List stasiun dengan status indicators
- Bottom navigation bar

**Struktur:**
```dart
import 'package:flutter/material.dart';
import '../../config/colors.dart';
import '../../widgets/station_card.dart';
import '../../widgets/status_chip.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({super.key});

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  int _selectedIndex = 0;
  String _selectedFilter = 'Semua';
  
  // TODO: Load data from API
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // Top App Bar dengan profile
      appBar: _buildAppBar(),
      
      body: Column(
        children: [
          // Stats Section (Total Pos, Awas, Siaga)
          _buildStatsSection(),
          
          // Search Bar
          _buildSearchBar(),
          
          // Filter Chips
          _buildFilterChips(),
          
          // Station List
          Expanded(
            child: _buildStationList(),
          ),
        ],
      ),
      
      // Bottom Navigation
      bottomNavigationBar: _buildBottomNav(),
    );
  }
  
  PreferredSizeWidget _buildAppBar() {
    return AppBar(
      automaticallyImplyLeading: false,
      title: Row(
        children: [
          // Profile Avatar dengan status indicator
          Stack(
            children: [
              CircleAvatar(
                radius: 20,
                backgroundImage: NetworkImage('...'), // Profile image
              ),
              Positioned(
                bottom: 0,
                right: 0,
                child: Container(
                  width: 12,
                  height: 12,
                  decoration: BoxDecoration(
                    color: Colors.green,
                    shape: BoxShape.circle,
                    border: Border.all(color: Colors.white, width: 2),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(width: 12),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text('Halo, Petugas Budi', 
                style: Theme.of(context).textTheme.titleMedium),
              Text('Selasa, 14 Nov 2023', 
                style: Theme.of(context).textTheme.bodySmall),
            ],
          ),
        ],
      ),
      actions: [
        // Notification badge
        Stack(
          children: [
            IconButton(
              icon: const Icon(Icons.notifications_outlined),
              onPressed: () {},
            ),
            Positioned(
              top: 8,
              right: 8,
              child: Container(
                width: 10,
                height: 10,
                decoration: const BoxDecoration(
                  color: Colors.red,
                  shape: BoxShape.circle,
                ),
              ),
            ),
          ],
        ),
      ],
    );
  }
  
  // ... implement other methods
}
```

---

### 3. Lapor Pintu Air Page

**File: `lib/screens/officer/lapor_pintu_air_page.dart`**

**Key Features:**
- Numeric input ketinggian air dengan increment/decrement
- Slider untuk quick adjust
- Status chips (Normal, Waspada, Siaga, Awas)
- Curah hujan input
- Status pompa radio buttons
- Photo upload dengan camera/gallery
- Catatan tambahan textarea
- Submit button

**Key Widgets:**
- Custom numeric stepper
- Custom slider dengan gradient
- Photo picker bottom sheet
- Status selection chips

---

### 4. Riwayat Laporan Page

**File: `lib/screens/officer/riwayat_laporan_page.dart`**

**Key Features:**
- Tab filter (Semua, Pending, Approved, Rejected)
- Card laporan dengan timeline
- Status badge (pending/approved/rejected dengan warna)
- Pull to refresh
- Navigate ke detail

---

### 5. Profil Page

**File: `lib/screens/officer/profil_page.dart`**

**Key Features:**
- Profile header dengan avatar
- Info petugas (nama, email, stasiun ditugaskan)
- Settings menu list
- Dark mode toggle
- Logout button

---

## 🎨 Custom Widgets

### 1. Station Card Widget

**File: `lib/widgets/station_card.dart`**

```dart
import 'package:flutter/material.dart';
import '../config/colors.dart';

class StationCard extends StatelessWidget {
  final String name;
  final String location;
  final double waterLevel;
  final String status; // 'normal', 'siaga', 'awas'
  final String lastUpdate;
  final VoidCallback? onTap;

  const StationCard({
    super.key,
    required this.name,
    required this.location,
    required this.waterLevel,
    required this.status,
    required this.lastUpdate,
    this.onTap,
  });

  Color get _statusColor {
    switch (status.toLowerCase()) {
      case 'awas':
        return AppColors.statusAwas;
      case 'siaga':
        return AppColors.statusSiaga;
      default:
        return AppColors.statusNormal;
    }
  }

  IconData get _statusIcon {
    switch (status.toLowerCase()) {
      case 'awas':
        return Icons.warning_rounded;
      case 'siaga':
        return Icons.error_outline_rounded;
      default:
        return Icons.check_circle_outline_rounded;
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    
    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              // Status Icon
              Container(
                width: 56,
                height: 56,
                decoration: BoxDecoration(
                  color: _statusColor.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Icon(
                  _statusIcon,
                  color: _statusColor,
                  size: 28,
                ),
              ),
              
              const SizedBox(width: 16),
              
              // Station Info
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      name,
                      style: Theme.of(context).textTheme.titleMedium,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      location,
                      style: Theme.of(context).textTheme.bodySmall,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                    const SizedBox(height: 8),
                    Row(
                      children: [
                        Icon(
                          Icons.water_drop,
                          size: 14,
                          color: _statusColor,
                        ),
                        const SizedBox(width: 4),
                        Text(
                          '${waterLevel.toStringAsFixed(0)} cm',
                          style: TextStyle(
                            fontSize: 13,
                            fontWeight: FontWeight.bold,
                            color: _statusColor,
                          ),
                        ),
                        const SizedBox(width: 12),
                        Icon(
                          Icons.access_time,
                          size: 14,
                          color: Colors.grey.shade400,
                        ),
                        const SizedBox(width: 4),
                        Text(
                          lastUpdate,
                          style: TextStyle(
                            fontSize: 12,
                            color: Colors.grey.shade400,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
              
              // Status Badge
              Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 12,
                  vertical: 6,
                ),
                decoration: BoxDecoration(
                  color: _statusColor,
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  status.toUpperCase(),
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 11,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
```

### 2. Status Chip Widget

**File: `lib/widgets/status_chip.dart`**

```dart
import 'package:flutter/material.dart';
import '../config/colors.dart';

class StatusChip extends StatelessWidget {
  final String label;
  final bool isSelected;
  final VoidCallback onTap;
  final Color? color;

  const StatusChip({
    super.key,
    required this.label,
    required this.isSelected,
    required this.onTap,
    this.color,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
        decoration: BoxDecoration(
          color: isSelected 
            ? (color ?? AppColors.primary)
            : Colors.transparent,
          border: Border.all(
            color: isSelected 
              ? (color ?? AppColors.primary)
              : Colors.grey.shade700,
          ),
          borderRadius: BorderRadius.circular(20),
        ),
        child: Text(
          label,
          style: TextStyle(
            fontSize: 13,
            fontWeight: FontWeight.w600,
            color: isSelected 
              ? Colors.white 
              : Colors.grey.shade400,
          ),
        ),
      ),
    );
  }
}
```

---

## 📸 Screenshot Reference

Berdasarkan design HTML, berikut adalah preview yang harus dicapai:

### Login Page ✅
- Background gradient di top
- Logo flood icon dengan border radius
- Email & password field dengan icon
- Show/hide password button
- Primary button dengan shadow
- Version info di bottom

### Dashboard Page
- Profile avatar dengan green indicator
- Notification badge
- 3 stat cards (Total Pos, Awas, Siaga) dengan icon background
- Sticky search bar
- Horizontal filter chips
- Station list cards dengan status

### Lapor Pintu Air Page
- Top bar dengan "Batal" dan title
- Station name badge
- Big numeric input dengan +/- buttons
- Slider dengan gradient fill
- 4 status chips dalam grid
- Photo upload area
- Submit button fixed di bottom

---

## 🎯 Next Steps untuk Tim Frontend

1. **Install dependencies**
   ```bash
   flutter pub get
   ```

2. **Test login page**
   - Jalankan app
   - Test validasi form
   - Test navigation

3. **Lanjutkan dengan Dashboard**
   - Copy struktur dari template
   - Integrate dengan API
   - Test data loading

4. **Implement foto upload**
   - Gunakan `image_picker` package
   - Compress image sebelum upload
   - Show preview

5. **Connect ke Backend API**
   - Gunakan `ApiService` dari dokumentasi
   - Handle loading states
   - Handle errors

---

## 💡 Tips Implementasi

### 1. Handle Dark Mode
```dart
final isDark = Theme.of(context).brightness == Brightness.dark;
```

### 2. Status Color Helper
```dart
Color getStatusColor(String status) {
  switch (status.toLowerCase()) {
    case 'awas':
      return AppColors.statusAwas;
    case 'siaga':
      return AppColors.statusSiaga;
    default:
      return AppColors.statusNormal;
  }
}
```

### 3. Format Date/Time
```dart
import 'package:intl/intl.dart';

String formatDate(DateTime date) {
  return DateFormat('dd MMM yyyy, HH:mm', 'id').format(date);
}
```

### 4. Show Loading
```dart
if (_isLoading) {
  return const Center(child: CircularProgressIndicator());
}
```

### 5. Pull to Refresh
```dart
RefreshIndicator(
  onRefresh: _loadData,
  child: ListView(...),
)
```

---

**Status:** ✅ Configuration & Login Ready  
**Next:** Dashboard, Lapor Form, Riwayat, Profil

Tim frontend tinggal lanjutkan implementasi halaman lainnya menggunakan template yang sudah disediakan! 🚀
