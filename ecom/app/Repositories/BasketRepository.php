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
        return $product ? $product->stock : 0;
    }
    public function removeFromBasket(int $busketItemId): string
    {
        $busket_item = BasketItem::find($busketItemId);
        if (!$busketItemId) {
            return "not found busket item";
        }
        $busket_item->destroy();
        $busket_item->save();
        return "busket item was deleted";
    }
}
