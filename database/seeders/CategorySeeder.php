<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Berbagai jenis makanan dan minuman lokal',
                'is_active' => true,
            ],
            [
                'name' => 'Kerajinan Tangan',
                'description' => 'Produk kerajinan tangan buatan lokal',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian dan aksesoris fashion',
                'is_active' => true,
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'description' => 'Produk kesehatan dan kecantikan',
                'is_active' => true,
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Produk elektronik dan gadget',
                'is_active' => true,
            ],
            [
                'name' => 'Pertanian',
                'description' => 'Produk pertanian dan hasil bumi',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
}
