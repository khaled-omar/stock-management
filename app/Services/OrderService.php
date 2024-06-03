<?php

namespace App\Services;

use App\Exceptions\OutOfStockIngredientException;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\LowStockNotification;
use App\Repositories\OrderRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $orderData)
    {
        // Validate amount is sufficient;
       return DB::transaction(function () use ($orderData) {
            // save order into database..
            $order = $this->orderRepository->persistOrder($orderData);
            // Update stock amount
            $productIngredient = $this->updateStockAmount($order);
            // Send alert if used ingredient is less than 50%
            $this->handleLowStockNotification($productIngredient);

            return $order->load('orderItems');
        });
    }

    protected function updateStockAmount(Order $order): Collection
    {
        $orderIngredients = collect();
        $order->orderItems()->each(function (OrderItem $orderItem) use (&$orderIngredients) {
            $orderIngredients = $orderIngredients->merge($orderItem->product->ingredients);
            $this->updateSingleProductStock($orderItem);
        });

        return $orderIngredients;
    }

    protected function updateSingleProductStock(OrderItem $orderItem): void
    {
        $orderItem->product->ingredients->each(function (Ingredient $productIngredient) use ($orderItem) {
            $totalQuantity = $productIngredient->pivot->quantity * $orderItem->quantity;
            if ($productIngredient->stock_amount - $totalQuantity < 0) {
                throw new OutOfStockIngredientException($productIngredient, $orderItem->product);
            }
            $productIngredient->stock_amount = $productIngredient->stock_amount - $totalQuantity;
            $productIngredient->save();
        });
    }

    protected function handleLowStockNotification(Collection $productIngredient): void
    {
        $productIngredient->each(function (Ingredient $ingredient) {
            if ($this->isStockBelowThreshold($ingredient)) {
                $this->sendLowStockNotification($ingredient);
                $ingredient->update(['out_of_stock_notification_date' => now()]);
            }
        });
    }

    protected function isStockBelowThreshold(Ingredient $ingredient): bool
    {
        return $ingredient->stock_amount < $ingredient->original_stock_amount * 0.5;
    }

    protected function sendLowStockNotification(Ingredient $ingredient)
    {
        $merchant = User::query()->first(); // Assuming this user is the merchant for now.
        Notification::send($merchant, new LowStockNotification($ingredient));
    }
}
