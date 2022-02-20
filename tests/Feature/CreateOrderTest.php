<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesOrders;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use CreatesOrders;

    public function testPublicAccessIsRestricted(): void
    {
        $this->postJson('/api/orders', $this->getValidOrderCreatePayload())->assertUnauthorized();
    }

    public function testSalesCanNotAccess(): void
    {
        $this->asSales()->postJson('/api/orders', $this->getValidOrderCreatePayload())->assertForbidden();
    }

    public function testCourierCanNotAccess(): void
    {
        $this->asCourier()->postJson('/api/orders', $this->getValidOrderCreatePayload())->assertForbidden();
    }

    /**
     * Successful request
     */
    public function testCanCreateOrder(): void
    {
        $response = $this->asCustomer()
            ->postJson('/api/orders', $this->getValidOrderCreatePayload());

        $response->assertCreated();

        // assert there is an id
        $response->assertJsonStructure([
            'id',
            'email',
            // ...
        ]);
    }
}
