<?php
namespace App\Http\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\MyGallery;
use App\Models\ProjectSaya;
use Illuminate\Http\Request;
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
        
        // Mengambil gambar untuk galeri yang aktif (Rule 14 & 15)
        $myGalleries = MyGallery::where('is_active', true)->get();
        
        // Mengambil gambar latar belakang (body background) utama jika diset
        $backgroundImage = MyGallery::where('is_background', true)->first();
        
        // Mengambil seluruh data proyek dari tabel Project_Saya
        $projects = ProjectSaya::all();

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
            'myGalleries',
            'backgroundImage',
            'projects'
        ));
    }

    /**
     * Menampilkan halaman detail proyek dinamis berdasarkan query parameter 'project' (ID).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showProjectDetail(Request $request)
    {
        $projectId = $request->query('project');
        
        // Cari proyek berdasarkan ID di tabel Project_Saya menggunakan Eloquent
        $project = ProjectSaya::find($projectId);

        return view('project-detail', compact('project'));
    }
}
