<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Orders;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    /**
     * Creates a new order
     */
    public function store(CreateOrderRequest $request, Orders $orders): Response
    {
        // the data has been validated in CreateOrderRequest class, so passing the data directly to `create` method
        $order = $orders->create($request->validated());

        return $this->created($order);
    }
}
