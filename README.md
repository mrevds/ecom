# E-Commerce API Routes

Base URL: `http://localhost:8000/api`

## Публичные роуты

```
POST   /register-customer
POST   /register-seller
POST   /login
GET    /products
GET    /products/{id}
```

## Защищенные роуты (требуется Bearer токен)

### Аутентификация
```
GET    /profile
POST   /logout
```

### Продукты
```
POST   /products
PUT    /products/{id}
DELETE /products/{id}
```

### Корзина
```
POST   /add-item-to-basket
GET    /get-basket-list
DELETE /delete-item-from-basket/{id}
```

### Заказы
```
POST   /make-order
POST   /set-address
```

### Карты и оплата
```
POST   /add-card
GET    /cards
POST   /pay-order
```



