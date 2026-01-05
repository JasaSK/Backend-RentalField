<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cegah duplicate jika seeder dijalankan ulang
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin12@gmail.com'],
            [
                'name'     => 'Super Admin',
                'no_telp'  => '081234567899',
                'password' => Hash::make('super1_admin2'),
                'role'     => 'superadmin',
            ]
        );

        // Buat / update email verification (auto verified)
        $superAdmin->emailVerification()->updateOrCreate(
            ['user_id' => $superAdmin->id],
            [
                'verification_code' => null,
                'expires_at'        => null,
            ]
        );

        // Jika pakai kolom email_verified_at di users
        if (Schema::hasColumn('users', 'email_verified_at')) {
            $superAdmin->update([
                'email_verified_at' => now(),
            ]);
        }
    }
}
