<?php
namespace App\Http\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        // Jika sudah login, langsung alihkan ke dashboard (atau halaman portfolio)
        if (Auth::check()) {
            return redirect()->intended('/portal-admin/dashboard');
        }

        return view('admin.login');
    }

    /**
     * Memproses permintaan login via AJAX POST.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi input sisi server dengan form_validation / Validator
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:50',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Input tidak valid. Silakan periksa kembali format pengisian Anda.'
            ], 422);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // 2. Mencoba autentikasi menggunakan Laravel Auth
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk menghindari session fixation
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil! Mengalihkan ke dashboard...',
                'redirect' => url('/portal-admin/dashboard')
            ]);
        }

        // 3. Jika gagal login, catat log kesalahan keamanan (Rule 22)
        // Karena login gagal, kita tidak punya User ID, jadi kita catat username-nya.
        log_message('error', 'Security Alert: Unauthorized access attempt by username: ' . html_escape($request->username));

        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah. Silakan coba lagi.'
        ], 401);
    }

    /**
     * Menampilkan halaman dashboard admin (sementara/awal).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            // Jika ada percobaan akses ilegal ke dashboard, catat log keamanan
            log_message('error', 'Security Alert: Unauthorized access attempt by User ID guest');
            return redirect('/portal-admin')->with('error', 'Anda harus login terlebih dahulu.');
        }

        return view('admin.dashboard');
    }

    /**
     * Memproses logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/portal-admin')->with('success', 'Anda telah berhasil keluar.');
    }
}
