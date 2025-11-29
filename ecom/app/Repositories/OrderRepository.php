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
    public function getOrderAddress(int $orderId): ?string
    {
        $order = Order::find($orderId);
        return $order?->address;
    }
    public function changeStatus(int $userId, string $status){
        $status = Order::where('user_id', $userId)->first();
        $status->status = $status;
        $status->save();
        return $status;
    }
    public function getStatus(int $orderId)
    {
        $status = Order::find($orderId);
        return $status->status;
    }
    public function myOrders(int $userID){
        $orders = Order::where('user_id', $userID)->get();
        return $orders;
    }
    public function deliever(int $order_id)
    {
        $deliver = Order::where('id', $order_id)->first();
        $address = $deliver->address;
        $deliver->status = "on the way";
        $deliver->save();
    }
}
