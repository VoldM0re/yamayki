<?php
session_start();
require_once 'includes/db.php';

// Получение всех товаров из базы данных
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/index.css">
    <title>ЯМайки - Главная</title>
</head>

<style>
.shirts {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.shirt {
    width: 200px;
    text-align: center;
}

.shirt img {
    width: 100%;
    height: auto;
}

.descr_product {
    margin-top: 10px;
}

.estimate_price {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.estimate {
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container">

        </section>

        <section class="products">
            <h1>Каталог товаров</h1>
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
                            <div class="estimate">
                                <img src="assets/svg/Vector.svg" alt="Рейтинг">
                                <p>2.5</p> <!-- Здесь можно добавить логику для реального рейтинга -->
                            </div>
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