<?php

namespace App\Http\Controllers;

use App\Services\CardService;
use  Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct(
        private CardService $cardService
    ){}
    public function addCard(Request $request)
    {

        $card = $this->cardService->addCard(
            $request->user()->id,
            [
            'card_number' => $request->input('card_number'),
            'cvv' => $request->input('cvv'),
            'expiry_date' => $request->input('expiry_date'),
        ]);
        return response()->json($card);
    }
    public function pay(Request $request)
    {
        $price = $request->input('price');
        $cardID = $request->input('cardID');
        $pay = $this->cardService->pay($price,$cardID,$request->user()->id);
        return response()->json($pay);
    }

    public function getUserCards(Request $request)
    {
        $cards = $this->cardService->getUserCards($request->user()->id);
        return response()->json($cards);
    }
}
