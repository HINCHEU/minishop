<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with USB receiver',
                'price' => 15.99,
                'stock' => 50,
                'image_url' => 'https://manhattanproducts.us/cdn/shop/products/wireless-ergonomic-mouse-with-2-in-1-usb-receiver-190237-1.jpg?v=1695233143',
                'status' => 'ACTIVE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical keyboard with blue switches',
                'price' => 49.99,
                'stock' => 30,
                'image_url' => 'https://cdn.shopify.com/s/files/1/2695/9506/products/K551RGB-2_450x450.png?v=1525704010',
                'status' => 'ACTIVE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming Headset',
                'description' => 'Surround sound gaming headset with microphone',
                'price' => 39.50,
                'stock' => 20,
                'image_url' => 'https://clearbuy-cloud.nyc3.digitaloceanspaces.com/media/9439/astroa10gen2.png',
                'status' => 'ACTIVE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB-C Charger',
                'description' => 'Fast charging USB-C wall charger 65W',
                'price' => 29.00,
                'stock' => 100,
                'image_url' => 'https://m.media-amazon.com/images/I/61c0UMl3MPL.jpg',
                'status' => 'ACTIVE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
