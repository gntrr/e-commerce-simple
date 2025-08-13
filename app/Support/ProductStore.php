<?php

namespace App\Support;

class ProductStore
{
    public static function all(): array
    {
        $jsonPath = storage_path('app/products.json');
        
        if (!file_exists($jsonPath)) {
            return [];
        }
        
        $jsonContent = file_get_contents($jsonPath);
        return json_decode($jsonContent, true) ?: [];
    }
    
    public static function findBySku(string $sku): ?array
    {
        $products = self::all();
        
        foreach ($products as $product) {
            if ($product['sku'] === $sku) {
                return $product;
            }
        }
        
        return null;
    }
}