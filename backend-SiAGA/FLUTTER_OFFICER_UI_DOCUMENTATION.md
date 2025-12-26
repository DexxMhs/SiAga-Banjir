# Dokumentasi Flutter UI - Aplikasi Petugas SiAGA Banjir

## Daftar Isi
1. [Setup Project](#setup-project)
2. [Struktur Folder](#struktur-folder)
3. [Konfigurasi Dependencies](#konfigurasi-dependencies)
4. [Konfigurasi Warna](#konfigurasi-warna)
5. [Konfigurasi Tema](#konfigurasi-tema)
6. [Main Application](#main-application)
7. [Login Page](#login-page)
8. [Reusable Widgets](#reusable-widgets)
9. [Implementasi Halaman Lainnya](#implementasi-halaman-lainnya)
10. [Integrasi API](#integrasi-api)

---

## Setup Project

### 1. Buat Project Flutter Baru
```bash
flutter create siaga_banjir_petugas
cd siaga_banjir_petugas
```

### 2. Struktur Folder yang Dibutuhkan
```
lib/
├── main.dart
├── config/
│   ├── colors.dart
│   └── theme.dart
├── screens/
│   └── officer/
│       ├── login_page.dart
│       ├── dashboard_page.dart
│       ├── lapor_pintu_air_page.dart
│       ├── riwayat_laporan_page.dart
│       ├── detail_laporan_page.dart
│       └── profil_page.dart
├── widgets/
│   ├── station_card.dart
│   ├── status_chip.dart
│   └── stat_card.dart
└── services/
    ├── api_service.dart
    ├── auth_service.dart
    └── fcm_service.dart
```

---

## Konfigurasi Dependencies

### File: `pubspec.yaml`

```yaml
name: siaga_banjir_petugas
description: Aplikasi monitoring banjir untuk petugas BPBD
publish_to: 'none'
version: 1.0.0+1

environment:
  sdk: '>=3.0.0 <4.0.0'

dependencies:
  flutter:
    sdk: flutter
  
  # UI & Design
  google_fonts: ^6.1.0
  cupertino_icons: ^1.0.6
  
  # State Management
  provider: ^6.1.1
  
  # Network & API
  http: ^1.1.0
  dio: ^5.4.0
  
  # Local Storage
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  
  # Image Handling
  image_picker: ^1.0.5
  cached_network_image: ^3.3.0
  
  # Utilities
  intl: ^0.18.1
  
  # Push Notifications
  firebase_core: ^2.24.2
  firebase_messaging: ^14.7.9

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.0

flutter:
  uses-material-design: true
```

**Cara Install:**
```bash
flutter pub get
```

---

## Konfigurasi Warna

### File: `lib/config/colors.dart`

```dart
import 'package:flutter/material.dart';

class AppColors {
  // Primary Colors
  static const Color primary = Color(0xFF135BEC);
  static const Color primaryDark = Color(0xFF0E47C0);
  static const Color primaryLight = Color(0xFF3B7BF6);
  
  // Background Colors - Light Mode
  static const Color backgroundLight = Color(0xFFF8FAFC);
  static const Color surfaceLight = Color(0xFFFFFFFF);
  static const Color cardLight = Color(0xFFFFFFFF);
  
  // Background Colors - Dark Mode
  static const Color backgroundDark = Color(0xFF0F172A);
  static const Color surfaceDark = Color(0xFF1E293B);
  static const Color cardDark = Color(0xFF334155);
  
  // Text Colors - Light Mode
  static const Color textPrimaryLight = Color(0xFF1E293B);
  static const Color textSecondaryLight = Color(0xFF64748B);
  static const Color textTertiaryLight = Color(0xFF94A3B8);
  
  // Text Colors - Dark Mode
  static const Color textPrimaryDark = Color(0xFFF1F5F9);
  static const Color textSecondaryDark = Color(0xFFCBD5E1);
  static const Color textTertiaryDark = Color(0xFF94A3B8);
  
  // Border Colors
  static const Color borderLight = Color(0xFFE2E8F0);
  static const Color borderDark = Color(0xFF334155);
  
  // Status Colors
  static const Color statusNormal = Color(0xFF10B981);
  static const Color statusSiaga = Color(0xFFF59E0B);
  static const Color statusAwas = Color(0xFFEF4444);
  
  // Utility Colors
  static const Color error = Color(0xFFEF4444);
  static const Color success = Color(0xFF10B981);
  static const Color warning = Color(0xFFF59E0B);
  static const Color info = Color(0xFF3B82F6);
}
```

---

## Konfigurasi Tema

### File: `lib/config/theme.dart`

```dart
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'colors.dart';

class AppTheme {
  // Light Theme
  static ThemeData lightTheme = ThemeData(
    useMaterial3: true,
    brightness: Brightness.light,
    primaryColor: AppColors.primary,
    scaffoldBackgroundColor: AppColors.backgroundLight,
    
    // AppBar Theme
    appBarTheme: AppBarTheme(
      backgroundColor: AppColors.surfaceLight,
      elevation: 0,
      centerTitle: false,
      iconTheme: const IconThemeData(color: AppColors.textPrimaryLight),
      titleTextStyle: GoogleFonts.publicSans(
        fontSize: 20,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryLight,
      ),
    ),
    
    // Text Theme
    textTheme: TextTheme(
      displayLarge: GoogleFonts.publicSans(
        fontSize: 32,
        fontWeight: FontWeight.bold,
        color: AppColors.textPrimaryLight,
      ),
      displayMedium: GoogleFonts.publicSans(
        fontSize: 28,
        fontWeight: FontWeight.bold,
        color: AppColors.textPrimaryLight,
      ),
      displaySmall: GoogleFonts.publicSans(
        fontSize: 24,
        fontWeight: FontWeight.bold,
        color: AppColors.textPrimaryLight,
      ),
      headlineMedium: GoogleFonts.publicSans(
        fontSize: 20,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryLight,
      ),
      headlineSmall: GoogleFonts.publicSans(
        fontSize: 18,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryLight,
      ),
      titleLarge: GoogleFonts.publicSans(
        fontSize: 16,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryLight,
      ),
      bodyLarge: GoogleFonts.publicSans(
        fontSize: 16,
        fontWeight: FontWeight.normal,
        color: AppColors.textPrimaryLight,
      ),
      bodyMedium: GoogleFonts.publicSans(
        fontSize: 14,
        fontWeight: FontWeight.normal,
        color: AppColors.textSecondaryLight,
      ),
      bodySmall: GoogleFonts.publicSans(
        fontSize: 12,
        fontWeight: FontWeight.normal,
        color: AppColors.textTertiaryLight,
      ),
    ),
    
    // Input Decoration Theme
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: AppColors.surfaceLight,
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.borderLight),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.borderLight),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.primary, width: 2),
      ),
      errorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.error),
      ),
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
      hintStyle: GoogleFonts.publicSans(
        color: AppColors.textTertiaryLight,
        fontSize: 14,
      ),
    ),
    
    // Elevated Button Theme
    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        backgroundColor: AppColors.primary,
        foregroundColor: Colors.white,
        elevation: 0,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        textStyle: GoogleFonts.publicSans(
          fontSize: 16,
          fontWeight: FontWeight.w600,
        ),
      ),
    ),
    
    // Card Theme
    cardTheme: CardTheme(
      color: AppColors.cardLight,
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: const BorderSide(color: AppColors.borderLight),
      ),
    ),
  );
  
  // Dark Theme
  static ThemeData darkTheme = ThemeData(
    useMaterial3: true,
    brightness: Brightness.dark,
    primaryColor: AppColors.primary,
    scaffoldBackgroundColor: AppColors.backgroundDark,
    
    // AppBar Theme
    appBarTheme: AppBarTheme(
      backgroundColor: AppColors.surfaceDark,
      elevation: 0,
      centerTitle: false,
      iconTheme: const IconThemeData(color: AppColors.textPrimaryDark),
      titleTextStyle: GoogleFonts.publicSans(
        fontSize: 20,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryDark,
      ),
    ),
    
    // Text Theme
    textTheme: TextTheme(
      displayLarge: GoogleFonts.publicSans(
        fontSize: 32,
        fontWeight: FontWeight.bold,
        color: AppColors.textPrimaryDark,
      ),
      displayMedium: GoogleFonts.publicSans(
        fontSize: 28,
        fontWeight: FontWeight.bold,
        color: AppColors.textPrimaryDark,
      ),
      displaySmall: GoogleFonts.publicSans(
        fontSize: 24,
        fontWeight: FontWeight.bold,
        color: AppColors.textPrimaryDark,
      ),
      headlineMedium: GoogleFonts.publicSans(
        fontSize: 20,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryDark,
      ),
      headlineSmall: GoogleFonts.publicSans(
        fontSize: 18,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryDark,
      ),
      titleLarge: GoogleFonts.publicSans(
        fontSize: 16,
        fontWeight: FontWeight.w600,
        color: AppColors.textPrimaryDark,
      ),
      bodyLarge: GoogleFonts.publicSans(
        fontSize: 16,
        fontWeight: FontWeight.normal,
        color: AppColors.textPrimaryDark,
      ),
      bodyMedium: GoogleFonts.publicSans(
        fontSize: 14,
        fontWeight: FontWeight.normal,
        color: AppColors.textSecondaryDark,
      ),
      bodySmall: GoogleFonts.publicSans(
        fontSize: 12,
        fontWeight: FontWeight.normal,
        color: AppColors.textTertiaryDark,
      ),
    ),
    
    // Input Decoration Theme
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: AppColors.surfaceDark,
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.borderDark),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.borderDark),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.primary, width: 2),
      ),
      errorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.error),
      ),
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
      hintStyle: GoogleFonts.publicSans(
        color: AppColors.textTertiaryDark,
        fontSize: 14,
      ),
    ),
    
    // Elevated Button Theme
    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        backgroundColor: AppColors.primary,
        foregroundColor: Colors.white,
        elevation: 0,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        textStyle: GoogleFonts.publicSans(
          fontSize: 16,
          fontWeight: FontWeight.w600,
        ),
      ),
    ),
    
    // Card Theme
    cardTheme: CardTheme(
      color: AppColors.cardDark,
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: const BorderSide(color: AppColors.borderDark),
      ),
    ),
  );
}
```

---

## Main Application

### File: `lib/main.dart`

```dart
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'config/theme.dart';
import 'screens/officer/login_page.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Set status bar transparent
  SystemChrome.setSystemUIOverlayStyle(
    const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.light,
    ),
  );
  
  // Lock orientation to portrait
  SystemChrome.setPreferredOrientations([
    DeviceOrientation.portraitUp,
    DeviceOrientation.portraitDown,
  ]);
  
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
      themeMode: ThemeMode.dark, // Default dark mode
      home: const LoginPage(),
    );
  }
}
```

---

## Login Page

### File: `lib/screens/officer/login_page.dart`

```dart
import 'package:flutter/material.dart';
import '../../config/colors.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  bool _isPasswordVisible = false;
  bool _isLoading = false;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _handleLogin() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    setState(() {
      _isLoading = true;
    });

    // Simulate API call
    await Future.delayed(const Duration(seconds: 2));

    if (mounted) {
      setState(() {
        _isLoading = false;
      });

      // TODO: Navigate to dashboard after successful login
      // Navigator.pushReplacement(
      //   context,
      //   MaterialPageRoute(builder: (context) => const DashboardPage()),
      // );
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    
    return Scaffold(
      body: SafeArea(
        child: SingleChildScrollView(
          child: SizedBox(
            height: MediaQuery.of(context).size.height - 
                    MediaQuery.of(context).padding.top - 
                    MediaQuery.of(context).padding.bottom,
            child: Column(
              children: [
                _buildBrandingSection(isDark),
                Expanded(
                  child: Container(
                    width: double.infinity,
                    decoration: BoxDecoration(
                      color: isDark 
                          ? AppColors.surfaceDark 
                          : AppColors.surfaceLight,
                      borderRadius: const BorderRadius.only(
                        topLeft: Radius.circular(32),
                        topRight: Radius.circular(32),
                      ),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.all(24.0),
                      child: _buildLoginForm(isDark),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildBrandingSection(bool isDark) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(vertical: 48),
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            AppColors.primary,
            AppColors.primaryDark,
          ],
        ),
      ),
      child: Column(
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.2),
              borderRadius: BorderRadius.circular(20),
            ),
            child: const Icon(
              Icons.water_drop,
              size: 40,
              color: Colors.white,
            ),
          ),
          const SizedBox(height: 16),
          Text(
            'SiAGA Banjir',
            style: Theme.of(context).textTheme.headlineMedium?.copyWith(
              color: Colors.white,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Aplikasi Petugas BPBD',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: Colors.white.withOpacity(0.9),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLoginForm(bool isDark) {
    return Form(
      key: _formKey,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const SizedBox(height: 8),
          Text(
            'Selamat Datang',
            style: Theme.of(context).textTheme.displaySmall,
          ),
          const SizedBox(height: 8),
          Text(
            'Silakan login dengan akun petugas Anda',
            style: Theme.of(context).textTheme.bodyMedium,
          ),
          const SizedBox(height: 32),
          _buildEmailField(isDark),
          const SizedBox(height: 16),
          _buildPasswordField(isDark),
          const SizedBox(height: 24),
          _buildLoginButton(),
          const Spacer(),
          _buildFooter(),
        ],
      ),
    );
  }

  Widget _buildEmailField(bool isDark) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Email',
          style: Theme.of(context).textTheme.titleLarge,
        ),
        const SizedBox(height: 8),
        TextFormField(
          controller: _emailController,
          keyboardType: TextInputType.emailAddress,
          decoration: InputDecoration(
            hintText: 'Masukkan email Anda',
            prefixIcon: Icon(
              Icons.email_outlined,
              color: isDark 
                  ? AppColors.textSecondaryDark 
                  : AppColors.textSecondaryLight,
            ),
          ),
          validator: (value) {
            if (value == null || value.isEmpty) {
              return 'Email tidak boleh kosong';
            }
            if (!value.contains('@')) {
              return 'Email tidak valid';
            }
            return null;
          },
        ),
      ],
    );
  }

  Widget _buildPasswordField(bool isDark) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Password',
          style: Theme.of(context).textTheme.titleLarge,
        ),
        const SizedBox(height: 8),
        TextFormField(
          controller: _passwordController,
          obscureText: !_isPasswordVisible,
          decoration: InputDecoration(
            hintText: 'Masukkan password Anda',
            prefixIcon: Icon(
              Icons.lock_outlined,
              color: isDark 
                  ? AppColors.textSecondaryDark 
                  : AppColors.textSecondaryLight,
            ),
            suffixIcon: IconButton(
              icon: Icon(
                _isPasswordVisible 
                    ? Icons.visibility_outlined 
                    : Icons.visibility_off_outlined,
                color: isDark 
                    ? AppColors.textSecondaryDark 
                    : AppColors.textSecondaryLight,
              ),
              onPressed: () {
                setState(() {
                  _isPasswordVisible = !_isPasswordVisible;
                });
              },
            ),
          ),
          validator: (value) {
            if (value == null || value.isEmpty) {
              return 'Password tidak boleh kosong';
            }
            if (value.length < 6) {
              return 'Password minimal 6 karakter';
            }
            return null;
          },
        ),
      ],
    );
  }

  Widget _buildLoginButton() {
    return SizedBox(
      width: double.infinity,
      height: 56,
      child: ElevatedButton(
        onPressed: _isLoading ? null : _handleLogin,
        child: _isLoading
            ? const SizedBox(
                width: 24,
                height: 24,
                child: CircularProgressIndicator(
                  color: Colors.white,
                  strokeWidth: 2,
                ),
              )
            : const Text('Masuk'),
      ),
    );
  }

  Widget _buildFooter() {
    return Center(
      child: Text(
        '© 2025 BPBD - SiAGA Banjir',
        style: Theme.of(context).textTheme.bodySmall,
      ),
    );
  }
}
```

**Credentials untuk Testing:**
- Email: `petugas1@example.com`
- Password: `password`

---

## Reusable Widgets

### 1. Station Card Widget

**File: `lib/widgets/station_card.dart`**

```dart
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../config/colors.dart';

class StationCard extends StatelessWidget {
  final String stationName;
  final String regionName;
  final String status;
  final double waterLevel;
  final DateTime lastUpdate;
  final VoidCallback? onTap;

  const StationCard({
    super.key,
    required this.stationName,
    required this.regionName,
    required this.status,
    required this.waterLevel,
    required this.lastUpdate,
    this.onTap,
  });

  Color _getStatusColor() {
    switch (status.toLowerCase()) {
      case 'awas':
        return AppColors.statusAwas;
      case 'siaga':
        return AppColors.statusSiaga;
      default:
        return AppColors.statusNormal;
    }
  }

  IconData _getStatusIcon() {
    switch (status.toLowerCase()) {
      case 'awas':
        return Icons.warning;
      case 'siaga':
        return Icons.error_outline;
      default:
        return Icons.check_circle;
    }
  }

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    final statusColor = _getStatusColor();
    final dateFormat = DateFormat('dd MMM yyyy, HH:mm', 'id_ID');

    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          stationName,
                          style: Theme.of(context).textTheme.titleLarge,
                        ),
                        const SizedBox(height: 4),
                        Row(
                          children: [
                            Icon(
                              Icons.location_on,
                              size: 14,
                              color: isDark 
                                  ? AppColors.textSecondaryDark 
                                  : AppColors.textSecondaryLight,
                            ),
                            const SizedBox(width: 4),
                            Text(
                              regionName,
                              style: Theme.of(context).textTheme.bodySmall,
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 12,
                      vertical: 6,
                    ),
                    decoration: BoxDecoration(
                      color: statusColor.withOpacity(0.1),
                      borderRadius: BorderRadius.circular(8),
                      border: Border.all(
                        color: statusColor.withOpacity(0.3),
                      ),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(
                          _getStatusIcon(),
                          size: 16,
                          color: statusColor,
                        ),
                        const SizedBox(width: 4),
                        Text(
                          status.toUpperCase(),
                          style: TextStyle(
                            color: statusColor,
                            fontSize: 12,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 16),
              Container(
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: isDark 
                      ? AppColors.backgroundDark 
                      : AppColors.backgroundLight,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Row(
                  children: [
                    Icon(
                      Icons.water,
                      color: AppColors.primary,
                      size: 20,
                    ),
                    const SizedBox(width: 8),
                    Text(
                      'Ketinggian Air:',
                      style: Theme.of(context).textTheme.bodyMedium,
                    ),
                    const Spacer(),
                    Text(
                      '${waterLevel.toStringAsFixed(1)} cm',
                      style: Theme.of(context).textTheme.titleLarge?.copyWith(
                        color: AppColors.primary,
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 12),
              Row(
                children: [
                  Icon(
                    Icons.access_time,
                    size: 14,
                    color: isDark 
                        ? AppColors.textTertiaryDark 
                        : AppColors.textTertiaryLight,
                  ),
                  const SizedBox(width: 4),
                  Text(
                    'Update terakhir: ${dateFormat.format(lastUpdate)}',
                    style: Theme.of(context).textTheme.bodySmall,
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
```

**Cara Penggunaan:**
```dart
StationCard(
  stationName: 'Stasiun Katulampa',
  regionName: 'Bogor',
  status: 'Normal',
  waterLevel: 50.0,
  lastUpdate: DateTime.now(),
  onTap: () {
    // Navigate to detail page
  },
)
```

---

### 2. Status Chip Widget

**File: `lib/widgets/status_chip.dart`**

```dart
import 'package:flutter/material.dart';
import '../config/colors.dart';

class StatusChip extends StatelessWidget {
  final String label;
  final bool isSelected;
  final VoidCallback onTap;

  const StatusChip({
    super.key,
    required this.label,
    required this.isSelected,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    
    return AnimatedContainer(
      duration: const Duration(milliseconds: 200),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          onTap: onTap,
          borderRadius: BorderRadius.circular(8),
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
            decoration: BoxDecoration(
              color: isSelected
                  ? AppColors.primary
                  : (isDark 
                      ? AppColors.surfaceDark 
                      : AppColors.surfaceLight),
              borderRadius: BorderRadius.circular(8),
              border: Border.all(
                color: isSelected
                    ? AppColors.primary
                    : (isDark 
                        ? AppColors.borderDark 
                        : AppColors.borderLight),
              ),
              boxShadow: isSelected
                  ? [
                      BoxShadow(
                        color: AppColors.primary.withOpacity(0.3),
                        blurRadius: 8,
                        offset: const Offset(0, 2),
                      ),
                    ]
                  : null,
            ),
            child: Text(
              label,
              style: TextStyle(
                color: isSelected
                    ? Colors.white
                    : (isDark 
                        ? AppColors.textPrimaryDark 
                        : AppColors.textPrimaryLight),
                fontSize: 14,
                fontWeight: isSelected ? FontWeight.w600 : FontWeight.normal,
              ),
            ),
          ),
        ),
      ),
    );
  }
}
```

**Cara Penggunaan:**
```dart
Row(
  children: [
    StatusChip(
      label: 'Semua',
      isSelected: selectedStatus == 'all',
      onTap: () => setState(() => selectedStatus = 'all'),
    ),
    SizedBox(width: 8),
    StatusChip(
      label: 'Normal',
      isSelected: selectedStatus == 'normal',
      onTap: () => setState(() => selectedStatus = 'normal'),
    ),
  ],
)
```

---

### 3. Stat Card Widget

**File: `lib/widgets/stat_card.dart`**

```dart
import 'package:flutter/material.dart';
import '../config/colors.dart';

class StatCard extends StatelessWidget {
  final String title;
  final String value;
  final IconData icon;
  final Color? color;

  const StatCard({
    super.key,
    required this.title,
    required this.value,
    required this.icon,
    this.color,
  });

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;
    final cardColor = color ?? AppColors.primary;
    
    return Container(
      width: 140,
      height: 112,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: isDark ? AppColors.cardDark : AppColors.cardLight,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: isDark ? AppColors.borderDark : AppColors.borderLight,
        ),
      ),
      child: Stack(
        children: [
          // Background icon
          Positioned(
            right: -8,
            top: -8,
            child: Icon(
              icon,
              size: 64,
              color: cardColor.withOpacity(0.1),
            ),
          ),
          // Content
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: cardColor.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Icon(
                  icon,
                  size: 20,
                  color: cardColor,
                ),
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    value,
                    style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    title,
                    style: Theme.of(context).textTheme.bodySmall,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ],
              ),
            ],
          ),
        ],
      ),
    );
  }
}
```

**Cara Penggunaan:**
```dart
Row(
  children: [
    StatCard(
      title: 'Total Stasiun',
      value: '24',
      icon: Icons.location_on,
      color: AppColors.primary,
    ),
    SizedBox(width: 12),
    StatCard(
      title: 'Status Awas',
      value: '3',
      icon: Icons.warning,
      color: AppColors.statusAwas,
    ),
  ],
)
```

---

## Implementasi Halaman Lainnya

### Template Dashboard Page

```dart
// lib/screens/officer/dashboard_page.dart

class DashboardPage extends StatefulWidget {
  const DashboardPage({super.key});

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  String selectedStatus = 'all';
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard'),
        actions: [
          // Profile button
          IconButton(
            icon: const Icon(Icons.person),
            onPressed: () {
              // Navigate to profile
            },
          ),
          // Notification button with badge
          Stack(
            children: [
              IconButton(
                icon: const Icon(Icons.notifications),
                onPressed: () {
                  // Navigate to notifications
                },
              ),
              Positioned(
                right: 8,
                top: 8,
                child: Container(
                  padding: const EdgeInsets.all(4),
                  decoration: const BoxDecoration(
                    color: AppColors.statusAwas,
                    shape: BoxShape.circle,
                  ),
                  child: const Text(
                    '3',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 10,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
      body: Column(
        children: [
          // Stats section
          Container(
            padding: const EdgeInsets.all(16),
            child: SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: Row(
                children: [
                  StatCard(
                    title: 'Total Stasiun',
                    value: '24',
                    icon: Icons.location_on,
                  ),
                  const SizedBox(width: 12),
                  StatCard(
                    title: 'Status Awas',
                    value: '3',
                    icon: Icons.warning,
                    color: AppColors.statusAwas,
                  ),
                  const SizedBox(width: 12),
                  StatCard(
                    title: 'Siaga',
                    value: '5',
                    icon: Icons.error_outline,
                    color: AppColors.statusSiaga,
                  ),
                ],
              ),
            ),
          ),
          
          // Search bar
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: TextField(
              decoration: InputDecoration(
                hintText: 'Cari stasiun...',
                prefixIcon: const Icon(Icons.search),
              ),
            ),
          ),
          
          const SizedBox(height: 16),
          
          // Filter chips
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: Row(
                children: [
                  StatusChip(
                    label: 'Semua',
                    isSelected: selectedStatus == 'all',
                    onTap: () => setState(() => selectedStatus = 'all'),
                  ),
                  const SizedBox(width: 8),
                  StatusChip(
                    label: 'Normal',
                    isSelected: selectedStatus == 'normal',
                    onTap: () => setState(() => selectedStatus = 'normal'),
                  ),
                  const SizedBox(width: 8),
                  StatusChip(
                    label: 'Siaga',
                    isSelected: selectedStatus == 'siaga',
                    onTap: () => setState(() => selectedStatus = 'siaga'),
                  ),
                  const SizedBox(width: 8),
                  StatusChip(
                    label: 'Awas',
                    isSelected: selectedStatus == 'awas',
                    onTap: () => setState(() => selectedStatus = 'awas'),
                  ),
                ],
              ),
            ),
          ),
          
          const SizedBox(height: 16),
          
          // Station list
          Expanded(
            child: ListView.builder(
              padding: const EdgeInsets.symmetric(horizontal: 16),
              itemCount: 10,
              itemBuilder: (context, index) {
                return StationCard(
                  stationName: 'Stasiun ${index + 1}',
                  regionName: 'Bogor',
                  status: index % 3 == 0 ? 'Awas' : 'Normal',
                  waterLevel: 50.0 + (index * 10),
                  lastUpdate: DateTime.now(),
                  onTap: () {
                    // Navigate to detail
                  },
                );
              },
            ),
          ),
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: 0,
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Beranda',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.add_circle),
            label: 'Lapor',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.history),
            label: 'Riwayat',
          ),
        ],
      ),
    );
  }
}
```

### Template Lapor Pintu Air Page

```dart
// lib/screens/officer/lapor_pintu_air_page.dart

class LaporPintuAirPage extends StatefulWidget {
  const LaporPintuAirPage({super.key});

  @override
  State<LaporPintuAirPage> createState() => _LaporPintuAirPageState();
}

class _LaporPintuAirPageState extends State<LaporPintuAirPage> {
  double waterLevel = 0;
  String selectedStatus = '';
  double curahHujan = 0;
  String pumpStatus = '';
  File? selectedImage;
  final notesController = TextEditingController();
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Lapor Pintu Air'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Water level input with +/- buttons
            Text('Ketinggian Air (cm)', style: Theme.of(context).textTheme.titleLarge),
            const SizedBox(height: 12),
            Row(
              children: [
                IconButton(
                  onPressed: () => setState(() => waterLevel = (waterLevel - 1).clamp(0, 300)),
                  icon: const Icon(Icons.remove_circle),
                ),
                Expanded(
                  child: TextField(
                    textAlign: TextAlign.center,
                    controller: TextEditingController(text: waterLevel.toStringAsFixed(0)),
                    keyboardType: TextInputType.number,
                    onChanged: (value) {
                      setState(() => waterLevel = double.tryParse(value) ?? 0);
                    },
                  ),
                ),
                IconButton(
                  onPressed: () => setState(() => waterLevel = (waterLevel + 1).clamp(0, 300)),
                  icon: const Icon(Icons.add_circle),
                ),
              ],
            ),
            
            const SizedBox(height: 24),
            
            // Slider
            Slider(
              value: waterLevel,
              min: 0,
              max: 300,
              divisions: 300,
              label: '${waterLevel.toStringAsFixed(0)} cm',
              onChanged: (value) => setState(() => waterLevel = value),
            ),
            
            const SizedBox(height: 24),
            
            // Status selection grid
            Text('Status Air', style: Theme.of(context).textTheme.titleLarge),
            const SizedBox(height: 12),
            GridView.count(
              crossAxisCount: 2,
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              mainAxisSpacing: 12,
              crossAxisSpacing: 12,
              childAspectRatio: 2.5,
              children: [
                _buildStatusButton('Normal', AppColors.statusNormal),
                _buildStatusButton('Waspada', AppColors.warning),
                _buildStatusButton('Siaga', AppColors.statusSiaga),
                _buildStatusButton('Awas', AppColors.statusAwas),
              ],
            ),
            
            const SizedBox(height: 24),
            
            // Photo upload
            Text('Foto Kondisi', style: Theme.of(context).textTheme.titleLarge),
            const SizedBox(height: 12),
            InkWell(
              onTap: () async {
                final picker = ImagePicker();
                final image = await picker.pickImage(source: ImageSource.camera);
                if (image != null) {
                  setState(() => selectedImage = File(image.path));
                }
              },
              child: Container(
                height: 200,
                decoration: BoxDecoration(
                  border: Border.all(color: AppColors.borderLight),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: selectedImage != null
                    ? Image.file(selectedImage!, fit: BoxFit.cover)
                    : const Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(Icons.camera_alt, size: 48),
                            SizedBox(height: 8),
                            Text('Ambil Foto'),
                          ],
                        ),
                      ),
              ),
            ),
            
            const SizedBox(height: 24),
            
            // Notes
            Text('Catatan', style: Theme.of(context).textTheme.titleLarge),
            const SizedBox(height: 12),
            TextField(
              controller: notesController,
              maxLines: 4,
              decoration: const InputDecoration(
                hintText: 'Tambahkan catatan kondisi...',
              ),
            ),
            
            const SizedBox(height: 32),
            
            // Submit button
            SizedBox(
              width: double.infinity,
              height: 56,
              child: ElevatedButton(
                onPressed: () {
                  // Handle submit
                },
                child: const Text('Kirim Laporan'),
              ),
            ),
          ],
        ),
      ),
    );
  }
  
  Widget _buildStatusButton(String label, Color color) {
    final isSelected = selectedStatus == label;
    return InkWell(
      onTap: () => setState(() => selectedStatus = label),
      child: Container(
        decoration: BoxDecoration(
          color: isSelected ? color : color.withOpacity(0.1),
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: color),
        ),
        child: Center(
          child: Text(
            label,
            style: TextStyle(
              color: isSelected ? Colors.white : color,
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
      ),
    );
  }
}
```

---

## Integrasi API

### API Service

```dart
// lib/services/api_service.dart

import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class ApiService {
  static const String baseUrl = 'http://localhost:8000/api';
  final storage = const FlutterSecureStorage();
  
  // Get headers with token
  Future<Map<String, String>> _getHeaders() async {
    final token = await storage.read(key: 'auth_token');
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }
  
  // Login
  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: await _getHeaders(),
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );
    
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      await storage.write(key: 'auth_token', value: data['data']['token']);
      return data;
    } else {
      throw Exception('Login failed');
    }
  }
  
  // Get stations
  Future<List<dynamic>> getStations() async {
    final response = await http.get(
      Uri.parse('$baseUrl/officer/stations'),
      headers: await _getHeaders(),
    );
    
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return data['data'];
    } else {
      throw Exception('Failed to load stations');
    }
  }
  
  // Submit report with photo
  Future<Map<String, dynamic>> submitReport({
    required int stationId,
    required double waterLevel,
    File? photo,
    String? notes,
  }) async {
    final token = await storage.read(key: 'auth_token');
    var request = http.MultipartRequest(
      'POST',
      Uri.parse('$baseUrl/officer/reports'),
    );
    
    request.headers['Authorization'] = 'Bearer $token';
    request.fields['station_id'] = stationId.toString();
    request.fields['water_level'] = waterLevel.toString();
    if (notes != null) request.fields['notes'] = notes;
    
    if (photo != null) {
      request.files.add(
        await http.MultipartFile.fromPath('photo', photo.path),
      );
    }
    
    final streamedResponse = await request.send();
    final response = await http.Response.fromStream(streamedResponse);
    
    if (response.statusCode == 201) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to submit report');
    }
  }
  
  // Logout
  Future<void> logout() async {
    await http.post(
      Uri.parse('$baseUrl/logout'),
      headers: await _getHeaders(),
    );
    await storage.delete(key: 'auth_token');
  }
}
```

### Cara Penggunaan API Service

```dart
// Di LoginPage
final apiService = ApiService();

try {
  final result = await apiService.login(
    _emailController.text,
    _passwordController.text,
  );
  
  // Navigate to dashboard
  Navigator.pushReplacement(
    context,
    MaterialPageRoute(builder: (context) => const DashboardPage()),
  );
} catch (e) {
  // Show error
  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(content: Text('Login gagal: $e')),
  );
}
```

---

## Catatan Penting

### 1. Test Credentials
Gunakan user testing yang sudah ada di database:
- **Email:** `petugas1@example.com`
- **Password:** `password`

### 2. Backend URL
- Development: `http://localhost:8000/api`
- Production: Ganti dengan URL server production

### 3. Firebase Configuration
Untuk push notification, tambahkan file:
- Android: `android/app/google-services.json`
- iOS: `ios/Runner/GoogleService-Info.plist`

### 4. Permissions
Tambahkan di `AndroidManifest.xml`:
```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.CAMERA" />
<uses-permission android:name="android.permission.READ_EXTERNAL_STORAGE" />
<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />
```

### 5. Build & Run
```bash
# Install dependencies
flutter pub get

# Run development
flutter run

# Build APK
flutter build apk --release

# Build iOS
flutter build ios --release
```

---

## Next Steps

1. ✅ **Setup project** - Buat project Flutter baru
2. ✅ **Konfigurasi tema** - Copy files config (colors.dart, theme.dart)
3. ✅ **Implementasi login** - Copy login_page.dart
4. ⏳ **Implementasi dashboard** - Gunakan template di atas
5. ⏳ **Implementasi form laporan** - Gunakan template lapor_pintu_air_page.dart
6. ⏳ **Integrasi API** - Copy api_service.dart dan hubungkan ke backend
7. ⏳ **Testing** - Test dengan backend localhost:8000
8. ⏳ **Deploy** - Build APK/iOS untuk production

---

## Support & Dokumentasi

- **Backend API Documentation:** Lihat file `API_DOCUMENTATION.md`
- **Database Schema:** Lihat file `DATABASE_SCHEMA.md`
- **Flutter Quick Start:** Lihat file `FLUTTER_QUICK_START.md`

---

**© 2025 BPBD - SiAGA Banjir**
