# Документация API - Ecommerce

## Базовый URL
```
http://localhost:8000/api
```

## Публичные роуты

### Получить все продукты
```
GET /products
```
Параметры: нет
Ответ: Массив всех продуктов

### Получить продукт по ID
```
GET /products/{id}
```
Параметры: `id` - ID продукта
Ответ: Данные продукта

### Регистрация покупателя
```
POST /register-customer
```
Тело запроса:
```json
{
  "username": "mrevds",
  "password": "password123"
}
```
Ответ: Токен доступа

### Регистрация продавца
```
POST /register-seller
```
Тело запроса:
```json
{
  "username": "mrevdsSeller",
  "password": "password123"
}
```
Ответ: Токен доступа

### Вход в аккаунт
```
POST /login
```
Тело запроса:
```json
{
  "username": "user@example.com",
  "password": "password123"
}
```
Ответ: Токен доступа

---

## Защищённые роуты (требуется Bearer токен)

**Заголовок:** `Authorization: Bearer {token}`

### Получить профиль
```
GET /profile
```
Ответ: Данные текущего пользователя

### Выход из аккаунта
```
POST /logout
```
Ответ: Успешное сообщение

### Создать продукт (только для продавцов)
```
POST /products
```
Тело запроса:
```json
{
  "category_id": 1,
  "name": "iPhone 15 Pro",
  "description": "Latest Apple smartphone",
  "price": 999.99,
  "stock": 50
}
```
Ответ: Данные созданного продукта

### Редактировать продукт
```
PUT /products/{id}
```
Тело запроса: те же поля что и при создании
Ответ: Обновленные данные продукта

### Удалить продукт
```
DELETE /products/{id}
```
Ответ: Успешное сообщение

---

## Коды ошибок

| Код | Описание |
|-----|---------|
| 200 | OK - успешный запрос |
| 201 | Created - ресурс создан |
| 400 | Bad Request - ошибка валидации |
| 401 | Unauthorized - требуется токен |
| 403 | Forbidden - недостаточно прав |
| 404 | Not Found - ресурс не найден |
| 500 | Internal Server Error - ошибка сервера |

---

## Пример использования

### 1. Регистрация продавца
```bash
curl -X POST http://localhost:8000/api/register-seller \
  -H "Content-Type: application/json" \
  -d '{
    "name": "My Store",
    "password": "password123"
  }'
```

### 2. Создание продукта с токеном
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "name": "iPhone 15 Pro",
    "description": "Latest Apple smartphone",
    "price": 999.99,
    "stock": 50
  }'
```

---

## Структура проекта

- `app/Http/Controllers/` - контроллеры (обработка запросов)
- `app/Models/` - модели БД
- `app/Services/` - бизнес-логика
- `app/Repositories/` - работа с данными
- `routes/api.php` - определение API роутов
- `database/migrations/` - миграции БД
- `database/seeders/` - начальные данные

---



