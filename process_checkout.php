<?php
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Проверяем, что форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Сохраняем данные формы в сессию
    $_SESSION['order_data'] = [
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'patronymic' => $_POST['patronymic'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone'],
        'delivery_method' => $_POST['delivery_method']
    ];

    // Перенаправляем на страницу успешного оформления заказа
    header("Location: order_success.php");
    exit();
}