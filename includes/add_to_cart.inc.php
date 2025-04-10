<?php

require_once "db.php";
require_once "helpers.php";
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user'])) {
    die("Ошибка: Вы должны войти в аккаунт, чтобы добавить товар в корзину.");
}

// Проверяем, что запрос был отправлен методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
    $size = isset($_POST['size']) ? trim($_POST['size']) : null;

    // Проверяем, что product_id и размер переданы корректно
    if (!$product_id || !$size) {
        die("Ошибка: Неверные данные товара.");
    }

    try {
        // Получаем информацию о товаре из базы данных
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Ошибка: Товар не найден.");
        }

        // Проверяем, есть ли уже такой товар с таким размером в корзине
        $stmt = $pdo->prepare("SELECT id, quantity FROM carts WHERE user_id = :user_id AND product_id = :product_id AND size = :size");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'size' => $size]);
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            // Если товар уже есть, увеличиваем количество
            $new_quantity = $cart_item['quantity'] + 1;
            $stmt = $pdo->prepare("UPDATE carts SET quantity = :quantity WHERE id = :id");
            $stmt->execute(['quantity' => $new_quantity, 'id' => $cart_item['id']]);
        } else {
            // Если товара нет, добавляем новый элемент в корзину
            $stmt = $pdo->prepare("INSERT INTO carts (user_id, product_id, size, quantity) VALUES (:user_id, :product_id, :size, 1)");
            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'size' => $size]);
        }

        // Перенаправляем пользователя обратно на страницу товара
        // header("Location: ../product.php?product_id=$product_id");
        redirect("../product.php?product_id=$product_id");
        // exit();
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}
?>