<?php
session_start();

require_once "includes/db.php";
require_once "includes/helpers.php";

// Получение ID товара из URL (например, ?product_id=1)
$product_id = isset($_GET['product_id']) ? trim($_GET['product_id']) : null;

// Проверка, что product_id существует и является числом
if (!$product_id || !is_numeric($product_id)) {
    die("Неверный формат product_id. Убедитесь, что вы передали корректный числовой ID товара.");
}

// Преобразование product_id в целое число
$product_id = (int)$product_id;

// Получение информации о товаре из базы данных
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Если товар не найден
if (!$product) {
    die("Товар не найден.");
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/product.css">
    <title>ЯМайки - Главная</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container products">
            <div class="shirts">
                <div class="shirt">
                    <div class="shirt-image">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    </div>
                    <div class="product-info">
                        <div class="base-info">
                            <h2><?= htmlspecialchars($product['product_name']) ?></h2>
                            <div class="estimate-price">
                                <p><?= htmlspecialchars($product['price']) ?> ₽</p>
                            </div>
                        </div>
                        <div class="actions">

                            <!-- Кнопка "Добавить в корзину" -->
                            <?php if (isset($_SESSION['user'])): ?>
                            <form action="includes/add_to_cart.inc.php" method="post" class="add-to-cart-form">
                                <!-- Скрытый инпут для product_id -->
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                                <!-- Выбор размера -->
                                <label for="size">Выберите размер:</label>
                                <select name="size" id="size" required>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>

                                <!-- Кнопка submit -->
                                <button type="submit" class="add-to-cart">В корзину</button>
                            </form>
                            <?php else: ?>
                            <p>Чтобы добавить товар в корзину, <a href="login.php">войдите</a> или <a href="registration.php">зарегистрируйтесь</a>.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>