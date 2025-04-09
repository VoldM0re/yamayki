<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/svg/favicon.svg" type="image/x-icon">
    <title>ЯМайки - логин</title>
</head>
<body>
    <form action="includes/log.inc.php" method="post">
        <h1>Войти</h1>
        <p>Почта:</p>
        <input type="text" name="email" placeholder="nagiev@mail.ru"><br>
        <p>Пароль:</p>
        <input type="password" name="password" placeholder="Введите пароль"><br><br>
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

