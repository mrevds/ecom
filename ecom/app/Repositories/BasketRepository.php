<?php

namespace App\Repositories;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Products;

class BasketRepository {
    public function addItemToBascet($data){
        return BasketItem::create($data);
    }
    public function getProductsQuanity(int $productId): int
    {
        $product = Products::find($productId);
        return $product ? $product->quantity : 0;
    }
}
