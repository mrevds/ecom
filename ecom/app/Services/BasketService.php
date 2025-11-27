<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\Products;
use App\Repositories\BasketRepository;
use App\Models\BasketItem;
use App\Repositories\ProductRepository;

class BasketService {
    public function __construct(
        private BasketRepository $bascetRepository,
        private ProductRepository $productRepository
    ){}
    public function addToBascet(int $userId, array $data): BasketItem
    {
        $basket = Basket::firstOrCreate(['user_id' => $userId]);

        $productPrice = $this->productRepository->getProductPrice($data['product_id']);

        if ($data['quantity'] > $this->bascetRepository->getProductsQuanity($data['product_id'])) {
            throw new \Exception('Not enough stock available');
        }

        $data = [
            'basket_id' => $basket->id,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'price' => $productPrice,
        ];

        return $this->bascetRepository->addItemToBascet($data);
    }
    public function removeBasketItem(int $basketItemID)
    {
        return $this->bascetRepository->remove($basketItemID);
    }
    public function getBasketList(int $userID)
    {
        $basketID = $this->bascetRepository->getBasketID($userID);
        return $this->bascetRepository->getList($basketID);
    }
}
