<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Rute Portfolio Utama (Dinamis dari database MySQL)
Route::get('/', [PortfolioController::class, 'index']);

// Rute Detail Proyek (Dinamis dari database MySQL)
Route::get('/project-detail', [PortfolioController::class, 'showProjectDetail']);

// Rute untuk menyajikan gambar langsung dari kolom BLOB database MySQL
Route::get('/profile/image/{type}', function ($type) {
    if (!in_array($type, ['hero', 'about'])) {
        abort(404);
    }

    $profile = \App\Models\Profile::first();
    
    // Default gambar fallback jika data BLOB di database masih kosong
    $fallbackFile = ($type === 'about') 
        ? public_path('foto_pribadi/IMG_20250803_075342_629.webp') 
        : public_path('foto_pribadi/2211500030.jpg');

    if (!$profile) {
        return response()->file($fallbackFile);
    }

    $blob = ($type === 'hero') ? $profile->hero_image_blob : $profile->about_image_blob;
    $mime = ($type === 'hero') ? $profile->hero_image_mime : $profile->about_image_mime;

    // Jika data BLOB kosong di database, tampilkan file fisik lokal bawaan (backwards compatible)
    if (empty($blob)) {
        return response()->file($fallbackFile);
    }

    // Kembalikan file biner langsung ke client dengan header mime-type yang sesuai
    return response($blob)
        ->header('Content-Type', $mime ?? 'image/jpeg')
        ->header('Cache-Control', 'public, max-age=86400');
});


// Grup Rute Admin (dengan URL akses unik /portal-admin)
Route::group(['prefix' => 'portal-admin'], function () {
    // Tampilan Halaman Login
    Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');
    
    // Proses Autentikasi Login (Dibatasi 5 kali per menit)
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    
    // Rute panel admin yang dilindungi oleh middleware 'auth'
    Route::middleware(['auth'])->group(function () {
        // Halaman Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Proses Update Warna Tema Portofolio via AJAX (Rule 5)
        Route::post('/dashboard/update-colors', [AdminController::class, 'updateThemeColors'])->name('admin.update_theme_colors');
        
        // Tampilan Halaman Ubah Gambar
        Route::get('/ubah-gambar', [AdminController::class, 'showUbahGambar'])->name('admin.ubah_gambar');
        
        // Proses Unggah Gambar Hero/About via AJAX (Dibatasi 10 kali per menit per user untuk keamanan)
        Route::post('/ubah-gambar/upload', [AdminController::class, 'uploadGambar'])->middleware('throttle:10,1');
        
        // Proses Unggah Gambar My Gallery Baru via AJAX (my_galleries)
        Route::post('/ubah-gambar/upload-my-gallery', [AdminController::class, 'uploadMyGallery'])->middleware('throttle:10,1');
        
        // Proses Hapus Gambar My Gallery via AJAX (my_galleries)
        Route::delete('/ubah-gambar/delete-my-gallery/{id}', [AdminController::class, 'deleteMyGallery'])->name('admin.delete_my_gallery');
        
        // Proses Update Status My Gallery via AJAX (is_active / is_background)
        Route::post('/ubah-gambar/update-my-gallery-status/{id}', [AdminController::class, 'updateMyGalleryStatus'])->name('admin.update_my_gallery_status');
        
        // Tampilan Halaman Kelola Proyek (Project_Saya)
        Route::get('/kelola-proyek', [AdminController::class, 'showKelolaProyek'])->name('admin.kelola_proyek');
        
        // Proses Unggah/Edit Project Saya via AJAX (Project_Saya)
        Route::post('/kelola-proyek/upload', [AdminController::class, 'uploadProject'])->middleware('throttle:15,1');
        
        // Proses Hapus Project Saya via AJAX (Project_Saya)
        Route::delete('/kelola-proyek/delete/{id}', [AdminController::class, 'deleteProject'])->name('admin.delete_project');
        
        // Proses Keluar (Logout)
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
});
