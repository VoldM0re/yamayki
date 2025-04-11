<?php
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

require_once 'includes/db.php';

// Если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Получаем данные из формы
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $patronymic = $_POST['patronymic'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $deliveryMethod = $_POST['delivery_method'];

        // Рассчитываем стоимость доставки
        $deliveryCost = 0;
        if ($deliveryMethod === 'pickup_point') {
            $deliveryCost = 200;
        } elseif ($deliveryMethod === 'postal_delivery') {
            $deliveryCost = 300;
        }

        // Получаем корзину пользователя
        $stmt = $pdo->prepare("
            SELECT c.id AS cart_id, p.id AS product_id, p.price, c.size, c.quantity
            FROM carts c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $user['id']]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cart)) {
            die("Ошибка: Ваша корзина пуста.");
        }

        // Рассчитываем общую стоимость заказа
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $totalPrice += $deliveryCost;

        // Начинаем транзакцию
        $pdo->beginTransaction();

        // Вставляем заказ в таблицу orders
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, name, surname, patronymic, email, address, phone, delivery_method, total_price)
            VALUES (:user_id, :name, :surname, :patronymic, :email, :address, :phone, :delivery_method, :total_price)
        ");
        $stmt->execute([
            'user_id' => $user['id'],
            'name' => $name,
            'surname' => $surname,
            'patronymic' => $patronymic,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'delivery_method' => $deliveryMethod,
            'total_price' => $totalPrice
        ]);

        // Получаем ID созданного заказа
        $orderId = $pdo->lastInsertId();

        // Добавляем товары из корзины в таблицу order_items
        foreach ($cart as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, size, quantity, price)
                VALUES (:order_id, :product_id, :size, :quantity, :price)
            ");
            $stmt->execute([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Очищаем корзину пользователя
        $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user['id']]);

        // Фиксируем транзакцию
        $pdo->commit();

        // Перенаправляем пользователя на страницу успешного оформления заказа
        header("Location: successful_order.php");
        exit();
    } catch (PDOException $e) {
        // Откатываем транзакцию в случае ошибки
        $pdo->rollBack();
        die("Ошибка при оформлении заказа: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pages/checkout.css">
    <title>Оформление заказа - ЯМайки</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="checkout-wrapper container">
            <h1>Оформление заказа</h1>

            <!-- Форма для ввода информации -->
            <form method="post">
                <!-- Имя, фамилия, отчество, почта (заполнены автоматически) -->
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="surname">Фамилия</label>
                    <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($user['surname'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="patronymic">Отчество</label>
                    <input type="text" id="patronymic" name="patronymic" value="<?= htmlspecialchars($user['patronymic'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Почта</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                </div>

                <!-- Адрес и телефон (вводятся пользователем) -->
                <div class="form-group">
                    <label for="address">Адрес</label>
                    <input type="text" id="address" name="address" placeholder="Введите ваш адрес" required>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" id="phone" name="phone" placeholder="+7 123 456 78 90" required>
                </div>

                <!-- Способ доставки -->
                <div class="form-group">
                    <label>Способ доставки</label>
                    <div class="delivery-options">
                        <label>
                            <input type="radio" name="delivery_method" value="self_pickup" required>
                            Самовывоз (бесплатно)
                        </label>
                        <label>
                            <input type="radio" name="delivery_method" value="pickup_point">
                            В пунктах МНДАД (200 рублей)
                        </label>
                        <label>
                            <input type="radio" name="delivery_method" value="postal_delivery">
                            Доставка почтой России (300 рублей)
                        </label>
                    </div>
                </div>

                <!-- Кнопка отправки формы -->
                <button type="submit" class="checkout-button">Заказать</button>
            </form>
        </section>
    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>