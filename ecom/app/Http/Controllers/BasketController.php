<?php

namespace App\Http\Controllers;

use App\Services\BasketService;
use  Illuminate\Http\Request;

class BasketController extends Controller {
    public function __construct(
        private BasketService $bascetService
    ){}
    public function addItem(Request $request)
    {
        $item = $this->bascetService->addToBascet(
            $request->user()->id,
            [
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
            ]
        );
        return response()->json($item);
    }
    public function removeFromList(int $basketItemID)
    {
        $item = $this->bascetService->removeBasketItem($basketItemID);
        return response()->json("removed from basketITEMS");
    }
    public function getBasketList(Request $request)
    {
        $userId = $request->user()->id;
        $list = $this->bascetService->getBasketList($userId);
        return response()->json($list);
    }
}
