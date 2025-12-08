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
        User::create([
            'name' => 'Admin UMKM',
            'email' => 'admin@umkm.com',
            'password' => bcrypt('password'),
        ]);

        // Run category seeder first
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
