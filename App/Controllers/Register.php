<?php

namespace MyApp\Controllers;

use MyApp\Model\UserModel;

require_once __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    $username = sanitizeInput($_POST['username']);
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    $userModel = new UserModel();

    if ($userModel->isEmailTaken($email)) {
        $errors[] = "User with this email already exists";
    }

    if (empty($errors)) {
        if ($userModel->registerUser($username, $email, $password, $phone)) {
            header("Location: ../../View/auth/login.php");
            exit();
        } else {
            header("Location: ../../View/auth/signup.php");
            exit();
        }
    }

}
?>
