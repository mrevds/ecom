<?php

namespace App\Repositories;

use App\Models\Card;

class CardRepository {
    public function addCard($data){
        return Card::create($data);
    }

    public function deleteCard(int $cardId): bool {
        $card = Card::find($cardId);
        return $card ? $card->delete(): false;
    }

    public function payBucket(int $totalPrice, int $cardId): array {
        $card = Card::find($cardId);

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
}
