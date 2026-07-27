<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rute Portfolio Utama
Route::get('/', function () {
    return view('portfolio');
});

// Rute Detail Proyek
Route::get('/project-detail', function () {
    return view('project-detail');
});

// Grup Rute Admin (dengan URL akses unik /portal-admin)
Route::group(['prefix' => 'portal-admin'], function () {
    // Tampilan Halaman Login
    Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');
    
    // Proses Autentikasi Login (Dibatasi 5 kali per menit)
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    
    // Halaman Dashboard Admin
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    
    // Proses Keluar (Logout)
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
