<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = [
            [
                'name' => 'Beef', 'stock_amount' => '20000', 'original_stock_amount' => '20000',
            ],
            [
                'name' => 'Cheese', 'stock_amount' => '5000', 'original_stock_amount' => '5000',
            ],
            [
                'name' => 'Onion', 'stock_amount' => '1000', 'original_stock_amount' => '1000',
            ],
        ];
        Ingredient::query()->insert($ingredients);
    }
}
