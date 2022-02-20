<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesOrders;
use Tests\TestCase;

class OrdersEndpointTest extends TestCase
{
    use CreatesOrders;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPublicAccessIsRestricted(): void
    {
        // public access
        $this->getJson('/api/orders')->assertUnauthorized();
        $this->getJson('/api/orders/1')->assertUnauthorized();
    }

    public function testOrderIdShouldBeInteger(): void
    {
        $response = $this->asSales()->getJson('/api/orders/abc');

        $response->assertUnprocessable();

        $response->assertJsonFragment([
            'errors' => [
                'order_id' => 'Order id must be integer',
            ],
        ]);
    }

    public function testCustomerCantAccess(): void
    {
        $this->asCustomer()
            ->getJson('/api/orders')->assertForbidden();

        $this->asCustomer()
            ->getJson('/api/orders/1')->assertForbidden();
    }

    public function testSalesCan(): void
    {
        $this->asSales()
            ->getJson('/api/orders')->assertSuccessful();
    }

    public function testCourierCant(): void
    {
        // courier can't
        $this->asCourier()
            ->getJson('/api/orders')->assertForbidden();
    }

    public function testReturnsListOfOrders(): void
    {
        $total = Order::query()->count();

        while ($total < 2) {
            $this->createOrder();

            $total = Order::query()->count();
        }

        $response = $this->asSales()->getJson('/api/orders');

        $response->assertSuccessful();

        $data = $response->json();

        $this->assertEquals($total, count($data['orders']));
    }
}
