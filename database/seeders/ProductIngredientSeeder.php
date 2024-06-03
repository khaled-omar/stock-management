<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Database\Seeder;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $burgerId = Product::query()->first()->id;
        $data = [
            [
                'product_id' => $burgerId,
                'ingredient_id' => Ingredient::query()->firstWhere('name', 'Beef')->id,
                'quantity' => 150,
            ], [
                'product_id' => $burgerId,
                'ingredient_id' => Ingredient::query()->firstWhere('name', 'Cheese')->id,
                'quantity' => 30,
            ], [
                'product_id' => $burgerId,
                'ingredient_id' => Ingredient::query()->firstWhere('name', 'Onion')->id,
                'quantity' => 20,
            ],
        ];
        ProductIngredient::query()->insert($data);
    }
}
