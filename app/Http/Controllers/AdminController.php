<?php
namespace App\Http\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\MyGallery;
use App\Models\ProjectSaya;
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

        // Mengambil profil untuk data kustomisasi warna
        $profile = Profile::first();

        return view('admin.dashboard', compact('stats', 'profile'));
    }

    /**
     * Memperbarui kustomisasi warna tema dinamis (primary, secondary, accent) di database MySQL.
     * Jika request mengandung reset, warna akan dikembalikan ke nilai NULL (default).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateThemeColors(Request $request)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan modifikasi warna tema tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Validasi input warna berupa kode HEX valid dan opasitas desimal (Rule 13)
        $validator = Validator::make($request->all(), [
            'primary_color'   => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'accent_color'    => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'primary_opacity' => 'nullable|numeric|between:0,1',
            'navigator_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'reset'           => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan format warna adalah kode HEX valid (misal: #293681) dan opasitas antara 0 dan 1.'
            ], 422);
        }

        try {
            $profile = Profile::first();
            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil tidak ditemukan.'
                ], 404);
            }

            if ($request->input('reset')) {
                // Reset warna tema ke NULL / Default (kembali ke default CSS)
                $profile->primary_color = null;
                $profile->secondary_color = null;
                $profile->accent_color = null;
                $profile->primary_opacity = '0.85';
                $profile->navigator_color = null;
            } else {
                // Perbarui warna sesuai input
                $profile->primary_color = $request->input('primary_color');
                $profile->secondary_color = $request->input('secondary_color');
                $profile->accent_color = $request->input('accent_color');
                $profile->primary_opacity = $request->input('primary_opacity', '0.85');
                $profile->navigator_color = $request->input('navigator_color');
            }

            $profile->save();

            return response()->json([
                'success' => true,
                'message' => $request->input('reset') 
                    ? 'Warna tema berhasil direset ke pengaturan default CSS!' 
                    : 'Warna tema portofolio berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error: Gagal memperbarui warna tema. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat memperbarui warna tema.'
            ], 500);
        }
    }

    /**
     * Menampilkan halaman formulir "Ubah & Tambah Gambar".
     *
     * @return \Illuminate\View\View
     */
    public function showUbahGambar()
    {
        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create([
                'name'        => 'Rakhmat Perdianto',
                'title'       => 'Berdedikasi merancang dan membangun sistem web berkinerja tinggi yang responsif, aman, dan berestetika modern. Spesialisasi dalam ekosistem PHP (Laravel, CodeIgniter), JavaScript, dan Tailwind CSS.',
                'bio'         => 'Lulusan Teknik Informatika yang adaptif dan berdedikasi dengan pengalaman praktis dalam pengembangan web (Full Stack) menggunakan PHP, CodeIgniter 3, dan JavaScript, serta dukungan teknologi (IT Support).',
                'email'       => 'rakhmatperdianto@gmail.com',
                'phone'       => '088231197728',
                'address'     => 'Pangkalpinang, Indonesia',
                'profile_pic' => 'profile.jpg',
            ]);
        }
        $myGalleries = MyGallery::all();
        return view('admin.ubah_gambar', compact('myGalleries', 'profile'));
    }

    /**
     * Menampilkan halaman kelola proyek (Project_Saya).
     *
     * @return \Illuminate\View\View
     */
    public function showKelolaProyek()
    {
        $projects = ProjectSaya::all();
        return view('admin.kelola_proyek', compact('projects'));
    }

    /**
     * Memproses unggahan berkas gambar dan menyimpannya langsung ke database MySQL (BLOB).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadGambar(Request $request)
    {
        // 1. Validasi masukan sisi server
        $validator = Validator::make($request->all(), [
            'type'  => 'required|in:hero,about',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'name'  => 'nullable|string|max:100',
            'title' => 'nullable|string|max:500',
            'bio'   => 'nullable|string|max:1000',
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
            // Mendapatkan baris profil pertama dari MySQL
            $profile = Profile::first();

            if (!$profile) {
                // Jika profil kosong (misal instalasi baru), buat baris default
                $profile = Profile::create([
                    'name'        => 'Rakhmat Perdianto',
                    'title'       => 'Berdedikasi merancang dan membangun sistem web berkinerja tinggi yang responsif, aman, dan berestetika modern. Spesialisasi dalam ekosistem PHP (Laravel, CodeIgniter), JavaScript, dan Tailwind CSS.',
                    'bio'         => 'Lulusan Teknik Informatika yang adaptif dan berdedikasi dengan pengalaman praktis dalam pengembangan web (Full Stack) menggunakan PHP, CodeIgniter 3, dan JavaScript, serta dukungan teknologi (IT Support).',
                    'email'       => 'rakhmatperdianto@gmail.com',
                    'phone'       => '088231197728',
                    'address'     => 'Pangkalpinang, Indonesia',
                    'profile_pic' => 'profile.jpg',
                ]);
            }

            // Simpan gambar jika ada file yang diunggah
            if ($file) {
                $binaryData = file_get_contents($file->getRealPath());
                $mimeType = $file->getMimeType();

                if ($type === 'hero') {
                    $profile->hero_image_blob = $binaryData;
                    $profile->hero_image_mime = $mimeType;
                } else {
                    $profile->about_image_blob = $binaryData;
                    $profile->about_image_mime = $mimeType;
                }
            }

            // Jika tipe adalah hero, perbarui nama dan subtitle (title) jika disediakan
            if ($type === 'hero') {
                if ($request->has('name')) {
                    $profile->name = $request->input('name');
                }
                if ($request->has('title')) {
                    $profile->title = $request->input('title');
                }
            } elseif ($type === 'about') {
                if ($request->has('bio')) {
                    $profile->bio = $request->input('bio');
                }
            }

            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            // Catat log kesalahan keamanan/sistem jika proses gagal (Rule 22)
            log_message('error', 'Security Alert/Error: Gagal memperbarui profil. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat memperbarui profil.'
            ], 500);
        }
    }



    /**
     * Memproses unggahan foto my_gallery baru (tabel my_galleries) ke penyimpanan disk lokal dan database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadMyGallery(Request $request)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan upload my_gallery tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Validasi gambar sisi server (maksimal 5MB)
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title'         => 'required|string|max:255',
            'caption'       => 'nullable|string|max:1000',
            'is_active'     => 'nullable',
            'is_background' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan file berupa gambar (JPG/PNG/WEBP, maks 5MB) dan judul diisi.'
            ], 422);
        }

        $file = $request->file('image');
        $title = $request->input('title');
        $caption = $request->input('caption');
        
        // Membaca status checkbox dari input (Rule 13)
        $isBackground = $request->has('is_background');
        $isActive = $request->has('is_active');

        try {
            // Simpan file ke directory storage/app/public/my_gallery
            $path = $file->store('my_gallery', 'public');

            // Jika checkbox is_background diaktifkan, reset background aktif lainnya terlebih dahulu
            if ($isBackground) {
                MyGallery::where('is_background', true)->update(['is_background' => false]);
            }

            // Simpan ke database menggunakan Eloquent Model MyGallery
            MyGallery::create([
                'title'         => $title,
                'image_path'    => $path,
                'caption'       => $caption,
                'is_active'     => $isActive,
                'is_background' => $isBackground,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil ditambahkan ke My Gallery!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal menambahkan foto my_gallery. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan foto ke My Gallery.'
            ], 500);
        }
    }

    /**
     * Memperbarui status is_active (tampil di galeri) atau is_background (latar belakang halaman) secara asinkron (AJAX).
     * Logika ini mematikan background aktif lainnya jika gambar ini diset sebagai background.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMyGalleryStatus(Request $request, $id)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan modifikasi status my_gallery tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Validasi parameter request
        $validator = Validator::make($request->all(), [
            'field' => 'required|in:is_active,is_background',
            'value' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Masukan status tidak valid.'
            ], 422);
        }

        $field = $request->input('field');
        $value = filter_var($request->input('value'), FILTER_VALIDATE_BOOLEAN);

        try {
            // Dapatkan entri berdasarkan ID
            $gallery = MyGallery::find($id);

            if (!$gallery) {
                return response()->json([
                    'success' => false,
                    'message' => 'Foto tidak ditemukan.'
                ], 404);
            }

            // Jika bidang yang dirubah adalah background dan nilainya true
            if ($field === 'is_background') {
                if ($value === true) {
                    // Matikan seluruh status background lainnya terlebih dahulu
                    MyGallery::where('is_background', true)->update(['is_background' => false]);
                    $gallery->is_background = true;
                } else {
                    $gallery->is_background = false;
                }
            } else {
                // Merubah status keaktifan di dalam Galeri Aktivitas
                $gallery->is_active = $value;
            }

            $gallery->save();

            return response()->json([
                'success' => true,
                'message' => 'Pembaruan status berhasil disimpan!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error: Gagal memperbarui status gallery ID ' . $id . '. Pesan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat memperbarui status.'
            ], 500);
        }
    }

    /**
     * Menghapus data foto my_gallery dari database dan disk penyimpanan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMyGallery($id)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan menghapus my_gallery tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $gallery = MyGallery::find($id);

            if (!$gallery) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data My Gallery tidak ditemukan.'
                ], 404);
            }

            // Hapus file fisik dari public storage jika ada
            if ($gallery->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->image_path);
            }

            // Hapus baris data dari database
            $gallery->delete();
 
             return response()->json([
                 'success' => true,
                 'message' => 'Foto My Gallery berhasil dihapus.'
             ]);
 
         } catch (\Exception $e) {
             log_message('error', 'Security Alert/Error: Gagal menghapus my_gallery ID ' . $id . '. Pesan: ' . $e->getMessage());
 
             return response()->json([
                 'success' => false,
                 'message' => 'Terjadi kesalahan sistem saat menghapus gambar dari My Gallery.'
             ], 500);
         }
     }

    /**
     * Memproses penambahan atau pengubahan data proyek (Project_Saya) beserta gambarnya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadProject(Request $request)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan modifikasi Project_Saya tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Validasi masukan
        $validator = Validator::make($request->all(), [
            'id'             => 'nullable|integer|exists:Project_Saya,id',
            'nama'           => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Maksimal 5MB
            'caption'        => 'nullable|string',
            'Work_Story'     => 'nullable|string',
            'Main_Features'  => 'nullable|string',
            'Kategori'       => 'nullable|string|max:100',
            'Tanggal_Proyek' => 'nullable|string|max:100',
            'Role'           => 'nullable|string|max:100',
            'Teknologi'      => 'nullable|string',
            'url_code'       => 'nullable|url|max:255',
            'url_demo'       => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Pastikan seluruh bidang diisi dengan benar dan file berupa gambar (maks 5MB).'
            ], 422);
        }

        try {
            $projectId = $request->input('id');
            $project = $projectId ? ProjectSaya::find($projectId) : new ProjectSaya();

            $project->nama           = $request->input('nama');
            $project->caption        = $request->input('caption');
            $project->Work_Story     = $request->input('Work_Story');
            $project->Main_Features  = $request->input('Main_Features');
            $project->Kategori       = $request->input('Kategori');
            $project->Tanggal_Proyek = $request->input('Tanggal_Proyek');
            $project->Role           = $request->input('Role');
            $project->Teknologi      = $request->input('Teknologi');
            $project->url_code       = $request->input('url_code');
            $project->url_demo       = $request->input('url_demo');

            // Simpan berkas gambar jika ada file baru diunggah
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ini proses edit dan gambar lama ada
                if ($projectId && $project->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($project->image_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($project->image_path);
                }

                $file = $request->file('image');
                $path = $file->store('project_images', 'public');
                $project->image_path = $path;
            }

            $project->save();

            return response()->json([
                'success' => true,
                'message' => $projectId ? 'Data proyek berhasil diperbarui!' : 'Proyek baru berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal memproses data Project_Saya. Pesan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan data proyek.'
            ], 500);
        }
    }

    /**
     * Menghapus data proyek (Project_Saya) beserta berkas gambarnya dari server.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProject($id)
    {
        // Pengecekan hak akses admin (Rule 15 & 17)
        if (!auth()->check()) {
            log_message('error', 'Security Alert: Percobaan menghapus Project_Saya tanpa autentikasi.');
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            $project = ProjectSaya::find($id);

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data proyek tidak ditemukan.'
                ], 404);
            }

            // Hapus berkas gambar fisik dari storage
            if ($project->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($project->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($project->image_path);
            }

            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proyek berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Security Alert/Error: Gagal menghapus Project_Saya ID ' . $id . '. Pesan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghapus data proyek.'
            ], 500);
        }
    }
}

