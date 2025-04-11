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
        <!-- <section class="sortings-wrapper container">
            <h2 class="section-title">Каталог</h2>
            <nav class="menu">
                <a class="menu-link current-catalogue" href="">Футболки</a>
                <a class="menu-link" href="">Майки</a>
                <a class="menu-link" href="">Худи</a>
                <a class="menu-link" href="">Аксессуары</a>
            </nav>

            <div class="sortings">
                <div class="sorting">
                    <p class="small-title">Сортировка</p>
                    <select class="sorting_select" name="order">
                        <option value="decreasing">По убыванию</option>
                        <option value="ascending ">По возрастанию</option>
                    </select>
                </div>
                <div class="sorting">
                    <p class="small-title">Цена, ₽</p>
                    <div class="price">
                        <input class="price_input" type="text" pattern="[0-9]*" inputmode="numeric" step="100" min="0" name="price_from" placeholder="от">
                        <input class="price_input" type="text" pattern="[0-9]*" inputmode="numeric" step="100" min="0" name="price_to" placeholder="до">
                    </div>
                </div>
            </div>
            <div class="sortings">
                <div class="sorting">
                    <p class="small-title">Материал</p>
                    <div class="sorting-box">
                        <label class="sorting-item">
                            <input type="checkbox" name="material" value="hlopok" id="">
                            <span>Хлопок</span>
                        </label>
                        <label class="sorting-item">
                            <input type="checkbox" name="material" value="laikra">
                            <span>Лайкра</span>
                        </label>
                        <label class="sorting-item">
                            <input type="checkbox" name="material" value="sintetika">
                            <span>Синтетика</span>
                        </label>
                    </div>
                </div>
                <div class="sorting">
                    <p class="small-title">Пол</p>
                    <div class="sorting-box">
                        <label class="sorting-item">
                            <input type="radio" name="sex" value="male">
                            <span>Мужской</span>
                        </label>
                        <label class="sorting-item">
                            <input type="radio" name="sex" value="female">
                            <span>Женский</span>
                        </label>
                    </div>
                </div>
                <div class="sorting">
                    <p class="small-title">Размер</p>
                    <select class="sorting_select" name="size">
                        <option value="XS">XS (42)</option>
                        <option value="S">S (44)</option>
                        <option value="M">M (46)</option>
                        <option value="L">L (48)</option>
                        <option value="XL">XL (50)</option>
                        <option value="XXL">XXL (52)</option>
                    </select>
                </div>
            </div>
            <div class="sorting-buttons">
                <button class="button">Применить</button>
                <a class="button red-button" href="#">Сбросить фильтры</a>
            </div>
        </section> -->

        <!-- <section class="container">
            <div class="cards">
                <div class="card">
                    <div class="card__product">
                        <div class="like-button">
                            <svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_260_1130)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.8033 19.3849L20.0225 12.3971C22.7141 9.5584 22.5952 5.99319 20.7806 3.82761C19.8775 2.74981 18.5615 2.04065 17.0398 2.00169C15.7394 1.9684 14.3727 2.42526 13.0542 3.4222C11.7314 2.42532 10.3617 1.96879 9.05956 2.00213C7.5361 2.04113 6.21863 2.74977 5.31521 3.8282C3.49947 5.99569 3.38959 9.56144 6.09183 12.3989L12.3093 19.3849C12.499 19.5981 12.7709 19.7201 13.0563 19.7201C13.3417 19.7201 13.6135 19.5982 13.8033 19.3849ZM16.9886 4.00148C16.085 3.97834 14.9527 4.34563 13.7288 5.46075C13.3476 5.808 12.765 5.80855 12.3832 5.46203C11.1542 4.34659 10.0176 3.9787 9.11075 4.00191C8.20271 4.02516 7.41093 4.4414 6.84835 5.11297C5.73493 6.44209 5.48331 8.86907 7.55003 11.0304L13.0563 17.2164L18.5619 11.0311C20.6172 8.87181 20.3632 6.44381 19.2477 5.11256C18.6844 4.44036 17.8935 4.02464 16.9886 4.00148Z"
                                        fill="#A8A6A6" />
                                    <path
                                        d="M13.7288 5.46075C14.9527 4.34563 16.085 3.97834 16.9886 4.00148C17.8935 4.02464 18.6844 4.44036 19.2477 5.11256C20.3632 6.44381 20.6172 8.87181 18.5619 11.0311L13.0563 17.2164L7.55003 11.0304C5.48331 8.86907 5.73493 6.44209 6.84835 5.11297C7.41093 4.4414 8.20271 4.02516 9.11075 4.00191C10.0176 3.9787 11.1542 4.34659 12.3832 5.46203C12.765 5.80855 13.3476 5.808 13.7288 5.46075Z"
                                        fill="#FAFAFA" />
                                </g>
                                <defs>
                                    <filter id="filter0_d_260_1130" x="0" y="0" width="26.0999" height="25.7201" filterUnits="userSpaceOnUse"
                                        color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                        <feOffset dy="2" />
                                        <feGaussianBlur stdDeviation="2" />
                                        <feComposite in2="hardAlpha" operator="out" />
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_260_1130" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_260_1130" result="shape" />
                                    </filter>
                                </defs>
                            </svg>

                        </div>
                        <div class="card__image">
                            <img src="assets/img/products/42.png" alt="Картинка товара">
                        </div>
                        <div class="card__info">
                            <p class="card__info-title"></p>
                            <div class="card__info-details">
                                <div class="card__info-rating">
                                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.49978 7.53974L2.31845 8.91561C2.22208 8.97981 2.12134 9.00733 2.01622 8.99816C1.91109 8.98899 1.81911 8.9523 1.74027 8.88809C1.66142 8.82388 1.6001 8.74372 1.5563 8.64759C1.5125 8.55146 1.50374 8.44359 1.53002 8.32399L2.1082 5.7236L0.176543 3.97625C0.0889399 3.8937 0.0342753 3.79959 0.0125496 3.69392C-0.00917605 3.58826 -0.00269342 3.48516 0.0319976 3.38463C0.0666886 3.2841 0.119251 3.20155 0.189684 3.13697C0.260117 3.0724 0.356481 3.03112 0.478775 3.01314L3.02804 2.77925L4.01358 0.330208C4.05738 0.220139 4.12536 0.137586 4.21752 0.0825518C4.30968 0.0275172 4.40376 0 4.49978 0C4.59579 0 4.68988 0.0275172 4.78203 0.0825518C4.87419 0.137586 4.94217 0.220139 4.98598 0.330208L5.97152 2.77925L8.52078 3.01314C8.64342 3.03149 8.73979 3.07277 8.80987 3.13697C8.87995 3.20118 8.93251 3.28373 8.96755 3.38463C9.0026 3.48553 9.00925 3.58881 8.98753 3.69447C8.9658 3.80014 8.91096 3.89407 8.82301 3.97625L6.89135 5.7236L7.46953 8.32399C7.49582 8.44323 7.48706 8.55109 7.44325 8.64759C7.39945 8.74408 7.33813 8.82425 7.25929 8.88809C7.18044 8.95193 7.08846 8.98862 6.98334 8.99816C6.87821 9.0077 6.77747 8.98018 6.6811 8.91561L4.49978 7.53974Z"
                                            fill="#FFC75E" />
                                    </svg>
                                    <span>4.2</span>
                                </div>
                                <p class="card__info-price">4200 ₽</p>
                            </div>
                        </div>
                    </div>
                    <a class="button" href=""></a>
                </div>
                <div class="card">
                    <div class="card__product">
                        <div class="card__image">
                            <img src="assets/img/products/42.png" alt="Картинка товара">
                        </div>
                        <div class="card__info">
                            <p class="card__info-title"></p>
                            <div class="card__info-details">
                                <div class="card__info-rating">
                                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.49978 7.53974L2.31845 8.91561C2.22208 8.97981 2.12134 9.00733 2.01622 8.99816C1.91109 8.98899 1.81911 8.9523 1.74027 8.88809C1.66142 8.82388 1.6001 8.74372 1.5563 8.64759C1.5125 8.55146 1.50374 8.44359 1.53002 8.32399L2.1082 5.7236L0.176543 3.97625C0.0889399 3.8937 0.0342753 3.79959 0.0125496 3.69392C-0.00917605 3.58826 -0.00269342 3.48516 0.0319976 3.38463C0.0666886 3.2841 0.119251 3.20155 0.189684 3.13697C0.260117 3.0724 0.356481 3.03112 0.478775 3.01314L3.02804 2.77925L4.01358 0.330208C4.05738 0.220139 4.12536 0.137586 4.21752 0.0825518C4.30968 0.0275172 4.40376 0 4.49978 0C4.59579 0 4.68988 0.0275172 4.78203 0.0825518C4.87419 0.137586 4.94217 0.220139 4.98598 0.330208L5.97152 2.77925L8.52078 3.01314C8.64342 3.03149 8.73979 3.07277 8.80987 3.13697C8.87995 3.20118 8.93251 3.28373 8.96755 3.38463C9.0026 3.48553 9.00925 3.58881 8.98753 3.69447C8.9658 3.80014 8.91096 3.89407 8.82301 3.97625L6.89135 5.7236L7.46953 8.32399C7.49582 8.44323 7.48706 8.55109 7.44325 8.64759C7.39945 8.74408 7.33813 8.82425 7.25929 8.88809C7.18044 8.95193 7.08846 8.98862 6.98334 8.99816C6.87821 9.0077 6.77747 8.98018 6.6811 8.91561L4.49978 7.53974Z"
                                            fill="#FFC75E" />
                                    </svg>
                                    <span>4.2</span>
                                </div>
                                <p class="card__info-price">4200 ₽</p>
                            </div>
                        </div>
                    </div>
                    <a class="button" href=""></a>
                </div>
            </div>
        </section> -->
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