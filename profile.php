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
    <link rel="shortcut icon" href="./assets/svg/favicon.svg" type="image/x-icon">
    <title>Главная страница</title>
</head>
<body>
    <h2>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h2>
    <a href="logout.php">Выйти</a>
</body>
</html>