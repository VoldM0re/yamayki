<?php
session_start();
require_once 'includes/helpers.php';

if (!isset($_SESSION['user'])) {
    redirect('login.php');
} ?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/profile.css">
    <title>ЯМайки - Профиль</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container">
            <h2 class="section-title">Личный кабинет</h2>
            <form class="sign_form" action="includes/update_profile.inc.php" method="post">
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Имя</p>
                    <input class="sign__form-input" type="text" name="name" placeholder="Пётр" required value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Фамилия</p>
                    <input class="sign__form-input" type="text" name="surname" placeholder="Петрович" required
                        value="<?= htmlspecialchars($_SESSION['user']['surname'] ?? '') ?>">
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Отчество</p>
                    <input class="sign__form-input" type="text" name="patronymic" placeholder="Петров"
                        value="<?= htmlspecialchars($_SESSION['user']['patronymic'] ?? '') ?>">
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Почта</p>
                    <input class="sign__form-input" type="email" name="email" placeholder="post@mail.ru" required
                        value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>">
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Адрес</p>
                    <input class="sign__form-input" type="text" name="address" placeholder="Москва, ул. Пушкина, д. 12"
                        value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Номер телефона</p>
                    <input class="sign__form-input" type="tel" name="phone" placeholder="71234567890" maxlength="11" pattern="[0-9]*"
                        value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '') ?>">
                </div>
                <button class="button">Сохранить</button>
                <a class="button red-button" href="includes/logout.inc.php">Выйти из аккаунта</a>
            </form>
        </section>

        <section class="container">
            <h2 class="section-title">Ваши заказы</h2>
            <div class="order">
                <img class="order-image" src="assets/img/products/tryapki.png" alt="Картинка товара">
                <div class="order__details">
                    <div class="order__details-info">
                        <div class="order__details-main">
                            <p class="order__details-price">14200 ₽</p>
                            <p class="order__details-name">Футболка "Имба"</p>
                        </div>
                        <small class="order__details-size">XS (42)</small>
                    </div>
                    <div class="order__details-addinfo">
                        <small class="order__details-date">Заказ от 29.07.2024</small>
                        <small class="order__details-count">123 шт.</small>
                    </div>
                </div>
            </div>
            <div class="order">
                <img class="order-image" src="assets/img/products/tryapki.png" alt="Картинка товара">
                <div class="order__details">
                    <div class="order__details-info">
                        <div class="order__details-main">
                            <p class="order__details-price">4200 ₽</p>
                            <p class="order__details-name">Футболка "Нааааааааааааа тряпки"</p>
                        </div>
                        <small class="order__details-size">XS (42)</small>
                    </div>
                    <div class="order__details-addinfo">
                        <small class="order__details-date">Заказ от 29.07.2024</small>
                        <small class="order__details-count">1 шт.</small>
                    </div>
                </div>
            </div>
            <div class="order">
                <img class="order-image" src="assets/img/products/tryapki.png" alt="Картинка товара">
                <div class="order__details">
                    <div class="order__details-info">
                        <div class="order__details-main">
                            <p class="order__details-price">12 ₽</p>
                            <p class="order__details-name">Футболка "Нищета"</p>
                        </div>
                        <small class="order__details-size">XS (42)</small>
                    </div>
                    <div class="order__details-addinfo">
                        <small class="order__details-date">Заказ от 29.07.2024</small>
                        <small class="order__details-count">1 шт.</small>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>