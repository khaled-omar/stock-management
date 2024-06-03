<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequestValidation as Request;
use App\Services\OrderService;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * @var \App\Services\OrderService
     */
    protected $service;

    public function __construct(OrderService $orderService)
    {
        $this->service = $orderService;
    }

    /**
     * Handle order creation.
     *
     * @param  \App\Http\Requests\OrderRequestValidation  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validated();
        $orderData =  $data['products'] ?? [];
        $order = $this->service->createOrder($orderData);

        return response()->json([$order]);
    }
}
