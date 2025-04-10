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

    if (!$cart_id) {
        die("Неверные данные для удаления товара из корзины.");
    }

    // Удаление товара из корзины
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = :cart_id");
    $stmt->execute(['cart_id' => $cart_id]);

    // Перенаправляем пользователя обратно в корзину
    header("Location: cart.php");
    exit();
} else {
    die("Неверный метод запроса.");
}
?>