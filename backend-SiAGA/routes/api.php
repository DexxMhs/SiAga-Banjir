<?php

use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\OfficerManagementController;
use App\Http\Controllers\Api\Admin\PublicReportAdminController;
use App\Http\Controllers\Api\Admin\RegionController;
use App\Http\Controllers\Api\Admin\ReportValidationController;
use App\Http\Controllers\Api\Admin\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Officer\OfficerReportController;
use App\Http\Controllers\Api\Public\PublicReportController;
use App\Http\Controllers\Api\Public\PublicStationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Rute Publik (Tanpa Token) ---

// Digunakan oleh masyarakat umum untuk mendaftar
Route::post('/register', [AuthController::class, 'register']); //tested

// Digunakan oleh Admin, Petugas, dan Public untuk masuk ke sistem
Route::post('/login', [AuthController::class, 'login']); //tested


// --- Rute Terproteksi (Memerlukan Bearer Token Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    // Mendapatkan data profil user yang sedang login
    Route::get('/user', function (Request $request) { //tested
        return $request->user();
    });

    // Menghapus token aktif dan keluar dari sistemsaya
    Route::post('/logout', [AuthController::class, 'logout']); //tested

    // Memperbarui token notif
    Route::post('/user/update-token', [AuthController::class, 'updateToken']); //tested

    // Endpoint Terbuka (Bisa dilihat tanpa login untuk beberapa info dasar)
    Route::get('/stations', [PublicStationController::class, 'index']); //tested
    Route::get('/stations/{id}', [PublicStationController::class, 'show']); //tested
    Route::get('/regions', [PublicStationController::class, 'regions']); //tested

    // Endpoint Khusus Warga Terdaftar (Membutuhkan Login)
    Route::middleware(['auth:sanctum', 'role:public'])->group(function () {
        Route::post('/public/report', [PublicReportController::class, 'store']); //tested
        Route::get('/public/area-status', [PublicReportController::class, 'areaStatus']); //tested
        Route::post('/public/emergency-report', [PublicReportController::class, 'emergency']); //tested
    });

    // Group khusus Petugas
    Route::middleware(['role:petugas'])->group(function () {
        // Ambil daftar stasiun yang ditugaskan ke petugas
        Route::get('/officer/stations', [OfficerReportController::class, 'getStations']); //tested

        // Membuat laporan lainnya
        Route::post('/officer/reports', [OfficerReportController::class, 'store']); //tested
        Route::get('/officer/reports', [OfficerReportController::class, 'index']); //tested
        Route::get('/officer/reports/{id}', [OfficerReportController::class, 'show']); //tested
    });

    // Group khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        // Admin - Stations
        Route::get('/admin/stations', [StationController::class, 'index']); //tested
        Route::post('/admin/stations', [StationController::class, 'store']); //tested
        Route::get('/admin/stations/{id}', [StationController::class, 'show']); //tested
        Route::put('/admin/stations/{id}', [StationController::class, 'update']); //tested
        Route::put('/admin/stations/{id}/status', [StationController::class, 'updateStatus']); //tested
        Route::delete('/admin/stations/{id}', [StationController::class, 'destroy']); //tested
        Route::put('/admin/stations/{id}/thresholds', [StationController::class, 'updateThresholds']); //tested
        Route::put('/admin/stations/{id}/assign-officers', [StationController::class, 'assignOfficers']); //tested

        // Admin - Officers Management
        Route::get('/admin/officers', [OfficerManagementController::class, 'index']); //tested
        Route::post('/admin/officers', [OfficerManagementController::class, 'store']); //tested
        Route::get('/admin/officers/{id}', [OfficerManagementController::class, 'show']); //tested
        Route::put('/admin/officers/{id}', [OfficerManagementController::class, 'update']); //tested
        Route::delete('/admin/officers/{id}', [OfficerManagementController::class, 'destroy']); //tested

        // Validasi Laporan Petugas
        Route::get('/admin/reports/officer', [ReportValidationController::class, 'index']); //tested
        Route::put('/admin/reports/officer/{id}/approve', [ReportValidationController::class, 'approve']); //tested
        Route::put('/admin/reports/officer/{id}/reject', [ReportValidationController::class, 'reject']); //tested

        // Monitoring Laporan Masyarakat
        Route::get('/admin/reports/public', [PublicReportAdminController::class, 'index']); //tested
        Route::put('/admin/reports/public/{id}', [PublicReportAdminController::class, 'update']); //tested

        // Manajemen Wilayah Potensial banjir
        Route::get('/admin/regions', [RegionController::class, 'index']); //tested
        Route::post('/admin/regions', [RegionController::class, 'store']); //tested
        Route::put('/admin/regions/{id}', [RegionController::class, 'update']); //tested

        // Pengaturan Template Notifikasi
        Route::get('/admin/notifications/rules', [NotificationController::class, 'getRules']);
        Route::put('/admin/notifications/rules/{id}', [NotificationController::class, 'updateRule']);

        // Broadcast Manual
        Route::post('/admin/notifications/broadcast', [NotificationController::class, 'broadcast']);
    });
});
