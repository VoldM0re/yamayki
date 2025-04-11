<?php
require_once "db.php";
require_once "helpers.php";
session_start();

// Проверка, что пользователь авторизован и является администратором
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    redirect('../login.php');
}

// Обработка данных из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $image = $_FILES['image'];

    // Проверка загруженного файла
    if ($image['error'] !== UPLOAD_ERR_OK) {
        $_SESSION["adding_error"] = "Ошибка при загрузке изображения";
    }

    // Проверка типа файла
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        $_SESSION["adding_error"] = "Недопустимый формат изображения. Допустимые форматы: JPEG, PNG, GIF.";
    }

    // Генерация уникального имени для файла
    $uploadDir = __DIR__ . '/../assets/img/products/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Создаем директорию, если её нет
    }
    $imageName = time() . '_' . basename($image['name']);
    $imagePath = $uploadDir . $imageName;

    $imageForDb = 'assets/img/products/' . $imageName;

    // Перемещение файла в указанную директорию
    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        $_SESSION["adding_error"] = "Не удалось сохранить изображение";
    }
    if (!isset($_SESSION["adding_error"])) {
        // Вставка данных в базу данных
        $stmt = $pdo->prepare("INSERT INTO products (product_name, price, image) VALUES (:name, :price, :image)");
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':image' => $imageForDb,
        ]);
    }
    redirect('../profile.php');
}