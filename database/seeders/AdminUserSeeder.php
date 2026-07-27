<?php
namespace Database\Seeders;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Cari pengguna dengan username admin
        $admin = User::where('username', 'admin')->first();

        if ($admin) {
            // Update password menjadi 'password123'
            $admin->update([
                'password' => Hash::make('password123'),
                'name' => 'Rakhmat Perdianto'
            ]);
            $this->command->info('Akun admin berhasil diperbarui dengan password: password123');
        } else {
            // Buat baru jika belum ada
            User::create([
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'name' => 'Rakhmat Perdianto'
            ]);
            $this->command->info('Akun admin baru berhasil dibuat dengan password: password123');
        }
    }
}
