<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    public function testPublicAccessIsRestricted(): void
    {
        //$this->getJson('/api/orders')->assertUnauthorized();
        $this->postJson('/api/orders', $this->getValidPayload())->assertUnauthorized();
    }

    /**
     * Successful request
     */
    public function testCanCreateOrder(): void
    {
        $response = $this->asCustomer()
            ->postJson('/api/orders', $this->getValidPayload());

        $response->assertCreated();

        // assert there is an id
        $response->assertJsonStructure([
            'id',
            'email',
            // ...
        ]);
    }

    public function getValidPayload(): array
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
}
