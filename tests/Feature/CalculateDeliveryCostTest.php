<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculateDeliveryCostTest extends TestCase
{
    public function testPublicAccessIsRestricted(): void
    {
        $this->postJson('/api/delivery/cost', $this->getValidPayload())->assertUnauthorized();
    }

    public function testSalesCanNotAccess(): void
    {
        $this->asSales()->postJson('/api/delivery/cost', $this->getValidPayload())->assertForbidden();
    }

    public function testCourierCanNotAccess(): void
    {
        $this->asCourier()->postJson('/api/delivery/cost', $this->getValidPayload())->assertForbidden();
    }

    /**
     * Successful request
     */
    public function testCanCalculateDeliveryCost(): void
    {
        $response = $this->asCustomer()
            ->postJson('/api/delivery/cost', $this->getValidPayload());

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'cost' => 2,
        ]);
    }

    // Validation tests. Assuming country, postcode, and item SKU are required

    public function testEmptyRequestFails(): void
    {
        $this->asCustomer()
            ->postJson('/api/delivery/cost', [])
            ->assertUnprocessable();
    }

    public function testMissingCountry(): void
    {
        $this->asCustomer()
            ->postJson('/api/delivery/cost', collect($this->getValidPayload())->except('address.country')->all())
            ->assertUnprocessable();
    }

    public function testMissingPostcode(): void
    {
        $this->asCustomer()
            ->postJson('/api/delivery/cost', collect($this->getValidPayload())->except('address.postcode')->all())
            ->assertUnprocessable();
    }

    public function testMissingSku(): void
    {
        $this->asCustomer()
            ->postJson('/api/delivery/cost', collect($this->getValidPayload())->except('items.0.sku')->all())
            ->assertUnprocessable();
    }

    public function getValidPayload(): array
    {
        return [
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
