<?php
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user'])) {
    die("Ошибка: Вы должны войти в аккаунт, чтобы оформить заказ.");
}

// Получаем данные пользователя из сессии
$user_id = $_SESSION['user']['id'];
$user_email = $_SESSION['user']['email'];

// Подключаемся к базе данных
require_once 'db.php';

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $patronymic = trim($_POST['patronymic']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $delivery_method = trim($_POST['delivery_method']);
    
    // Проверяем обязательные поля
    if (empty($address) || empty($phone) || empty($delivery_method)) {
        $_SESSION['error'] = "Заполните все обязательные поля.";
        header("Location: checkout.php");
        exit();
    }

    try {
        // Получаем корзину пользователя
        $stmt = $pdo->prepare("
            SELECT c.id AS cart_id, p.id AS product_id, p.product_name, p.price, c.size, c.quantity
            FROM carts c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $user_id]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cart)) {
            die("Ошибка: Ваша корзина пуста. Добавьте товары в корзину перед оформлением заказа.");
        }

        // Рассчитываем стоимость доставки
        $delivery_cost = 0;
        if ($delivery_method === 'pickup_point') {
            $delivery_cost = 200;
        } elseif ($delivery_method === 'postal_delivery') {
            $delivery_cost = 300;
        }

        // Рассчитываем общую стоимость заказа
        $total_cost = 0;
        foreach ($cart as $item) {
            $total_cost += $item['price'] * $item['quantity'];
        }
        $final_total = $total_cost + $delivery_cost;

        // Сохраняем заказ в базе данных
        $stmt = $pdo->prepare("
            INSERT INTO orders (
                user_id,
                name,
                surname,
                patronymic,
                email,
                address,
                phone,
                delivery_method,
                total_cost,
                delivery_cost,
                final_total
            ) VALUES (
                :user_id,
                :name,
                :surname,
                :patronymic,
                :email,
                :address,
                :phone,
                :delivery_method,
                :total_cost,
                :delivery_cost,
                :final_total
            )
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':name' => $name,
            ':surname' => $surname,
            ':patronymic' => $patronymic,
            ':email' => $email,
            ':address' => $address,
            ':phone' => $phone,
            ':delivery_method' => $delivery_method,
            ':total_cost' => $total_cost,
            ':delivery_cost' => $delivery_cost,
            ':final_total' => $final_total
        ]);

        // Получаем ID нового заказа
        $order_id = $pdo->lastInsertId();

        // Сохраняем товары в таблицу order_items
        foreach ($cart as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO order_items (
                    order_id,
                    product_id,
                    size,
                    quantity,
                    price
                ) VALUES (
                    :order_id,
                    :product_id,
                    :size,
                    :quantity,
                    :price
                )
            ");
            $stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $item['product_id'],
                ':size' => $item['size'],
                ':quantity' => $item['quantity'],
                ':price' => $item['price']
            ]);
        }

        // Очищаем корзину пользователя после оформления заказа
        $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // Перенаправляем на страницу подтверждения заказа
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
} else {
    header("Location: ../checkout.php");
    exit();
}
?>