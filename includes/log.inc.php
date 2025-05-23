<?php
require_once "db.php";
require_once "helpers.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Некорректный email!";
    }

    if (empty($email) || empty($password)) {
        $_SESSION["error"] = "Заполните все поля!";
    }

    try {
        if (empty($_SESSION["error"])) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'surname' => $user['surname'],
                    'patronymic' => $user['patronymic'],
                    'address' => $user['address'],
                    'phone' => $user['phone'],
                    'role' => $user['role']
                ];
                redirect('../profile.php');
            } else {
                $_SESSION["error"] = "Неверный логин или пароль!";
                redirect('../login.php');
            }
        } else {
            redirect('../login.php');
        }
    } catch (Throwable $e) {
        die("Ошибка: " . $e->getMessage());
    }
}