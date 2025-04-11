<?php
require_once 'helpers.php';
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $patronymic = trim($_POST["patronymic"]);
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);

    if (empty($name)) {
        $_SESSION["error"] = "Имя не может быть пустым!";
    }

    try {
        if (empty($_SESSION['error'])) {
            $stmt = $pdo->prepare("UPDATE `users` SET name = :name, surname = :surname, patronymic = :patronymic, address = :address, phone = :phone WHERE `id` = :user_id;");
            $stmt->execute([
                ':user_id' => $_SESSION['user']['id'],
                ':name' => $name,
                ':surname' => $surname,
                ':patronymic' => $patronymic,
                ':address' => $address,
                ':phone' => $phone,
            ]);

            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['surname'] = $surname;
            $_SESSION['user']['patronymic'] = $patronymic;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['phone'] = $phone;

            redirect("../profile.php");
        } else {
            redirect("../profile.php");
        }
    } catch (PDOException $e) {
        die("Ошибка в базе данных: " . $e->getMessage());
    }
} else {
    redirect("../profile.php");
}