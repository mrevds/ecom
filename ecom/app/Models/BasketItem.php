<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    //
    protected $fillable = ['basket_id', 'product_id', 'quantity', 'price'];

}
