<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string email
 * @property string phone
 * @property Address address
 * @property ItemList items
 */
class Order extends Model
{
    protected $casts = [
        'address' => 'json',
        'items' => 'json',
    ];

    public function getAddress(): Address
    {
        return new Address($this->address);
    }

    public function getItems(): ItemList
    {
        return new ItemList($this->items);
    }
}
