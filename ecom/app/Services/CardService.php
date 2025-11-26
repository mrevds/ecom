<?php

namespace App\Services;

use App\Models\Card;
use App\Repositories\CardRepository;

class CardService {
    public function __construct(
        private CardRepository $cardRepository
    ){}
    private function validateExpiry(string $date): bool
    {
        // Проверяем формат: 2 цифры, слэш, 2 цифры
        if (!preg_match('/^\d{2}\/\d{2}$/', $date)) {
            return false;
        }

        [$month, $year] = explode('/', $date);

        // Превращаем в числа
        $month = (int)$month;
        $year = (int)$year;

        // Месяц должен быть 1–12
        if ($month < 1 || $month > 12) {
            return false;
        }

        // Год должен быть >= текущего
        $currentYear = (int)date('y');
        if ($year < $currentYear) {
            return false;
        }

        return true;
    }

    public function addCard(int $userId,array $data): Card
    {
        $firstDigit = $data['card_number'][0];
        if (!$this->validateExpiry($data['expiry_date'])) {
            throw new \Exception("Invalid expiration date format");
        }
        if ($firstDigit == "9") {
            $cardType = "humo";
        } else if ($firstDigit == "8" || $firstDigit == "5") {
            $cardType = "uzcard";
        } else {
            $cardType = "unknown";
        }

        $cardData = [
            'user_id' => $userId,
            'card_number' => $data['card_number'],
            'card_type' => $cardType,
            'cvv' => $data['cvv'],
            'expiry_date' => $data['expiry_date'],
        ];
        return $this->cardRepository->addCard($cardData);
    }
    public function deleteCard(int $cardId){
        return $this->cardRepository->deleteCard($cardId);
    }
}
