<?php

namespace MyApp\Controllers;

use MyApp\Model\UserModel;

require_once __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['processLogin'])) {
    function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    $errors = [];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        $userModel = new UserModel();

        if ($userModel->isEmailTaken($email)) {
            $userDetails = $userModel->getUserDetailsByEmail($email);

            // After successful login
            if (password_verify($password, $userDetails['password'])) {
                session_start();
                $_SESSION['userId'] = $userDetails['id'];
                $_SESSION['username'] = $userDetails['name'];
                $_SESSION['role'] = $userDetails['role'];

               
                if ($_SESSION['role'] === 1) {
                    header("Location: ../../View/admin/dashmin.php");
                } else { 
                    header("Location: ../../View/user/wiki.php");
                }

                exit();
            } else {
                $errors[] = "Invalid email or password";
            }

        } else {
            $errors[] = "Invalid email or password";
        }
    }
}

?>