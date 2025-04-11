<?php
require_once 'helpers.php';
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $againpassword = trim($_POST["againpassword"]);

    // Обработчики ошибок
    if ($password != $againpassword) {
        $_SESSION["error"] = "Ваши пароли не совпадают!";
    }

    $stmt = $pdo->prepare("SELECT `name` FROM `users` WHERE `email` = :email");
    $stmt->execute([':email' => $email]);
    $isOccupied = $stmt->fetch();
    if ($isOccupied) {
        $_SESSION["error"] = "Такой email уже занят!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Некорректный email!";
    }

    if (empty($name) || empty($email) || empty($password) || empty($againpassword)) {
        $_SESSION["error"] = "Заполните все поля!";
    }

    // Проверка на ошибки базы данных и отсутсвие ошибок в $_SESSION['error']
    try {
        if (empty($_SESSION['error'])) {
            $stmt = $pdo->prepare("INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_BCRYPT)
            ]);

            $stmt = $pdo->prepare("SELECT `id` FROM `users` WHERE `email` = :email");
            $stmt->execute([':email' => $email]);
            $user_id = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user'] = [
                'name' => $name,
                'id' => $user_id['id'],
                'email' => $user['email'],
                'surname' => '',
                'patronymic' => '',
                'address' => '',
                'phone' => '',
                'role' => 'user'
            ];
            redirect("../index.php");
        } else {
            redirect("../registration.php");
        }
    } catch (PDOException $e) {
        die("Ошибка в базе данных: " . $e->getMessage());
    }
} else {
    redirect("../registration.php");
}