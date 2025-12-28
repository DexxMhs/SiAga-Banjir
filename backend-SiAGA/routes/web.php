<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/station', StationController::class);
    Route::get('/stations/export', [StationController::class, 'export'])->name('stations.export');

    Route::resource('/officer', OfficerController::class);
    Route::resource('/region', RegionController::class);
});
