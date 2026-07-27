<?php
namespace App\Http\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\GalleryMe;
use App\Models\ProjectsGallery;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    /**
     * Menampilkan halaman depan portfolio dengan data dinamis dari MySQL.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Mengambil data profil utama dari MySQL
        $profile = Profile::first();

        // Jika profil kosong (instalasi pertama kali), buat profil default
        if (!$profile) {
            $profile = Profile::create([
                'name'        => 'Rakhmat Perdianto',
                'title'       => 'Full Stack Developer & IT Support',
                'bio'         => 'Lulusan Teknik Informatika yang adaptif dan berdedikasi dengan pengalaman praktis dalam pengembangan web (Full Stack) menggunakan PHP, CodeIgniter 3, dan JavaScript, serta dukungan teknologi (IT Support).',
                'email'       => 'rakhmatperdianto@gmail.com',
                'phone'       => '088231197728',
                'address'     => 'Pangkalpinang, Indonesia',
                'profile_pic' => 'profile.jpg',
            ]);
        }

        // 2. Mengambil data riwayat pendidikan, pengalaman, keahlian, dan galeri
        $skills = DB::table('skills')->get();
        $educations = DB::table('educations')->get();
        $experiences = DB::table('experiences')->orderBy('order_num', 'asc')->get();
        $achievements = DB::table('achievements')->get();
        $certifications = DB::table('certifications')->get();
        $galleries = GalleryMe::all();
        $projectsGalleries = ProjectsGallery::all();

        // Mengelompokkan skill berdasarkan kategori untuk memudahkan render tabel di view
        $groupedSkills = [];
        foreach ($skills as $skill) {
            $groupedSkills[$skill->category][] = $skill->name;
        }

        return view('portfolio', compact(
            'profile',
            'skills',
            'groupedSkills',
            'educations',
            'experiences',
            'achievements',
            'certifications',
            'galleries',
            'projectsGalleries'
        ));
    }

    /**
     * Menyajikan data biner (BLOB) gambar galeri langsung dari tabel gallery_me database MySQL.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function serveGalleryImage($id)
    {
        $gallery = GalleryMe::find($id);
        
        if (!$gallery || empty($gallery->gallery)) {
            abort(404);
        }

        return response($gallery->gallery)
            ->header('Content-Type', 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Menyajikan data biner (BLOB) gambar galeri proyek langsung dari tabel projects_gallery database MySQL.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function serveProjectsGalleryImage($id)
    {
        $gallery = ProjectsGallery::find($id);
        
        if (!$gallery || empty($gallery->gallery)) {
            abort(404);
        }

        return response($gallery->gallery)
            ->header('Content-Type', 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
