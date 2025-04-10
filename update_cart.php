<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$dbname = 'yamayki';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Проверка наличия данных из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if (!$cart_id || !$action) {
        die("Неверные данные для изменения количества товара.");
    }

    // Получаем текущее количество товара
    $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE id = :cart_id");
    $stmt->execute(['cart_id' => $cart_id]);
    $current_quantity = $stmt->fetchColumn();

    if ($current_quantity === false) {
        die("Товар не найден в корзине.");
    }

    // Обновляем количество товара в зависимости от действия
    if ($action === 'increase') {
        $new_quantity = $current_quantity + 1;
    } elseif ($action === 'decrease') {
        $new_quantity = max(1, $current_quantity - 1); // Минимальное значение — 1
    } else {
        die("Неверное действие.");
    }

    // Обновляем количество товара в базе данных
    $update_stmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :cart_id");
    $update_stmt->execute([
        ':quantity' => $new_quantity,
        ':cart_id' => $cart_id
    ]);

    // Перенаправляем пользователя обратно в корзину
    header("Location: cart.php");
    exit();
} else {
    die("Неверный метод запроса.");
}
?>