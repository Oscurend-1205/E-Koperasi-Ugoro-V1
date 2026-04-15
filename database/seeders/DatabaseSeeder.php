<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's base users.
     */
    public function run(): void
    {
        // Sample Anggota
        User::updateOrCreate(
            ['no_anggota' => 'AGT001'],
            [
                'name' => 'Anggota Contoh',
                'nik' => '1234567890123456',
                'alamat' => 'Jl. Koperasi No. 1, Jakarta',
                'no_hp' => '081234567890',
                'email' => 'anggota@ugoro.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Specific User (Original Seeder)
        User::updateOrCreate(
            ['no_anggota' => '1036'],
            [
                'name' => 'Anggota Spesial',
                'nik' => '9876543210987654',
                'alamat' => 'Jl. Khusus No. 1036',
                'no_hp' => '089876543210',
                'email' => '1036@ugoro.com',
                'password' => Hash::make('btnd2'),
                'role' => 'user',
            ]
        );

        // Requested Demo User
        User::updateOrCreate(
            ['no_anggota' => '1234'],
            [
                'name' => 'User Demo',
                'nik' => '1234567890123456',
                'alamat' => 'Alamat Demo',
                'no_hp' => '081234567891',
                'email' => 'demo@ugoro.com',
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]
        );

        // Requested Admin User
        User::updateOrCreate(
            ['no_anggota' => '0000'],
            [
                'name' => 'Super Admin',
                'nik' => '0000000000000000',
                'alamat' => 'Kantor Pusat Koperasi Ugoro',
                'no_hp' => '080000000000',
                'email' => 'admin@ugoro.com',
                'password' => Hash::make('Koperasiugoro-admin0912#'),
                'role' => 'admin',
            ]
        );
    }
}
