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
                'name' => 'Apple Watch',
                'description' => 'The Apple Watch is a smartwatch that was first released in 2016.',
                'price' => 499.99,
            ],
            [
                'name' => 'Rolex Watch',
                'description' => 'The Rolex Watch is a smartwatch that was first released in 2016.',
                'price' => 499.99,
            ],
            [
                'name' => 'Samsung Watch',
                'description' => 'The Samsung Watch is a smartwatch that was first released in 2016.',
                'price' => 499.99,
            ],
            [
                'name' => 'Fitbit Watch',
                'description' => 'The Fitbit Watch is a smartwatch that was first released in 2016.',
                'price' => 499.99,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
