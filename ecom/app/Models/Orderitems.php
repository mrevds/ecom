<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderitems extends Model
{
    //
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_moment',
    ];
}
