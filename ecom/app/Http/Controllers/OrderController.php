<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;


class OrderController {
    public function __construct(
        private OrderService $orderService
    ){}
    public function makeOrder(Request $request)
    {
        $order = $this->orderService->makeOrder($request->user()->id);
        return response()->json($order);
    }
    public function setAddress(Request $request)
    {
        $data = [
            'address' => $request->input('address'),
            'user_id' => $request->user()->id
        ];

        return response()->json($this->orderService->setAddress($data));
    }

    public function getOrders(Request $request)
    {
        $user_id = $request->user()->id;
        return response()->json($this->orderService->getMyOrders($user_id));
    }
    public function deliverOrder(Request $request)
    {
        $user_id = $request->user()->id;
        $order_id = $request->route('id');
        return response()->json($this->orderService->deliver($order_id,$user_id));
    }
}
