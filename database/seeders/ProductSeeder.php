<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            [
                'name' => 'Keripik Singkong Original',
                'description' => 'Keripik singkong renyah dengan rasa original yang nikmat',
                'price' => 15000,
                'stock' => 100,
                'is_featured' => true,
                'category_name' => 'Makanan & Minuman',
            ],
            [
                'name' => 'Batik Tulis Premium',
                'description' => 'Batik tulis berkualitas tinggi dengan motif tradisional',
                'price' => 500000,
                'stock' => 25,
                'is_featured' => true,
                'category_name' => 'Fashion',
            ],
            [
                'name' => 'Tas Anyaman Bambu',
                'description' => 'Tas anyaman bambu handmade dengan desain unik',
                'price' => 75000,
                'stock' => 50,
                'is_featured' => false,
                'category_name' => 'Kerajinan Tangan',
            ],
            [
                'name' => 'Minyak Kelapa Murni',
                'description' => 'Minyak kelapa murni organik untuk kesehatan',
                'price' => 45000,
                'stock' => 75,
                'is_featured' => true,
                'category_name' => 'Kesehatan & Kecantikan',
            ],
            [
                'name' => 'Lampu LED Solar',
                'description' => 'Lampu LED tenaga surya ramah lingkungan',
                'price' => 120000,
                'stock' => 30,
                'is_featured' => false,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Beras Organik Premium',
                'description' => 'Beras organik premium kualitas terbaik',
                'price' => 25000,
                'stock' => 200,
                'is_featured' => true,
                'category_name' => 'Pertanian',
            ],
            [
                'name' => 'Kopi Robusta',
                'description' => 'Kopi robusta segar dari petani lokal',
                'price' => 35000,
                'stock' => 80,
                'is_featured' => false,
                'category_name' => 'Makanan & Minuman',
            ],
            [
                'name' => 'Gelang Kayu Jati',
                'description' => 'Gelang kayu jati dengan ukiran tradisional',
                'price' => 25000,
                'stock' => 60,
                'is_featured' => false,
                'category_name' => 'Kerajinan Tangan',
            ],
        ];

        foreach ($products as $product) {
            $category = $categories->where('name', $product['category_name'])->first();
            
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'is_active' => true,
                    'is_featured' => $product['is_featured'],
                ]);
            }
        }
    }
}
