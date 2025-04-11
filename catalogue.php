<?php
session_start();
require_once 'includes/db.php';

// Получение всех товаров из базы данных
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/catalogue.css">
    <title>ЯМайки - Каталог</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container products">
            <h2>Каталог товаров</h2>
            <div class="shirts">
                <!-- Цикл для отображения товаров -->
                <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="shirt">
                    <a href="product.php?product_id=<?= htmlspecialchars($product['id']) ?>">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    </a>
                    <div class="descr_product">
                        <a href="product.php?product_id=<?= htmlspecialchars($product['id']) ?>">
                            <?= htmlspecialchars($product['product_name']) ?>
                        </a>
                        <div class="estimate_price">
                            <p><?= htmlspecialchars($product['price']) ?> ₽</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Товары не найдены.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>