<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Rute Portfolio Utama (Dinamis dari database MySQL)
Route::get('/', [PortfolioController::class, 'index']);

// Rute Detail Proyek
Route::get('/project-detail', function () {
    return view('project-detail');
});

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

// Rute untuk menyajikan gambar galeri langsung dari tabel gallery_me database MySQL
Route::get('/gallery/image/{id}', [PortfolioController::class, 'serveGalleryImage'])->name('gallery.image');

// Rute untuk menyajikan gambar galeri proyek dari tabel projects_gallery database MySQL
Route::get('/projects-gallery/image/{id}', [PortfolioController::class, 'serveProjectsGalleryImage'])->name('projects_gallery.image');

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
        
        // Tampilan Halaman Ubah Gambar
        Route::get('/ubah-gambar', [AdminController::class, 'showUbahGambar'])->name('admin.ubah_gambar');
        
        // Proses Unggah Gambar Hero/About via AJAX (Dibatasi 10 kali per menit per user untuk keamanan)
        Route::post('/ubah-gambar/upload', [AdminController::class, 'uploadGambar'])->middleware('throttle:10,1');
        
        // Proses Unggah Gambar Galeri Baru via AJAX (Dibatasi 10 kali per menit per user untuk keamanan)
        Route::post('/ubah-gambar/upload-gallery', [AdminController::class, 'uploadGallery'])->middleware('throttle:10,1');
        
        // Proses Hapus Gambar Galeri via AJAX
        Route::delete('/ubah-gambar/delete-gallery/{id}', [AdminController::class, 'deleteGallery'])->name('admin.delete_gallery');

        // Proses Unggah Gambar Galeri Proyek Baru via AJAX (projects_gallery)
        Route::post('/ubah-gambar/upload-projects-gallery', [AdminController::class, 'uploadProjectsGallery'])->middleware('throttle:10,1');
        
        // Proses Hapus Gambar Galeri Proyek via AJAX (projects_gallery)
        Route::delete('/ubah-gambar/delete-projects-gallery/{id}', [AdminController::class, 'deleteProjectsGallery'])->name('admin.delete_projects_gallery');
        
        // Proses Keluar (Logout)
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
});
