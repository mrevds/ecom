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
}
