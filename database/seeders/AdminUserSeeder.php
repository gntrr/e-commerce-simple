<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user admin jika belum ada
        User::firstOrCreate(
            ['email' => 'admin@spicestore.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@spicestore.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@spicestore.com');
        $this->command->info('Password: admin123');
        $this->command->warn('Please change the password after first login!');
    }
}