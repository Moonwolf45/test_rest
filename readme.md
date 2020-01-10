# Rest Api Lite

## Запуск миграций
php vendor/robmorgan/phinx/bin/phinx migrate

## 1. Создание начальных 20 товаров
/api/products/create (метод POST) Без данных

## 2. Получение всех товаров
/api/products (метод GET)

## 3. Создание заказа
/api/orders/create (метод POST)

Пример: 
```
{
    "amount": "17633",
    "products": [
        {"product_id": "2", "quantity": "3"},
        {"product_id": "7", "quantity": "2"}
    ]
}
```

## 4. Обновление заказа
/api/orders/update (метод PUT)

Пример: 
```
{
    "order_id": "12",
    "amount": "17633"
}
```
