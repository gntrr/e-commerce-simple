<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default seller user if not exists
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Default Seller',
                'password' => bcrypt('password'),
            ]
        );

        $products = [
            [
                'sku' => 'SPICE-001',
                'name' => 'Kayu Manis Ceylon',
                'description' => 'Kayu manis Ceylon premium kualitas terbaik, aroma harum dan rasa manis alami',
                'price' => 45000,
                'photo' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller->id,
            ],
            [
                'sku' => 'SPICE-002',
                'name' => 'Lada Hitam Lampung',
                'description' => 'Lada hitam asli Lampung dengan cita rasa pedas yang khas dan aroma yang kuat',
                'price' => 65000,
                'photo' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller->id,
            ],
            [
                'sku' => 'SPICE-003',
                'name' => 'Pala Banda',
                'description' => 'Pala asli Banda dengan aroma harum dan rasa yang hangat, cocok untuk masakan dan minuman',
                'price' => 85000,
                'photo' => 'https://images.unsplash.com/photo-1609501676725-7186f734b2b0?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller->id,
            ],
            [
                'sku' => 'SPICE-004',
                'name' => 'Cengkeh Maluku',
                'description' => 'Cengkeh premium dari Maluku dengan aroma khas dan kualitas terjamin',
                'price' => 75000,
                'photo' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );
        }
    }
}
