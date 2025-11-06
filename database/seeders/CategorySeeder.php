<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sembako',
                'slug' => 'sembako',
                'description' => 'Kebutuhan pokok sehari-hari',
                'icon' => 'fa-shopping-basket',
            ],
            [
                'name' => 'Buah & Sayur',
                'slug' => 'buah-sayur',
                'description' => 'Buah-buahan dan sayuran segar',
                'icon' => 'fa-apple-alt',
            ],
            [
                'name' => 'Makanan Ringan',
                'slug' => 'makanan-ringan',
                'description' => 'Snack dan makanan ringan',
                'icon' => 'fa-cookie-bite',
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Berbagai jenis minuman',
                'icon' => 'fa-glass-whiskey',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
