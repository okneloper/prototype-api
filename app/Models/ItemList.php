<?php

namespace App\Models;

use Illuminate\Support\Fluent;

class ItemList extends Fluent
{
    public function __construct($attributes = [])
    {
        $items = [];
        foreach ($attributes as $item) {
            $items[] = [
                'sku' => $item['sku'],
            ];
        }

        parent::__construct($items);
    }

}
