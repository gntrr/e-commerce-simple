<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code',
        'product_sku',
        'product_name',
        'price',
        'qty',
        'customer_name',
        'phone',
        'address',
        'status'
    ];
}
