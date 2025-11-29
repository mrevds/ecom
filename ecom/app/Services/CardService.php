<?php

namespace App\Services;

use App\Models\Card;
use App\Repositories\CardRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class CardService {
    public function __construct(
        private CardRepository $cardRepository,
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository
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
    public function pay(float $price, int $cardID, int $userId, int $orderID)
    {
        $getBalance = $this->cardRepository->getBalance($cardID);
        $getQuanitityOrder = $this->orderRepository->getCountOrder($orderID);
        $getStockStore = $this->productRepository->decreaseProductStock();

        foreach ($getQuanitityOrder as $to_buy) {
            $stockItem = null;
            foreach ($getStockStore as $stock) {
                if ($stock->id == $to_buy['product_id']) {
                    $stockItem = $stock;
                    break;
                }
            }
            if (!$stockItem) {
                throw new \Exception("product not found");
            }
            if ($stockItem->stock < $to_buy['quantity']) {
                throw new \Exception("not enouth stock for product ".$to_buy['product_id']);
            }
        }

        foreach ($getQuanitityOrder as $tobuy){
            $stockitem = null;
            foreach ($getStockStore as $stock) {
                if ($stock->id == $tobuy['product_id']) {
                    $stockitem = $stock;
                    break;
                }
            }
            $newStock = $stockitem->stock -= $tobuy['quantity'];
            $this->productRepository->update($stockitem->id, ['stock' => $newStock]);
        }

        if ($getBalance < $price) {
            throw new \Exception('not enought money)');
        }

        $status  = $this->orderRepository->changeStatus($orderID,"payed");
        return $this->cardRepository->payOrder($price,$cardID);
    }

    public function getUserCards(int $userId)
    {
        return $this->cardRepository->getUserCards($userId);
    }
}
