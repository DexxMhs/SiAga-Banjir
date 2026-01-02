<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\OfficerReportController;
use App\Http\Controllers\Admin\PublicReportController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CitizenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/stations', StationController::class);
    Route::get('/stations/export', [StationController::class, 'export'])->name('stations.export');

    Route::resource('/officers', OfficerController::class);

    Route::resource('/region', RegionController::class);

    Route::get('officer-reports/export', [OfficerReportController::class, 'export'])->name('officer-reports.export');
    Route::resource('/officer-reports', OfficerReportController::class);
    Route::get('officer-reports/{id}/print', [OfficerReportController::class, 'print'])->name('officer-reports.print');

    Route::get('public-reports/export', [PublicReportController::class, 'export'])->name('public-reports.export');
    Route::resource('/public-reports', PublicReportController::class);
    Route::get('public-reports/{id}/print', [PublicReportController::class, 'print'])->name('public-reports.print');

    Route::resource('/citizens', CitizenController::class);
});
