<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Orders;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    /**
     * Returns a list of orders
     */
    public function index(Request $request, Orders $orders)
    {
        // $request used for pagination etc

        return [
            'orders' => $orders->all(),
        ];
    }

    /**
     * Creates a new order
     */
    public function store(CreateOrderRequest $request, Orders $orders): Response
    {
        // the data has been validated in CreateOrderRequest class, so passing the data directly to `create` method
        $order = $orders->create($request->validated());

        return $this->created($order);
    }

    /**
     * Returns order details
     */
    public function show($order_id, Orders $orders): Response
    {
        if ((int)$order_id != $order_id) {
            // not an integer
            return $this->validationFailed([
                'order_id' => 'Order id must be integer',
            ]);
        }

        // if not found, throws a NotFound Exception and a 404 response is returned
        $order = $orders->find($order_id);

        return new JsonResponse($order);
    }
}
