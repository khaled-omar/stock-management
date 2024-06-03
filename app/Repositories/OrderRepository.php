<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    /** @var \App\Models\Order $model */
    protected $model;

    public function __construct()
    {
        $this->model = new Order();
    }

    public function persistOrder(array $orderData): Order
    {
        /** @var \App\Models\Order $order */
        $order = $this->model->newQuery()->create([]);
        // Create order items..
        $order->orderItems()->createMany($orderData);

        return $order;
    }

    public function find($id)
    {
        return $this->model->newQuery()->findOrFail($id);
    }
}
