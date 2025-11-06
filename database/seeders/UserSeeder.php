<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Pangara',
            'email' => 'admin.pangara@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
            'avatar' => null,
        ]);

        // Kasir User
        User::create([
            'name' => 'Kasir Pangara',
            'email' => 'kasir.pangara@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('kasir12345'),
            'role' => 'kasir',
            'phone' => '081234567891',
            'address' => 'Bandung, Indonesia',
            'avatar' => null,
        ]);

        // Pembeli User
        User::create([
            'name' => 'Pembeli Pangara',
            'email' => 'pembeli.pangara@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('pembeli12345'),
            'role' => 'pembeli',
            'phone' => '081234567892',
            'address' => 'Surabaya, Indonesia',
            'avatar' => null,
        ]);
    }
}
