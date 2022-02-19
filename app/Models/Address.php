<?php

namespace App\Models;

use Illuminate\Support\Fluent;

class Address extends Fluent
{
    public function __construct($attributes = [])
    {
        // only use the predefined attributes
        $attributes = [
            'line1' => $attributes['line1'],
            'line2' => $attributes['line2'] ?? null, // optional
            'city' => $attributes['city'],
            'postcode' => $attributes['postcode'],
            'country' => $attributes['country'],
        ];

        parent::__construct($attributes);
    }
}
