<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Headphone Wireless Premium',
                'description' => 'Headphone wireless dengan kualitas suara premium, noise cancellation, dan baterai tahan lama hingga 30 jam',
                'sku' => 'HP-WRL-001',
                'price' => 399000,
                'discount_price' => 299000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                'category' => 'Audio',
                'is_active' => true,
            ],
            [
                'name' => 'Smart Watch Series 5',
                'description' => 'Smart watch dengan fitur lengkap, GPS, heart rate monitor, dan waterproof',
                'sku' => 'SW-SER5-001',
                'price' => 1599000,
                'discount_price' => 1299000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                'category' => 'Wearable',
                'is_active' => true,
            ],
            [
                'name' => 'Sunglasses Classic',
                'description' => 'Kacamata hitam dengan UV protection dan frame premium',
                'sku' => 'SG-CLS-001',
                'price' => 299000,
                'discount_price' => 199000,
                'stock' => 100,
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500',
                'category' => 'Fashion',
                'is_active' => true,
            ],
            [
                'name' => 'Sneakers Sport Pro',
                'description' => 'Sepatu olahraga dengan teknologi cushioning terbaru dan desain modern',
                'sku' => 'SNK-SPR-001',
                'price' => 1199000,
                'discount_price' => 899000,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=500',
                'category' => 'Fashion',
                'is_active' => true,
            ],
            [
                'name' => 'Mechanical Keyboard RGB',
                'description' => 'Keyboard mechanical dengan RGB lighting dan switch cherry MX',
                'sku' => 'KB-MCH-001',
                'price' => 899000,
                'discount_price' => 749000,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500',
                'category' => 'Computer',
                'is_active' => true,
            ],
            [
                'name' => 'Gaming Mouse Pro',
                'description' => 'Mouse gaming dengan sensor optical 16000 DPI dan RGB lighting',
                'sku' => 'MS-GMG-001',
                'price' => 599000,
                'discount_price' => 449000,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500',
                'category' => 'Computer',
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Earbuds',
                'description' => 'Earbuds wireless dengan active noise cancellation dan case charging',
                'sku' => 'EB-WRL-001',
                'price' => 499000,
                'discount_price' => 399000,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500',
                'category' => 'Audio',
                'is_active' => true,
            ],
            [
                'name' => 'Backpack Laptop 15"',
                'description' => 'Tas ransel laptop dengan kompartmen banyak dan desain anti air',
                'sku' => 'BP-LPT-001',
                'price' => 349000,
                'discount_price' => 279000,
                'stock' => 70,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500',
                'category' => 'Accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Power Bank 20000mAh',
                'description' => 'Power bank kapasitas besar dengan fast charging dan dual USB port',
                'sku' => 'PB-20K-001',
                'price' => 249000,
                'discount_price' => 189000,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500',
                'category' => 'Electronics',
                'is_active' => true,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Speaker bluetooth portable dengan bass yang powerful dan waterproof',
                'sku' => 'SPK-BLT-001',
                'price' => 449000,
                'discount_price' => 349000,
                'stock' => 55,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',
                'category' => 'Audio',
                'is_active' => true,
            ],
            [
                'name' => 'USB-C Hub 7 in 1',
                'description' => 'USB hub dengan berbagai port: HDMI, USB 3.0, SD card reader',
                'sku' => 'HUB-USC-001',
                'price' => 299000,
                'discount_price' => 249000,
                'stock' => 90,
                'image' => 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=500',
                'category' => 'Computer',
                'is_active' => true,
            ],
            [
                'name' => 'Webcam HD 1080p',
                'description' => 'Webcam dengan resolusi full HD dan built-in microphone',
                'sku' => 'WBC-HD-001',
                'price' => 399000,
                'discount_price' => 329000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=500',
                'category' => 'Computer',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
