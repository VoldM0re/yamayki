<?php
session_start();
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4;");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/index.css">
    <title>ЯМайки - Главная</title>
</head>

<style>
.slider {
    position: relative;
    max-width: 900px;
    margin: 20px auto;
    overflow: hidden;
    aspect-ratio: 16 / 6;
    border: 1px solid #eee;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.slider .slide {
    display: none;
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
}

.slider .slide.active {
    display: block;
    opacity: 1;
    z-index: 1;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    background-color: rgba(0, 0, 0, 0.4);
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 1.5rem;
    cursor: pointer;
    border-radius: 4px;
    opacity: 0.7;
    transition: opacity 0.3s;
}

.slider-btn:hover {
    opacity: 1;
}

.slider-btn.prev {
    left: 15px;
}

.slider-btn.next {
    right: 15px;
}
</style>

<body>
    <?php require_once 'includes/components/header.php'; ?>

    <main>
        <section class="container products">
            <h2>Новинки</h2>
            <div class="shirts">
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