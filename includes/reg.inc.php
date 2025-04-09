<?php
require_once 'helpers.php';
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $patronymic = trim($_POST["patronymic"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $againpassword = trim($_POST["againpassword"]);

    // Обработчики ошибок
    if ($password != $againpassword) {
        $_SESSION["error"] = "Ваши пароли не совпадают!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Некорректный email!";
    }
    
    if (empty($name) || empty($surname) || empty($patronymic) || empty($email) || empty($password) || empty($againpassword)) {
        $_SESSION["error"] = "Заполните все поля!";
    }
 
    // Проверка на ошибки базы данных и отсутсвие ошибок в $_SESSION['error']
    try {
        if (empty($_SESSION['error'])) {
            $stmt = $pdo->prepare("INSERT INTO `users` (`name`, `surname`, `patronymic`, `email`, `password`) VALUES (:name, :surname, :patronymic, :email, :password)");
            $stmt->execute([
                ':name' => $name,
                ':surname' => $surname,
                ':patronymic' => $patronymic,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['user'] = [
                'name' => $name
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