<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\ItemList;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Orders repository
 */
class Orders
{
    /*
     * Creates an order
     */
    public function create(array $data): Order
    {
        // some additional validation would happen before storing the order, but skipping it in a prototype

        $order = new Order();
        $order->email = $data['email'];
        $order->phone = $data['phone'];
        $order->address = (new Address($data['address']))->jsonSerialize();
        $order->items = (new ItemList($data['items']))->jsonSerialize();
        $order->save();

        return $order;
    }

    /**
     * Returns all orders
     */
    public function all(): Collection
    {
        return Order::all();
    }

    /**
     * Finds an order by Id
     */
    public function find($order_id): Order
    {
        return Order::query()->findOrFail($order_id);
    }
}
