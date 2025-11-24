<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'status',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(){
        return $this->belongsTo(Categories::class);
    }

//    public function images()
//    {
//        return $this->hasMany(ProductsImage::class);
//    }
}
