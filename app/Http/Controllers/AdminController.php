<?php
namespace App\Http\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\GalleryMe;
use App\Models\ProjectsGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama admin beserta statistik ringkas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menghitung jumlah data statistik portofolio langsung dari database MySQL
        $stats = [
            'education_count'  => DB::table('educations')->count(),
            'experience_count' => DB::table('experiences')->count(),
            'skill_count'      => DB::table('skills')->count(),
            'message_count'    => DB::table('messages')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Menampilkan halaman formulir "Ubah & Tambah Gambar".
     *
     * @return \Illuminate\View\View
     */
    public function showUbahGambar()
    {
        $galleries = GalleryMe::all();
        $projectsGalleries = ProjectsGallery::all();
        return view('admin.ubah_gambar', compact('galleries', 'projectsGalleries'));
    }

    /**
     * Memproses unggahan berkas gambar dan menyimpannya langsung ke database MySQL (BLOB).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadGambar(Request $request)
    {
        // 1. Validasi masukan sisi server (Ukuran maksimal 5MB sesuai instruksi)
        $validator = Validator::make($request->all(), [
            'type'  => 'required|in:hero,about',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5120 KB = 5 MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan file berupa gambar (JPG/PNG/WEBP) dengan ukuran maksimal 5 MB.'
            ], 422);
        }

        $type = $request->input('type');
        $file = $request->file('image');

        try {
            // Membaca file gambar sebagai biner mentah (binary data)
            $binaryData = file_get_contents($file->getRealPath());
            $mimeType = $file->getMimeType();

            // Mendapatkan baris profil pertama dari MySQL
            $profile = Profile::first();

            if (!$profile) {
                // Jika profil kosong (misal instalasi baru), buat baris default
                $profile = Profile::create([
                    'name'        => 'Rakhmat Perdianto',
                    'title'       => 'Full Stack Developer & IT Support',
                    'bio'         => 'Lulusan Teknik Informatika yang adaptif dan berdedikasi...',
                    'email'       => 'rakhmatperdianto@gmail.com',
                    'phone'       => '088231197728',
                    'address'     => 'Pangkalpinang, Indonesia',
                    'profile_pic' => 'profile.jpg',
                ]);
            }

            // 2. Menyimpan data biner gambar langsung ke dalam kolom BLOB database (Rule 5)
            if ($type === 'hero') {
                $profile->hero_image_blob = $binaryData;
                $profile->hero_image_mime = $mimeType;
            } else {
                $profile->about_image_blob = $binaryData;
                $profile->about_image_mime = $mimeType;
            }

            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diunggah langsung ke database MySQL (Server Database)!'
            ]);

        } catch (\Exception $e) {
            // Catat log kesalahan keamanan/sistem jika proses gagal (Rule 22)
            log_message('error', 'Security Alert/Error: Gagal mengunggah gambar ke database. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan gambar ke database.'
            ], 500);
        }
    }

    /**
     * Memproses unggahan foto galeri baru (tabel gallery_me) langsung ke database MySQL (BLOB).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadGallery(Request $request)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan upload galeri tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Validasi gambar sisi server (maksimal 5MB sesuai instruksi)
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan file berupa gambar (JPG/PNG/WEBP) dengan ukuran maksimal 5 MB.'
            ], 422);
        }

        $file = $request->file('image');

        try {
            // Membaca file gambar sebagai biner mentah (binary data)
            $binaryData = file_get_contents($file->getRealPath());
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Simpan ke tabel gallery_me
            GalleryMe::create([
                'gallery'    => $binaryData,
                'name'       => $originalName,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil ditambahkan ke Galeri Aktivitas!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal menambahkan foto galeri. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan foto ke galeri.'
            ], 500);
        }
    }

    /**
     * Menghapus data foto galeri dari database MySQL.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGallery($id)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan menghapus galeri tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $gallery = GalleryMe::find($id);

            if (!$gallery) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data gambar tidak ditemukan.'
                ], 404);
            }

            // Hapus baris data dari database
            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto galeri berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal menghapus foto galeri ID ' . $id . '. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghapus gambar.'
            ], 500);
        }
    }

    /**
     * Memproses unggahan foto galeri proyek baru (tabel projects_gallery) langsung ke database MySQL (BLOB).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadProjectsGallery(Request $request)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan upload projects_gallery tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Validasi gambar sisi server (maksimal 5MB)
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan file berupa gambar (JPG/PNG/WEBP) dengan ukuran maksimal 5 MB.'
            ], 422);
        }

        $file = $request->file('image');

        try {
            // Membaca file gambar sebagai biner mentah (binary data)
            $binaryData = file_get_contents($file->getRealPath());
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Simpan ke tabel projects_gallery
            ProjectsGallery::create([
                'gallery'    => $binaryData,
                'name'       => $originalName,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil ditambahkan ke Galeri Proyek!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal menambahkan foto projects_gallery. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan foto ke galeri proyek.'
            ], 500);
        }
    }

    /**
     * Menghapus data foto galeri proyek dari database MySQL.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProjectsGallery($id)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan menghapus projects_gallery tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $gallery = ProjectsGallery::find($id);

            if (!$gallery) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data gambar galeri proyek tidak ditemukan.'
                ], 404);
            }

            // Hapus baris data dari database
            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto galeri proyek berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal menghapus projects_gallery ID ' . $id . '. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghapus gambar galeri proyek.'
            ], 500);
        }
    }
}
