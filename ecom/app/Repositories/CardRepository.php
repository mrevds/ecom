<?php

namespace App\Repositories;

use App\Models\Card;
use App\Models\Order;
use App\Repositories\OrderRepository;

class CardRepository {
    public function addCard($data){
        return Card::create($data);
    }

    public function deleteCard(int $cardId): bool {
        $card = Card::find($cardId);
        return $card ? $card->delete(): false;
    }

    public function payOrder(float $totalPrice, int $cardId): array {
        $card = Card::find($cardId);
        $cardUser = $card->user_id;

        if (!$card) {
            return [
                "success" => false,
                "message" => "Card not found"
            ];
        }

        if ($card->balance < $totalPrice) {
            return [
                "success" => false,
                "message" => "Not enough money"
            ];
        }

        $card->balance -= $totalPrice;
        $card->save();

        return [
            "success" => true,
            "message" => "Payment successful",
            "new_balance" => $card->balance
        ];
    }
    public function getBalance(int $cardID)
    {
        $card = Card::find($cardID);
        return $card->balance;
    }

    public function getUserCards(int $userId)
    {
        return Card::where('user_id', $userId)->get();
    }
}
