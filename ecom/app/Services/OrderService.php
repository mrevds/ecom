<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\BasketRepository;
use function PHPUnit\Framework\throwException;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private BasketRepository $basketRepository
    ){}
    public function makeOrder(int $userID)
    {
        $basketID = $this->basketRepository->getBasketID($userID);
        $basketList = $this->basketRepository->getList($basketID);

        if ($basketList->isEmpty()) {
            throw new \Exception("basket is empty");
        }

        $total = $basketList->sum(fn($item) => $item->price * $item->quantity);

        $order = $this->orderRepository->createOrder($userID, $total);

        foreach ($basketList as $basket) {
            $this->orderRepository->add($order->id, $basket->toArray());
        }
        $this->basketRepository->clearBasket($basketID);
        return $order;
    }
    public function setAddress(array $data)
    {
        if (empty($data['address'])) {
            throw new \Exception('not valid address');
        }
        $this->orderRepository->setAddress($data);
    }

}
