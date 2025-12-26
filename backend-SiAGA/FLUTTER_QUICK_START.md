# 🚀 Quick Start Guide - Flutter Integration

Panduan cepat untuk tim frontend memulai integrasi dengan backend SiAGA Banjir.

---

## 📋 Prerequisites

1. **Backend sudah running** di `http://localhost:8000`
2. **Database sudah di-migrate** dan di-seed
3. **Storage link** sudah dibuat: `php artisan storage:link`
4. **Flutter SDK** terinstall
5. **Firebase Project** sudah setup untuk push notification

---

## 🎯 Step by Step Integration

### Step 1: Setup Dependencies (pubspec.yaml)

```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # HTTP Client
  http: ^1.1.0
  
  # State Management (pilih salah satu)
  provider: ^6.1.1
  # atau
  # bloc: ^8.1.3
  
  # Storage
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  
  # Firebase
  firebase_core: ^2.24.2
  firebase_messaging: ^14.7.9
  
  # Image Picker
  image_picker: ^1.0.5
  
  # Maps (optional)
  google_maps_flutter: ^2.5.0
  
  # UI Helpers
  cached_network_image: ^3.3.0
```

---

### Step 2: Setup API Service

Buat file `lib/services/api_service.dart`:

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:io';

class ApiService {
  // Ganti dengan IP komputer jika test di device fisik
  static const String baseUrl = 'http://10.0.2.2:8000/api'; // Android Emulator
  // static const String baseUrl = 'http://localhost:8000/api'; // iOS Simulator
  // static const String baseUrl = 'http://192.168.1.100:8000/api'; // Physical Device
  
  // Storage URL untuk akses gambar
  static const String storageUrl = 'http://10.0.2.2:8000/storage';
  
  // Login
  Future<Map<String, dynamic>> login(String username, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: json.encode({
          'username': username,
          'password': password,
        }),
      );
      
      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
  
  // Register
  Future<Map<String, dynamic>> register({
    required String name,
    required String username,
    required String password,
    required int regionId,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/register'),
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
      body: json.encode({
        'name': name,
        'username': username,
        'password': password,
        'region_id': regionId,
      }),
    );
    
    return _handleResponse(response);
  }
  
  // GET dengan Authentication
  Future<Map<String, dynamic>> getWithAuth(String endpoint, String token) async {
    final response = await http.get(
      Uri.parse('$baseUrl$endpoint'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    
    return _handleResponse(response);
  }
  
  // POST dengan Authentication
  Future<Map<String, dynamic>> postWithAuth(
    String endpoint, 
    String token, 
    Map<String, dynamic> body,
  ) async {
    final response = await http.post(
      Uri.parse('$baseUrl$endpoint'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: json.encode(body),
    );
    
    return _handleResponse(response);
  }
  
  // PUT dengan Authentication
  Future<Map<String, dynamic>> putWithAuth(
    String endpoint, 
    String token, 
    Map<String, dynamic> body,
  ) async {
    final response = await http.put(
      Uri.parse('$baseUrl$endpoint'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: json.encode(body),
    );
    
    return _handleResponse(response);
  }
  
  // DELETE dengan Authentication
  Future<Map<String, dynamic>> deleteWithAuth(String endpoint, String token) async {
    final response = await http.delete(
      Uri.parse('$baseUrl$endpoint'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    
    return _handleResponse(response);
  }
  
  // Upload dengan Multipart (untuk foto)
  Future<Map<String, dynamic>> uploadWithAuth({
    required String endpoint,
    required String token,
    required Map<String, String> fields,
    File? photo,
    String photoFieldName = 'photo',
  }) async {
    var request = http.MultipartRequest(
      'POST',
      Uri.parse('$baseUrl$endpoint'),
    );
    
    // Headers
    request.headers['Authorization'] = 'Bearer $token';
    request.headers['Accept'] = 'application/json';
    
    // Fields
    request.fields.addAll(fields);
    
    // File
    if (photo != null) {
      request.files.add(
        await http.MultipartFile.fromPath(photoFieldName, photo.path),
      );
    }
    
    final streamedResponse = await request.send();
    final response = await http.Response.fromStream(streamedResponse);
    
    return _handleResponse(response);
  }
  
  // Handle Response
  Map<String, dynamic> _handleResponse(http.Response response) {
    final body = json.decode(response.body);
    
    if (response.statusCode >= 200 && response.statusCode < 300) {
      return body;
    } else {
      // Handle error
      throw ApiException(
        statusCode: response.statusCode,
        message: body['message'] ?? 'Unknown error',
        errors: body['errors'],
      );
    }
  }
}

// Custom Exception
class ApiException implements Exception {
  final int statusCode;
  final String message;
  final Map<String, dynamic>? errors;
  
  ApiException({
    required this.statusCode,
    required this.message,
    this.errors,
  });
  
  @override
  String toString() => message;
}
```

---

### Step 3: Setup Auth Manager

Buat file `lib/services/auth_manager.dart`:

```dart
import 'package:shared_preferences/shared_preferences.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class AuthManager {
  static const String _tokenKey = 'access_token';
  static const String _userKey = 'user_data';
  
  final _storage = const FlutterSecureStorage();
  final _prefs = SharedPreferences.getInstance();
  
  // Save login data
  Future<void> saveLoginData(String token, Map<String, dynamic> user) async {
    await _storage.write(key: _tokenKey, value: token);
    
    final prefs = await _prefs;
    await prefs.setString(_userKey, jsonEncode(user));
  }
  
  // Get token
  Future<String?> getToken() async {
    return await _storage.read(key: _tokenKey);
  }
  
  // Get user data
  Future<Map<String, dynamic>?> getUserData() async {
    final prefs = await _prefs;
    final userJson = prefs.getString(_userKey);
    
    if (userJson != null) {
      return jsonDecode(userJson);
    }
    return null;
  }
  
  // Check if logged in
  Future<bool> isLoggedIn() async {
    final token = await getToken();
    return token != null;
  }
  
  // Logout
  Future<void> logout() async {
    await _storage.delete(key: _tokenKey);
    
    final prefs = await _prefs;
    await prefs.remove(_userKey);
  }
}
```

---

### Step 4: Setup Firebase Cloud Messaging

Buat file `lib/services/fcm_service.dart`:

```dart
import 'package:firebase_messaging/firebase_messaging.dart';
import 'api_service.dart';
import 'auth_manager.dart';

class FCMService {
  final FirebaseMessaging _messaging = FirebaseMessaging.instance;
  final ApiService _apiService = ApiService();
  final AuthManager _authManager = AuthManager();
  
  Future<void> initialize() async {
    // Request permission (iOS)
    await _messaging.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );
    
    // Get FCM token
    String? token = await _messaging.getToken();
    
    if (token != null) {
      print('FCM Token: $token');
      await _sendTokenToBackend(token);
    }
    
    // Listen to token refresh
    _messaging.onTokenRefresh.listen(_sendTokenToBackend);
    
    // Handle foreground messages
    FirebaseMessaging.onMessage.listen(_handleForegroundMessage);
    
    // Handle background messages
    FirebaseMessaging.onMessageOpenedApp.listen(_handleBackgroundMessage);
  }
  
  Future<void> _sendTokenToBackend(String fcmToken) async {
    final authToken = await _authManager.getToken();
    
    if (authToken != null) {
      try {
        await _apiService.postWithAuth(
          '/user/update-token',
          authToken,
          {'notification_token': fcmToken},
        );
        print('FCM token sent to backend');
      } catch (e) {
        print('Failed to send FCM token: $e');
      }
    }
  }
  
  void _handleForegroundMessage(RemoteMessage message) {
    print('Foreground message: ${message.notification?.title}');
    
    // Show local notification atau dialog
    // TODO: Implementasi sesuai kebutuhan UI
  }
  
  void _handleBackgroundMessage(RemoteMessage message) {
    print('Background message clicked: ${message.notification?.title}');
    
    // Navigate ke halaman tertentu berdasarkan data
    // TODO: Implementasi navigation
  }
}

// Handle background message (harus top-level function)
@pragma('vm:entry-point')
Future<void> firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  print('Background message: ${message.notification?.title}');
}
```

Tambahkan di `main.dart`:

```dart
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Initialize Firebase
  await Firebase.initializeApp();
  
  // Set background message handler
  FirebaseMessaging.onBackgroundMessage(firebaseMessagingBackgroundHandler);
  
  runApp(MyApp());
}
```

---

### Step 5: Example Implementation - Login Page

```dart
import 'package:flutter/material.dart';

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  
  final ApiService _apiService = ApiService();
  final AuthManager _authManager = AuthManager();
  
  bool _isLoading = false;
  
  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;
    
    setState(() => _isLoading = true);
    
    try {
      final response = await _apiService.login(
        _usernameController.text,
        _passwordController.text,
      );
      
      // Save token and user data
      await _authManager.saveLoginData(
        response['access_token'],
        response['user'],
      );
      
      // Initialize FCM
      await FCMService().initialize();
      
      // Navigate based on role
      final role = response['user']['role'];
      
      if (role == 'admin') {
        Navigator.pushReplacementNamed(context, '/admin-dashboard');
      } else if (role == 'petugas') {
        Navigator.pushReplacementNamed(context, '/officer-dashboard');
      } else {
        Navigator.pushReplacementNamed(context, '/user-dashboard');
      }
      
    } on ApiException catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(e.message)),
      );
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error: $e')),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Login - SiAGA Banjir')),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              TextFormField(
                controller: _usernameController,
                decoration: InputDecoration(labelText: 'Username'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Username harus diisi';
                  }
                  return null;
                },
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: _passwordController,
                decoration: InputDecoration(labelText: 'Password'),
                obscureText: true,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Password harus diisi';
                  }
                  return null;
                },
              ),
              SizedBox(height: 24),
              _isLoading
                ? CircularProgressIndicator()
                : ElevatedButton(
                    onPressed: _login,
                    child: Text('Login'),
                  ),
            ],
          ),
        ),
      ),
    );
  }
}
```

---

### Step 6: Example Implementation - Submit Report (Public)

```dart
import 'dart:io';
import 'package:image_picker/image_picker.dart';

class SubmitReportPage extends StatefulWidget {
  @override
  _SubmitReportPageState createState() => _SubmitReportPageState();
}

class _SubmitReportPageState extends State<SubmitReportPage> {
  final _formKey = GlobalKey<FormState>();
  final _locationController = TextEditingController();
  final _waterHeightController = TextEditingController();
  
  File? _photo;
  final ImagePicker _picker = ImagePicker();
  
  bool _isLoading = false;
  
  Future<void> _pickPhoto() async {
    final XFile? image = await _picker.pickImage(
      source: ImageSource.camera,
      maxWidth: 1024,
      maxHeight: 1024,
      imageQuality: 85,
    );
    
    if (image != null) {
      setState(() {
        _photo = File(image.path);
      });
    }
  }
  
  Future<void> _submitReport() async {
    if (!_formKey.currentState!.validate()) return;
    
    setState(() => _isLoading = true);
    
    try {
      final token = await AuthManager().getToken();
      
      final response = await ApiService().uploadWithAuth(
        endpoint: '/public/report',
        token: token!,
        fields: {
          'location': _locationController.text,
          'water_height': _waterHeightController.text,
        },
        photo: _photo,
      );
      
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(response['message'])),
      );
      
      Navigator.pop(context);
      
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error: $e')),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Laporkan Banjir')),
      body: SingleChildScrollView(
        padding: EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              // Foto
              GestureDetector(
                onTap: _pickPhoto,
                child: Container(
                  height: 200,
                  width: double.infinity,
                  decoration: BoxDecoration(
                    border: Border.all(color: Colors.grey),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: _photo == null
                    ? Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(Icons.camera_alt, size: 50),
                          Text('Ambil Foto (Opsional)'),
                        ],
                      )
                    : Image.file(_photo!, fit: BoxFit.cover),
                ),
              ),
              SizedBox(height: 16),
              
              // Lokasi
              TextFormField(
                controller: _locationController,
                decoration: InputDecoration(
                  labelText: 'Lokasi',
                  hintText: 'Contoh: Jl. Raya No. 123, RT 01/05',
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Lokasi harus diisi';
                  }
                  return null;
                },
              ),
              SizedBox(height: 16),
              
              // Tinggi Air
              TextFormField(
                controller: _waterHeightController,
                decoration: InputDecoration(
                  labelText: 'Tinggi Air (cm)',
                  hintText: 'Contoh: 50',
                ),
                keyboardType: TextInputType.number,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Tinggi air harus diisi';
                  }
                  final num = double.tryParse(value);
                  if (num == null || num < 0) {
                    return 'Masukkan angka valid';
                  }
                  return null;
                },
              ),
              SizedBox(height: 24),
              
              // Submit Button
              _isLoading
                ? CircularProgressIndicator()
                : ElevatedButton(
                    onPressed: _submitReport,
                    child: Text('Kirim Laporan'),
                    style: ElevatedButton.styleFrom(
                      minimumSize: Size(double.infinity, 50),
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

---

### Step 7: Example Implementation - Display Stations

```dart
class StationsPage extends StatefulWidget {
  @override
  _StationsPageState createState() => _StationsPageState();
}

class _StationsPageState extends State<StationsPage> {
  final ApiService _apiService = ApiService();
  final AuthManager _authManager = AuthManager();
  
  List<dynamic> _stations = [];
  bool _isLoading = true;
  
  @override
  void initState() {
    super.initState();
    _loadStations();
  }
  
  Future<void> _loadStations() async {
    try {
      final token = await _authManager.getToken();
      final response = await _apiService.getWithAuth('/stations', token!);
      
      setState(() {
        _stations = response['data'];
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error: $e')),
      );
    }
  }
  
  Color _getStatusColor(String status) {
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
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Stasiun Pemantauan')),
      body: _isLoading
        ? Center(child: CircularProgressIndicator())
        : RefreshIndicator(
            onRefresh: _loadStations,
            child: ListView.builder(
              itemCount: _stations.length,
              itemBuilder: (context, index) {
                final station = _stations[index];
                
                return Card(
                  margin: EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                  child: ListTile(
                    leading: Icon(
                      Icons.water,
                      color: _getStatusColor(station['status']),
                      size: 40,
                    ),
                    title: Text(station['name']),
                    subtitle: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(station['location']),
                        SizedBox(height: 4),
                        Text(
                          'Tinggi Air: ${station['water_level']} cm',
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                      ],
                    ),
                    trailing: Chip(
                      label: Text(
                        station['status'].toUpperCase(),
                        style: TextStyle(color: Colors.white),
                      ),
                      backgroundColor: _getStatusColor(station['status']),
                    ),
                    onTap: () {
                      // Navigate to detail page
                    },
                  ),
                );
              },
            ),
          ),
    );
  }
}
```

---

## 🎨 UI/UX Recommendations

### Color Scheme
```dart
// Status colors
const Color colorNormal = Color(0xFF4CAF50);  // Green
const Color colorSiaga = Color(0xFFFF9800);   // Orange
const Color colorAwas = Color(0xFFF44336);    // Red

// Role colors
const Color colorAdmin = Color(0xFF2196F3);   // Blue
const Color colorOfficer = Color(0xFF9C27B0); // Purple
const Color colorPublic = Color(0xFF009688);  // Teal
```

### Icons
- Station: `Icons.water`
- Report: `Icons.report`
- SOS: `Icons.emergency`
- Notification: `Icons.notifications`
- Map: `Icons.map`

---

## 🔧 Testing

### Test dengan Postman atau cURL

#### Test Login:
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"warga1","password":"password"}'
```

#### Test Get Stations (dengan token):
```bash
curl -X GET http://localhost:8000/api/stations \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

---

## 📱 Test Users dari Seeder

### Admin
```
Username: admin
Password: password
```

### Petugas
```
Username: petugas1, petugas2
Password: password
```

### Warga
```
Username: warga1, warga2, warga3
Password: password
```

---

## 🐛 Troubleshooting

### 1. Connection Refused
**Problem:** `Failed to connect to localhost:8000`

**Solution:**
- Android Emulator: Gunakan `10.0.2.2` bukan `localhost`
- iOS Simulator: Gunakan `localhost`
- Physical Device: Gunakan IP komputer (cek dengan `ipconfig` atau `ifconfig`)

### 2. 401 Unauthorized
**Problem:** Token tidak valid

**Solution:**
- Pastikan token disimpan dengan benar
- Cek format header: `Bearer {token}`
- Token mungkin expired, login ulang

### 3. File Upload Error
**Problem:** Upload foto gagal

**Solution:**
- Pastikan `Content-Type: multipart/form-data`
- Cek ukuran file max 2MB
- Format harus jpg, jpeg, atau png

### 4. CORS Error (saat test di web)
**Problem:** CORS policy blocking

**Solution:**
- Tambahkan domain di `config/cors.php`
- Atau gunakan emulator/device

---

## 📚 Next Steps

1. ✅ Setup project structure
2. ✅ Implement authentication
3. ✅ Create API service layer
4. ⬜ Implement dashboard untuk setiap role
5. ⬜ Add map integration (Google Maps)
6. ⬜ Implement push notification UI
7. ⬜ Add offline support (local database)
8. ⬜ Testing & debugging
9. ⬜ Deployment preparation

---

## 💡 Pro Tips

1. **Gunakan Provider/Bloc** untuk state management yang lebih baik
2. **Implement retry mechanism** untuk request yang gagal
3. **Cache data** untuk mengurangi network call
4. **Show loading indicators** pada setiap async operation
5. **Handle errors gracefully** dengan user-friendly messages
6. **Add pull-to-refresh** di semua list pages
7. **Compress images** sebelum upload
8. **Test di real device** untuk push notification

---

Semoga dokumentasi ini membantu! 🚀

**Happy Coding!**
