<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create seller users
        User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);

        User::factory()->create([
            'name' => 'Toko Rempah Nusantara',
            'email' => 'seller2@example.com',
            'role' => 'seller',
        ]);

        // Create customer users
        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'role' => 'customer',
        ]);

        // Create additional test users
        User::factory(5)->create();

        // Run product seeder
        $this->call(ProductSeeder::class);
    }
}
