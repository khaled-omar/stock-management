<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test create new order.
     *
     * @return void
     */
    public function test_create_order()
    {
        /** @var Product $product */
        $product = Product::query()->firstOrFail();
        $quantity = 2;
        $data = [
            "products" => [
                [
                    "product_id" => $product->id, "quantity" => $quantity,
                ],
            ],
        ];
        $response = $this->postJson('api/order', $data);
        $response->assertStatus(200);
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);
    }

    /**
     * Test ingredients stock are updated.
     *
     * @return void
     */
    public function test_stock_is_updated()
    {
        /** @var Product $product */
        $product = Product::query()->firstOrFail();
        $quantity = 2;
        $data = [
            "products" => [
                [
                    "product_id" => $product->id, "quantity" => $quantity,
                ],
            ],
        ];
        $response = $this->postJson('api/order', $data);

        $beef = $product->ingredients()->firstWhere('name', '=', 'Beef');
        $onion = $product->ingredients()->firstWhere('name', '=', 'Onion');
        $cheese = $product->ingredients()->firstWhere('name', '=', 'Cheese');

        $response->assertOk();
        $this->assertEquals($beef->stock_amount, $beef->original_stock_amount - $beef->pivot->quantity * $quantity);
        $this->assertEquals($onion->stock_amount, $onion->original_stock_amount - $onion->pivot->quantity * $quantity);
        $this->assertEquals($cheese->stock_amount, $cheese->original_stock_amount - $cheese->pivot->quantity * $quantity);
    }

    /**
     * Test create order when out of stock ingredient.
     *
     * @return void
     */
    public function test_ingredient_out_of_stock()
    {
        /** @var Product $product */
        $product = Product::query()->firstOrFail();
        $outOfStockQuantity = 5000;
        $data = [
            "products" => [
                [
                    "product_id" => $product->id, "quantity" => $outOfStockQuantity,
                ],
            ],
        ];
        $response = $this->postJson('api/order', $data);

        $response->assertStatus(422);
    }
}
