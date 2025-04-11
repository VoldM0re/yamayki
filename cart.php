<?php
require_once "includes/db.php";
require_once "includes/helpers.php";
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

$user_id = $_SESSION['user']['id'];

// Обработка действий с корзиной (увеличение, уменьшение, удаление)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['cart_id'])) {
        $cart_id = (int)$_POST['cart_id'];
        $action = $_POST['action'];

        try {
            // Получаем текущее количество товара в корзине
            $stmt = $pdo->prepare("SELECT quantity FROM carts WHERE id = :id AND user_id = :user_id");
            $stmt->execute(['id' => $cart_id, 'user_id' => $user_id]);
            $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cart_item) {
                if ($action === 'increase') {
                    // Увеличиваем количество товара
                    $new_quantity = $cart_item['quantity'] + 1;
                    $stmt = $pdo->prepare("UPDATE carts SET quantity = :quantity WHERE id = :id");
                    $stmt->execute(['quantity' => $new_quantity, 'id' => $cart_id]);
                } elseif ($action === 'decrease') {
                    // Уменьшаем количество товара, но не ниже 1
                    $new_quantity = max(1, $cart_item['quantity'] - 1);
                    $stmt = $pdo->prepare("UPDATE carts SET quantity = :quantity WHERE id = :id");
                    $stmt->execute(['quantity' => $new_quantity, 'id' => $cart_id]);
                } elseif ($action === 'remove') {
                    // Удаляем товар из корзины
                    $stmt = $pdo->prepare("DELETE FROM carts WHERE id = :id AND user_id = :user_id");
                    $stmt->execute(['id' => $cart_id, 'user_id' => $user_id]);
                }
            }

            // Перенаправляем обратно в корзину
            redirect("cart.php");
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }
}

try {
    // Получаем корзину пользователя из базы данных
    $stmt = $pdo->prepare("
        SELECT c.id AS cart_id, p.id AS product_id, p.product_name, p.price, p.image, c.size, c.quantity
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user_id]);
    $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/cart.css">
    <title>Корзина - ЯМайки</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container">
            <h1>Корзина</h1>
            <?php if (empty($cart)): ?>
            <p>Ваша корзина пуста.</p>
            <?php else: ?>
            <div class="cart-container">
                <!-- Список товаров -->
                <div class="cart-items">
                    <?php foreach ($cart as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                        </div>
                        <div class="cart-item-info">
                            <div class="price-and-name">
                                <span class="price"><?= htmlspecialchars($item['price']) ?> ₽</span>
                                <p><?= htmlspecialchars($item['product_name']) ?></p>
                            </div>
                            <p class="size">Размер: <?= htmlspecialchars($item['size']) ?></p>
                            <div class="quantity-controls">
                                <form method="post" class="quantity-form">
                                    <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                    <button type="submit" name="action" value="decrease">-</button>
                                    <span class="quantity"><?= htmlspecialchars($item['quantity']) ?></span>
                                    <button type="submit" name="action" value="increase">+</button>
                                </form>
                                <form method="post" class="remove-form">
                                    <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                    <button type="submit" name="action" value="remove">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Форма оформления заказа -->
                <div class="checkout-summary">
                    <h2>Общее количество товаров: <?= count($cart) ?> шт.</h2>
                    <ul class="items-list">
                        <?php foreach ($cart as $item): ?>
                        <li>
                            <?= htmlspecialchars($item['product_name']) ?> - <?= htmlspecialchars($item['price']) ?> ₽
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="total">
                        <strong>Итого:</strong>
                        <?php
                            $total = 0;
                            foreach ($cart as $item) {
                                $total += $item['price'] * $item['quantity'];
                            }
                            echo htmlspecialchars($total) . ' ₽';
                            ?>
                    </div>
                    <form method="post" action="checkout.php">
                        <button type="submit" class="checkout-button">Оформить заказ</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>