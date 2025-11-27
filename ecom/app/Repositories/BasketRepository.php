<?php

namespace App\Repositories;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Products;

class BasketRepository {
    public function addItemToBascet($data){
        return BasketItem::create($data);
    }
    public function getBasketID(int $userID): int
    {
        $basket = Basket::firstOrCreate(['user_id' => $userID]);
        return $basket->id;
    }

    public function getProductsQuanity(int $productId): int
    {
        $product = Products::find($productId);
        return $product ? $product->stock : 0;
    }

    public function remove(int $busketItemId): string
    {
        $busket_item = BasketItem::find($busketItemId);
        if (!$busket_item) {
            return "not found busket item";
        }
        $busket_item->delete();
        return "busket item was deleted";
    }

    public function getList(int $basketId)
    {
        $list = BasketItem::where('basket_id',$basketId)->get();
        return $list;
    }
    public function clearBasket(int $basketId)
    {
        BasketItem::where('basket_id', $basketId)->delete();
        $list = Basket::find($basketId)?->delete();
        return $list;
    }
}
