<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $fillable = [
        'user_id',
        'card_number',
        'card_type',
        'cvv',
        'expiry_date',
        'balance',
        'is_active',
    ];
}
