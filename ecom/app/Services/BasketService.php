<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\Products;
use App\Repositories\BasketRepository;
use App\Models\BasketItem;

class BasketService {
    public function __construct(
        private BasketRepository $bascetRepository
    ){}
    public function addToBascet(int $userId, array $data): BasketItem
    {
        $basket = Basket::firstOrCreate(['user_id' => $userId]);

        if ($data['quantity'] > $this->bascetRepository->getProductsQuanity($data['product_id'])) {
            return 'not enough';
        }

        $data = [
            'basket_id' => $basket->id,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
        ];

        return $this->bascetRepository->addItemToBascet($data);
    }
}
