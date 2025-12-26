# 🚀 Flutter Integration Guide - SiAGA Banjir

**Panduan lengkap integrasi Flutter dengan Laravel Backend API**

---

## 📋 Table of Contents
1. [Setup & Dependencies](#setup--dependencies)
2. [Project Structure](#project-structure)
3. [API Service Layer](#api-service-layer)
4. [Authentication Flow](#authentication-flow)
5. [State Management](#state-management)
6. [File Upload](#file-upload)
7. [Push Notifications (FCM)](#push-notifications-fcm)
8. [Map Integration](#map-integration)
9. [Code Examples](#code-examples)

---

## 📦 Setup & Dependencies

### pubspec.yaml
```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # HTTP Client
  http: ^1.1.0
  dio: ^5.4.0  # Alternative, lebih powerful
  
  # State Management (pilih salah satu)
  provider: ^6.1.1
  # atau
  bloc: ^8.1.3
  flutter_bloc: ^8.1.3
  
  # Local Storage
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0  # untuk token
  
  # Image
  image_picker: ^1.0.5
  cached_network_image: ^3.3.0
  image: ^4.1.3  # untuk compress
  
  # Map
  google_maps_flutter: ^2.5.0
  geolocator: ^10.1.0
  
  # Push Notification
  firebase_core: ^2.24.2
  firebase_messaging: ^14.7.9
  flutter_local_notifications: ^16.3.0
  
  # UI
  intl: ^0.18.1  # date formatting
  shimmer: ^3.0.0  # loading skeleton
  pull_to_refresh: ^2.0.0
  
dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_launcher_icons: ^0.13.1
```

---

## 📁 Project Structure

```
lib/
├── main.dart
├── config/
│   ├── app_config.dart         # Base URL, constants
│   └── theme.dart              # App theme
├── models/
│   ├── user.dart
│   ├── station.dart
│   ├── report.dart
│   ├── notification.dart
│   └── api_response.dart
├── services/
│   ├── api_service.dart        # Base API service
│   ├── auth_service.dart       # Authentication
│   ├── storage_service.dart    # Local storage
│   └── fcm_service.dart        # Push notification
├── providers/                  # State management
│   ├── auth_provider.dart
│   ├── dashboard_provider.dart
│   └── report_provider.dart
├── screens/
│   ├── auth/
│   │   ├── login_screen.dart
│   │   └── register_screen.dart
│   ├── admin/
│   │   ├── dashboard_screen.dart
│   │   ├── station_management_screen.dart
│   │   └── officer_management_screen.dart
│   ├── officer/
│   │   ├── dashboard_screen.dart
│   │   ├── create_report_screen.dart
│   │   └── report_history_screen.dart
│   └── public/
│       ├── dashboard_screen.dart
│       ├── create_report_screen.dart
│       ├── map_screen.dart
│       └── notification_screen.dart
├── widgets/
│   ├── custom_button.dart
│   ├── status_badge.dart
│   └── loading_widget.dart
└── utils/
    ├── constants.dart
    ├── helpers.dart
    └── validators.dart
```

---

## 🔧 API Service Layer

### config/app_config.dart
```dart
class AppConfig {
  static const String baseUrl = 'http://10.0.2.2:8000/api'; // Android emulator
  // static const String baseUrl = 'http://localhost:8000/api'; // iOS simulator
  // static const String baseUrl = 'https://api.siaga-banjir.com/api'; // Production
  
  static const String storageUrl = 'http://10.0.2.2:8000/storage';
  
  // Timeout
  static const Duration connectTimeout = Duration(seconds: 30);
  static const Duration receiveTimeout = Duration(seconds: 30);
}
```

### services/api_service.dart
```dart
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:io';
import '../config/app_config.dart';
import 'storage_service.dart';

class ApiService {
  final StorageService _storage = StorageService();
  
  // Headers default
  Future<Map<String, String>> _getHeaders({bool needsAuth = true}) async {
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    if (needsAuth) {
      String? token = await _storage.getToken();
      if (token != null) {
        headers['Authorization'] = 'Bearer $token';
      }
    }
    
    return headers;
  }
  
  // GET Request
  Future<dynamic> get(String endpoint, {bool needsAuth = true}) async {
    try {
      final headers = await _getHeaders(needsAuth: needsAuth);
      final response = await http.get(
        Uri.parse('${AppConfig.baseUrl}$endpoint'),
        headers: headers,
      ).timeout(AppConfig.receiveTimeout);
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // POST Request
  Future<dynamic> post(
    String endpoint, 
    Map<String, dynamic> body, 
    {bool needsAuth = true}
  ) async {
    try {
      final headers = await _getHeaders(needsAuth: needsAuth);
      final response = await http.post(
        Uri.parse('${AppConfig.baseUrl}$endpoint'),
        headers: headers,
        body: jsonEncode(body),
      ).timeout(AppConfig.receiveTimeout);
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // PUT Request
  Future<dynamic> put(
    String endpoint, 
    Map<String, dynamic> body,
    {bool needsAuth = true}
  ) async {
    try {
      final headers = await _getHeaders(needsAuth: needsAuth);
      final response = await http.put(
        Uri.parse('${AppConfig.baseUrl}$endpoint'),
        headers: headers,
        body: jsonEncode(body),
      ).timeout(AppConfig.receiveTimeout);
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // DELETE Request
  Future<dynamic> delete(String endpoint, {bool needsAuth = true}) async {
    try {
      final headers = await _getHeaders(needsAuth: needsAuth);
      final response = await http.delete(
        Uri.parse('${AppConfig.baseUrl}$endpoint'),
        headers: headers,
      ).timeout(AppConfig.receiveTimeout);
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // Multipart Request (untuk upload file)
  Future<dynamic> postMultipart(
    String endpoint,
    Map<String, String> fields,
    Map<String, File> files,
  ) async {
    try {
      String? token = await _storage.getToken();
      
      var request = http.MultipartRequest(
        'POST',
        Uri.parse('${AppConfig.baseUrl}$endpoint'),
      );
      
      // Headers
      request.headers.addAll({
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      });
      
      // Fields
      request.fields.addAll(fields);
      
      // Files
      for (var entry in files.entries) {
        request.files.add(
          await http.MultipartFile.fromPath(entry.key, entry.value.path),
        );
      }
      
      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // Handle Response
  dynamic _handleResponse(http.Response response) {
    switch (response.statusCode) {
      case 200:
      case 201:
        return jsonDecode(response.body);
      case 401:
        throw Exception('Sesi Anda telah berakhir. Silakan login kembali.');
      case 403:
        throw Exception('Anda tidak memiliki akses ke fitur ini.');
      case 404:
        throw Exception('Data tidak ditemukan.');
      case 422:
        final data = jsonDecode(response.body);
        throw Exception(data['message'] ?? 'Data tidak valid.');
      case 500:
        throw Exception('Terjadi kesalahan pada server.');
      default:
        throw Exception('Terjadi kesalahan: ${response.statusCode}');
    }
  }
  
  // Handle Error
  String _handleError(dynamic error) {
    if (error is SocketException) {
      return 'Tidak ada koneksi internet.';
    } else if (error is HttpException) {
      return 'Server error.';
    } else if (error is FormatException) {
      return 'Format data tidak valid.';
    } else {
      return error.toString();
    }
  }
  
  // Get Image URL
  String getImageUrl(String? path) {
    if (path == null || path.isEmpty) return '';
    return '${AppConfig.storageUrl}/$path';
  }
}
```

### services/storage_service.dart
```dart
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'dart:convert';
import '../models/user.dart';

class StorageService {
  final FlutterSecureStorage _storage = const FlutterSecureStorage();
  
  // Keys
  static const String _tokenKey = 'auth_token';
  static const String _userKey = 'user_data';
  static const String _fcmTokenKey = 'fcm_token';
  
  // Save Token
  Future<void> saveToken(String token) async {
    await _storage.write(key: _tokenKey, value: token);
  }
  
  // Get Token
  Future<String?> getToken() async {
    return await _storage.read(key: _tokenKey);
  }
  
  // Save User
  Future<void> saveUser(User user) async {
    await _storage.write(key: _userKey, value: jsonEncode(user.toJson()));
  }
  
  // Get User
  Future<User?> getUser() async {
    String? userData = await _storage.read(key: _userKey);
    if (userData != null) {
      return User.fromJson(jsonDecode(userData));
    }
    return null;
  }
  
  // Save FCM Token
  Future<void> saveFcmToken(String token) async {
    await _storage.write(key: _fcmTokenKey, value: token);
  }
  
  // Get FCM Token
  Future<String?> getFcmToken() async {
    return await _storage.read(key: _fcmTokenKey);
  }
  
  // Clear All
  Future<void> clearAll() async {
    await _storage.deleteAll();
  }
  
  // Check if logged in
  Future<bool> isLoggedIn() async {
    String? token = await getToken();
    return token != null;
  }
}
```

---

## 🔐 Authentication Flow

### services/auth_service.dart
```dart
import '../models/user.dart';
import 'api_service.dart';
import 'storage_service.dart';

class AuthService {
  final ApiService _api = ApiService();
  final StorageService _storage = StorageService();
  
  // Login
  Future<User> login(String username, String password) async {
    final response = await _api.post(
      '/login',
      {
        'username': username,
        'password': password,
      },
      needsAuth: false,
    );
    
    // Save token & user
    await _storage.saveToken(response['access_token']);
    
    User user = User.fromJson(response['user']);
    await _storage.saveUser(user);
    
    return user;
  }
  
  // Register
  Future<User> register({
    required String name,
    required String username,
    required String password,
    required String passwordConfirmation,
    required int regionId,
  }) async {
    final response = await _api.post(
      '/register',
      {
        'name': name,
        'username': username,
        'password': password,
        'password_confirmation': passwordConfirmation,
        'region_id': regionId,
      },
      needsAuth: false,
    );
    
    // Save token & user
    await _storage.saveToken(response['access_token']);
    
    User user = User.fromJson(response['user']);
    await _storage.saveUser(user);
    
    return user;
  }
  
  // Logout
  Future<void> logout() async {
    await _api.post('/logout', {});
    await _storage.clearAll();
  }
  
  // Get Current User
  Future<User> getCurrentUser() async {
    final response = await _api.get('/user');
    return User.fromJson(response);
  }
  
  // Update FCM Token
  Future<void> updateFcmToken(String fcmToken) async {
    await _api.post('/user/update-token', {
      'notification_token': fcmToken,
    });
    await _storage.saveFcmToken(fcmToken);
  }
}
```

### screens/auth/login_screen.dart
```dart
import 'package:flutter/material.dart';
import '../../services/auth_service.dart';
import '../../models/user.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  final _authService = AuthService();
  
  bool _isLoading = false;
  bool _obscurePassword = true;
  
  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;
    
    setState(() => _isLoading = true);
    
    try {
      User user = await _authService.login(
        _usernameController.text,
        _passwordController.text,
      );
      
      // Navigate based on role
      if (user.role == 'admin') {
        Navigator.pushReplacementNamed(context, '/admin/dashboard');
      } else if (user.role == 'petugas') {
        Navigator.pushReplacementNamed(context, '/officer/dashboard');
      } else {
        Navigator.pushReplacementNamed(context, '/public/dashboard');
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(e.toString())),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Padding(
          padding: EdgeInsets.all(24.0),
          child: Form(
            key: _formKey,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                // Logo
                Image.asset('assets/logo.png', height: 120),
                SizedBox(height: 32),
                
                Text(
                  'SiAGA Banjir',
                  style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
                ),
                SizedBox(height: 8),
                Text('Sistem Informasi Alerting & Monitoring Banjir'),
                SizedBox(height: 32),
                
                // Username
                TextFormField(
                  controller: _usernameController,
                  decoration: InputDecoration(
                    labelText: 'Username',
                    prefixIcon: Icon(Icons.person),
                    border: OutlineInputBorder(),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Username tidak boleh kosong';
                    }
                    return null;
                  },
                ),
                SizedBox(height: 16),
                
                // Password
                TextFormField(
                  controller: _passwordController,
                  obscureText: _obscurePassword,
                  decoration: InputDecoration(
                    labelText: 'Password',
                    prefixIcon: Icon(Icons.lock),
                    suffixIcon: IconButton(
                      icon: Icon(
                        _obscurePassword ? Icons.visibility : Icons.visibility_off,
                      ),
                      onPressed: () {
                        setState(() => _obscurePassword = !_obscurePassword);
                      },
                    ),
                    border: OutlineInputBorder(),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Password tidak boleh kosong';
                    }
                    return null;
                  },
                ),
                SizedBox(height: 24),
                
                // Login Button
                SizedBox(
                  width: double.infinity,
                  height: 50,
                  child: ElevatedButton(
                    onPressed: _isLoading ? null : _login,
                    child: _isLoading
                        ? CircularProgressIndicator(color: Colors.white)
                        : Text('Masuk', style: TextStyle(fontSize: 16)),
                  ),
                ),
                SizedBox(height: 16),
                
                // Register Link (untuk public)
                TextButton(
                  onPressed: () {
                    Navigator.pushNamed(context, '/register');
                  },
                  child: Text('Belum punya akun? Daftar di sini'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
  
  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    super.dispose();
  }
}
```

---

## 🗂️ State Management

### providers/auth_provider.dart (menggunakan Provider)
```dart
import 'package:flutter/foundation.dart';
import '../models/user.dart';
import '../services/auth_service.dart';
import '../services/storage_service.dart';

class AuthProvider with ChangeNotifier {
  final AuthService _authService = AuthService();
  final StorageService _storage = StorageService();
  
  User? _user;
  bool _isLoading = false;
  String? _error;
  
  User? get user => _user;
  bool get isLoading => _isLoading;
  String? get error => _error;
  bool get isLoggedIn => _user != null;
  
  // Check Auth Status
  Future<void> checkAuthStatus() async {
    _user = await _storage.getUser();
    notifyListeners();
  }
  
  // Login
  Future<bool> login(String username, String password) async {
    _isLoading = true;
    _error = null;
    notifyListeners();
    
    try {
      _user = await _authService.login(username, password);
      _isLoading = false;
      notifyListeners();
      return true;
    } catch (e) {
      _error = e.toString();
      _isLoading = false;
      notifyListeners();
      return false;
    }
  }
  
  // Logout
  Future<void> logout() async {
    await _authService.logout();
    _user = null;
    notifyListeners();
  }
}
```

### main.dart (Setup Provider)
```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'providers/auth_provider.dart';
import 'screens/auth/login_screen.dart';

void main() {
  runApp(
    MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => AuthProvider()),
        // Add more providers here
      ],
      child: MyApp(),
    ),
  );
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SiAGA Banjir',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: LoginScreen(),
      routes: {
        '/login': (context) => LoginScreen(),
        // Add more routes
      },
    );
  }
}
```

---

## 📤 File Upload

### Upload Report dengan Foto
```dart
import 'dart:io';
import 'package:image_picker/image_picker.dart';
import 'package:image/image.dart' as img;
import '../services/api_service.dart';

class ReportService {
  final ApiService _api = ApiService();
  final ImagePicker _picker = ImagePicker();
  
  // Pick & Compress Image
  Future<File?> pickAndCompressImage() async {
    final XFile? pickedFile = await _picker.pickImage(
      source: ImageSource.camera, // atau ImageSource.gallery
      maxWidth: 1920,
      maxHeight: 1920,
      imageQuality: 85,
    );
    
    if (pickedFile == null) return null;
    
    // Compress image
    File imageFile = File(pickedFile.path);
    final bytes = await imageFile.readAsBytes();
    img.Image? image = img.decodeImage(bytes);
    
    if (image == null) return imageFile;
    
    // Resize jika lebih besar dari 1920
    if (image.width > 1920 || image.height > 1920) {
      image = img.copyResize(image, width: 1920);
    }
    
    // Save compressed
    final compressedBytes = img.encodeJpg(image, quality: 85);
    await imageFile.writeAsBytes(compressedBytes);
    
    return imageFile;
  }
  
  // Submit Public Report
  Future<void> submitPublicReport({
    required String location,
    required double waterHeight,
    File? photo,
  }) async {
    Map<String, String> fields = {
      'location': location,
      'water_height': waterHeight.toString(),
    };
    
    Map<String, File> files = {};
    if (photo != null) {
      files['photo'] = photo;
    }
    
    await _api.postMultipart('/public/report', fields, files);
  }
  
  // Submit Officer Report
  Future<void> submitOfficerReport({
    required int stationId,
    required double waterLevel,
    required double rainfall,
    required String pumpStatus,
    required File photo,
    String? note,
  }) async {
    Map<String, String> fields = {
      'station_id': stationId.toString(),
      'water_level': waterLevel.toString(),
      'rainfall': rainfall.toString(),
      'pump_status': pumpStatus,
      if (note != null) 'note': note,
    };
    
    Map<String, File> files = {
      'photo': photo, // Required
    };
    
    await _api.postMultipart('/officer/reports', fields, files);
  }
}
```

---

## 🔔 Push Notifications (FCM)

### Setup Firebase
1. Tambahkan `google-services.json` (Android) dan `GoogleService-Info.plist` (iOS)
2. Configure di `android/app/build.gradle` dan `ios/Runner/Info.plist`

### services/fcm_service.dart
```dart
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'auth_service.dart';

class FCMService {
  final FirebaseMessaging _fcm = FirebaseMessaging.instance;
  final FlutterLocalNotificationsPlugin _localNotifications = 
      FlutterLocalNotificationsPlugin();
  final AuthService _authService = AuthService();
  
  // Initialize
  Future<void> initialize() async {
    // Request permission
    NotificationSettings settings = await _fcm.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );
    
    if (settings.authorizationStatus == AuthorizationStatus.authorized) {
      // Get token
      String? token = await _fcm.getToken();
      if (token != null) {
        await _authService.updateFcmToken(token);
      }
      
      // Listen to token refresh
      _fcm.onTokenRefresh.listen((newToken) {
        _authService.updateFcmToken(newToken);
      });
      
      // Initialize local notifications
      const AndroidInitializationSettings androidSettings = 
          AndroidInitializationSettings('@mipmap/ic_launcher');
      const DarwinInitializationSettings iosSettings = 
          DarwinInitializationSettings();
      const InitializationSettings initSettings = InitializationSettings(
        android: androidSettings,
        iOS: iosSettings,
      );
      
      await _localNotifications.initialize(initSettings);
      
      // Handle foreground messages
      FirebaseMessaging.onMessage.listen(_handleForegroundMessage);
      
      // Handle background/terminated messages
      FirebaseMessaging.onMessageOpenedApp.listen(_handleBackgroundMessage);
    }
  }
  
  // Handle Foreground Message
  void _handleForegroundMessage(RemoteMessage message) {
    print('Foreground message: ${message.notification?.title}');
    
    // Show local notification
    _showLocalNotification(
      message.notification?.title ?? 'Notifikasi',
      message.notification?.body ?? '',
    );
  }
  
  // Handle Background Message
  void _handleBackgroundMessage(RemoteMessage message) {
    print('Background message clicked: ${message.notification?.title}');
    // Navigate to specific screen based on message.data
  }
  
  // Show Local Notification
  Future<void> _showLocalNotification(String title, String body) async {
    const AndroidNotificationDetails androidDetails = 
        AndroidNotificationDetails(
      'siaga_banjir_channel',
      'SiAGA Banjir Notifications',
      importance: Importance.high,
      priority: Priority.high,
    );
    
    const DarwinNotificationDetails iosDetails = DarwinNotificationDetails();
    
    const NotificationDetails details = NotificationDetails(
      android: androidDetails,
      iOS: iosDetails,
    );
    
    await _localNotifications.show(
      0,
      title,
      body,
      details,
    );
  }
}
```

---

## 🗺️ Map Integration

### screens/public/map_screen.dart
```dart
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import '../../models/station.dart';
import '../../services/api_service.dart';

class MapScreen extends StatefulWidget {
  @override
  _MapScreenState createState() => _MapScreenState();
}

class _MapScreenState extends State<MapScreen> {
  GoogleMapController? _mapController;
  final ApiService _api = ApiService();
  
  List<Station> _stations = [];
  Set<Marker> _markers = {};
  
  static const LatLng _jakarta = LatLng(-6.2088, 106.8456);
  
  @override
  void initState() {
    super.initState();
    _loadStations();
  }
  
  Future<void> _loadStations() async {
    try {
      final response = await _api.get('/stations');
      
      setState(() {
        _stations = (response['data'] as List)
            .map((json) => Station.fromJson(json))
            .toList();
        
        _markers = _stations.map((station) {
          return Marker(
            markerId: MarkerId(station.id.toString()),
            position: LatLng(station.latitude, station.longitude),
            icon: _getMarkerIcon(station.status),
            infoWindow: InfoWindow(
              title: station.name,
              snippet: 'Level: ${station.waterLevel}cm - ${station.status.toUpperCase()}',
            ),
            onTap: () => _showStationDetail(station),
          );
        }).toSet();
      });
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal memuat data stasiun')),
      );
    }
  }
  
  BitmapDescriptor _getMarkerIcon(String status) {
    // Buat custom marker berdasarkan status
    // normal = hijau, siaga = kuning, awas = merah
    switch (status) {
      case 'normal':
        return BitmapDescriptor.defaultMarkerWithHue(BitmapDescriptor.hueGreen);
      case 'siaga':
        return BitmapDescriptor.defaultMarkerWithHue(BitmapDescriptor.hueYellow);
      case 'awas':
        return BitmapDescriptor.defaultMarkerWithHue(BitmapDescriptor.hueRed);
      default:
        return BitmapDescriptor.defaultMarker;
    }
  }
  
  void _showStationDetail(Station station) {
    showModalBottomSheet(
      context: context,
      builder: (context) => Container(
        padding: EdgeInsets.all(16),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              station.name,
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 8),
            Text('Lokasi: ${station.location}'),
            Text('Ketinggian Air: ${station.waterLevel} cm'),
            Text('Status: ${station.status.toUpperCase()}'),
            Text('Update: ${station.lastUpdate}'),
          ],
        ),
      ),
    );
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Peta Stasiun')),
      body: GoogleMap(
        initialCameraPosition: CameraPosition(
          target: _jakarta,
          zoom: 12,
        ),
        markers: _markers,
        myLocationEnabled: true,
        myLocationButtonEnabled: true,
        onMapCreated: (controller) => _mapController = controller,
      ),
    );
  }
}
```

---

## 💻 Code Examples

### Dashboard Public
```dart
class PublicDashboardScreen extends StatefulWidget {
  @override
  _PublicDashboardScreenState createState() => _PublicDashboardScreenState();
}

class _PublicDashboardScreenState extends State<PublicDashboardScreen> {
  final ApiService _api = ApiService();
  Map<String, dynamic>? _dashboardData;
  bool _isLoading = true;
  
  @override
  void initState() {
    super.initState();
    _loadDashboard();
  }
  
  Future<void> _loadDashboard() async {
    setState(() => _isLoading = true);
    
    try {
      final response = await _api.get('/public/dashboard');
      setState(() {
        _dashboardData = response['data'];
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(e.toString())),
      );
    }
  }
  
  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }
    
    final userRegion = _dashboardData?['user_region'];
    final summary = _dashboardData?['summary'];
    
    return Scaffold(
      appBar: AppBar(title: Text('Dashboard')),
      body: RefreshIndicator(
        onRefresh: _loadDashboard,
        child: ListView(
          padding: EdgeInsets.all(16),
          children: [
            // Status Wilayah Card
            if (userRegion != null)
              _buildStatusCard(userRegion),
            
            SizedBox(height: 16),
            
            // Summary Cards
            Row(
              children: [
                Expanded(
                  child: _buildSummaryCard(
                    'Total Laporan',
                    summary['total_reports'].toString(),
                    Icons.assignment,
                  ),
                ),
                SizedBox(width: 16),
                Expanded(
                  child: _buildSummaryCard(
                    'Pending',
                    summary['pending_reports'].toString(),
                    Icons.pending,
                  ),
                ),
              ],
            ),
            
            SizedBox(height: 24),
            
            // Quick Actions
            Text(
              'Aksi Cepat',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: () => Navigator.pushNamed(context, '/public/report'),
                    icon: Icon(Icons.add_location),
                    label: Text('Lapor Banjir'),
                  ),
                ),
                SizedBox(width: 12),
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: _showEmergencyDialog,
                    icon: Icon(Icons.warning),
                    label: Text('SOS Darurat'),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.red,
                    ),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
  
  Widget _buildStatusCard(Map<String, dynamic> region) {
    Color statusColor;
    String status = region['flood_status'];
    
    switch (status) {
      case 'normal':
        statusColor = Colors.green;
        break;
      case 'siaga':
        statusColor = Colors.orange;
        break;
      case 'awas':
        statusColor = Colors.red;
        break;
      default:
        statusColor = Colors.grey;
    }
    
    return Card(
      color: statusColor.withOpacity(0.1),
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Icon(Icons.location_on, color: statusColor),
                SizedBox(width: 8),
                Expanded(
                  child: Text(
                    region['region_name'],
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ),
                Chip(
                  label: Text(
                    status.toUpperCase(),
                    style: TextStyle(color: Colors.white),
                  ),
                  backgroundColor: statusColor,
                ),
              ],
            ),
            SizedBox(height: 12),
            Text('Stasiun: ${region['station_name']}'),
            Text('Ketinggian Air: ${region['water_level']} cm'),
            Text('Update: ${region['last_update']}'),
          ],
        ),
      ),
    );
  }
  
  Widget _buildSummaryCard(String title, String value, IconData icon) {
    return Card(
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          children: [
            Icon(icon, size: 32, color: Colors.blue),
            SizedBox(height: 8),
            Text(
              value,
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            Text(title, textAlign: TextAlign.center),
          ],
        ),
      ),
    );
  }
  
  void _showEmergencyDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('Konfirmasi SOS Darurat'),
        content: Text('Apakah Anda yakin ingin mengirim sinyal darurat?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: Text('Batal'),
          ),
          ElevatedButton(
            onPressed: () async {
              Navigator.pop(context);
              // Call emergency API
              await _api.post('/public/emergency-report', {
                'location': 'Lokasi pengguna',
              });
              ScaffoldMessenger.of(context).showSnackBar(
                SnackBar(content: Text('Sinyal darurat telah dikirim!')),
              );
            },
            style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
            child: Text('Kirim SOS'),
          ),
        ],
      ),
    );
  }
}
```

---

## 📱 Best Practices

### 1. Error Handling
```dart
try {
  final response = await _api.get('/endpoint');
  // Success
} on SocketException {
  // No internet
  _showError('Tidak ada koneksi internet');
} catch (e) {
  // Other errors
  _showError(e.toString());
}
```

### 2. Loading States
```dart
bool _isLoading = false;

Widget build(BuildContext context) {
  return _isLoading 
    ? Center(child: CircularProgressIndicator())
    : YourActualWidget();
}
```

### 3. Image Caching
```dart
import 'package:cached_network_image/cached_network_image.dart';

CachedNetworkImage(
  imageUrl: _api.getImageUrl(report.photo),
  placeholder: (context, url) => CircularProgressIndicator(),
  errorWidget: (context, url, error) => Icon(Icons.error),
)
```

### 4. Pull to Refresh
```dart
RefreshIndicator(
  onRefresh: _loadData,
  child: ListView(...),
)
```

---

## 🔗 Useful Packages

- **http** / **dio**: HTTP client
- **provider** / **bloc**: State management
- **flutter_secure_storage**: Secure token storage
- **image_picker**: Pick images
- **google_maps_flutter**: Map integration
- **firebase_messaging**: Push notifications
- **cached_network_image**: Image caching
- **intl**: Date formatting
- **shimmer**: Loading skeleton
- **pull_to_refresh**: Pull to refresh
- **connectivity_plus**: Check internet connection

---

## 📚 Documentation References

- **Backend API**: [BACKEND_API_DOCUMENTATION.md](BACKEND_API_DOCUMENTATION.md)
- **API Mapping**: [HTML_TO_API_MAPPING.md](HTML_TO_API_MAPPING.md)
- **Database Schema**: [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)

---

**🎉 Selamat mengembangkan aplikasi Flutter!**
