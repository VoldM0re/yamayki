<?php
session_start();
require_once 'includes/helpers.php';
require_once 'includes/db.php';

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
    <link rel="stylesheet" href="css/pages/message_page.css">
    <title>ЯМайки - Профиль</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container">
            <h2 class="section-title">Личный кабинет</h2>
            <form class="sign_form" action="includes/update_profile.inc.php" method="post">
                <?php if (isset($_SESSION['error'])) {
                    echo "
                    <div class='error'>
                        <p>" . $_SESSION['error'] . "</p>
                    </div>";
                    unset($_SESSION['error']);
                } ?>
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

        <?php
        if ($_SESSION['user']['role'] === 'admin') {
            echo "
            <section class='container'>
                <form action='includes/add_product.inc.php' method='POST' enctype='multipart/form-data' class='product-form'>
                    <div class='form-group'>
                        <label for='name' class='form-label'>Название товара:</label>
                        <input type='text' id='name' name='name' class='form-input' required>
                    </div>
                    <div class='form-group'>
                        <label for='name' class='form-label'>Материал:</label>
                        <select name='material' class='form-input'>
                            <option value='hlopok'>Хлопок</option>
                            <option value='laikra'>Лайкра</option>
                            <option value='sintetika'>Синтетика</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='name' class='form-label'>Пол:</label>
                        <select name='sex' class='form-input'>
                            <option value='male'>Мужской</option>
                            <option value='female'>Женский</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='price' class='form-label'>Цена:</label>
                        <input type='number' id='price' name='price' min='0' class='form-input' required>
                    </div>
                    <div class='form-group'>
                        <label for='image' class='form-label'>Изображение:</label>
                        <input type='file' id='image' name='image' accept='image/png' class='form-input' required>
                    </div>
                    <button type='submit' class='form-button'>Добавить товар</button>";
            if (isset($_SESSION['adding_error'])) {
                echo "<p class='adding_error'>" . $_SESSION['adding_error'] ?? '' . "</p>";
                unset($_SESSION['adding_error']);
            }
            echo "</form>
            </section>";
        }
        ?>


        <section class="container">
            <h2 class="section-title">Ваши заказы</h2>

            <?php
            $stmt = $pdo->prepare("SELECT * FROM `orders` JOIN `order_items` ON orders.id = order_items.order_id JOIN `products` ON order_items.product_id = products.id WHERE `user_id` = :user_id");
            $stmt->execute([':user_id' => $_SESSION['user']['id']]);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($orders) {
                foreach ($orders as $order) {
                    echo "
                    <div class='order'>
                    <img class='order-image' src='" . $order['image'] . "' alt='Картинка товара'>
                    <div class='order__details'>
                        <div class='order__details-info'>
                            <div class='order__details-main'>
                                <p class='order__details-price'>" . $order['price'] . " ₽</p>
                                <p class='order__details-name'>" . $order['product_name'] . "</p>
                            </div>
                            <small class='order__details-size'>" . $order['size'] . "</small>
                        </div>
                        <div class='order__details-addinfo'>
                            <small class='order__details-date'>" . $order['created_at'] . "</small>
                            <small class='order__details-count'>" . $order['quantity'] . " шт.</small>
                        </div>
                    </div>
                </div>";
                }
            } else {
                echo "
                <div class='message__block' style='border-color:var(--black)'>
                    <p class='message__block-description'>У вас пока нет заказов</p>
                </div>";
            }
            ?>

        </section>

    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>