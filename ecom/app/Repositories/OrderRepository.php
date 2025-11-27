<?php

namespace App\Repositories;

use App\Models\Orderitems;
use App\Models\Order;

class OrderRepository {
    public function createOrder(int $userID, float $totalPrice)
    {
        return Order::create([
            'user_id' => $userID,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_method' => 'empty',
            'address' => 'empty'
        ]);
    }
    public function add(int $orderID, array $basketData)
    {
        $data = [
            'order_id' => $orderID,
            'product_id' => $basketData['product_id'],
            'quantity' => $basketData['quantity'],
            'price_at_moment' => $basketData['price'],
        ];
        return Orderitems::create($data);
    }
    public function setAddress(array $data)
    {

        $user = $data['user_id'];
        $order = Order::where('user_id', $user)->first();
        if (!$order) {
            return null;
        }
        $order->address = $data['address'];
        $order->save();
        return $order;
    }
    public function getOrderAddress(int $userId): ?string
    {
        $order = Order::where('user_id', $userId)->first();
        return $order?->address;
    }

}
