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
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Product ' . ($i + 1),
                'description' => 'Description for product ' . ($i + 1),
                'price' => rand(10, 1000),
                'stock' => rand(1, 100),
            ]);
        }
    }
}
