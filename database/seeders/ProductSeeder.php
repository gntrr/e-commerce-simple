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
        // Get the seller users that were created in DatabaseSeeder
        $seller1 = User::where('email', 'seller@example.com')->first();
        $seller2 = User::where('email', 'seller2@example.com')->first();
        
        if (!$seller1 || !$seller2) {
            throw new \Exception('Seller users not found. Make sure DatabaseSeeder runs first.');
        }

        $products = [
            // Products from Seller 1
            [
                'sku' => 'SPICE-001',
                'name' => 'Kayu Manis Ceylon',
                'description' => 'Kayu manis Ceylon premium kualitas terbaik, aroma harum dan rasa manis alami',
                'price' => 45000,
                'photo' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller1->id,
            ],
            [
                'sku' => 'SPICE-002',
                'name' => 'Lada Hitam Lampung',
                'description' => 'Lada hitam asli Lampung dengan cita rasa pedas yang khas dan aroma yang kuat',
                'price' => 65000,
                'photo' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller1->id,
            ],
            // Products from Seller 2 (Toko Rempah Nusantara)
            [
                'sku' => 'SPICE-003',
                'name' => 'Pala Banda',
                'description' => 'Pala asli Banda dengan aroma harum dan rasa yang hangat, cocok untuk masakan dan minuman',
                'price' => 85000,
                'photo' => 'https://images.unsplash.com/photo-1609501676725-7186f734b2b0?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller2->id,
            ],
            [
                'sku' => 'SPICE-004',
                'name' => 'Cengkeh Maluku',
                'description' => 'Cengkeh premium dari Maluku dengan aroma khas dan kualitas terjamin',
                'price' => 75000,
                'photo' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller2->id,
            ],
            [
                'sku' => 'SPICE-005',
                'name' => 'Kemiri Makassar',
                'description' => 'Kemiri asli Makassar untuk bumbu masakan tradisional Indonesia',
                'price' => 35000,
                'photo' => 'https://images.unsplash.com/photo-1599909533730-f9b2b3c0e7c5?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller2->id,
            ],
            [
                'sku' => 'SPICE-006',
                'name' => 'Jintan Putih',
                'description' => 'Jintan putih berkualitas tinggi untuk bumbu masakan dan obat tradisional',
                'price' => 25000,
                'photo' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=500&h=500&fit=crop&crop=center',
                'user_id' => $seller1->id,
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
