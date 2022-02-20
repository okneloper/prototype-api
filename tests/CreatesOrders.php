<?php

namespace Tests;

use App\Models\Order;
use App\Repositories\Orders;

trait CreatesOrders
{
    public function getValidOrderCreatePayload(): array
    {
        return [
            'email' => 'john@exmaple.com',
            'phone' => '777 888 119',
            'address' => [
                'line1' => '25 State Route',
                'line2' => '',
                'city' => 'Riga',
                'postcode' => 'LV-1011',
                'country' => 'LV',
            ],
            'items' => [
                [
                    'sku' => '111',
                ],
                [
                    'sku' => '222',
                ],
            ],
        ];
    }

    public function createOrder(): Order
    {
        return app(Orders::class)->create($this->getValidOrderCreatePayload());
    }
}
