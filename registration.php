<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/registration.css">
    <title>ЯМайки - Регистрация</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="container">
            <h2 class="section-title">Регистрация</h2>
            <form class="sign_form" action="includes/reg.inc.php" method="post">
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Имя</p>
                    <input class="sign__form-input" type="text" name="name" placeholder="Пётр" required">
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Почта</p>
                    <input class="sign__form-input" type="email" name="email" placeholder="post@mail.ru" required ">
                </div>
                <div class=" sign_form__block">
                    <p class="sign_form__block-title">Пароль</p>
                    <input class="sign__form-input" type="password" name="password" placeholder="Введите пароль" required>
                </div>
                <div class="sign_form__block">
                    <p class="sign_form__block-title">Пароль</p>
                    <input class="sign__form-input" type="password" name="againpassword" placeholder="Введите пароль повторно" required>
                </div>
                <button class="button">Зарегистрироваться</button>

                <?php if (isset($_SESSION['error'])) {
                    echo "
                    <div class='error'>
                        <p>" . $_SESSION['error'] . "</p>
                    </div>";
                    unset($_SESSION['error']);
                } ?>
                <p class="sign_link-block">Уже были у нас?<a class="sign_link" href="login.php">Войти в аккаунт</a></p>
            </form>
        </section>
    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>