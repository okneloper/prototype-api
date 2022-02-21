<?php

namespace Tests\Feature;

use App\Models\Order;
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
        $response = $this->asCustomer()->postJson('/api/orders', $this->getValidOrderCreatePayload());

        $response->assertCreated();

        // assert there is an id
        $response->assertJsonStructure([
            'id',
            'email',
            // ...
        ]);
    }

    public function testEmailValidation(): void
    {
        $data = $this->getValidOrderCreatePayload();
        $data['email'] = 'john@exmaple.';
        $response = $this->asCustomer()->postJson('/api/orders', $data);

        $response->assertUnprocessable();
    }

    public function testPhoneValidation(): void
    {
        $data = $this->getValidOrderCreatePayload();
        $data['phone'] = '777 888 + 119';
        $response = $this->asCustomer()->postJson('/api/orders', $data);

        $response->assertUnprocessable();
    }

    public function testStripsTagsValidation(): void
    {
        $data = $this->getValidOrderCreatePayload();
        $data['address']['line1'] = '<script>alert("17th Avenue")</script>';
        $response = $this->asCustomer()->postJson('/api/orders', $data);

        $response->assertCreated();

        $order = Order::find($response->json('id'));

        $this->assertStringNotContainsStringIgnoringCase('<script>', $order->address['line1']);
    }

    public function testSkuValidation(): void
    {
        $data = $this->getValidOrderCreatePayload();
        $data['items'][0]['sku'] = 'A667';
        $response = $this->asCustomer()->postJson('/api/orders', $data);

        $response->assertUnprocessable();
    }

    public function testCountryValidation(): void
    {
        $data = $this->getValidOrderCreatePayload();
        // unsupported country, see app/Http/Requests/CreateOrderRequest.php for rules
        $data['address']['country'] = 'US';
        $response = $this->asCustomer()->postJson('/api/orders', $data);

        $response->assertUnprocessable();
    }
}
