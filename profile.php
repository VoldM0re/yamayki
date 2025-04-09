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
    <link rel="stylesheet" href="css/pages/index.css">
    <title>ЯМайки - Профиль</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <h2>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h2>
    <a href="includes/logout.inc.php">Выйти</a>
</body>

</html>