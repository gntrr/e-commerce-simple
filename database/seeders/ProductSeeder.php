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
                'photo' => 'https://i.cdn.newsbytesapp.com/ind/images/l14520210518153604.jpeg',
                'user_id' => $seller1->id,
            ],
            [
                'sku' => 'SPICE-002',
                'name' => 'Lada Hitam Lampung',
                'description' => 'Lada hitam asli Lampung dengan cita rasa pedas yang khas dan aroma yang kuat',
                'price' => 65000,
                'photo' => 'https://media.suara.com/pictures/970x544/2014/07/30/shutterstock_29417425.jpg',
                'user_id' => $seller1->id,
            ],
            // Products from Seller 2 (Toko Rempah Nusantara)
            [
                'sku' => 'SPICE-003',
                'name' => 'Pala Banda',
                'description' => 'Pala asli Banda dengan aroma harum dan rasa yang hangat, cocok untuk masakan dan minuman',
                'price' => 85000,
                'photo' => 'https://blogger.googleusercontent.com/img/a/AVvXsEhX8rW5GasqxiT4C-sO4_yAJFDy_HymALl8YraQKc5PPuXSmFsU_hZkAHdhlBhVldzI4xgxkJ5YRjAb4G8MERqSEz2Hatoyw04LSKfazF5LBb-o4-YiRdZflHGY0TurpyNooPAQn9xY0Z5bJ8sA-bJf_W2R2nP1udOz31cEN8kka7Lolvt_N3Dfu65AHQ=s16000',
                'user_id' => $seller2->id,
            ],
            [
                'sku' => 'SPICE-004',
                'name' => 'Cengkeh Maluku',
                'description' => 'Cengkeh premium dari Maluku dengan aroma khas dan kualitas terjamin',
                'price' => 75000,
                'photo' => 'https://asset.kompas.com/crops/IAEIZq2paUrJvtaL0vh0fH_YDG8=/195x128:1725x1148/1200x800/data/photo/2021/08/17/611b37f99b727.jpg',
                'user_id' => $seller2->id,
            ],
            [
                'sku' => 'SPICE-005',
                'name' => 'Kemiri Makassar',
                'description' => 'Kemiri asli Makassar untuk bumbu masakan tradisional Indonesia',
                'price' => 35000,
                'photo' => 'https://res.cloudinary.com/dk0z4ums3/image/upload/v1671590469/attached_image/kemiri-ketahui-kandungan-dan-manfaatnya-untuk-kesehatan.jpg',
                'user_id' => $seller2->id,
            ],
            [
                'sku' => 'SPICE-006',
                'name' => 'Jintan Putih',
                'description' => 'Jintan putih berkualitas tinggi untuk bumbu masakan dan obat tradisional',
                'price' => 25000,
                'photo' => 'https://cdn.rri.co.id/berita/Tahuna/o/1719400552938-Jintan_(StockImageFactory.com-Shutterstock)/aljxrd8crmxcxwj.jpeg',
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
