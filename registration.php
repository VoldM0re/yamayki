<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/svg/favicon.svg" type="image/x-icon">
    <title>Document</title>
</head>
<body>
    <form action="includes/reg.inc.php" method="post">
        <h1>Регистрация</h1>
        <p>Имя:</p>
        <input type="text" name="name" placeholder="Дмитрий"><br>
        
        <p>Фамилия:</p>
        <input type="text" name="surname" placeholder="Нагиев"><br>
        
        <p>Отчество:</p>
        <input type="text" name="patronymic" placeholder="Владимирович"><br>
        
        <p>Почта:</p>
        <input type="text" name="email" placeholder="nagiev@mail.ru"><br>
        
        <p>Пароль:</p>
        <input type="password" name="password" placeholder="Введите пароль"><br>
        
        <p>Повторите пароль:</p>
        <input type="password" name="againpassword" placeholder="Введите пароль повторно"><br>
        
        <button type="sudmit">Отправить</button>

        <?php if (isset($_SESSION['error'])) {
            echo "
            <div class='error'>
                <p>" . $_SESSION['error'] . "</p>
            </div>";
            unset($_SESSION['error']);
        } ?>

    </form>
</body>
</html>
